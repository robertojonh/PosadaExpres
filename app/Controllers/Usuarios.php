<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;

class Usuarios extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new UsuariosModel();
    }
    public function index() {}

    public function show()
    {
        return view('usuarios/home');
    }

    function getUsuarios()
    {
        return $this->response->setJSON($this->model->getUsuarios());
    }
}
