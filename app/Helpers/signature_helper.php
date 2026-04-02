<?php

declare(strict_types=1);

/**
 * Gambar di dokumen cetak/PDF browser: src URL absolut sering tidak termuat saat print.
 * Data URI memuat byte gambar langsung di HTML sehingga selalu ikut tercetak.
 */

if (!function_exists('public_asset_data_uri')) {
    function public_asset_data_uri(?string $relativePath): string
    {
        if ($relativePath === null || $relativePath === '') {
            return '';
        }

        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
        $full         = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

        if (! is_file($full)) {
            return '';
        }

        $raw = @file_get_contents($full);
        if ($raw === false) {
            return '';
        }

        $mime = 'image/png';
        if (function_exists('mime_content_type')) {
            $detected = @mime_content_type($full);
            if (is_string($detected) && str_starts_with($detected, 'image/')) {
                $mime = $detected;
            }
        }

        return 'data:' . $mime . ';base64,' . base64_encode($raw);
    }
}

if (!function_exists('signature_data_uri')) {
    /**
     * File TTD (user_signatures atau tabel signatures): kolom berisi nama file saja,
     * atau path relatif dari public (mis. uploads/signatures/xxx.png).
     */
    function signature_data_uri(?array $signature, string $field): string
    {
        if (empty($signature) || empty($signature[$field])) {
            return '';
        }

        $v = ltrim(str_replace('\\', '/', (string) $signature[$field]), '/');
        if (str_starts_with($v, 'uploads/')) {
            return public_asset_data_uri($v);
        }

        return public_asset_data_uri('uploads/signatures/' . $v);
    }
}

if (!function_exists('signature_data_uri_first')) {
    /**
     * Ambil data URI TTD dari field pertama yang terisi (urutan prioritas).
     * Berguna untuk fallback: mis. tampilkan TTD aslap jika peran lain belum diunggah.
     *
     * @param list<string> $fields
     */
    function signature_data_uri_first(?array $signature, string ...$fields): string
    {
        foreach ($fields as $field) {
            $u = signature_data_uri($signature ?? [], $field);
            if ($u !== '') {
                return $u;
            }
        }

        return '';
    }
}

if (!function_exists('signature_row_for_pdf')) {
    /**
     * Baris user_signatures untuk cetak PDF: prioritas TTD aslap SPPG (session),
     * lalu pembuat dokumen, lalu user login. Dipakai semua role agar TTD aslap konsisten.
     */
    function signature_row_for_pdf(?int $createdByUserId): ?array
    {
        $model = new \App\Models\UserSignatureModel();

        $fetch = static function (int $uid) use ($model): ?array {
            if ($uid <= 0) {
                return null;
            }

            return $model->where('user_id', $uid)->first();
        };

        $sppgId = session()->get('sppg_id');
        if ($sppgId) {
            $aslap = \Config\Database::connect()->table('users')
                ->select('id')
                ->where('sppg_id', $sppgId)
                ->where('role', 'aslap')
                ->orderBy('id', 'ASC')
                ->limit(1)
                ->get()
                ->getRowArray();
            if ($aslap !== null) {
                $row = $fetch((int) $aslap['id']);
                if ($row !== null) {
                    return $row;
                }
            }
        }

        if ($createdByUserId !== null && $createdByUserId > 0) {
            $row = $fetch($createdByUserId);
            if ($row !== null) {
                return $row;
            }
        }

        $uid = session()->get('user_id');
        if ($uid) {
            return $fetch((int) $uid);
        }

        return null;
    }
}

if (!function_exists('signature_data_uri_with_aslap_fallback')) {
    /**
     * Coba field pada baris utama (mis. tabel signatures); jika kosong, pakai TTD dari user_signatures (aslap).
     */
    function signature_data_uri_with_aslap_fallback(?array $primaryRow, ?array $aslapFallbackRow, string $primaryField): string
    {
        $u = signature_data_uri($primaryRow ?? [], $primaryField);
        if ($u !== '') {
            return $u;
        }

        return signature_data_uri_first($aslapFallbackRow ?? [], 'ttd_aslap', 'ttd_akuntan', 'ttd_ahli_gizi', 'ttd_kepala_sppg');
    }
}
