<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuariosModel extends Model
{
    public function generar_id_usuario()
    {
        $id_usuario = uniqid('User_');
        // Verificar si el ID de usuario ya existe en la base de datos
        $usuario_existente = $this->db->table('usuarios')->where('id_user', $id_usuario)->get()->getRow();
        if (!empty($usuario_existente)) {
            // Si el ID de usuario ya existe en la base de datos, generar un nuevo ID
            $id_usuario = $this->generar_id_usuario();
        }
        return $id_usuario;
    }

    public function generar_nombre_usuario()
    {
        // Definir el alfabeto de caracteres permitidos para el nombre de usuario
        $alfabeto = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        // Generar un nombre de usuario aleatorio
        $nombre_usuario = "";
        while (true) {
            $nombre_usuario = "";
            for ($i = 0; $i < 8; $i++) {
                $nombre_usuario .= $alfabeto[rand(0, strlen($alfabeto) - 1)];
            }
            // Verificar si el nombre de usuario ya existe en la base de datos
            $usuario_existente = $this->db->table('usuarios')->where('user', $nombre_usuario)->get()->getRow();
            if (empty($usuario_existente)) {
                break;
            }
        }
        return $nombre_usuario;
    }

    public function generar_contrasena()
    {
        // Definimos los caracteres que pueden aparecer en la contraseña
        $minusculas = 'abcdefghijklmnopqrstuvwxyz';
        $mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $caracteres_especiales = '!@#$%^&*()]';
        $todos_caracteres = $minusculas . $mayusculas . $caracteres_especiales;

        // Obtenemos la longitud de la cadena de caracteres
        $longitud = strlen($todos_caracteres);

        // Definimos la longitud mínima y máxima de la contraseña
        $longitud_minima = 10;
        $longitud_maxima = 25;

        // Generamos una contraseña aleatoria
        $contrasena = '';
        $longitud_contrasena = rand($longitud_minima, $longitud_maxima);

        while (strlen($contrasena) < $longitud_contrasena) {
            // Seleccionamos un carácter aleatorio de la cadena de caracteres
            $caracter_aleatorio = $todos_caracteres[rand(0, $longitud - 1)];

            // Agregamos el carácter aleatorio a la contraseña
            $contrasena .= $caracter_aleatorio;
        }

        // Aseguramos que la contraseña tenga al menos una letra mayúscula y un caracter especial
        $tiene_mayuscula = false;
        $tiene_caracter_especial = false;

        foreach (str_split($contrasena) as $caracter) {
            if (ctype_upper($caracter)) {
                $tiene_mayuscula = true;
            } elseif (strpos($caracteres_especiales, $caracter) !== false) {
                $tiene_caracter_especial = true;
            }
        }

        if (!$tiene_mayuscula || !$tiene_caracter_especial) {
            // Si la contraseña no cumple con los requisitos, generamos otra
            $contrasena = $this->generar_contrasena();
        }

        // Devolvemos la contraseña generada
        return $contrasena;
    }

    public function datosdenull($data)
    {
        $usuarios = $this->db->table('usuarios');
        $usuarios->where($data)->where('deleted_at', null);
        return $usuarios->get()->getResultArray();
    }

    public function borrarusuariosycinvernaderos($id_invernadero)
    {
        //Esta función se encarga, como su nombre lo dice, borrar los usuarios que no tengan un invernadero, esto se refiere que cuando se borre un invernadero desde la vista invernadero.
        //Esta función se llama desde el controlador de invernadero, en el método de borrar invernadero, borrando así los usuarios que hagan referencia al invernadero eliminado.
        // Obtener los usuarios asociados al invernadero eliminado
        $usuarios = $this->where('invernadero_id_invernadero', $id_invernadero)->where('deleted_at', null)->findAll();
        foreach ($usuarios as $usuario) {
            $id_usuario = $usuario['id_user'];
            $this->delete($id_usuario);
        }
    }

    public function infousuariosinvernaderos()
    {
        $db = db_connect();
        $informacion_registro = $db->query('SELECT u.id_user, u.nombre, u.email, u.user, u.type, i.id_invernadero, i.nombre_invernadero FROM usuarios u INNER JOIN invernaderos i ON u.invernadero_id_invernadero = i.id_invernadero WHERE u.deleted_at IS NULL ');
        $ret = $informacion_registro->getResultArray();
        return $ret;
    }

    public function infousuariosinvernaderodueno($id_ivnernadero)
    {
        $db = db_connect();
        $informacion_registro = $db->query('SELECT u.id_user, u.nombre, u.email, u.user, u.type, i.id_invernadero, i.nombre_invernadero FROM usuarios u INNER JOIN invernaderos i ON u.invernadero_id_invernadero = i.id_invernadero WHERE u.deleted_at IS NULL AND u.invernadero_id_invernadero = "' . $id_ivnernadero . '"');
        $ret = $informacion_registro->getResultArray();
        return $ret;
    }

    //Invernadero al que pertenece el usuario
    public function infoinvernaderousuario($username)
    {
        $db = db_connect();
        $informacion_registro = $db->query('select u.id_user, u.nombre, u.email, u.user, u.type, i.id_invernadero, i.nombre_invernadero from usuarios u INNER JOIN invernaderos i ON u.invernadero_id_invernadero = i.id_invernadero WHERE u.user="' . $username . '" AND u.deleted_at IS NULL ');
        $ret = $informacion_registro->getResultArray();
        return $ret;
    }
    //Cultivos en producción del invernadero al que pertenece el usuario
    public function infocultivousuario($username)
    {
        $db = db_connect();
        $informacion_registro = $db->query('SELECT c.nombre from cultivos c INNER JOIN usuarios u ON c.invernadero_id_invernadero = u.invernadero_id_invernadero WHERE u.user="' . $username . '" AND produccion=1 AND u.deleted_at IS NULL ');
        $ret = $informacion_registro->getResultArray();
        return $ret;
    }
    public function infocultivodueno($username)
    {
        $db = db_connect();
        $informacion_registro = $db->query('SELECT c.nombre from cultivos c INNER JOIN invernaderos i ON c.invernadero_id_invernadero = i.id_invernadero WHERE i.id_dueno_invernadero="' . $username . '" AND c.produccion=1 AND i.deleted_at IS NULL ');
        $ret = $informacion_registro->getResultArray();
        return $ret;
    }
}