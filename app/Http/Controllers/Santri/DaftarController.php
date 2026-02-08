<?php

namespace App\Http\Controllers\Santri;

use App\Models\Santri;
use App\Models\InfoPsb;
use App\Models\Lembaga;
use App\Models\Program;
use App\Models\Pekerjaan;
use App\Models\KodeNegara;
use Illuminate\Http\Request;
use App\Services\DaftarService;
use App\Services\InfoPsbService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Requests\FormSantriBaruRequest;
use Carbon\Carbon;

class DaftarController extends Controller
{
    public function __construct(InfoPsbService $info, DaftarService $daftar)
    {
        $this->tahunAjaran = $info->tahunPsb();
        $this->DaftarService = $daftar;
        $this->infoPsbService = $info;
    }

    public function pilihProgram() {
        $data = [
            'title' => 'Pilih Program',
            'lembaga' => Lembaga::find(1),
            'psb' => $this->infoPsbService->psbAktif(),
            'tajwid' => Program::daftarTajwid($this->tahunAjaran),
            'bahasaArab' => Program::daftarBahasa($this->tahunAjaran),
            'takmili' => Program::daftarTakmili($this->tahunAjaran),
            'syariah' => Program::daftarSyariah($this->tahunAjaran),
        ];

        return view('santri.pilih_program', $data);
    }

    //Formulir Online
    public function create($id) {
        $data = [
            'title' => 'Formulir Online',
            'lembaga' => Lembaga::find(1),
            'program' => Program::find($id),
            'pekerjaan' => Pekerjaan::all(),
            'kodeNegara' => KodeNegara::all(),
            'tahunPsb' => $this->tahunAjaran,
            'psb' => $this->infoPsbService->psbAktif(),
        ];

        return view('santri.formulir_online', $data);
    }

    //Simpan Formulir Pendaftaran
    public function store(Request $request) {
        $date = date('Y-m-d H-i-s');
        $tahunPsb = $this->tahunAjaran;

        //Logic untuk kode registrasi
        $kodeRegistrasi = $this->DaftarService->kodeRegistrasi($tahunPsb);

        //Cek apakah data sudah ada
        $cekSantriTerdaftar = $this->DaftarService->cekSantriTerdaftar($tahunPsb, $request);

        if($cekSantriTerdaftar == 0) {
            $request->validate([
                'photo' => 'required|mimes:jpg,jpeg,png,bmp|max:1024',
                'ktp' => 'required|mimes:jpg,jpeg,png,bmp|max:1024',
                'transfer' => 'required|mimes:jpg,jpeg,png,bmp|max:1024',
            ],[
                'photo.required' => 'Wajib diisi',
                'photo.mimes' => 'File harus format gambar: jpg,jpeg,png,bmp',
                'photo.max' => 'File yang anda upload lebih dari 1 MB, silahkan upload ulang!',
                'ktp.required' => 'Wajib diisi',
                'ktp.mimes' => 'File harus format gambar: jpg,jpeg,png,bmp',
                'ktp.max' => 'File yang anda upload lebih dari 1 MB, silahkan upload ulang!',
                'transfer.required' => 'Wajib diisi',
                'transfer.mimes' => 'File harus format gambar: jpg,jpeg,png,bmp',
                'transfer.max' => 'File yang anda upload lebih dari 1 MB, silahkan upload ulang!',
            ]);

            //Upload file photo
            $jenisPhoto = 'Photo';
            $filePhoto = $request->photo;
            $filenamePhoto = $date.$jenisPhoto.'.'.$filePhoto->extension();
            $uploadPhoto = $filePhoto->move(public_path('berkas/'.$tahunPsb.'/'), $filenamePhoto);

            //Upload File KTP
            $jenisKtp = 'Ktp';
            $fileKtp = $request->ktp;
            $filenameKtp = $date.$jenisKtp.'.'.$fileKtp->extension();
            $uploadKtp = $fileKtp->move(public_path('berkas/'.$tahunPsb.'/'), $filenameKtp);

            //Upload File Bukti Transfer
            $jenisTransfer = 'Transfer';
            $fileTransfer = $request->transfer;
            $filenameTransfer = $date.$jenisTransfer.'.'.$fileTransfer->extension();
            $uploadTransfer = $fileTransfer->move(public_path('berkas/'.$tahunPsb.'/'), $filenameTransfer);

            $dataSantri = $this->DaftarService->dataSantri($request, $filenamePhoto, $filenameKtp,
            $filenameTransfer, $kodeRegistrasi);

            $namaLengkap = $request->nama;

            if(($uploadPhoto) && ($uploadKtp) && ($uploadTransfer)) {
                Santri::create($dataSantri);
                return redirect()->route('suksesDaftarSantri', [
                    'namaLengkap' => $namaLengkap,
                    'kodeRegistrasi' => $kodeRegistrasi,
                    ])->with('SuksesDaftar', 'Sukses');
            } else {
                return redirect()->route('isiForm.create')->with('GagalUpload', 'Error');
            }

        } else {
            $dataTerdaftar = $this->DaftarService->dataTerdaftar($tahunPsb, $request);
            $tglDaftar = $dataTerdaftar->created_at;
            $tgl = Carbon::parse($tglDaftar);
            $tanggalIndo = $tgl->isoFormat('D MMMM Y');
            $jamIndo = $tgl->format('H:i:s');

            return redirect()->route('isiFormError',[
                'nama' => $dataTerdaftar->nama,
                'jk' => $dataTerdaftar->jk,
                'hp' => $dataTerdaftar->hp,
                'programPilihan' => $dataTerdaftar->nama_program,
                'tgl' => $tanggalIndo,
                'jam' => $jamIndo,
                'idProgram' => $dataTerdaftar->program_id,
            ])->with('DataSudahAda', 'Error');
        }
    }

    //Error isi form
    public function errorDaftar(Request $request) {
        $idProgram = $request->idProgram;
        $data = [
            'title' => 'Formulir Online',
            'lembaga' => Lembaga::find(1),
            'program' => Program::find($idProgram),
            'pekerjaan' => Pekerjaan::all(),
            'kodeNegara' => KodeNegara::all(),
            'tahunPsb' => $this->tahunAjaran,
            'psb' => InfoPsb::find(1),
            'nama' => $request->nama,
            'jk' => $request->jk,
            'hp' => $request->hp,
            'programPilihan' => $request->programPilihan,
            'tgl' => $request->tgl,
            'jam' => $request->jam,
        ];

        return view('santri.formulir_online', $data);
    }

    public function suksesDaftar(Request $request) {

        if($request->has('kodeRegistrasi')) {
            $namaLengkap = $request->namaLengkap;
            $kodeRegistrasi = $request->kodeRegistrasi;
            $berhasil = 1;
        } else {
            $namaLengkap = '';
            $kodeRegistrasi = '';
            $berhasil = 0;
        }

        $data = [
            'title' => 'Sukses Daftar',
            'lembaga' => Lembaga::find(1),
            'namaLengkap' => $namaLengkap,
            'kodeRegistrasi' => $kodeRegistrasi,
            'berhasil' => $berhasil
        ];

        return view('santri.sukses_daftar', $data);
    }
}
