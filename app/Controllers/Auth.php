<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
    {
        // TODO: Add authentication logic here
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // Placeholder for authentication - redirect to admin dashboard
        return redirect()->to(base_url('admin'));
    }

    public function register()
    {
        return view('auth/register');
    }
}
