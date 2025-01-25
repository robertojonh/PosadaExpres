<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservacionesModel extends Model
{
    public function getReservaciones()
    {
        return $this->db->query("SELECT * FROM reservaciones")->getResult();
    }

    public function guardarReservacion($data){
        $builder = $this->db->table('reservaciones');
        $builder->insert($data);
        return $this->db->insertID();
    }
}
