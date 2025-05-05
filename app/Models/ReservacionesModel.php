<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

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
        $fecha_actual = new DateTime();
        foreach ($reservaciones as $reservacion) {
            $fecha_inicio = new DateTime($reservacion->fecha_inicio);
            $diferencia = (int) $fecha_actual->diff($fecha_inicio)->format('%r%a');
            if ($diferencia === 0 || $diferencia === 1) {
                $this->db->query("UPDATE habitaciones SET estado='espera_h' WHERE habitacion_id = ?", [$reservacion->habitacion_id]);
            } elseif ($diferencia < 0) {
                $this->db->query("INSERT INTO reservaciones_cancelacion (reservacion_id, motivo, fecha) 
                              VALUES (?, ?, ?)", [
                    $reservacion->reservacion_id,
                    'Reservación expirada',
                    $fecha_actual->format('Y-m-d')
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

    function getInfo($reservacion_id)
    {
        return $this->db->query("SELECT r.habitacion_id, r.nombre_huesped, r.num_noches, r.reservacion_id, r.num_telefono, r.correo_e, r.fecha_inicio, r.fecha_fin, r.observaciones,
         r.precio as precio_reservacion, h.precio as precio_habitacion, h.num as habitacion_numero FROM reservaciones AS r
        INNER JOIN habitaciones AS h ON h.habitacion_id = r.habitacion_id WHERE r.reservacion_id = ?", [$reservacion_id])->getResult();
    }
}
