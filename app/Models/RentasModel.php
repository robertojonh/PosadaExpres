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

    public function getRentas()
    {
        return $this->db->query("SELECT r.*,h.num FROM rentas AS r LEFT JOIN habitaciones AS h ON h.habitacion_id = r.habitacion_id")->getResult();
    }
}
