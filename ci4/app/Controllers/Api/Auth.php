<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class Auth extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        try {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            if (empty($username) || empty($password)) {
                return $this->respond([
                    'status'   => 400,
                    'messages' => 'Username dan Password wajib diisi.'
                ], 400);
            }

            $model = new UserModel();

            $user = $model->where('username', $username)
                          ->orWhere('useremail', $username)
                          ->first();

            if ($user) {
                // Cari nama kolom password
                $dbPassword = isset($user['userpassword']) ? $user['userpassword'] : (isset($user['password']) ? $user['password'] : null);

                if ($dbPassword === null) {
                    return $this->respond(['status' => 500, 'messages' => 'Kolom password tidak ditemukan di DB.'], 500);
                }

                // Verifikasi Password
                $isPasswordValid = false;
                if ($password === $dbPassword || password_verify($password, $dbPassword)) {
                    $isPasswordValid = true;
                }

                if ($isPasswordValid) {
                    return $this->respond([
                        'status'   => 200,
                        'error'    => null,
                        'messages' => 'Login Berhasil',
                        'data'     => [
                            'id'       => $user['id'] ?? null,
                            'username' => $user['username'],
                            'token'    => base64_encode("TOKEN-SECRET-" . $user['username'])
                        ]
                    ], 200);
                }
            }

            return $this->respond(['status' => 401, 'messages' => 'Username atau Password salah.'], 401);

        } catch (\Exception $e) {
            return $this->respond(['status' => 500, 'messages' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}