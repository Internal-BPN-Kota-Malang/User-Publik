<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Daftar email yang diizinkan mengakses halaman admin.
     * Tambahkan email admin resmi kantor di sini.
     */
    protected array $allowedEmails = [
        'amaliavina34@gmail.com',
        // tambahkan email admin lain di sini
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->email, $this->allowedEmails)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }

    /**
     * Dipanggil dari AdminController->pengguna() untuk menandai
     * user mana saja yang berstatus admin di halaman Data Pengguna.
     */
    public function getAllowedEmails(): array
    {
        return $this->allowedEmails;
    }
}