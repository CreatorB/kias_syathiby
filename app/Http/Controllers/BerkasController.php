<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Support\Facades\Auth;

/**
 * Akses berkas di public/berkas lewat Laravel (public/.htaccess mengarahkan /berkas/* ke sini),
 * supaya KTP, foto, dan bukti transfer tidak bisa diunduh tanpa login.
 *  - events/images/*            : publik (poster event)
 *  - admin (role 1, 2)          : semua berkas
 *  - santri                     : berkas miliknya ({tahun}/{kode}/{file} atau {tahun}/{file} data lama)
 *  - events/payments/{file}     : pemilik pendaftaran event
 */
class BerkasController extends Controller
{
    public function show(string $path)
    {
        $base = realpath(public_path('berkas'));
        $file = realpath(public_path('berkas/' . $path));
        if (!$base || !$file || !str_starts_with($file, $base . DIRECTORY_SEPARATOR) || !is_file($file)) {
            abort(404);
        }

        $parts = explode('/', str_replace('\\', '/', $path));
        $public = $parts[0] === 'events' && ($parts[1] ?? '') === 'images';

        if (!$public && !$this->allowed($parts)) {
            abort(Auth::check() ? 403 : 404);
        }

        return response()->file($file, [
            'Cache-Control' => $public ? 'public, max-age=86400' : 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    private function allowed(array $parts): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }
        if (in_array((int) $user->role_id, [1, 2], true)) {
            return true;
        }

        $name = end($parts);

        if ($parts[0] === 'events') {
            return ($parts[1] ?? '') === 'payments'
                && EventRegistration::where('user_id', $user->id)->where('payment_proof', $name)->exists();
        }

        $santri = $user->santri;
        if (!$santri) {
            return false;
        }
        if (count($parts) === 3) {
            return (string) $parts[1] === (string) $santri->kode_registrasi;
        }
        if (count($parts) === 2) {
            return in_array($name, array_filter([$santri->photo, $santri->ktp, $santri->transfer]), true);
        }

        return false;
    }
}
