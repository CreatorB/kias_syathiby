<?php

namespace App\Http\Requests\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class FormSantriBaruRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
        return $request->validate([
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

    }
}
