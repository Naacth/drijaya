<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (! $user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan.')->withInput();
        }

        if (! password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.')->withInput();
        }

        $sppgId   = $user['sppg_id'];
        $sppgName = 'Pusat (Admin)';
        $sppgAlamat = 'Alamat belum diatur oleh PIC';
        
        if ($sppgId) {
            $sppgModel = new \App\Models\SppgModel();
            $sppg = $sppgModel->find($sppgId);
            
            if ($sppg) {
                $sppgName = $sppg['nama_sppg'] ?? 'Dapur SPPG';
                $sppgAlamat = !empty($sppg['alamat']) ? $sppg['alamat'] : 'Alamat belum diatur oleh PIC';
            } else {
                $sppgName = 'Dapur SPPG';
                $sppgAlamat = 'Alamat belum diatur oleh PIC';
            }
        }

        session()->set([
            'user_id'    => $user['id'],
            'nama'       => $user['nama'],
            'username'   => $user['username'],
            'role'       => $user['role'],
            'sppg_id'    => $sppgId,
            'sppg_nama'  => $sppgName,
            'sppg_alamat'=> $sppgAlamat,
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }
}
