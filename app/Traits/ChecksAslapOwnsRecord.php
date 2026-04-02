<?php

namespace App\Traits;

trait ChecksAslapOwnsRecord
{
    /**
     * Asisten lapangan hanya boleh mengakses/mengubah data yang dibuatnya sendiri (selaras filter index).
     */
    protected function redirectIfAslapCannotAccessRecord(array $header, string $listUrl): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('role') !== 'aslap') {
            return null;
        }
        $uid = (int) session()->get('user_id');
        if ((int) ($header['created_by'] ?? 0) !== $uid) {
            return redirect()->to($listUrl)->with('error', 'Anda hanya dapat mengakses data yang Anda buat sendiri.');
        }

        return null;
    }
}
