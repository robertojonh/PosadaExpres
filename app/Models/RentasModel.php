<?php

namespace App\Models;

use CodeIgniter\Model;

class RentasModel extends Model
{

    public function rentar($data)
    {
        $builder = $this->db->table('rentas');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function actualizarEstado($habitacion_id, $estado)
    {
        $builder = $this->db->table('habitaciones')
            ->where('habitacion_id', $habitacion_id)
            ->update($estado);
    }
}
