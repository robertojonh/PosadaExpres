<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginFailsModel extends Model
{
    protected $table = 'loginfails';
    public function intentosfallidos($ipusuario)
    {
        $fecha_inicio = date('Y-m-d H:i:s');
        $fecha_restada = date("Y-m-d H:i:s", strtotime($fecha_inicio . "- 1 hour"));
        $db = db_connect();
        $informacion_registro = $db->query('select count(ip_address) from loginfails where ip_address = "' . $ipusuario . '" AND created_at BETWEEN "' . $fecha_restada . '" AND "' . $fecha_inicio . '" ');
        $ret = $informacion_registro->getResultArray();
        return $ret;

        /* $usuarios = $this->db->table('loginfails');
        $usuarios->selectCount('*');
        $usuarios->where('user_id = " ' . $usuario . ' "')->where('created_at BETWEEN "' . $fecha_restada . '" AND "' . $fecha_inicio . '" ');
        $result = $usuarios->get()->getRow();
        $total = $result->total;
        return $total; */
    }

    public function insertar($datafails)
    {
        // Asegúrate de que $this->db está correctamente inicializado.
        $builder = $this->db->table($this->table); // Seleccionar la tabla
        $builder->insert($datafails); // Insertar los datos
    }

}