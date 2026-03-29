<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AbsensiController extends BaseController
{
    protected $absensiModel;
    protected $itemModel;
    protected $relawanModel;

    public function __construct()
    {
        $this->absensiModel = new \App\Models\AbsensiModel();
        $this->itemModel    = new \App\Models\AbsensiItemModel();
        $this->relawanModel = new \App\Models\RelawanModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $sppgId = session()->get('sppg_id');
        $builder = $this->absensiModel->orderBy('tanggal', 'DESC');
        
        if ($role == 'admin' || $role == 'pic') {
            if ($sppgId) $builder->where('sppg_id', $sppgId);
        }

        $data = [
            'title'   => 'Daftar Absensi Relawan',
            'absensi' => $builder->findAll()
        ];

        return view('absensi/index', $data);
    }

    public function create()
    {
        $sppgId = session()->get('sppg_id');
        $relawan = $this->relawanModel->where('sppg_id', $sppgId)->orderBy('divisi', 'ASC')->findAll();
        
        // Group by division
        $grouped = [];
        foreach ($relawan as $r) {
            $grouped[$r['divisi']][] = $r;
        }

        $data = [
            'title'   => 'Input Absensi Hari Ini',
            'grouped' => $grouped,
            'today'   => date('Y-m-d')
        ];

        return view('absensi/create', $data);
    }

    public function store()
    {
        $sppgId    = session()->get('sppg_id');
        $createdBy = session()->get('user_id');
        $tanggal   = $this->request->getPost('tanggal');

        // Check if already exist
        $existing = $this->absensiModel->where(['tanggal' => $tanggal, 'sppg_id' => $sppgId])->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Absensi untuk tanggal ini sudah dibuat.');
        }

        $absensiId = $this->absensiModel->insert([
            'tanggal'     => $tanggal,
            'sppg_id'     => $sppgId,
            'created_by'  => $createdBy
        ]);

        $statuses = $this->request->getPost('status'); // [relawan_id => status]
        if ($statuses) {
            foreach ($statuses as $relawanId => $status) {
                $this->itemModel->insert([
                    'absensi_id' => $absensiId,
                    'relawan_id' => $relawanId,
                    'status'     => $status
                ]);
            }
        }

        return redirect()->to('/absensi')->with('success', 'Absensi berhasil disimpan');
    }

    public function show($id)
    {
        $sppgId = session()->get('sppg_id');
        $absensi = $this->absensiModel->where(['id' => $id, 'sppg_id' => $sppgId])->first();
        if (!$absensi) return redirect()->to('/absensi')->with('error', 'Data tidak ditemukan');

        $data = [
            'title'   => 'Detail Absensi - ' . date('d/m/Y', strtotime($absensi['tanggal'])),
            'absensi' => $absensi,
            'items'   => $this->itemModel->getByAbsensi($id)
        ];

        return view('absensi/show', $data);
    }

    public function exportPdf($id)
    {
        $sppgId = session()->get('sppg_id');
        $absensi = $this->absensiModel->where(['id' => $id, 'sppg_id' => $sppgId])->first();
        if (!$absensi) return redirect()->to('/absensi');

        // Get 2 week range surrounding this date for the "rekap" request
        // But usually "rekap per 2 minggu" means we select a range. 
        // For now, let's just export THIS single day session as a list, 
        // OR implement the 2-week logic as a separate report.

        $data = [
            'title'   => 'Absensi Relawan',
            'absensi' => $absensi,
            'items'   => $this->itemModel->getByAbsensi($id),
            'header'  => [
                'nama_sppg' => session()->get('sppg_nama') ?? 'Dapur SPPG',
                'alamat_sppg' => session()->get('sppg_alamat') ?? 'Alamat belum diatur'
            ]
        ];

        return view('absensi/print', $data);
    }
    
    public function rekap()
    {
        $sppgId = session()->get('sppg_id');
        $start = $this->request->getGet('start') ?: date('Y-m-d', strtotime('-14 days'));
        $end   = $this->request->getGet('end') ?: date('Y-m-d');

        // Get all attendance sessions in range
        $sessions = $this->absensiModel->where('sppg_id', $sppgId)
                                     ->where('tanggal >=', $start)
                                     ->where('tanggal <=', $end)
                                     ->orderBy('tanggal', 'ASC')
                                     ->findAll();
        
        $sessionIds = array_column($sessions, 'id');
        
        // Get all volunteers to show them in rows
        $relawan = $this->relawanModel->where('sppg_id', $sppgId)->orderBy('divisi', 'ASC')->findAll();
        
        // Matrix of [relawan_id][date] = status
        $matrix = [];
        if ($sessionIds) {
            $items = $this->itemModel->whereIn('absensi_id', $sessionIds)->findAll();
            
            // Map items for easier lookup
            $statusMap = [];
            foreach ($items as $item) {
                // Find session date
                foreach ($sessions as $s) {
                    if ($s['id'] == $item['absensi_id']) {
                        $statusMap[$item['relawan_id']][$s['tanggal']] = $item['status'];
                        break;
                    }
                }
            }
        }

        $data = [
            'title'    => 'Rekap Absensi 2 Minggu',
            'sessions' => $sessions,
            'relawan'  => $relawan,
            'matrix'   => $statusMap ?? [],
            'start'    => $start,
            'end'      => $end
        ];

        return view('absensi/rekap', $data);
    }

    public function rekapPdf()
    {
        $sppgId = session()->get('sppg_id');
        $start = $this->request->getGet('start');
        $end   = $this->request->getGet('end');

        $sessions = $this->absensiModel->where('sppg_id', $sppgId)
                                     ->where('tanggal >=', $start)
                                     ->where('tanggal <=', $end)
                                     ->orderBy('tanggal', 'ASC')
                                     ->findAll();
        
        $sessionIds = array_column($sessions, 'id');
        $relawan = $this->relawanModel->where('sppg_id', $sppgId)->orderBy('divisi', 'ASC')->findAll();
        
        $matrix = [];
        if ($sessionIds) {
            $items = $this->itemModel->whereIn('absensi_id', $sessionIds)->findAll();
            foreach ($items as $item) {
                foreach ($sessions as $s) {
                    if ($s['id'] == $item['absensi_id']) {
                        $matrix[$item['relawan_id']][$s['tanggal']] = $item['status'];
                        break;
                    }
                }
            }
        }

        $data = [
            'title'    => 'Laporan Rekap Absensi',
            'sessions' => $sessions,
            'relawan'  => $relawan,
            'matrix'   => $matrix,
            'start'    => $start,
            'end'      => $end,
            'header'   => [
                'nama_sppg' => session()->get('sppg_nama') ?? 'Dapur SPPG Bunar',
                'alamat_sppg' => 'KP. BEJI No.001, RT.004, Bunar, Kec. Sukamulya, Kabupaten Tangerang, Banten'
            ]
        ];

        return view('absensi/rekap_print', $data);
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->itemModel->where('absensi_id', $id)->delete();
        $this->absensiModel->delete($id);
        $db->transComplete();

        if ($db->transStatus() === false) return redirect()->back()->with('error', 'Gagal menghapus data.');
        return redirect()->to('/absensi')->with('success', 'Data berhasil dihapus.');
    }
}
