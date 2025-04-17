<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
class Rentas extends BaseController
{
    private $model;
    private $habitacionModel;
    public function __construct()
    {
        $this->model = model('RentasModel');
        $this->habitacionModel = model('HabitacionModel');
    }
    public function index()
    {
        return view('/rentas/rentas');
    }

    public function getRentas()
    {
        return $this->response->setJSON($this->model->getRentas());
    }

    public function rentarHabitacion()
    {
        $datosJson = $this->request->getJSON();
        $data = $datosJson->data;
        $dateTimeInicio = new DateTime($data->fechaInicio);
        $dateTimeFin = new DateTime($data->fechaFin);
        $formatoInicio = $dateTimeInicio->format('Y-m-d H:i:s');
        $formatoFin = $dateTimeFin->format('Y-m-d H:i:s');
        $infoReservacion = isset($data->reservacion_id) ? $data->reservacion_id : null; 
        $rentar = [
            'habitacion_id' => $data->habitacion_id,
            'tipo' => 1,
            'total' => $data->total,
            'observaciones' => $data->observaciones,
            'fecha_inicio' => $formatoInicio,
            'fecha_fin' => $formatoFin,
            'fecha' => date('Y-m-d H:i:s'),
        ];
        if ($data->tipoRenta == "horas") {
        } else {
            $dateTimeFin->setTime(12, 0, 0);
            $formatoFin = $dateTimeFin->format('Y-m-d H:i:s');
            $rentar['tipo'] = 2;
            $rentar['fecha_fin'] = $formatoFin;
            $rentar['nombre_huesped'] = $data->nombreHuesped;
            $rentar['num_telefono'] = $data->telefonoHuesped;
            $rentar['correo_e'] = $data->correoHuesped;
            $rentar['num_noches'] = $data->numNoches;
        }
        $rentar['renta_id'] = $this->model->rentar($rentar);
        return $this->response->setJSON(['status' => 'success', 'data' => $rentar]);
    }
}
