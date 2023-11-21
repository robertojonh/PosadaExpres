<?php

namespace App\Controllers;

use App\Models\loginfailsModelo;
use App\Models\usuariosModelo;

class LoginController extends BaseController
{
    public function index(): string
    {
        return view('Login/LoginUserView');
    }

    public function Login()
    {
        //VALIDAMOS LOS IMPUTS
        $validation = \Config\Services::validation();
        //$validation = service('validation');
        $validation->setRules([
            'username' => [
                'label'  => 'Nombre de Usuario',
                /* 'rules'  => 'required|regex_match[/^[A-Z][a-zÀ-ÿ]{2,25}$/]|min_length[8]|max_length[20]', */
                'rules'  => 'required|min_length[1]|max_length[20]',
                'errors' => [
                    'required'   => 'El campo {field} es obligatorio',
                    /* 'regex_match' => 'Debe empezar con mayuscula', */
                    'min_length' => 'El campo {field} debe tener al menos 8 caracteres',
                    'max_length' => 'El campo {field} debe tener hasta 20 caractéres',
                    /* 'alpha_numeric' => 'EL campo {field} debe contener solo alfanumericos' */
                ]
            ],
            'password' => [
                'label'  => 'Contraseña',
                'rules'  => 'required|min_length[1]|max_length[30]',
                'errors' => [
                    'required'   => 'El campo {field} es obligatorio',
                    'min_length' => 'El campo {field} debe tener al menos 8 caracteres',
                    'max_length' => 'El campo {field} debe tener hasta 30 caractéres',

                ]
            ],
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            //dd($validation->getErrors());
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {

            $ipusuario = $_SERVER['REMOTE_ADDR'];
            $failscount = new loginfailsModelo();
            $intentos = $failscount->intentosfallidos($ipusuario);
            $contado = $intentos[0]['count(ip_address)'];
            $contado2 = intval($contado);
            if ($contado2 < 5) {

                $Usuario = new usuariosModelo();
                $username = $this->request->getPost('username');
                $datosUsuarios = $Usuario->datosdenull(['user' => $username]);
                if (count($datosUsuarios) > 0) {

                    $Usuario = new usuariosModelo();
                    $username = $this->request->getPost('username');
                    $password = $this->request->getPost('password');
                    $datosUsuarios = $Usuario->datosdenull(['user' => $username]);
                    if (count($datosUsuarios) > 0 && password_verify($password, $datosUsuarios[0]['password'])) {

                        $username = $this->request->getPost('username');
                        $datosUsuariosInvernadero = $Usuario->infoinvernaderousuario($username);
                        $datosUsuariosCultivos = $Usuario->infocultivousuario($username);
                        //Validación en caso de que el invernadero no contiene algún cultivo en producción - variable $datosUsuariosCultivos
                        if ($datosUsuariosCultivos) {
                            $nombredelcultivoenproduccion = $datosUsuariosCultivos[0]['nombre'];
                        } else {
                            $nombredelcultivoenproduccion = "Ningún cultivo en producción";
                        }
                        //Termina validación
                        $data = [
                            "id_user" => $datosUsuarios[0]['id_user'],
                            "username" => $datosUsuarios[0]['user'],
                            "type" => $datosUsuarios[0]['type'],
                            "email" => $datosUsuarios[0]['email'],
                        ];
                        $session = session();
                        $session->set($data);
                        return redirect()->to('/');
                    } else {
                        $ipusuario = $_SERVER['REMOTE_ADDR'];
                        $datafails = [
                            "user_id" => $datosUsuarios[0]['id_user'],
                            "ip_address" => $ipusuario,
                        ];
                        $fails = new loginfailsModelo();
                        $fails->insert($datafails);
                        return redirect()->to('/Login')->with('msg', 'La contraseña es Incorrecta');
                    }
                } else {
                    $ipusuario = $_SERVER['REMOTE_ADDR'];
                    $datafails = [
                        "user_id" => "UsuarioIncorrecto",
                        "ip_address" => $ipusuario,
                    ];
                    $fails = new loginfailsModelo();
                    $fails->insert($datafails);
                    return redirect()->to('/Login')->with('msg', 'El usuario que has ingresado no existe');
                }
            } else {
                return redirect()->to('/Login')->with('msg', 'Se te ha bloqueado el acceso ' . $ipusuario . ' , espera 1 Hora para poder volver a Ingresar.');
            }
        }
    }

    public function Salir()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/Login');
    }
}
