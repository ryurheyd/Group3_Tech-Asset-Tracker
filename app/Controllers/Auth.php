<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    /* Display login page */
    public function login()
    {
        return view('auth/login');
    }

    /* Authenticate user credentials */
    public function checkLogin()
    {
        $session = session();

        // Get login credentials from form input
        $login = $this->request->getPost('login');

        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        // Find user by email address
        $user = $userModel
            ->where('email', $login)
            ->first();

        // Return error if email does not exist
        if (!$user) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email address');
        }

        // Verify hashed password
        if (!password_verify($password, $user['password'])) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Incorrect password');
        }

        // Store authenticated user information in session
        $session->set([

            'user_id' => $user['id'],

            'name' => $user['name'],

            'role_id' => $user['role_id'],

            'isLoggedIn' => true

        ]);

        // Redirect user to dashboard after successful login
        return redirect()->to('/dashboard');
    }

    /* Destroy session and log out user */
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }

    /* Display unauthorized access page */
    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}