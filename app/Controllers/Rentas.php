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
        $reservacion_id = isset($data->reservacion_id) ? $data->reservacion_id : null;
        $infoReservacion = $this->model->getInforReservacion($reservacion_id);
        $formatoFin = null;
        if ($infoReservacion) {

            if ($data->tipoRenta == 'horas') {
                $rentaFin = new DateTime($data->fechaFin);
                $formatoFin = $rentaFin->format('Y-m-d H:i:s');
            } else {
                $rentaFin = clone $dateTimeInicio;
                $rentaFin->modify('+' . $data->numNoches . ' days');
                $rentaFin->setTime(12, 0, 0);
                $formatoFin = $rentaFin->format('Y-m-d H:i:s');
            }
            $reservaInicio = new DateTime($infoReservacion->fecha_inicio);
            $reservaFin = new DateTime($infoReservacion->fecha_fin);
            $rentaInicio = clone $dateTimeInicio;
            $hayCruce = ($rentaInicio <= $reservaFin && $rentaFin >= $reservaInicio);
            if ($hayCruce) {
                return $this->response->setJSON([
                    'status' => 'no_guardado',
                    'mensaje' => 'Las fechas de la renta se cruzan o incluyen una reservación existente.'
                ]);
            }
        } else {
            if ($data->tipoRenta == 'horas') {
                $formatoFin = (new DateTime($data->fechaFin))->format('Y-m-d H:i:s');
            } else {
                $dateTimeFin = clone $dateTimeInicio;
                $dateTimeFin->modify('+' . $data->numNoches . ' days');
                $dateTimeFin->setTime(12, 0, 0);
                $formatoFin = $dateTimeFin->format('Y-m-d H:i:s');
            }
        }
        $rentar = [
            'habitacion_id' => $data->habitacion_id,
            'tipo' => ($data->tipoRenta == 'horas') ? 1 : 2,
            'total' => $data->total,
            'observaciones' => $data->observaciones,
            'fecha_inicio' => $dateTimeInicio->format('Y-m-d H:i:s'),
            'fecha_fin' => $formatoFin,
            'fecha' => date('Y-m-d H:i:s'),
        ];
        if ($data->tipoRenta !== 'horas') {
            $rentar['nombre_huesped'] = $data->nombreHuesped;
            $rentar['num_telefono'] = $data->telefonoHuesped;
            $rentar['correo_e'] = $data->correoHuesped;
            $rentar['num_noches'] = $data->numNoches;
        }
        $rentar['renta_id'] = $this->model->rentar($rentar);
        return $this->response->setJSON(['status' => 'success', 'data' => $rentar]);
    }

    public function continuarReservacion()
    {
        $datosJson = $this->request->getJSON();
        $data = $datosJson->data;
        $dateTimeInicio = new DateTime($data->fechaInicio);
        $dateTimeFin = clone $dateTimeInicio;
        $dateTimeFin->modify('+' . $data->numNoches . ' days');
        $dateTimeFin->setTime(12, 0, 0);
        $formatoFin = $dateTimeFin->format('Y-m-d H:i:s');
        $rentar = [
            'habitacion_id' => $data->habitacion_id,
            'tipo' => 2,
            'total' => $data->total,
            'observaciones' => $data->observaciones,
            'fecha_inicio' => $dateTimeInicio->format('Y-m-d H:i:s'),
            'fecha_fin' => $formatoFin,
            'fecha' => date('Y-m-d H:i:s'),
            'nombre_huesped' => $data->nombreHuesped,
            'num_telefono' => $data->telefonoHuesped,
            'correo_e' => $data->correoHuesped,
            'num_noches' => $data->numNoches,
        ];
        $rentar['renta_id'] = $this->model->rentarReservacion($rentar);
        return $this->response->setJSON(['status' => 'success', 'data' => $rentar]);
    }

}
