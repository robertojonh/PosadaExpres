<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Model;

class Inicio extends BaseController
{
    private $habitacionModel;
    private $reservacionModel;
    public function __construct()
    {
        $this->habitacionModel = model('HabitacionModel');
        $this->reservacionModel = model('ReservacionesModel');
    }
    public function index()
    {
        $this->reservacionModel->actualizarReservaciones();
        $data['habitaciones'] = $this->habitacionModel->getHabitaciones(2);
        /* return $this->response->setJson(['datos' => $data]); */
        return view('Inicio/InicioView', $data);
    }
}
