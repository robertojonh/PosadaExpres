<?php
function money_float($money)
{

    return str_replace(",", "", $money);
}

function mes_min($mes)
{
    $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic", "Ene", "Feb");
    return $meses[$mes - 1];
}
function getPeriodos($f1, $f2)
{
    $data = array();
    $ts1 = strtotime($f1);
    $ts2 = strtotime($f2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    if ($year1 == $year2) {
        $aux = intval($month1);
        while ($aux <= $month2) {
            $item = array(
                "anio" => $year1,
                "mes" => $aux,
                "mes_name" => mes_min($aux),
                "name" => $year1 . '_' . $aux,
            );
            $data[] = $item;
            $aux++;
        }
    } else {
        $auxYear = $year1;
        $aux = intval($month1);
        $aux2 = intval($month2);
        while ($auxYear <= $year2) {
            $aux2 = $auxYear != $year2 ? 12 : $aux2;
            $aux2 = $year2 == $auxYear ? $month2 : $aux2;
            while ($aux <= $aux2) {
                $item = array(
                    "anio" => $auxYear,
                    "mes" => $aux,
                    "mes_name" => mes_min($aux) . "_" . $auxYear,
                    "name" => $auxYear . '_' . $aux,
                );
                $data[] = $item;
                $aux++;
            }
            $auxYear++;
            $aux = 1;
        }
    }
    return $data;
}

function etiqueta_semaforo($color)
{

    if (empty($color) or $color == null) {
        return '';
    }
    $data["verde"] = 'Terminado';
    $data["azul"] = 'En proceso';
    $data["gris"] = 'Por iniciar';
    return $data[$color];
}

if (!function_exists('formato_fecha')) {
    function formato_fecha($fecha, $option)
    {
        $val = "";
        if ($fecha == '0000-00-00') {
            return '';
        }
        if (empty($fecha)) {
            return '';
        }
        if ($option == 1) {
            $val = date("d-m-y", strtotime($fecha));
            $temp = explode("-", $val);
            $val = $temp[0] . "-" . mes_min($temp[1]) . "-" . $temp[2];
        }
        if ($option == 2) {
            $dia = date("d", strtotime($fecha));
            $mes = date("m", strtotime($fecha));
            $val = $dia . " DE " . formato_mes_completo($mes);
        }
        if ($option == 3) {
            $dia = date("d", strtotime($fecha));
            $mes = date("m", strtotime($fecha));
            $anio = date("Y", strtotime($fecha));
            $val = $dia . " DE " . formato_mes_completo($mes) . " DEL " . $anio;
        }
        if ($option == 4) {
            $val = date("d-m-y", strtotime($fecha));
            $temp = explode("-", $val);
            $val = $temp[0] . "-" . mes_min($temp[1]);
        }
        if ($option == 5) {
            if (empty($fecha)) {
                return '';
            }
            if ($fecha == '0000-00-00') {
                return '';
            }
            $val = date("d-m-Y", strtotime($fecha));
            $temp = explode("-", $val);

            $val = $temp[0] . "-" . strtolower(mes_min($temp[1])) . "-" . $temp[2];
        }
        if ($option == 6) {
            $dia = date("d", strtotime($fecha));
            $mes = date("m", strtotime($fecha));
            $val = $dia;
        }
        if ($option == 7) {
            if (empty($fecha)) {
                return '';
            }
            if ($fecha == '0000-00-00') {
                return '';
            }
            $val = date("d-m-Y", strtotime($fecha));
            $temp = explode("-", $val);

            $val = $temp[0] . "-" . strtoupper(mes_min($temp[1])) . "-" . $temp[2];
        }
        if ($option == 8) {
            $val = date("d-m-y", strtotime($fecha));
            $temp = explode("-", $val);
            $val = $temp[0] . "-" . strtolower(mes_min($temp[1])) . "-" . $temp[2];
        }
        if ($option == 9) {
            $hora = date("H:i", strtotime($fecha));
            $val = date("d-m-Y", strtotime($fecha));
            $temp = explode("-", $val);
            $val = $temp[0] . "-" . mes_min($temp[1]) . "-" . $temp[2] . " " . $hora;
        }
        if ($option == 10) {
            $dia = date("d", strtotime($fecha));
            $mes = date("m", strtotime($fecha));
            $anio = date("Y", strtotime($fecha));
            $hora = date("H:i", strtotime($fecha));
            $val = $dia . " DE " . strtoupper(formato_mes_completo($mes)) . " DEL " . $anio . " A LAS " . $hora . " HRS";
        }
        return $val;
    }
}
function formato_mes_completo($mes)
{
    $val = "";
    switch ($mes) {
        case "01":
            $val = "ENERO";
            break;
        case "02":
            $val = "FEBRERO";
            break;
        case "03":
            $val = "MARZO";
            break;
        case "04":
            $val = "ABRIL";
            break;
        case "05":
            $val = "MAYO";
            break;
        case "06":
            $val = "JUNIO";
            break;
        case "07":
            $val = "JULIO";
            break;
        case "08":
            $val = "AGOSTO";
            break;
        case "09":
            $val = "SEPTIEMBRE";
            break;
        case "10":
            $val = "OCTUBRE";
            break;
        case "11":
            $val = "NOVIEMBRE";
            break;
        case "12":
            $val = "DICIEMBRE";
            break;
    }
    return $val;
}
if (!function_exists('getGps')) {
    function getGps($exifCoord, $hemi)
    {
        $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2] . "") : 0;
        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }
}

if (!function_exists('gps2Num')) {
    function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0)
            return 0;
        if (count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }
}

function file_size($size)
{
    if ($size < 1024) {
        $size = $size . ' B';
    } elseif ($size < 1048576) {
        $size = round($size / 1024, 2) . ' KB';
    } else {
        $size = round($size / 1048576, 2) . ' MB';
    }
    return $size;
}