<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckCompanyIP
{
    /**
     * Daftar IP yang diizinkan untuk mengakses aplikasi.
     */
    protected $allowedIPs = [
        '192.168.1.6',
        '192.168.1.7',
        '192.168.1.8',
        // '192.168.1.19',
        // '192.168.1.26',
        '192.168.100.187',
        '192.168.100.190'

    ];

    public function handle(Request $request, Closure $next)
    {
        // Log IP pengguna untuk debugging (opsional)
        Log::info('IP Address Detected: ' . $request->ip());

        // Periksa apakah IP pengguna ada dalam daftar yang diizinkan
        if (!in_array($request->ip(), $this->allowedIPs)) {
            // Arahkan kembali dengan pesan SweetAlert jika IP tidak sesuai
            return redirect()->back()->with('error', 'Akses ditolak. Anda harus terhubung ke jaringan perusahaan.');
        }

        return $next($request);
    }
}

class CheckCompanyIPs
{
    /**
     * IP dasar yang diizinkan untuk mengakses aplikasi.
     */
    protected $allowedSubnet = '192.168.1.';

    public function handle(Request $request, Closure $next)
    {
        // Log IP pengguna untuk debugging (opsional)
        Log::info('IP Address Detected: ' . $request->ip());

        // Ambil IP pengguna
        $userIP = $request->ip();

        // Periksa apakah IP pengguna sesuai dengan subnet yang diizinkan
        if (!$this->isAllowedIP($userIP)) {
            // Arahkan kembali dengan pesan SweetAlert jika IP tidak sesuai
            return redirect()->back()->with('error', 'Akses ditolak. Anda harus terhubung ke jaringan perusahaan.');
        }

        return $next($request);
    }

    /**
     * Periksa apakah IP berada dalam rentang yang diizinkan.
     */
    protected function isAllowedIP($ip)
    {
        // Cek apakah IP dimulai dengan $allowedSubnet dan memiliki format yang benar
        $subnet = $this->allowedSubnet;
        return strpos($ip, $subnet) === 0 && filter_var($ip, FILTER_VALIDATE_IP);
    }
}
