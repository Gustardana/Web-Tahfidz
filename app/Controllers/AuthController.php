<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\ActivityLogger;

class AuthController extends BaseController
{
    public function index()
    {
        // Jika sudah login, lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('pages/auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        $usersModel = new UserModel();
        $user = $usersModel->where('username', $username)->first();

        // Verifikasi password hash
        if ($user && password_verify($password, $user['password'])) {
            
            // Set session data
            session()->set([
                'id'           => $user['id'],
                'username'     => $user['username'],
                'role'         => $user['role'],
                'nama_lengkap' => $user['nama_lengkap'],
                'isLoggedIn'   => true
            ]);
            
            ActivityLogger::log('LOGIN_SUCCESS', "User {$username} berhasil login.");
            return redirect()->to('/dashboard')->with('success', 'Selamat datang kembali, ' . $user['nama_lengkap']);
        }
        
        ActivityLogger::log('LOGIN_FAILED', "Percobaan login gagal untuk username: {$username}");
        return redirect()->back()->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        ActivityLogger::log('LOGOUT', "User " . session()->get('username') . " melakukan logout.");
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
