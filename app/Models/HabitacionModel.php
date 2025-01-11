<?php

namespace App\Models;

use CodeIgniter\Model;

class HabitacionModel extends Model
{


    public function getHabitaciones()
    {
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
