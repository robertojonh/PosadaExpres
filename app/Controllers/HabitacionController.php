<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HabitacionController extends BaseController
{
    private $model;
    public function __construct()
    {
        $this->model = model('HabitacionModel');
    }
    public function index()
    {
        $data["habitaciones"] = $this->model->getHabitaciones();
        return view('/habitaciones/habitaciones', $data);
    }
    public function getHabitaciones()
    {
        $data = $this->model->getHabitaciones();
        return $this->response->setJSON(['habitaciones' => $data]);
    }

    public function guardarHabitacion()
    {
        $datosJson = $this->request->getJSON();
        $data = [
            'num' => $datosJson->numeroHabitacion,
            'num_camas' => $datosJson->numeroCamas,
            'precio' => $datosJson->precioNoche,
            'fecha' => date('Y-m-d H:i:s'),
            'observaciones' => $datosJson->observaciones
        ];
        $id_insertado = $this->model->guardarHabitacion($data);
        return $this->response->setJSON(['status' => 'success', 'habitacion_id' => $id_insertado]);
    }

    public function cambiarDisponibilidad()
    {
        $datosJson = $this->request->getJSON();
        $this->model->cambiarDisponibilidad($datosJson->habitacion_id, $datosJson->estado);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function cambiarObservacion()
    {
        $datosJson = $this->request->getJSON();
        $this->model->cambiarObservacion($datosJson->habitacion_id, $datosJson->observacion);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function borrarHabitacion()
    {
        $datosJson = $this->request->getJSON();
        $this->model->borrarHabitacion($datosJson->habitacion_id);
        return $this->response->setJSON(['status' => 'success']);
    }

}
