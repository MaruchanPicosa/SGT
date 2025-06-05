<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->request->is('post')) {
            $rules = [
                'correo' => 'required|valid_email',
                'contrasena' => 'required|min_length[8]'
            ];

            if ($this->validate($rules)) {
                $model = new UsuarioModel();
                $correo = $this->request->getPost('correo');
                $contrasena = $this->request->getPost('contrasena');
                $usuario = $model->where('correo', $correo)->first();

                if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                    session()->set([
                        'user_id' => $usuario['id'],
                        'nombre' => $usuario['nombre'],
                        'rol' => $usuario['rol'],
                        'isLoggedIn' => true
                    ]);
                    return redirect()->to('/dashboard');
                } else {
                    session()->setFlashdata('error', 'Correo o contraseña incorrectos.');
                }
            } else {
                session()->setFlashdata('error', $this->validator->listErrors());
            }
        }

        return view('auth/login');
    }

    public function registrar()
    {
        if ($this->request->is('post')) {
            $rules = [
                'nombre' => 'required|min_length[3]',
                'correo' => 'required|valid_email|is_unique[usuarios.correo]',
                'contrasena' => 'required|min_length[8]',
                'rol' => 'required|in_list[agente,supervisor,administrador]'
            ];

            if ($this->validate($rules)) {
                $model = new UsuarioModel();
                $data = [
                    'nombre' => $this->request->getPost('nombre'),
                    'correo' => $this->request->getPost('correo'),
                    'contrasena' => password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT),
                    'rol' => $this->request->getPost('rol')
                ];

                if ($model->insert($data)) {
                    return redirect()->to('/register')->with('success', 'Usuario registrado correctamente.');
                } else {
                    session()->setFlashdata('error', 'Error al registrar el usuario.');
                }
            } else {
                session()->setFlashdata('error', $this->validator->listErrors());
            }
        }

        return view('auth/register');
    }

    public function register()
    {

        if ($this->request->is('post')) {
            $rules = [
                'nombre' => 'required|min_length[3]',
                'correo' => 'required|valid_email|is_unique[usuarios.correo]',
                'contrasena' => 'required|min_length[8]',
                'rol' => 'required|in_list[agente,supervisor,administrador]'
            ];

            if ($this->validate($rules)) {
                $model = new UsuarioModel();
                $data = [
                    'nombre' => $this->request->getPost('nombre'),
                    'correo' => $this->request->getPost('correo'),
                    'contrasena' => password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT),
                    'rol' => $this->request->getPost('rol')
                ];

                if ($model->insert($data)) {
                    return redirect()->to('/register')->with('success', 'Usuario registrado correctamente.');
                } else {
                    session()->setFlashdata('error', 'Error al registrar el usuario.');
                }
            } else {
                session()->setFlashdata('error', $this->validator->listErrors());
            }
        }

        return view('auth/register');
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}