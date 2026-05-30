<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class MaintenancePassword
{
    public function handle(Request $request, Closure $next): Response
    {
        $verifiedAt = Session::get('maintenance_password_verified_at', 0);
        $timeout = 10 * 60;

        if (Session::get('maintenance_password_verified') && (now()->timestamp - $verifiedAt) < $timeout) {
            return $next($request);
        }

        $password = $request->input('password', '');

        if (empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password required',
                'requires_password' => true,
            ], 401);
        }

        $maintenancePassword = config('app.maintenance_password');

        if (empty($maintenancePassword)) {
            return response()->json([
                'success' => false,
                'message' => 'Maintenance password not configured',
            ], 403);
        }

        if (!Hash::check($password, $maintenancePassword)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password',
            ], 401);
        }

        Session::put('maintenance_password_verified', true);
        Session::put('maintenance_password_verified_at', now()->timestamp);

        return $next($request);
    }
}
