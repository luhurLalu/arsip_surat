<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $this->checkRole(['admin']); // hanya admin boleh melihat daftar pengguna
        $data['users'] = $this->userModel->findAll();
        return view('user/index', $data);
    }

    public function create()
    {
        $this->checkRole(['admin']); // hanya admin boleh menambah pengguna
        return view('user/create');
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|alpha_dash|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,staff,viewer]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role')
        ];

        $this->userModel->insert($data);
        return redirect()->to('/user')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->checkRole(['admin']); // hanya admin boleh mengedit pengguna

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/user')->with('error', 'Pengguna tidak ditemukan');
        }

        $data['user'] = $user;
        return view('user/edit', $data);
    }

    public function update($id)
    {
        $this->checkRole(['admin']); // hanya admin boleh mengubah pengguna

        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'username' => 'required|alpha_dash|is_unique[users.username,id,' . $id . ']',
            'role'     => 'required|in_list[admin,staff,viewer]'
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role')
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return redirect()->to('/user')->with('success', 'Pengguna berhasil diupdate');
    }

    public function delete($id)
    {
        $this->checkRole(['admin']); // hanya admin boleh menghapus pengguna
        $this->userModel->delete($id);
        return redirect()->to('/user')->with('success', 'Pengguna berhasil dihapus');
    }
}