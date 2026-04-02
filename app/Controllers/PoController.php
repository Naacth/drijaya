<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderItemModel;
use App\Models\PurchaseOrderApprovalModel;
use CodeIgniter\Controller;

class PoController extends BaseController
{
    protected $poModel;
    protected $itemModel;
    protected $approvalModel;

    public function __construct()
    {
        $this->poModel = new PurchaseOrderModel();
        $this->itemModel = new PurchaseOrderItemModel();
        $this->approvalModel = new PurchaseOrderApprovalModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');

        $query = $this->poModel->select('purchase_orders.*, users.nama as pembuat')
            ->join('users', 'users.id = purchase_orders.user_id');

        if ($role == 'ahli_gizi') {
            $query->where('purchase_orders.user_id', $userId);
        } elseif ($role == 'admin' || $role == 'pic') {
            $sppgId = session()->get('sppg_id');
            if ($sppgId) $query->where('users.sppg_id', $sppgId);
        }

        if ($status) {
            $query->where('purchase_orders.status', $status);
        }

        if ($search) {
            $query->groupStart()
                  ->like('purchase_orders.nomor_po', $search)
                  ->orLike('purchase_orders.vendor', $search)
                  ->orLike('purchase_orders.menu', $search)
                  ->groupEnd();
        }

        $data['pos'] = $query->orderBy('purchase_orders.created_at', 'DESC')->paginate(10, 'pos');
        $data['pager'] = $this->poModel->pager;
        $data['title'] = 'Daftar Purchase Order';
        $data['filter'] = ['status' => $status, 'search' => $search];

        return view('po/index', $data);
    }

    public function create()
    {
        $role = session()->get('role');
        if (!in_array($role, ['ahli_gizi', 'akuntan'])) {
            return redirect()->to('/po')->with('error', 'Hanya Ahli Gizi atau Akuntan yang dapat membuat PO.');
        }

        $akgModel = new \App\Models\AnalisisGiziModel();
        $data['akgs']  = $akgModel->orderBy('created_at', 'DESC')->limit(20)->findAll();
        $data['title'] = 'Buat Purchase Order Baru';
        return view('po/create', $data);
    }

