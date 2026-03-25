<?php

namespace App\Controllers;

use App\Models\BeneficiaryModel;
use App\Models\BeneficiaryItemModel;

class BeneficiaryController extends BaseController
{
    protected $beneficiaryModel;
    protected $itemModel;

    public function __construct()
    {
        $this->beneficiaryModel = new BeneficiaryModel();
        $this->itemModel = new BeneficiaryItemModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');

        $query = $this->beneficiaryModel->getWithCreator();

        if ($role == 'aslap') {
            $query->where('beneficiaries.created_by', $userId);
        }

        if ($status) {
            $query->where('beneficiaries.status', $status);
        }

        if ($search) {
            $query->groupStart()
                  ->like('beneficiaries.sppg', $search)
                  ->orLike('beneficiaries.kecamatan', $search)
                  ->groupEnd();
        }

        $data['title'] = 'Data Penerima Manfaat SPPG';
        $data['items'] = $query->paginate(10, 'beneficiaries');
        $data['pager'] = $this->beneficiaryModel->pager;
        $data['filter'] = ['status' => $status, 'search' => $search];

        return view('beneficiary/index', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'aslap') {
            return redirect()->to('/penerima-manfaat')->with('error', 'Unauthorized');
        }

        $data['title'] = 'Input Data Penerima Manfaat';
        return view('beneficiary/create', $data);
    }

    public function store()
    {
        $role = session()->get('role');
        if ($role != 'aslap') {
            return redirect()->to('/penerima-manfaat')->with('error', 'Unauthorized');
        }

        $items = $this->request->getPost('items');
        if (empty($items)) {
            return redirect()->back()->with('error', 'Minimal harus ada 1 sekolah.')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerData = [
            'tanggal'    => $this->request->getPost('tanggal'),
            'sppg'       => $this->request->getPost('sppg'),
            'kecamatan'  => $this->request->getPost('kecamatan'),
            'created_by' => session()->get('user_id'),
            'status'     => ($this->request->getPost('action') == 'submit') ? 'submitted' : 'draft',
        ];

        $beneficiaryId = $this->beneficiaryModel->insert($headerData);

        foreach ($items as $item) {
            // Logic: Porsi Besar (di Excel) = Porsi Besar + Pendidik + Non Pendidik
            // But usually we store discrete values and calculate in view/export
            // User requested: Jumlah Porsi Besar = Porsi besar + pendidik + non pendidik
            
            $porsiKecilVal = (int)$item['porsi_kecil'];
            $porsiBesarVal = (int)$item['porsi_besar'];
            $pendidikVal = (int)$item['pendidik'];
            $nonPendidikVal = (int)$item['non_pendidik'];
            
            // Total Porsi calculation based on user request:
            // "Jumlah Porsi Besar = Porsi besar + pendidik + non pendidik"
            // "Jumlah Porsi Kecil = Porsi kecil"
            // So "Total Porsi" (Jumlah Porsi Seluruh) = Porsi Kecil + (Porsi Besar + Pendidik + Non Pendidik)
            
            $totalPorsi = $porsiKecilVal + $porsiBesarVal + $pendidikVal + $nonPendidikVal;

            $this->itemModel->insert([
                'beneficiary_id' => $beneficiaryId,
                'nama_sekolah'   => $item['nama_sekolah'],
                'jumlah_siswa'   => $item['jumlah_siswa'],
                'porsi_kecil'    => $porsiKecilVal,
                'porsi_besar'    => $porsiBesarVal,
                'pendidik'       => $pendidikVal,
                'non_pendidik'   => $nonPendidikVal,
                'total_porsi'    => $totalPorsi
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data.')->withInput();
        }

        return redirect()->to('/penerima-manfaat')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $data['header'] = $this->beneficiaryModel->getWithCreator()->find($id);
        $data['items'] = $this->itemModel->where('beneficiary_id', $id)->findAll();
        $data['title'] = 'Detail Data Penerima Manfaat';

        return view('beneficiary/show', $data);
    }

    public function approve($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $this->beneficiaryModel->update($id, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Data disetujui.');
    }

    public function reject($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $this->beneficiaryModel->update($id, ['status' => 'rejected']);
        return redirect()->back()->with('success', 'Data ditolak.');
    }

    public function exportPdf($id)
    {
        $data['header'] = $this->beneficiaryModel->getWithCreator()->find($id);
        $data['items'] = $this->itemModel->where('beneficiary_id', $id)->findAll();
        $data['title'] = 'Laporan Penerima Manfaat SPPG';

        return view('beneficiary/export_pdf', $data);
    }

    public function exportExcel($id)
    {
        $header = $this->beneficiaryModel->getWithCreator()->find($id);
        $items = $this->itemModel->where('beneficiary_id', $id)->findAll();

        $filename = 'Data_Penerima_Manfaat_' . date('Ymd_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        
        // BOM for Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header Info
        fputcsv($output, ['DATA PENERIMA MANFAAT SPPG']);
        fputcsv($output, ['Tanggal', date('d/m/Y', strtotime($header['tanggal']))]);
        fputcsv($output, ['SPPG', $header['sppg']]);
        fputcsv($output, ['Kecamatan', $header['kecamatan']]);
        fputcsv($output, []); // Empty row
        
        // Table Header
        fputcsv($output, ['No', 'Nama Sekolah', 'Jumlah Siswa', 'Porsi Kecil', 'Porsi Besar', 'Guru', 'Staf', 'Total Porsi']);
        
        foreach ($items as $index => $item) {
            fputcsv($output, [
                $index + 1,
                $item['nama_sekolah'],
                $item['jumlah_siswa'],
                $item['porsi_kecil'],
                $item['porsi_besar'],
                $item['pendidik'],
                $item['non_pendidik'],
                $item['total_porsi']
            ]);
        }
        
        fclose($output);
        exit;
    }
}
