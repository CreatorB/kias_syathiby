<?php

namespace App\Services;

use App\Models\Santri;

class CariNamaService {
    public function dataUpdate($request) {
        $hp = $request->noHp;
        $kodeNegara = $request->kodeNegara;

        //Cek input nomor HP
        $str_nomor = substr($hp, 0, 1);
        if ($str_nomor == 0) {
            $noHp = substr($hp, 1);
        } else {
            $noHp = $hp;
        }
        $nomorHp = $kodeNegara.$noHp;

        $data = [
            'nama' => $request->nama,
            'jk' => $request->jk,
            'tmp_lahir' => $request->tmpLahir,
            'tgl_lahir' => $request->tglLahir,
            'alamat' => $request->alamat,
            'pendidikan' => $request->pendidikan,
            'pekerjaan_id' => $request->pekerjaanId,
            'email' => $request->email,
            'kode_negara' => $request->kodeNegara,
            'no_hp' => $noHp,
            'hp' => $nomorHp,
            'tahun_psb' => $request->tahunPsb,
            'program_id' => $request->programId,
        ];

        return $data;
    }
}
