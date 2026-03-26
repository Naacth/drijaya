<?php

namespace App\Controllers;

use App\Models\SppgModel;
use App\Models\PurchaseOrderModel;

class PicController extends BaseController
{
    public function orders()
    {
        $poModel = new PurchaseOrderModel();
        
        // Handle filter and search
        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');

        $builder = $poModel->where('sppg_id', session()->get('sppg_id'));

        if ($status && $status !== 'Semua') {
            $builder->where('status', $status);
        }
        if ($search) {
            $builder->like('po_number', $search);
        }

        $builder->orderBy('tanggal', 'DESC');
        $orders = $builder->paginate(10);
        
        $data = [
            'title' => 'Daftar Purchase Order',
            'orders' => $orders,
            'pager' => $poModel->pager,
            'currentSearch' => $search,
            'currentStatus' => $status,
        ];

        return view('pic/po', $data);
    }

    public function settings()
    {
        $sppgId = session()->get('sppg_id');
        if (!$sppgId) {
            return redirect()->to('/dashboard')->with('error', 'Akun Anda belum terasosiasi dengan SPPG manapun.');
        }

        $sppgModel = new SppgModel();
        $sppg = $sppgModel->find($sppgId);

        $data = [
            'title' => 'Pengaturan SPPG',
            'sppg'  => $sppg
        ];

        return view('pic/settings', $data);
    }

    public function updateSettings()
    {
        $sppgId = session()->get('sppg_id');
        if (!$sppgId) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $alamat = $this->request->getPost('alamat');

        $sppgModel = new SppgModel();
        $sppgModel->update($sppgId, [
            'alamat' => $alamat
        ]);

        // Update session as well
        session()->set('sppg_alamat', $alamat);

        return redirect()->to('/pic/settings')->with('success', 'Alamat SPPG berhasil diperbarui.');
    }
}
