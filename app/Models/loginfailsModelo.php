<?php

namespace App\Models;

use CodeIgniter\Model;

class loginfailsModelo extends Model
{
    //logica para hacer lo de intentos
    //Cuando se ingresan mal los datos, usuario o contraseña es un intento
    //Se cuentan los intentos en un lapso de tiempo 1 Hora por ejemplo, si en el lapso de una hora estos intentos son mayor a 5
    //El inicio de sesión para este usuario queda bloqueado, se guarda la ip, pero para tener un control del tiempo en el que puedan acceder
    //Se toma la hora del servidor y se bloquea el acceso en general, aunque se trate de otra IP, si en ese tiempo se superan los intentos ese usuario queda bloqueado.
    protected $table = 'loginfails';
    protected $primaryKey = 'id_fail';
    protected $allowedFields = ['id_fail', 'user_id', 'ip_address','created_at','updated_at'];
    protected $useTimestamps = true;

    public function intentosfallidos($ipusuario)
    {
        $fecha_inicio = date('Y-m-d H:i:s');
        /* $fecha_fin = date('Y-m-d 23:59:59'); */
        $fecha_restada = date("Y-m-d H:i:s",strtotime($fecha_inicio."- 1 hour")); 
        $db = db_connect();
        $informacion_registro = $db->query('select count(ip_address) from loginfails where ip_address = "'. $ipusuario.'" AND created_at BETWEEN "'. $fecha_restada .'" AND "'. $fecha_inicio .'" ');
        $ret =  $informacion_registro->getResultArray();
        return $ret;

        /* $usuarios = $this->db->table('loginfails');
        $usuarios->selectCount('*');
        $usuarios->where('user_id = " ' . $usuario . ' "')->where('created_at BETWEEN "' . $fecha_restada . '" AND "' . $fecha_inicio . '" ');
        $result = $usuarios->get()->getRow();
        $total = $result->total;
        return $total; */
    }

}