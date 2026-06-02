<?php

namespace App\Services;

use App\Models\Santri;
use App\Providers\StatusProvider;

class SantriService
{
    //Hitug total pemasukan PSB
    public function nominalTransferValid($tahunPsb) {
        return Santri::queryPendaftaran($tahunPsb)
        ->where('status_transfer', StatusProvider::TRANSFER_VALID)
        ->sum('nominal_transfer');
    }

    //Hitung bukti transfer yg belum diverifikasi
    public function verifikasiTransfer($tahunPsb) {
        return Santri::queryPendaftaran($tahunPsb)
        ->where('status_transfer', StatusProvider::TRANSFER_PROSES)
        ->count();
    }

    //Hitung total Santi transfer valid
    public function totalTransferValid($tahunPsb) {
        return Santri::queryPendaftaran($tahunPsb)
        ->where('status_transfer', StatusProvider::TRANSFER_VALID)
        ->count();
    }

    //Hitung total Santi transfer valid
    public function totalTransferInvalid($tahunPsb) {
        return Santri::queryPendaftaran($tahunPsb)
        ->where('status_transfer', StatusProvider::TRANSFER_INVALID)
        ->count();
    }

    //Tampilkan semua status transfer pendaftar
    public function paginateVerifikasiTransfer($tahunPsb, $limitData, $filterData = null) {
        return Santri::queryPendaftaran($tahunPsb, $filterData)
        ->orderBy('id', 'desc')
        ->paginate($limitData);
    }

    //Tampilkan semua Santi yang sudah lunas pembayaran
    public function paginateSantriInduk($tahunPsb, $limitData, $filterData = null) {
        return Santri::queryPendaftaran($tahunPsb, $filterData)
        ->where('status_transfer', StatusProvider::TRANSFER_VALID)
        ->orderBy('nama', 'asc')
        ->paginate($limitData);
    }

    //Hitung total Santi transfer valid
    public function totalSantriInduk($tahunPsb, $filterData = null) {
        return Santri::queryPendaftaran($tahunPsb, $filterData)
        ->where('status_transfer', StatusProvider::TRANSFER_VALID)
        ->count();
    }

    //Hitung total Santi ikhwan transfer valid
    public function totalSantriIkhwan($tahunPsb, $filterData = null) {
        return Santri::queryPendaftaran($tahunPsb, $filterData)
        ->where('status_transfer', StatusProvider::TRANSFER_VALID)
        ->where('jk', 'Laki-Laki')
        ->count();
    }

    //Hitung total Santi akhwat transfer valid
    public function totalSantriAkhwat($tahunPsb, $filterData = null) {
        return Santri::queryPendaftaran($tahunPsb, $filterData)
        ->where('status_transfer', StatusProvider::TRANSFER_VALID)
        ->where('jk', 'Perempuan')
        ->count();
    }

    //Hitung total bukti transfer by jk
    public function totalTransferByJk($tahunPsb, $jk) {
        return Santri::queryPendaftaran($tahunPsb)
        ->where('jk', $jk)
        ->count();
    }

    //Hitung total bukti transfer by status
    public function totalTransferByStatus($tahunPsb, $status) {
        return Santri::queryPendaftaran($tahunPsb)
        ->where('status_transfer', $status)
        ->count();
    }

    //Hitung bukti transfer by jk and status
    public function totalTransferByJkAndStatus($tahunPsb, $jk, $status) {
        return Santri::queryPendaftaran($tahunPsb)
        ->where('jk', $jk)
        ->where('status_transfer', $status)
        ->count();
    }

}