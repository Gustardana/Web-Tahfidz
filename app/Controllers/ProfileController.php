<?php
namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('id'));

        $data = [
            'title' => 'Profil Saya',
            'user'  => $user
        ];

        return view('pages/profile/index', $data);
    }

    public function update()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $userModel = new UserModel();
        $id = session()->get('id');

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'foto_profil'  => 'max_size[foto_profil,2048]|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $updateData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
        ];

        // Jika password diisi, maka update password
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Upload foto profil
        $file = $this->request->getFile('foto_profil');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profile', $newName);
            
            // Hapus foto lama jika ada
            $oldUser = $userModel->find($id);
            if (!empty($oldUser['foto_profil']) && file_exists(FCPATH . 'uploads/profile/' . $oldUser['foto_profil'])) {
                unlink(FCPATH . 'uploads/profile/' . $oldUser['foto_profil']);
            }
            
            $updateData['foto_profil'] = $newName;
            
            // Update session foto_profil
            session()->set('foto_profil', $newName);
        }

        // Update session nama_lengkap
        session()->set('nama_lengkap', $updateData['nama_lengkap']);

        $userModel->update($id, $updateData);

        \App\Libraries\ActivityLogger::log('UPDATE_PROFILE', 'Memperbarui data profil');
        
        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
