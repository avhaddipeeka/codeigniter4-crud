<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Users extends Controller
{
    public function index(): string
    {
        $userModel = new UserModel();
     
        $data = [
            'users' => $userModel->getAllUsers()->paginate(10),   // 10 per page
            'pager'    => $userModel->pager
        ];

        return view('users/list', $data);
    }
    public function create(): string
    {
        return view('users/add', [
            'validation' => \Config\Services::validation()
        ]);
    }

    public function store()
    {   
        $validation = [
            'fullname' => 'required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z\s]+$/]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'mobile'   => 'required|min_length[10]|numeric|regex_match[/^[0-9]{10}$/]',
            'password' => 'required|min_length[6]',
            'profile_file' => [
                'rules' => 'uploaded[profile_file]|max_size[profile_file,2048]|ext_in[profile_file,jpg,jpeg,png,gif,webp,pdf,doc,docx]',
                'label' => 'Profile File'
            ],
        ];

        if (! $this->validate($validation)) {
            return view('users/add', [
                'validation' => $this->validator
            ]);
        }

        // Upload file
        $file = $this->request->getFile('profile_file');
        $newName = $file->getRandomName();
        $file->move('uploads/profile', $newName);

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'email'    => $this->request->getPost('email'),
            'mobile'   => $this->request->getPost('mobile'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'profile_file' => 'uploads/profile/' . $newName,
        ];
        $userModel = new UserModel();
        $userModel->save($data);

        return redirect()->to('/users')->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User not found");
        }

        return view('users/edit', [
            'user' => $user,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $userModel = new \App\Models\UserModel();
    
        // Set dynamic validation to ignore current user
        $userModel->setUpdateValidationRules($id);

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'email'    => $this->request->getPost('email'),
            'mobile'   => $this->request->getPost('mobile'),
            'password' => $this->request->getPost('password'),
        ];

        $file = $this->request->getFile('profile_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $data['profile_file'] = $newName;
        }

        if (!$userModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        return redirect()->to('/users')->with('success', 'User updated successfully');

    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User not found");
        }

        // Delete file
        if ($user['profile_file'] && file_exists($user['profile_file'])) {
            unlink($user['profile_file']);
        }

        $userModel->delete($id);

        return redirect()->to('/users')->with('success', 'User deleted successfully!');
    }
}
