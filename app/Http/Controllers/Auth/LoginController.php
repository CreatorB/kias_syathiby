<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Normalize phone number to standard format.
     * Converts: 089xxx, +6289xxx, 6289xxx -> all variants for search
     */
    protected function normalizePhone(string $phone): array
    {
        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        $variants = [];

        // Remove + if exists
        $phone = ltrim($phone, '+');

        // If starts with 62, convert to 0
        if (str_starts_with($phone, '62')) {
            $localPhone = '0' . substr($phone, 2);
            $intlPhone = $phone;
        }
        // If starts with 0, also create 62 version
        elseif (str_starts_with($phone, '0')) {
            $localPhone = $phone;
            $intlPhone = '62' . substr($phone, 1);
        }
        // Other formats, use as-is
        else {
            $localPhone = $phone;
            $intlPhone = $phone;
        }

        // Return all possible variants to search
        $variants[] = $localPhone;           // 089xxx
        $variants[] = $intlPhone;            // 6289xxx
        $variants[] = '+' . $intlPhone;      // +6289xxx

        return array_unique($variants);
    }

    /**
     * Find user by email or phone number.
     * Supports:
     * - Email
     * - Phone number (peserta's no_hp)
     * - Phone number (wali's no_hp_ayah via related Santri)
     */
    protected function findUserByIdentifier(string $identifier): ?User
    {
        $identifier = trim($identifier);

        $user = User::whereRaw('LOWER(email) = ?', [strtolower($identifier)])->first();

        if ($user) {
            return $user;
        }

        $phoneVariants = $this->normalizePhone($identifier);

        $userByPhone = User::where(function ($query) use ($phoneVariants) {
            foreach ($phoneVariants as $phone) {
                $query->orWhere('phone', $phone);
            }
        })->first();

        if ($userByPhone) {
            return $userByPhone;
        }

        $normalizedInput = ltrim($identifier, '+');
        if (str_starts_with($normalizedInput, '62')) {
            $localInput = '0' . substr($normalizedInput, 2);
        } else {
            $localInput = $identifier;
        }

        return User::whereHas('santri', function ($query) use ($localInput) {
            $query->where('no_hp_ayah', $localInput);
        })->first();
    }

    /**
     * Check if peserta has a registration for an event happening today.
     */
    protected function pesertaHasEventToday(User $user): bool
    {
        if (!$user->isPeserta()) {
            return false;
        }

        return EventRegistration::where('user_id', $user->id)
            ->whereHas('event', function ($query) {
                $today = now()->toDateString();
                $query->whereIn('status', ['published', 'internal'])
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            })
            ->exists();
    }

    public function login(Request $request)
    {
        $inputIdentifier = trim($request->email); // Can be email or phone
        $inputPassword = $request->password;

        // Find user by email or phone
        $user = $this->findUserByIdentifier($inputIdentifier);

        // Debug: Log attempt
        \Log::info('Login attempt', [
            'input' => $inputIdentifier,
            'user_found' => $user ? $user->email : 'NOT FOUND',
            'user_id' => $user?->id,
        ]);

        if (!$user) {
            return redirect()->route('login')->with('flash_message_error', 'User tidak ditemukan dengan email/No.HP: ' . $inputIdentifier);
        }

        if ($user->isBanned()) {
            return redirect()->route('login')->with('flash_message_error', 'Akun Anda diblokir. Hubungi admin untuk informasi lebih lanjut.');
        }

        $authenticated = false;

        // If password provided, try normal authentication
        if (!empty($inputPassword)) {
            $authenticated = Auth::attempt(['email' => $user->email, 'password' => $inputPassword]);
        }

        // If not authenticated via password, check if peserta with today's event (passwordless login)
        if (!$authenticated && $this->pesertaHasEventToday($user)) {
            Auth::login($user);
            $authenticated = true;
        }

        if ($authenticated) {
            // Save login credentials if requested
            if ($request->has('simpanpwd') && !empty($inputPassword)) {
                Cookie::queue('saveuser', $request->email, 40160);
                Cookie::queue('savepwd', $request->password, 40160);
            }

            // Redirect based on role
            $roleId = auth()->user()->role_id;

            if (in_array($roleId, [1, 2])) {
                // Admin/Superadmin -> Admin Dashboard
                return redirect()->route('admin::dashboard');
            } elseif ($roleId == 3) {
                // Santri -> Dashboard
                return redirect()->route('peserta::index');
            } else {
                // Peserta (role 4) -> Events Dashboard
                return redirect()->route('peserta::events');
            }
        } else {
            return redirect()->route('login')->with('flash_message_error', 'Password salah untuk akun: ' . $user->email);
        }
    }
}