    public function store()
    {
        $role = session()->get('role');
        if (!in_array($role, ['ahli_gizi', 'akuntan'])) {
            return redirect()->to('/po')->with('error', 'Unauthorized');
        }

        // Validation
        $rules = [
            'vendor'  => 'required',
            'tanggal' => 'required|valid_date',
            'items.*.nama_barang' => 'required',
            'items.*.qty'         => 'required|numeric',
            'items.*.satuan'      => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Mohon lengkapi semua field yang wajib diisi.')->withInput();
        }

        $items = $this->request->getPost('items');
        
        $db = \Config\Database::connect();
        $db->transStart();

        $role   = session()->get('role');
        $status = 'draft';
        if ($this->request->getPost('action') == 'submit') {
            $status = ($role == 'akuntan') ? 'menunggu_review' : 'menunggu_harga';
        }

        $poData = [
            'user_id'          => session()->get('user_id'),
            'analisis_gizi_id' => $this->request->getPost('analisis_gizi_id') ?: null,
            'nomor_po'         => 'PO-' . date('YmdHis'),
            'tanggal'          => $this->request->getPost('tanggal'),
            'vendor'           => $this->request->getPost('vendor'),
            'menu'             => $this->request->getPost('menu'),
            'status'           => $status,
            'keterangan'       => $this->request->getPost('keterangan'),
            'total'            => 0
        ];

        $poId = $this->poModel->insert($poData);

        if (!$poId) {
            $error = $db->error();
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal membuat header PO: ' . ($error['message'] ?? 'Unknown DB Error'))->withInput();
        }

        foreach ($items as $item) {
            $hargaSatuan   = (float)($item['harga_satuan'] ?? 0);
            $jumlahFaktual = (float)($item['jumlah_faktual'] ?? 0);
            $tambahan      = (float)($item['tambahan'] ?? 0);
            $totalRow      = ($hargaSatuan * $jumlahFaktual) + $tambahan;

            $this->itemModel->insert([
                'po_id'          => $poId,
                'nama_barang'    => $item['nama_barang'],
                'qty'            => $item['qty'],
                'satuan'         => $item['satuan'],
                'harga_satuan'   => $hargaSatuan,
                'tambahan'       => $tambahan,
                'jumlah_faktual' => $jumlahFaktual,
                'total'          => $totalRow,
                'catatan'        => $item['catatan'] ?? ''
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan item PO. Bagian teknis sedang meninjau.')->withInput();
        }

        // Update grand total
        $grandTotal = 0;
        $savedItems = $this->itemModel->where('po_id', $poId)->findAll();
        foreach ($savedItems as $si) {
            $grandTotal += (float)$si['total'];
        }
        $this->poModel->update($poId, ['total' => $grandTotal]);

        $message = ($status == 'draft') ? 'Draft PO berhasil disimpan.' : (($status == 'menunggu_review') ? 'PO berhasil diajukan ke PIC.' : 'PO berhasil diajukan ke Akuntan.');
        return redirect()->to('/po')->with('success', $message);
    }
    public function edit($id)
    {
        $po = $this->poModel->find($id);

        if (!$po) {
            return redirect()->to('/po')->with('error', 'Purchase Order tidak ditemukan.');
        }

        $role = session()->get('role');
        $isCreator = ($po['user_id'] == session()->get('user_id'));
        $canEdit = in_array($role, ['admin', 'pic', 'akuntan']) || $isCreator;

        if (!in_array($po['status'], ['draft', 'rejected']) || !$canEdit) {
            return redirect()->to('/po')->with('error', 'Purchase Order tidak dapat diubah.');
        }

        $data['title'] = 'Edit Purchase Order';
        $data['po']    = $po;
        $data['items'] = $this->itemModel->where('po_id', $id)->findAll();
        
        $akgModel = new \App\Models\AnalisisGiziModel();
        $data['akgList'] = $akgModel->orderBy('created_at', 'DESC')->limit(20)->findAll();

        return view('po/edit', $data);
    }

    public function update($id)
    {
        $po = $this->poModel->find($id);

        if (!$po) {
            return redirect()->to('/po')->with('error', 'Purchase Order tidak ditemukan.');
        }

        $role = session()->get('role');
        $isCreator = ($po['user_id'] == session()->get('user_id'));
        $canEdit = in_array($role, ['admin', 'pic', 'akuntan']) || $isCreator;

        if (!in_array($po['status'], ['draft', 'rejected']) || !$canEdit) {
            return redirect()->to('/po')->with('error', 'Purchase Order tidak dapat diubah.');
        }

        // Validation
        $rules = [
            'vendor'  => 'required',
            'tanggal' => 'required|valid_date',
            'items.*.nama_barang' => 'required',
            'items.*.qty'         => 'required|numeric',
            'items.*.satuan'      => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Mohon lengkapi semua field yang wajib diisi.')->withInput();
        }

        $items = $this->request->getPost('items');
        
        $db = \Config\Database::connect();
        $db->transStart();

        $role   = session()->get('role');
        $status = 'draft';
        if ($this->request->getPost('action') == 'submit') {
            $status = ($role == 'akuntan') ? 'menunggu_review' : 'menunggu_harga';
        }

        $poData = [
            'analisis_gizi_id' => $this->request->getPost('analisis_gizi_id') ?: null,
            'tanggal'          => $this->request->getPost('tanggal'),
            'vendor'           => $this->request->getPost('vendor'),
            'menu'             => $this->request->getPost('menu'),
            'status'           => $status,
            'keterangan'       => $this->request->getPost('keterangan'),
            'total'            => 0
        ];

        $this->poModel->update($id, $poData);

        // Delete old items and re-insert
        $this->itemModel->where('po_id', $id)->delete();

        foreach ($items as $item) {
            $hargaSatuan   = (float)($item['harga_satuan'] ?? 0);
            $jumlahFaktual = (float)($item['jumlah_faktual'] ?? 0);
            $tambahan      = (float)($item['tambahan'] ?? 0);
            $totalRow      = ($hargaSatuan * $jumlahFaktual) + $tambahan;

            $this->itemModel->insert([
                'po_id'          => $id,
                'nama_barang'    => $item['nama_barang'],
                'qty'            => $item['qty'],
                'satuan'         => $item['satuan'],
                'harga_satuan'   => $hargaSatuan,
                'tambahan'       => $tambahan,
                'jumlah_faktual' => $jumlahFaktual,
                'total'          => $totalRow,
                'catatan'        => $item['catatan'] ?? ''
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal update item PO. Bagian teknis sedang meninjau.')->withInput();
        }

        // Update grand total
        $grandTotal = 0;
        $savedItems = $this->itemModel->where('po_id', $id)->findAll();
        foreach ($savedItems as $si) {
            $grandTotal += (float)$si['total'];
        }
        $this->poModel->update($id, ['total' => $grandTotal]);

        $message = ($status == 'draft') ? 'Draft PO berhasil diubah.' : (($status == 'menunggu_review') ? 'PO berhasil diajukan ke PIC.' : 'PO berhasil diajukan ke Akuntan.');
        return redirect()->to('/po')->with('success', $message);
    }

    public function editPrice($id)
    {
        if (session()->get('role') != 'akuntan') {
            return redirect()->to('/po')->with('error', 'Unauthorized');
        }

        $data['po'] = $this->poModel->find($id);
        $data['items'] = $this->itemModel->where('po_id', $id)->findAll();
        $data['title'] = 'Input Harga Purchase Order';

        return view('po/edit_price', $data);
    }

    public function updatePrice($id)
    {
        if (session()->get('role') != 'akuntan') {
            return redirect()->to('/po')->with('error', 'Unauthorized');
        }

        $action = $this->request->getPost('action');
        if ($action == 'revisi') {
            $this->poModel->update($id, ['status' => 'draft']);
            return redirect()->to('/po')->with('success', 'PO dikembalikan ke Ahli Gizi untuk revisi.');
        }

        $items = $this->request->getPost('items');
        $grandTotal = 0;

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($items as $itemId => $val) {
            $hargaSatuan = (float)($val['harga_satuan'] ?? 0);
            $jumlahFaktual = (float)($val['jumlah_faktual'] ?? 0);
            $tambahan = (float)($val['tambahan'] ?? 0);

            $total = ($hargaSatuan * $jumlahFaktual) + $tambahan;

            $this->itemModel->update($itemId, [
                'harga_satuan'   => $hargaSatuan,
                'tambahan'       => $tambahan,
                'jumlah_faktual' => $jumlahFaktual,
                'total'          => $total
            ]);
            $grandTotal += $total;
        }

        $this->poModel->update($id, [
            'total'  => $grandTotal,
            'status' => 'menunggu_review'
        ]);

        $db->transComplete();

        return redirect()->to('/po')->with('success', 'Harga berhasil dikirim ke PIC.');
    }

    public function review($id)
    {
        if (session()->get('role') != 'pic') {
            return redirect()->to('/po')->with('error', 'Unauthorized');
        }

        $data['po'] = $this->poModel->find($id);
        $data['items'] = $this->itemModel->where('po_id', $id)->findAll();
        $data['title'] = 'Review Purchase Order';

        return view('po/review', $data);
    }

    public function doReview($id)
    {
        if (session()->get('role') != 'pic') {
            return redirect()->to('/po')->with('error', 'Unauthorized');
        }

        $status = $this->request->getPost('status'); 
        $catatan = $this->request->getPost('catatan');
        $roleLabel = 'PIC';

        if ($status == 'approve') {
            $newStatus = 'menunggu_approval';
        } elseif ($status == 'revisi_akuntan') {
            $newStatus = 'menunggu_harga';
        } else {
            $newStatus = 'draft'; // Ahli Gizi
        }

        $this->poModel->update($id, ['status' => $newStatus]);

        $this->approvalModel->insert([
            'po_id'   => $id,
            'role'    => 'pic',
            'user_id' => session()->get('user_id'),
            'status'  => $status,
            'catatan' => $catatan,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/po')->with('success', 'Review PO berhasil dikirim.');
    }

    public function approve($id)
    {
        // Assuming Kepala SPPG role or checking specifically
        // Here we just use 'admin' as example or you can map a role
        if (!in_array(session()->get('role'), ['admin', 'pic'])) { // Adjusting based on user's preference or system roles
             // For now let's say 'admin' is Kepala SPPG if not defined otherwise
        }

        $data['po'] = $this->poModel->find($id);
        $data['items'] = $this->itemModel->where('po_id', $id)->findAll();
        $data['title'] = 'Persetujuan Final PO';

        return view('po/approve', $data);
    }

    public function doApprove($id)
    {
        $status = $this->request->getPost('status'); // approved/rejected
        $catatan = $this->request->getPost('catatan');

        $this->poModel->update($id, ['status' => $status]);

        $this->approvalModel->insert([
            'po_id'   => $id,
            'role'    => 'kepala_sppg',
            'user_id' => session()->get('user_id'),
            'status'  => $status,
            'catatan' => $catatan,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/po')->with('success', 'Status PO diperbarui.');
    }

    public function show($id)
    {
        $data['po'] = $this->poModel->select('purchase_orders.*, users.nama as pembuat')
            ->join('users', 'users.id = purchase_orders.user_id')
            ->find($id);
        $data['items'] = $this->itemModel->where('po_id', $id)->findAll();
        $data['approvals'] = $this->approvalModel->where('po_id', $id)->findAll();
        $data['title'] = 'Detail Purchase Order';

        return view('po/show', $data);
    }

    public function print($id)
    {
        $data['po'] = $this->poModel->select('purchase_orders.*, users.nama as pembuat')
            ->join('users', 'users.id = purchase_orders.user_id')
            ->find($id);
        $data['items'] = $this->itemModel->where('po_id', $id)->findAll();
        $data['approvals'] = $this->approvalModel->select('purchase_order_approvals.*, users.nama')
            ->join('users', 'users.id = purchase_order_approvals.user_id')
            ->where('po_id', $id)->findAll();
        
        return view('po/print', $data);
    }

    public function exportExcel()
    {
        if (!in_array(session()->get('role'), ['admin', 'pic'])) {
            return redirect()->to('/po')->with('error', 'Unauthorized');
        }

        $pos = $this->poModel->select('purchase_orders.*, users.nama as pembuat')
            ->join('users', 'users.id = purchase_orders.user_id')
            ->orderBy('purchase_orders.created_at', 'DESC')->findAll();

        $filename = 'Laporan_PO_' . date('Ymd_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        
        // BOM for Excel UTF-8 support
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['Nomor PO', 'Tanggal', 'Pembuat', 'Supplier', 'Menu', 'Total Biaya', 'Status', 'Keterangan']);
        
        foreach ($pos as $po) {
            fputcsv($output, [
                $po['nomor_po'],
                date('d/m/Y', strtotime($po['tanggal'])),
                $po['pembuat'],
                $po['vendor'],
                $po['menu'],
                $po['total'],
                ucwords(str_replace('_', ' ', $po['status'])),
                $po['keterangan']
            ]);
        }
        
        fclose($output);
        exit;
    }

    public function exportPdf()
    {
        if (!in_array(session()->get('role'), ['admin', 'pic'])) {
            return redirect()->to('/po')->with('error', 'Unauthorized');
        }

        $data['pos'] = $this->poModel->select('purchase_orders.*, users.nama as pembuat')
            ->join('users', 'users.id = purchase_orders.user_id')
            ->orderBy('purchase_orders.created_at', 'DESC')->findAll();
        $data['title'] = 'Laporan Purchase Order';

        return view('po/export_pdf', $data);
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->approvalModel->where('po_id', $id)->delete();
        $this->itemModel->where('po_id', $id)->delete();
        $this->poModel->delete($id);
        $db->transComplete();

        return redirect()->to('/po')->with('success', 'Purchase Order berhasil dihapus.');
    }

    public function getAkgDetails($id)
    {
        $akgModel = new \App\Models\AnalisisGiziModel();
        $itemModel = new \App\Models\AnalisisGiziItemModel();

        $header = $akgModel->find($id);
        if (!$header) return $this->response->setJSON(['error' => 'Data tidak ditemukan']);

        $items = $itemModel->where('analisis_gizi_id', $id)->findAll();
        
        return $this->response->setJSON([
            'header' => $header,
            'items'  => $items
        ]);
    }
}
