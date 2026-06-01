<?php

namespace App\Helpers;

class FotoHelper
{
    public static function getPathFoto($tahunPsb, $kodeRegistrasi, $namaFile, $placeholder = 'images/placeholder.png')
    {
        if (!$namaFile) {
            return asset($placeholder);
        }

        $newPath = "berkas/{$tahunPsb}/{$kodeRegistrasi}/{$namaFile}";
        if (file_exists(public_path($newPath))) {
            return asset($newPath);
        }

        $oldPath = "berkas/{$tahunPsb}/{$namaFile}";
        if (file_exists(public_path($oldPath))) {
            return asset($oldPath);
        }

        return asset($placeholder);
    }
}
