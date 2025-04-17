<?php

namespace App\Models;

use CodeIgniter\Model;

class HabitacionModel extends Model
{


    /*  public function getHabitaciones($filtro = 1)
     {
         if ($filtro != 1) {
             $sql = "SELECT h.*, r.renta_id,r.tipo,r.nombre_huesped,r.num_telefono,r.correo_e,r.num_noches,r.total,r.observaciones,r.fecha_inicio,r.fecha_fin
                     FROM habitaciones AS h
                     LEFT JOIN (
                         SELECT r1.*
                         FROM rentas AS r1
                         INNER JOIN (
                             SELECT habitacion_id, MAX(fecha) AS ultima_renta
                             FROM rentas
                             GROUP BY habitacion_id
                         ) AS ultimas_rentas
                         ON r1.habitacion_id = ultimas_rentas.habitacion_id
                         AND r1.fecha = ultimas_rentas.ultima_renta
                     ) AS r ON r.habitacion_id = h.habitacion_id
                     AND h.estado = 'ocupada'
                     WHERE h.estado != 'no_disponible';";
             return $this->db->query($sql)->getResult();
         }
         return $this->db->query("SELECT * FROM habitaciones")->getResult();
     } */

    public function getHabitaciones($filtro = 1)
    {
        $sql = "SELECT h.*, 
                    r.renta_id, r.tipo, r.nombre_huesped, r.num_telefono, 
                    r.correo_e, r.num_noches, r.total, r.observaciones, 
                    r.fecha_inicio, r.fecha_fin,
                    res.reservacion_id, res.nombre_huesped AS nombre_reservacion, res.num_telefono AS telefono_reservacion, 
                    res.correo_e AS correo_reservacion, res.fecha_inicio AS fecha_inicio_reserva, 
                    res.fecha_fin AS fecha_fin_reserva,res.observaciones AS observacion_reserva,res.num_noches AS noches_reserva
             FROM habitaciones AS h
             LEFT JOIN rentas AS r 
                 ON h.habitacion_id = r.habitacion_id 
                 AND h.estado = 'ocupada' 
                 AND r.estatus_renta = 'activa'
             LEFT JOIN reservaciones AS res 
                 ON h.habitacion_id = res.habitacion_id 
                 AND (h.estado = 'reservada' OR h.estado = 'espera_h') 
                 AND res.estatus_reservacion = 'activa'
             WHERE h.estado != 'no_disponible'
             ORDER BY h.fecha ASC";

        if ($filtro == 1) {
            $sql = "SELECT * FROM habitaciones WHERE estado != 'no_disponible'";
        }
        return $this->db->query($sql)->getResult();
    }

    /* public function getHabitaciones($filtro = 1)
{
    $sql = "SELECT h.*, 
                r.renta_id, r.tipo, r.nombre_huesped, r.num_telefono, 
                r.correo_e, r.num_noches, r.total, r.observaciones, 
                r.fecha_inicio, r.fecha_fin,
                res.reservacion_id, res.nombre_huesped AS nombre_reservacion, res.num_telefono AS telefono_reservacion, 
                res.correo_e AS correo_reservacion, res.fecha_inicio AS fecha_inicio_reserva, 
                res.fecha_fin AS fecha_fin_reserva
         FROM habitaciones AS h
         LEFT JOIN rentas AS r 
             ON h.habitacion_id = r.habitacion_id 
             AND h.estado = 'ocupada' 
             AND r.estatus_renta = 'activa'
         LEFT JOIN reservaciones AS res 
             ON h.habitacion_id = res.habitacion_id 
             AND (h.estado = 'reservada' OR h.estado = 'espera_h') 
             AND res.estatus_reservacion = 'activa'
             AND (r.renta_id IS NULL OR r.fecha_fin < res.fecha_inicio) 
         WHERE h.estado != 'no_disponible'
         ORDER BY h.fecha ASC";

    if ($filtro == 1) {
        $sql = "SELECT * FROM habitaciones WHERE estado != 'no_disponible'";
    }
    
    return $this->db->query($sql)->getResult();
}
 */

    public function getHabitacion($habitacion_id)
    {
        return $this->db->query("SELECT * FROM habitaciones WHERE habitacion_id = ?", [$habitacion_id])->getRow();
    }

    public function guardarHabitacion($data)
    {
        $builder = $this->db->table('habitaciones');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function actualizar($habitacion_id, $data)
    {
        $this->db->table('habitaciones')
            ->where('habitacion_id', $habitacion_id)
            ->update($data);
    }

    public function actualizarEstado($habitacion_id, $estado)
    {
        return $this->db->table('habitaciones')
            ->where('habitacion_id', $habitacion_id)
            ->update($estado);
    }

    public function cambiarDisponibilidad($habitacion_id, $nuevo_estado, $tipo = null, $tipo_id = null)
    {
        $this->db->table('habitaciones')
            ->where('habitacion_id', $habitacion_id)
            ->update(['estado' => $nuevo_estado]);

        if ($tipo === 'rentas' && $tipo_id !== null) {
            $this->db->table('rentas')
                ->where('renta_id', $tipo_id)
                ->update(['estatus_renta' => 'inactiva']);
        }

        if ($tipo === 'reservaciones' && $tipo_id !== null) {
            $this->db->table('reservaciones')
                ->where('reservacion_id', $tipo_id)
                ->update(['estatus_reservacion' => 'inactiva']);
        }

        $haveReservation = $this->db->table('reservaciones')
            ->where('habitacion_id', $habitacion_id)
            ->where('estatus_reservacion', 'activa')
            ->get()
            ->getRow();

        if ($haveReservation) {
            $this->db->table('habitaciones')
                ->where('habitacion_id', $habitacion_id)
                ->update(['estado' => 'reservada']);
        }
    }

    public function cambiarObservacion($habitacion_id, $observacion)
    {
        return $this->db->table('habitaciones')
            ->where('habitacion_id', $habitacion_id)
            ->update(['observaciones' => $observacion]);
    }

    public function borrarHabitacion($habitacion_id)
    {
        $this->db->table('habitaciones')
            ->where('habitacion_id', $habitacion_id)
            ->delete();
    }

}
