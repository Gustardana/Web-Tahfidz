<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filter Role-Based Access Control (RBAC)
 * 
 * Melakukan pemblokiran secara ketat di level Middleware/Filter
 * dan merespons dengan Graceful Degradation (JSON untuk API, Halaman UI untuk Web).
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Validasi Autentikasi
        if (!$session->get('isLoggedIn')) {
            if ($request->isAJAX() || strpos($request->getHeaderLine('Accept'), 'application/json') !== false) {
                return \Config\Services::response()->setJSON(['error' => '401 Unauthorized', 'message' => 'Silakan login terlebih dahulu.'])->setStatusCode(401);
            }
            return redirect()->to('/login')->with('error', 'Sesi telah habis, silakan login kembali.');
        }

        $userRole = $session->get('role');

        // 2. Validasi Hak Akses (Role)
        if ($arguments && !in_array($userRole, $arguments)) {
            
            // Log upaya manipulasi/penerobosan URL (Activity Logging & Security)
            log_message('alert', "Upaya akses ilegal ke rute terbatas oleh User ID: {$session->get('id')} dengan Role: {$userRole}");

            // Graceful Degradation: Respons sesuai tipe request
            if ($request->isAJAX() || strpos($request->getHeaderLine('Accept'), 'application/json') !== false) {
                return \Config\Services::response()->setJSON(['error' => '403 Forbidden', 'message' => 'Hak akses Anda ditolak.'])->setStatusCode(403);
            }
            
            // Hard block menggunakan View Error Kustom (tidak membocorkan stack trace)
            return \Config\Services::response()->setBody(view('errors/html/error_403'))->setStatusCode(403);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
