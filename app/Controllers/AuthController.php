<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DiskonModel;
use CodeIgniter\I18n\Time;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $user;

    function __construct()
    {
        helper('form');
        $this->user = new UserModel;
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]|numeric',
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where(['username' => $username])->first();

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                        $sessionData = [
                            'username'   => $dataUser['username'],
                            'role'       => $dataUser['role'],
                            'isLoggedIn' => TRUE
                        ];

                        // Cari diskon untuk hari ini
                        $diskonModel = new DiskonModel();
                        $tanggalHariIni = Time::today()->toDateString(); // Format: YYYY-MM-DD
                        $diskonHariIni = $diskonModel->where('tanggal', $tanggalHariIni)->first();

                        // ika ada diskon, tambahkan ke data session
                        if ($diskonHariIni) {
                            $sessionData['diskon_nominal'] = $diskonHariIni['nominal'];
                        }

                        // Simpan semua data ke session dan redirect
                        session()->set($sessionData);
                        return redirect()->to(base_url('/'));
                        
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }

        return view('v_login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}