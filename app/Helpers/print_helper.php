<?php

declare(strict_types=1);

if (! function_exists('format_date_id')) {
    /** Tanggal untuk cetak d/m/Y; kosong jika input kosong/tidak valid. */
    function format_date_id(?string $d): string
    {
        if ($d === null || $d === '') {
            return '';
        }
        $ts = strtotime($d);

        return $ts ? date('d/m/Y', $ts) : '';
    }
}

if (! function_exists('format_date_long_id')) {
    /** Format d F Y (nama bulan Inggris seperti template lama). */
    function format_date_long_id(?string $d): string
    {
        if ($d === null || $d === '') {
            return '';
        }
        $ts = strtotime($d);

        return $ts ? date('d F Y', $ts) : '';
    }
}

if (! function_exists('format_weekday_date_long_id')) {
    /** Format l, d F Y */
    function format_weekday_date_long_id(?string $d): string
    {
        if ($d === null || $d === '') {
            return '';
        }
        $ts = strtotime($d);

        return $ts ? date('l, d F Y', $ts) : '';
    }
}

if (! function_exists('format_time_id')) {
    /** H:i dari datetime string */
    function format_time_id(?string $d): string
    {
        if ($d === null || $d === '') {
            return '';
        }
        $ts = strtotime($d);

        return $ts ? date('H:i', $ts) : '';
    }
}

if (! function_exists('format_dm_hi_id')) {
    /** d/m H:i */
    function format_dm_hi_id(?string $d): string
    {
        if ($d === null || $d === '') {
            return '';
        }
        $ts = strtotime($d);

        return $ts ? date('d/m H:i', $ts) : '';
    }
}
