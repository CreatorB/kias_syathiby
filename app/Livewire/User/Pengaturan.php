<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

#[Title('Pengaturan Akun')]
class Pengaturan extends Component
{
    // User Profile fields
    public $nama = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $gender = '';
    public $birth_place = '';
    public $birth_date = '';
    public $occupation = '';

    // Santri fields
    public $santri_id = null;
    public $nik = '';
    public $nisn = '';
    public $tmp_lahir = '';
    public $tgl_lahir = '';
    public $alamat = '';
    public $no_hp = '';
    public $kode_negara = '62';
    public $nama_ayah = '';
    public $no_hp_ayah = '';
    public $nama_ibu = '';
    public $no_hp_ibu = '';
    public $nama_wali = '';
    public $no_hp_wali = '';
    public $pendidikan = '';
    public $pekerjaan = '';
    public $has_santri = false;

    // Password fields
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    public function mount()
    {
        $user = Auth::user();

        // User fields
        $this->nama = $user->nama ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->gender = $user->gender ?? '';
        $this->birth_place = $user->birth_place ?? '';
        $this->birth_date = $user->birth_date ? $user->birth_date->format('Y-m-d') : '';
        $this->occupation = $user->occupation ?? '';

        // Santri fields
        $santri = $user->santri;
        if (!$santri) {
            $santri = \App\Models\Santri::where('email', $user->email)->first();
        }

        if ($santri) {
            $this->has_santri = true;
            $this->santri_id = $santri->id;
            $this->nik = $santri->nik ?? '';
            $this->nisn = $santri->nisn ?? '';
            $this->tmp_lahir = $santri->tmp_lahir ?? '';
            $this->tgl_lahir = $santri->tgl_lahir ? \Carbon\Carbon::parse($santri->tgl_lahir)->format('Y-m-d') : '';
            $this->alamat = $santri->alamat ?? '';
            $this->no_hp = $santri->no_hp ?? '';
            $this->kode_negara = $santri->kode_negara ?? '62';
            $this->nama_ayah = $santri->nama_ayah ?? '';
            $this->no_hp_ayah = $santri->no_hp_ayah ?? '';
            $this->nama_ibu = $santri->nama_ibu ?? '';
            $this->no_hp_ibu = $santri->no_hp_ibu ?? '';
            $this->nama_wali = $santri->nama_wali ?? '';
            $this->no_hp_wali = $santri->no_hp_wali ?? '';
            $this->pendidikan = $santri->pendidikan ?? '';
            $this->pekerjaan = $santri->pekerjaan ?? '';
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:Laki-Laki,Perempuan',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'occupation' => 'nullable|string|max:100',
            // Santri validations
            'nik' => 'nullable|string|size:16',
            'nisn' => 'nullable|string|size:10',
            'tmp_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date|before:today',
            'alamat' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:20',
            'kode_negara' => 'nullable|string|max:10',
            'nama_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:100',
            'no_hp_ibu' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string|max:100',
            'no_hp_wali' => 'nullable|string|max:20',
            'pendidikan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'nik.size' => 'NIK harus 16 digit.',
            'nisn.size' => 'NISN harus 10 digit.',
            'tgl_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
        ]);

        // Update User
        $user = Auth::user();
        $user->update([
            'nama' => $this->nama,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'address' => $this->address ?: null,
            'gender' => $this->gender ?: null,
            'birth_place' => $this->birth_place ?: null,
            'birth_date' => $this->birth_date ?: null,
            'occupation' => $this->occupation ?: null,
        ]);

        // Update Santri if exists
        if ($this->has_santri && $this->santri_id) {
            $hp = $this->no_hp;
            $str_nomor = substr($hp, 0, 1);
            if ($str_nomor == '0') {
                $noHp = substr($hp, 1);
            } else {
                $noHp = $hp;
            }
            $nomorHp = $this->kode_negara . $noHp;

            \App\Models\Santri::where('id', $this->santri_id)->update([
                'nik' => $this->nik ?: null,
                'nisn' => $this->nisn ?: null,
                'tmp_lahir' => $this->tmp_lahir ?: null,
                'tgl_lahir' => $this->tgl_lahir ?: null,
                'alamat' => $this->alamat ?: null,
                'no_hp' => $noHp ?: null,
                'hp' => $nomorHp ?: null,
                'kode_negara' => $this->kode_negara ?: '62',
                'nama_ayah' => $this->nama_ayah ?: null,
                'no_hp_ayah' => $this->no_hp_ayah ?: null,
                'nama_ibu' => $this->nama_ibu ?: null,
                'no_hp_ibu' => $this->no_hp_ibu ?: null,
                'nama_wali' => $this->nama_wali ?: null,
                'no_hp_wali' => $this->no_hp_wali ?: null,
                'pendidikan' => $this->pendidikan ?: null,
                'pekerjaan' => $this->pekerjaan ?: null,
            ]);
        }

        session()->flash('profile_success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Password lama tidak sesuai.');
            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('password_success', 'Password berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.user.pengaturan')
            ->layout('layouts.app', ['title' => 'Pengaturan Akun']);
    }
}
