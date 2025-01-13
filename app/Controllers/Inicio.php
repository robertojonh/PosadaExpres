<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Inicio extends BaseController
{
    private $habitacionModel;
    public function __construct()
    {
        $this->habitacionModel = model('HabitacionModel');
    }
    public function index()
    {
        $data['habitaciones'] = $this->habitacionModel->getHabitaciones(2);
        return view('Inicio/InicioView', $data);
    }
}
