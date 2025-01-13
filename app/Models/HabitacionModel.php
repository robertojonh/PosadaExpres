<?php

namespace App\Models;

use CodeIgniter\Model;

class HabitacionModel extends Model
{


    public function getHabitaciones($filtro = 1)
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
    }

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

    public function cambiarDisponibilidad($habitacion_id, $nuevo_estado)
    {
        return $this->db->table('habitaciones')
            ->where('habitacion_id', $habitacion_id)
            ->update(['estado' => $nuevo_estado]);
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
