<?php

namespace App\Controllers;

use App\Models\UserSignatureModel;

class SignatureController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $signatureModel = new UserSignatureModel();
        
        $data['title'] = 'Pengaturan Tanda Tangan';
        $data['signature'] = $signatureModel->where('user_id', $userId)->first();
        
        return view('signatures/index', $data);
    }

    public function store()
    {
        $userId = session()->get('user_id');
        $signatureModel = new UserSignatureModel();
        $existing = $signatureModel->where('user_id', $userId)->first();

        $dataToSave = ['user_id' => $userId];
        $uploadPath = ROOTPATH . 'public/uploads/signatures';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fields = ['ttd_aslap', 'ttd_kepala_sppg', 'ttd_ahli_gizi', 'ttd_kepala_koki', 'ttd_akuntan'];

        foreach ($fields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);
                
                // Delete old file if exists
                if ($existing && !empty($existing[$field])) {
                    @unlink($uploadPath . '/' . $existing[$field]);
                }
                
                $dataToSave[$field] = $newName;
            }
        }

        if ($existing) {
            $signatureModel->update($existing['id'], $dataToSave);
        } else {
            $signatureModel->insert($dataToSave);
        }

        return redirect()->to('/signatures')->with('success', 'Tanda tangan berhasil diperbarui!');
    }
}
