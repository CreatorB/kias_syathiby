<?php

namespace App\Http\Controllers\Santri;

use App\Models\Santri;
use App\Models\User;
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
use Illuminate\Support\Facades\Log;

class DaftarController extends Controller
{
    public function __construct(InfoPsbService $info, DaftarService $daftar)
    {
        $this->tahunAjaran = $info->tahunPsb();
        $this->DaftarService = $daftar;
        $this->infoPsbService = $info;
    }

    public function pilihProgram() {
        $psb = $this->infoPsbService->psbAktif();

        $data = [
            'title' => 'Pilih Program',
            'lembaga' => Lembaga::find(1),
            'psb' => $psb,
            'tajwid' => Program::daftarTajwid($this->tahunAjaran),
            'bahasaArab' => Program::daftarBahasa($this->tahunAjaran),
            'takmili' => Program::daftarTakmili($this->tahunAjaran),
            'syariah' => Program::daftarSyariah($this->tahunAjaran),
        ];

        return view('santri.pilih_program', $data);
    }

    //Formulir Online
    public function create($id) {
        $psb = $this->infoPsbService->psbAktif();

        if (!$psb || !$psb->isOpen()) {
            return redirect('/pilih-program')->with('error', 'Pendaftaran sudah ditutup.');
        }

        $program = Program::find($id);

        if (!$program || $program->status_psb !== 'Buka') {
            return redirect('/pilih-program')->with('error', 'Program tidak tersedia.');
        }

        $data = [
            'title' => 'Formulir Online',
            'lembaga' => Lembaga::find(1),
            'program' => $program,
            'pekerjaan' => Pekerjaan::all(),
            'kodeNegara' => KodeNegara::all(),
            'tahunPsb' => $this->tahunAjaran,
            'psb' => $psb,
        ];

        return view('santri.formulir_online', $data);
    }

//Simpan Formulir Pendaftaran
    public function store(Request $request) {
        $tahunPsb = $this->tahunAjaran;
        $psb = $this->infoPsbService->psbAktif();

        if (!$psb || !$psb->isOpen()) {
            return redirect('/pilih-program')->with('error', 'Pendaftaran sudah ditutup.');
        }

        if (!$psb->canRegister($request->jk)) {
            $gender = $request->jk === 'Laki-Laki' ? 'Ikhwan' : 'Akhwat';
            return redirect('/pilih-program')->with('error', "Mohon maaf, kuota pendaftaran {$gender} sudah penuh.");
        }

        $cekSantriTerdaftar = $this->DaftarService->cekSantriTerdaftar($tahunPsb, $request);

        if($cekSantriTerdaftar == 0) {
            $request->validate([
                'noInduk' => 'nullable|string|max:50',
                'nik' => 'nullable|string|max:16',
                'nisn' => 'nullable|string|max:10',
                'nama' => 'required|string|min:3|max:100',
                'jk' => 'required|in:Laki-Laki,Perempuan',
                'tmpLahir' => 'required|string|max:50',
                'tglLahir' => 'required|date|before:today|after:1950-01-01',
                'alamat' => 'required|string|min:10|max:500',
                'namaAyah' => 'nullable|string|max:100',
                'noHpAyah' => 'nullable|digits_between:8,15',
                'pendidikan' => 'required|string',
                'pekerjaanId' => 'required|integer|exists:pekerjaan,id',
                'email' => 'required|email|max:100',
                'kodeNegara' => 'required|integer',
                'noHp' => 'required|digits_between:8,15',
                'programId' => 'required|integer|exists:program,id',
                'tahunPsb' => 'required|string',
                'nominalTransfer' => 'required|numeric',
                'photo' => 'required|image|mimes:jpg,jpeg,png,bmp|max:1024|dimensions:min_width=100,min_height=100',
                'ktp' => 'required|image|mimes:jpg,jpeg,png,bmp|max:1024|dimensions:min_width=100,min_height=100',
                'transfer' => 'required|image|mimes:jpg,jpeg,png,bmp|max:1024|dimensions:min_width=100,min_height:100',
            ],[
                'noInduk.max' => 'Nomor Induk maksimal 50 karakter',
                'nik.max' => 'NIK maksimal 16 digit',
                'nisn.max' => 'NISN maksimal 10 digit',
                'nama.required' => 'Nama lengkap wajib diisi',
                'nama.min' => 'Nama minimal 3 karakter',
                'nama.max' => 'Nama maksimal 100 karakter',
                'jk.required' => 'Jenis kelamin wajib dipilih',
                'jk.in' => 'Jenis kelamin tidak valid',
                'tmpLahir.required' => 'Tempat lahir wajib diisi',
                'tmpLahir.max' => 'Tempat lahir maksimal 50 karakter',
                'tglLahir.required' => 'Tanggal lahir wajib diisi',
                'tglLahir.date' => 'Format tanggal lahir tidak valid',
                'tglLahir.before' => 'Tanggal lahir harus sebelum hari ini',
                'alamat.required' => 'Alamat wajib diisi',
                'alamat.min' => 'Alamat minimal 10 karakter',
                'alamat.max' => 'Alamat maksimal 500 karakter',
                'namaAyah.max' => 'Nama ayah maksimal 100 karakter',
                'noHpAyah.digits_between' => 'Nomor HP ayah harus 8-15 digit',
                'pendidikan.required' => 'Pendidikan terakhir wajib dipilih',
                'pekerjaanId.required' => 'Pekerjaan wajib dipilih',
                'pekerjaanId.exists' => 'Pekerjaan tidak valid',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'noHp.required' => 'Nomor WhatsApp wajib diisi',
                'noHp.digits_between' => 'Nomor WhatsApp harus 8-15 digit',
                'photo.required' => 'Pas photo wajib diupload',
                'photo.image' => 'File harus berupa gambar',
                'photo.mimes' => 'Format file harus jpg, jpeg, png, atau bmp',
                'photo.max' => 'Ukuran file maksimal 1 MB',
                'photo.dimensions' => 'Ukuran gambar terlalu kecil (min 100x100 pixel)',
                'ktp.required' => 'KTP/Kartu identitas wajib diupload',
                'ktp.image' => 'File harus berupa gambar',
                'ktp.mimes' => 'Format file harus jpg, jpeg, png, atau bmp',
                'ktp.max' => 'Ukuran file maksimal 1 MB',
                'ktp.dimensions' => 'Ukuran gambar terlalu kecil (min 100x100 pixel)',
                'transfer.required' => 'Bukti transfer wajib diupload',
                'transfer.image' => 'File harus berupa gambar',
                'transfer.mimes' => 'Format file harus jpg, jpeg, png, atau bmp',
                'transfer.max' => 'Ukuran file maksimal 1 MB',
                'transfer.dimensions' => 'Ukuran gambar terlalu kecil (min 100x100 pixel)',
            ]);

            $kodeRegistrasi = $this->DaftarService->kodeRegistrasi($tahunPsb);

            $sanitizeName = function($name) use ($kodeRegistrasi) {
                $clean = preg_replace('/[^a-zA-Z0-9]/', '_', $name);
                return $kodeRegistrasi . '_' . $clean . '_' . time();
            };

            $filePhoto = $request->photo;
            $filenamePhoto = $sanitizeName('Photo') . '.' . strtolower($filePhoto->extension());
            $uploadPhoto = $filePhoto->move(public_path('berkas/'.$tahunPsb.'/'), $filenamePhoto);

            $fileKtp = $request->ktp;
            $filenameKtp = $sanitizeName('Ktp') . '.' . strtolower($fileKtp->extension());
            $uploadKtp = $fileKtp->move(public_path('berkas/'.$tahunPsb.'/'), $filenameKtp);

            $fileTransfer = $request->transfer;
            $filenameTransfer = $sanitizeName('Transfer') . '.' . strtolower($fileTransfer->extension());
            $uploadTransfer = $fileTransfer->move(public_path('berkas/'.$tahunPsb.'/'), $filenameTransfer);

            $dataSantri = $this->DaftarService->dataSantri($request, $filenamePhoto, $filenameKtp,
            $filenameTransfer, $kodeRegistrasi);

            $namaLengkap = $request->nama;

            if(($uploadPhoto) && ($uploadKtp) && ($uploadTransfer)) {
                $santri = Santri::create($dataSantri);

                try {
                    $user = User::create([
                        'nama' => $santri->nama,
                        'email' => $santri->email,
                        'password' => bcrypt($kodeRegistrasi),
                        'role_id' => 4,
                        'phone' => $santri->hp,
                        'is_active' => false,
                        'santri_id' => $santri->id,
                    ]);
                } catch (\Exception $e) {
                    Log::error('User creation failed: ' . $e->getMessage());
                    // Continue with redirect even if user creation fails
                }

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
