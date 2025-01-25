<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Reservaciones extends BaseController
{
    private $model;
    public function __construct()
    {
        $this->model = model('ReservacionesModel');
    }
    public function index()
    {
        $data = $this->model->getReservaciones();
        return view('/reservaciones/reservaciones', $data);
    }

    public function guardarReservacion()
    {
        $datosJson = $this->request->getJSON();

        $data =
            [
                'habitacion_id' => $datosJson->habitacion_id
            ];
        $this->model->guardarReservacion($data);
    }
}
