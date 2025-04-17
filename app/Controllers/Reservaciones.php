<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
        $reservacion = $datosJson->data;
        $data =
            [
                'habitacion_id' => $reservacion->habitacion_id,
                'estatus_reservacion' => 'activa',
                'nombre_huesped' => $reservacion->nombreHuesped,
                'num_telefono' => $reservacion->telefonoHuesped,
                'correo_e' => $reservacion->correoHuesped,
                'num_noches' => $reservacion->numNoches,
                'fecha_inicio' => $reservacion->fechaInicio,
                'fecha_fin' => $reservacion->fechaFin,
                'observaciones' => $reservacion->observaciones,
                'precio' => $reservacion->total,
                'fecha' => date('Y-m-d H:i:s'),
            ];
        $reservacion_id = $this->model->guardarReservacion($data);
        return $this->response->setJSON(['status' => 'success', 'habitacion_id' => $reservacion->habitacion_id, 'reservacion_id' => $reservacion_id]);
    }

    function cancelar()
    {
        $datosJson = $this->request->getJSON();
        $data =
            [
                'reservacion_id' => $datosJson->reservacion_id,
                'motivo' => $datosJson->motivo,
                'fecha' => date('Y-m-d H:i:s'),
            ];
        $this->model->cancelarReservacion($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    function getReservaciones()
    {
        return $this->response->setJSON($this->model->getReservaciones());
    }
}
