<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        $identifier = $this->request->getPost('email');
        $password   = $this->request->getPost('password');

        $model = new UserModel();
        $user  = $model->where('email', $identifier)
                       ->orWhere('username', $identifier)
                       ->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Invalid credentials.');
        }

        if ($user['status'] !== 'active') {
            return redirect()->back()->with('error', 'Your account is inactive.');
        }

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'user_name'  => $user['username'],
            'user_role'  => strtolower($user['role']),
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }

    public function register()
    {
        return view('auth/register');
    }
}
