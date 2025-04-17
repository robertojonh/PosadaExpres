<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservacionesModel extends Model
{
    public function getReservaciones()
    {
        return $this->db->query("SELECT rese.*,h.num FROM reservaciones AS rese 
                                        LEFT JOIN habitaciones AS h ON h.habitacion_id = rese.habitacion_id")->getResult();
    }

    /* 
    public function actualizarReservaciones()
    {
        $reservaciones = $this->db->query("SELECT * FROM reservaciones WHERE estatus_reservacion='activa'")->getResult();
        if (empty($reservaciones)) {
            return;
        }
        $fecha_actual = date('Y-m-d');
        foreach ($reservaciones as $reservacion) {
            $fecha_reservacion = date('Y-m-d', strtotime($reservacion->fecha_inicio));
            if ($fecha_reservacion == $fecha_actual) {
                $this->db->query("UPDATE habitaciones SET estado='espera_h' WHERE habitacion_id = ?", [$reservacion->habitacion_id]);
            }
        }
    }
    */

    public function actualizarReservaciones()
    {
        $reservaciones = $this->db->query("SELECT * FROM reservaciones WHERE estatus_reservacion='activa'")->getResult();
        if (empty($reservaciones)) {
            return;
        }
        $fecha_actual = date('Y-m-d');
        foreach ($reservaciones as $reservacion) {
            $fecha_reservacion = date('Y-m-d', strtotime($reservacion->fecha_inicio));
            if ($fecha_reservacion == $fecha_actual) {
                $this->db->query("UPDATE habitaciones SET estado='espera_h' WHERE habitacion_id = ?", [$reservacion->habitacion_id]);
            } elseif ($fecha_reservacion < $fecha_actual) {
                $this->db->query("INSERT INTO reservaciones_cancelacion (reservacion_id, motivo, fecha) 
                              VALUES (?, ?, ?)", [
                    $reservacion->reservacion_id,
                    'Reservación expirada',
                    $fecha_actual
                ]);
                $this->db->query("UPDATE reservaciones SET estatus_reservacion='inactiva' WHERE reservacion_id = ?", [$reservacion->reservacion_id]);
                $this->db->query("UPDATE habitaciones SET estado='libre' WHERE habitacion_id = ?", [$reservacion->habitacion_id]);
            }
        }
    }


    public function guardarReservacion($data)
    {
        $builder = $this->db->table('reservaciones');
        $builder->insert($data);
        $reservacion_id = $this->db->insertID();
        $this->db->query("UPDATE habitaciones SET estado = 'reservada' WHERE habitacion_id = ?", [$data['habitacion_id']]);
        return $reservacion_id;
    }

    function cancelarReservacion($data)
    {
        $builder = $this->db->table('reservaciones_cancelacion');
        $builder->insert($data);
    }
}
