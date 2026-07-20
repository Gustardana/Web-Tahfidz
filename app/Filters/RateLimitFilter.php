<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filter Rate Limiter (Brute Force Protection)
 * 
 * Melindungi titik-titik krusial (seperti form Login) dari serangan percobaan berulang 
 * (Brute Force/DDoS level aplikasi).
 */
class RateLimitFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $throttler = \Config\Services::throttler();
        
        // Parameter dinamis dari routes (misal: rateLimit:5,60)
        $limit = $arguments[0] ?? 5;  // Default: Maks 5 request
        $time  = $arguments[1] ?? 60; // Default: Dalam 60 detik
        
        // Hash IP Address menggunakan md5 agar terhindar dari karakter ilegal 
        // seperti titik dua (:) pada alamat IPv6 (contoh: ::1 di localhost)
        $throttleKey = md5($request->getIPAddress());
        
        if ($throttler->check($throttleKey, $limit, $time) === false) {
            
            // Catat log keamanan
            log_message('emergency', 'BRUTE FORCE ALERT: IP Address ' . $request->getIPAddress() . ' diblokir sementara.');
            
            // Graceful Degradation
            if ($request->isAJAX() || strpos($request->getHeaderLine('Accept'), 'application/json') !== false) {
                return \Config\Services::response()->setJSON([
                    'error' => '429 Too Many Requests', 
                    'message' => 'Anda mencoba terlalu sering. Harap tunggu beberapa saat.'
                ])->setStatusCode(429);
            }

            return \Config\Services::response()->setBody('
                <div style="font-family:sans-serif;text-align:center;padding:50px;">
                    <h1 style="color:#ef4444;">429 Too Many Requests</h1>
                    <p>Sistem keamanan kami mendeteksi terlalu banyak permintaan dari jaringan Anda. Harap tunggu sebentar sebelum mencoba lagi.</p>
                </div>
            ')->setStatusCode(429);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
