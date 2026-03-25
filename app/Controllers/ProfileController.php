<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));

        if (!$user) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Pengaturan Profil',
            'user'  => $user
        ];

        return view('profile/index', $data);
    }

    public function update()
    {
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
        ];

        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $rules['password'] = 'required|min_length[6]';
            $rules['confirm_password'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userId = session()->get('user_id');

        $updateData = [
            'nama' => $this->request->getPost('nama'),
        ];

        if (!empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        if ($userModel->update($userId, $updateData)) {
            session()->set('nama', $updateData['nama']);
            return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }
}
