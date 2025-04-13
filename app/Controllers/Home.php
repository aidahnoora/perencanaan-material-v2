<?php

namespace App\Controllers;

use App\Models\ModelUser;
class Home extends BaseController
{
    public function __construct()
    {
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        $data = [
            'judul' => 'Login',
        ];
        return view('v_login', $data);
    }

    public function CekLogin()
    {
        if ($this->validate([
            'email' => [
                'label' => 'E-Mail',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong!',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong!',
                ]
            ],
            
        ])) {
            $email = $this->request->getPost('email');
            $password = sha1($this->request->getPost('password'));
            $cek_login = $this->ModelUser->LoginUser($email, $password);
            if ($cek_login) {
                // Jika login berhasil
                session()->set('id_user', $cek_login['id_user']);
                session()->set('nama_user', $cek_login['nama_user']);
                session()->set('level', $cek_login['level']);
                if ($cek_login['level'] == 1) {
                    return redirect()->to(base_url('Admin'));
                } elseif ($cek_login['level'] == 2) {
                    return redirect()->to(base_url('Manajer'));
                } elseif ($cek_login['level'] == 3) {
                    return redirect()->to(base_url('Perencana'));
                } elseif ($cek_login['level'] == 4) {
                    return redirect()->to(base_url('Gudang'));
                }
            } else {
                // Jika login gagal
                session()->setFlashdata('gagal', 'E-mail atau Password salah!');
                return redirect()->to(base_url('Home'));
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Home'))->withInput('validation',\Config\Services::validation());
        }
    }

    public function Logout()
    {
        session()->remove('id_user');
        session()->remove('nama_user');
        session()->remove('level');
        session()->setFlashdata('pesan', 'Anda telah berhasil Logout!');
        return redirect()->to(base_url('Home'));
    }
}
