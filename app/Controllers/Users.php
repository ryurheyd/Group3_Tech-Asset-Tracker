<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function __construct()
    {
        if (!session()->get('isLoggedIn')) {

            return redirect()->to('/login')->send();
        }

        if (session()->get('role_id') != 1) {

            return redirect()->to('/unauthorized')->send();

            exit;
        }
    }

    public function index()
    {
        $userModel = new UserModel();

        $data['users'] = $userModel
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('users/index', $data);
    }

    public function store()
    {
        $userModel = new UserModel();

        $validation = \Config\Services::validation();

        $validation->setRules([

            'name' => [

                'rules' => 'required|min_length[3]',

                'errors' => [

                    'required' => 'Full name is required.',

                    'min_length' => 'Full name must be at least 3 characters.'

                ]

            ],

            'email' => [

                'rules' => 'required|valid_email|is_unique[users.email]',

                'errors' => [

                    'required' => 'Email address is required.',

                    'valid_email' => 'Please enter a valid email address.',

                    'is_unique' => 'Email already exists.'

                ]

            ],

            'password' => [

                'rules' => 'required|min_length[6]',

                'errors' => [

                    'required' => 'Password is required.',

                    'min_length' => 'Password must be at least 6 characters.'

                ]

            ],

            'role_id' => [

                'rules' => 'required',

                'errors' => [

                    'required' => 'Role is required.'

                ]

            ]

        ]);

        if (!$validation->withRequest($this->request)->run()) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $userModel->save([

            'name' => $this->request->getPost('name'),

            'email' => $this->request->getPost('email'),

            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),

            'role_id' => $this->request->getPost('role_id')

        ]);

        return redirect()->back()
            ->with('success', 'User created successfully');
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (!$user) {

            return redirect()->back()
                ->with('error', 'User not found');
        }

        $userModel->update($id, [

            'role_id' => $this->request->getPost('role_id')

        ]);

        return redirect()->back()
            ->with('success', 'User role updated successfully');
    }

    public function delete($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (!$user) {

            return redirect()->back()
                ->with('error', 'User not found');
        }

        $userModel->delete($id);

        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }
}