<?php

namespace App\Services;

use App\Models\Santri;

class DaftarService {

    public function dataSantri($request, $filenamePhoto, $filenameKtp, $filenameTransfer, $kodeRegistrasi) {

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
            'kode_registrasi' => $kodeRegistrasi,
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
            'photo' => $filenamePhoto,
            'ktp' => $filenameKtp,
            'transfer' => $filenameTransfer,
            'nominal_transfer' => $request->nominalTransfer
        ];

        return $data;
    }

    public function kodeRegistrasi($tahunPsb) {
        //Hitung jumlah pendaftar
        $pendaftar = Santri::where('tahun_psb', $tahunPsb)->count();
        $menit = date('i');
        $detik = date('s');
        $tahun = date('y');
        $urutan = $pendaftar + 1;

        $kode = $tahun.$menit.$detik.$urutan;

        return $kode;
    }

    public function cekSantriTerdaftar($tahunPsb, $request) {
        $hp = $request->noHp;

        //Cek input nomor HP
        $str_nomor = substr($hp, 0, 1);
        if ($str_nomor == 0) {
            $noHp = substr($hp, 1);
        } else {
            $noHp = $hp;
        }

        $nama = $request->nama;
        $tahunPsb = $request->tahunPsb;
        $programId = $request->programId;

        //Cek di database
        $cekData = Santri::where('nama', $nama)
        ->where('no_hp', $noHp)
        ->where('tahun_psb', $tahunPsb)
        ->where('program_id', $programId)
        ->count();

        return $cekData;
    }

    public function dataTerdaftar($tahunPsb, $request) {
        $hp = $request->noHp;

        //Cek input nomor HP
        $str_nomor = substr($hp, 0, 1);
        if ($str_nomor == 0) {
            $noHp = substr($hp, 1);
        } else {
            $noHp = $hp;
        }

        $nama = $request->nama;
        $tahunPsb = $request->tahunPsb;
        $programId = $request->programId;

        $query = Santri::join('program', 'santri.program_id', 'program.id')
        ->where('nama', $nama)
        ->where('no_hp', $noHp)
        ->where('tahun_psb', $tahunPsb)
        ->where('program_id', $programId)
        ->select('santri.*', 'program.nama_program')
        ->firstOrFail();

        return $query;
    }
}
