<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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
     */
    protected function findUserByIdentifier(string $identifier): ?User
    {
        $identifier = trim($identifier);

        // First, try to find by email (case-insensitive)
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($identifier)])->first();

        if ($user) {
            return $user;
        }

        // If not found by email, try phone number with all variants
        $phoneVariants = $this->normalizePhone($identifier);

        return User::where(function ($query) use ($phoneVariants) {
            foreach ($phoneVariants as $phone) {
                $query->orWhere('phone', $phone);
            }
        })->first();
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

        if (Auth::attempt(['email' => $user->email, 'password' => $inputPassword])) {
            // Save login credentials if requested
            if ($request->has('simpanpwd')) {
                Cookie::queue('saveuser', $request->email, 40160);
                Cookie::queue('savepwd', $request->password, 40160);
            }

            // Redirect based on role
            $roleId = auth()->user()->role_id;

            if (in_array($roleId, [1, 2])) {
                // Admin/Superadmin -> Admin Dashboard
                return redirect()->route('admin::dashboard');
            } elseif ($roleId == 3) {
                // Santri -> Home
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                // Peserta (role 4) -> Events Dashboard
                return redirect()->route('dashboard::events');
            }
        } else {
            return redirect()->route('login')->with('flash_message_error', 'Password salah untuk akun: ' . $user->email);
        }
    }
}
