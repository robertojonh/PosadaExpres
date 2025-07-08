<?php

namespace App\Controllers;

class Login extends BaseController
{
    private $loginFails;
    private $userModel;

    public function __construct()
    {
        $this->loginFails = model('LoginFailsModel');
        $this->userModel = model('UsuarioModel');
    }
    public function index()
    {
        if (session()->has('id_user')) {
            return redirect()->to('/');
        } else {
            return view('/Login/LoginUserView');
        }
    }

    public function Login()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => [
                'label' => 'Nombre de Usuario',
                /* 'rules'  => 'required|regex_match[/^[A-Z][a-zÀ-ÿ]{2,25}$/]|min_length[8]|max_length[20]', */
                'rules' => 'required|min_length[1]|max_length[20]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    /* 'regex_match' => 'Debe empezar con mayuscula', */
                    'min_length' => 'El campo {field} debe tener al menos 8 caracteres',
                    'max_length' => 'El campo {field} debe tener hasta 20 caractéres',
                    /* 'alpha_numeric' => 'EL campo {field} debe contener solo alfanumericos' */
                ]
            ],
            'password' => [
                'label' => 'Contraseña',
                'rules' => 'required|min_length[1]|max_length[30]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'min_length' => 'El campo {field} debe tener al menos 8 caracteres',
                    'max_length' => 'El campo {field} debe tener hasta 30 caractéres',

                ]
            ],
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $ipusuario = $_SERVER['REMOTE_ADDR'];
            $intentos = $this->loginFails->intentosfallidos($ipusuario);
            $contado = $intentos[0]['count(ip_address)'];
            $contado2 = intval($contado);
            if ($contado2 < 5) {
                $username = $this->request->getPost('username');
                $datosUsuarios = $this->userModel->datosdenull($username);

                if ($datosUsuarios !== null) {
                    $password = $this->request->getPost('password');
                    if (password_verify($password, $datosUsuarios->password)) {
                        $data = [
                            "user_id" => $datosUsuarios->user_id,
                            "username" => $datosUsuarios->user,
                            "type" => $datosUsuarios->type,
                            "tipo" => $datosUsuarios->tipo,
                            "email" => $datosUsuarios->email,
                        ];
                        $session = session();
                        $session->set($data);
                        return redirect()->to(base_url('/home'));
                    } else {
                        $datafails = [
                            "user_id" => $datosUsuarios->user_id,
                            "ip_address" => $ipusuario,
                        ];
                        $this->loginFails->insertar($datafails);
                        return redirect()->to(base_url('Login'))->with('msg', 'La contraseña es Incorrecta');
                    }
                } else {
                    $datafails = [
                        "user_id" => "UsuarioIncorrecto",
                        "ip_address" => $ipusuario,
                    ];
                    $this->loginFails->insertar($datafails);
                    return redirect()->to(base_url('Login'))->with('msg', 'El usuario que has ingresado no existe');
                }
            } else {
                return redirect()->to(base_url('Login'))->with('msg', 'Se te ha bloqueado el acceso ' . $ipusuario . ' , espera 1 Hora para poder volver a Ingresar.');
            }
        }
    }

    public function Salir()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('Login'));
    }
}
