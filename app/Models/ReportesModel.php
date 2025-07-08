<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportesModel extends Model
{
    function getRentas()
    {
        return $this->db->query("SELECT r.*, h.num
        FROM rentas AS r 
        LEFT JOIN habitaciones AS h ON h.habitacion_id = r.habitacion_id")->getResult();
    }
    function getReservaciones()
    {
        return $this->db->query("SELECT r.*, h.num FROM reservaciones as r 
        LEFT JOIN habitaciones AS h ON h.habitacion_id = r.habitacion_id")->getResult();
    }
}
