<?php

namespace App\Models;

use CodeIgniter\Model;

class RentasModel extends Model
{

    public function rentar($data)
    {
        $builder = $this->db->table('rentas');
        $builder->insert($data);
        $renta_id = $this->db->insertID();
        $this->db->query("UPDATE habitaciones SET estado = 'ocupada' WHERE habitacion_id = ?", [$data['habitacion_id']]);
        return $renta_id;
    }

    public function rentarReservacion($data)
    {
        $builder = $this->db->table('rentas');
        $builder->insert($data);
        $renta_id = $this->db->insertID();
        $this->db->query("UPDATE habitaciones SET estado = 'ocupada' WHERE habitacion_id = ?", [$data['habitacion_id']]);
        $this->db->query("UPDATE reservaciones SET estatus_reservacion = 'inactiva' WHERE habitacion_id = ?", [$data['habitacion_id']]);
        return $renta_id;
    }

    public function getRentas()
    {
        return $this->db->query("SELECT r.*,h.num FROM rentas AS r LEFT JOIN habitaciones AS h ON h.habitacion_id = r.habitacion_id")->getResult();
    }

    function infoReservacion($habitacion_id)
    {
        return $this->db->query("SELECT * FROM reservaciones WHERE habitacion_id = ? AND estatus_reservacion = 'activa'", [$habitacion_id])->getRow();
    }

    function getInforReservacion($reservacion_id)
    {
        return $this->db->query("SELECT * FROM reservaciones WHERE reservacion_id = ?", [$reservacion_id])->getRow();
    }
}
