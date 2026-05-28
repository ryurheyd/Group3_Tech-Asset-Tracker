<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function checkLogin()
    {
        $session = session();

        $login = $this->request->getPost('login');

        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel
            ->where('email', $login)
            ->first();

        if (!$user) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email address');
        }

        if (!password_verify($password, $user['password'])) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Incorrect password');
        }

        $session->set([

            'user_id' => $user['id'],

            'name' => $user['name'],

            'role_id' => $user['role_id'],

            'isLoggedIn' => true

        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }

    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}
