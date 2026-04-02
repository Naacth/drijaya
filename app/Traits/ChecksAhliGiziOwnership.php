<?php

namespace App\Traits;

trait ChecksAhliGiziOwnership
{
    /**
     * Ahli gizi hanya boleh mengakses/mengubah data yang dibuatnya sendiri (sesuai filter index).
     */
    protected function redirectIfAhliGiziCannotAccessRecord(array $header, string $listUrl): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('role') !== 'ahli_gizi') {
            return null;
        }
        $uid = (int) session()->get('user_id');
        if ((int) ($header['created_by'] ?? 0) !== $uid) {
            return redirect()->to($listUrl)->with('error', 'Anda hanya dapat mengakses data yang Anda buat sendiri.');
        }

        return null;
    }
}
