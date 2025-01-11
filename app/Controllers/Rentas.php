<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
class Rentas extends BaseController
{
    private $model;
    public function __construct()
    {
        $this->model = model('RentasModel');
    }
    public function index()
    {
        //
    }

    public function rentarHabitacion()
    {
        $datosJson = $this->request->getJSON();
        $data = $datosJson->data;
        $dateTimeInicio = new DateTime($data->fechaInicio);
        $dateTimeFin = new DateTime($data->fechaFin);
        $formatoInicio = $dateTimeInicio->format('Y-m-d H:i:s');
        $formatoFin = $dateTimeFin->format('Y-m-d H:i:s');
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
            $this->model->rentar($rentar);
        } else {
            $rentar['tipo'] = 2;
            $rentar['nombre_huesped'] = $data->nombreHuesped;
            $rentar['num_telefono'] = $data->telefonoHuesped;
            $rentar['correo_e'] = $data->correoHuesped;
            $rentar['num_noches'] = $data->numNoches;
            $this->model->rentar($rentar);
        }
        $estado = [
            'estado' => 'ocupada'
        ];
        $this->model->actualizarEstado($data->habitacion_id, $estado);
        return $this->response->setJSON(['status' => 'success', 'data' => $rentar]);
    }
}
