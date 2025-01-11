<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class InicioController extends BaseController
{
    private $habitacionModel;
    private $habitacionController;
    public function __construct()
    {
        $this->habitacionModel = model('HabitacionModel');
        $this->habitacionController = new \App\Controllers\HabitacionController();
    }
    public function index()
    {
        $data['habitaciones'] = $this->habitacionModel->getHabitaciones();
        return view('Inicio/InicioView', $data);
    }
}
