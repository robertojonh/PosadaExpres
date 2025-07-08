<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    function getUsuarios()
    {
        return $this->db->query("SELECT user_id, nombre_completo(user_id) as nombre_completo, email, user, tipo
        FROM usuarios")->getResult();
    }
}
