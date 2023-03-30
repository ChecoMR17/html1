<?php

$host = "localhost";
$user = "root";
$password = "smr17";
$BD = "FF";
$port = "3306";
$conexion = mysqli_connect($host, $user, $password, $BD, $port);
if ($conexion) {
    if (!function_exists('ejecutarConsulta')) {
        function ejecutarConsulta($sql)
        {
            global $conexion;
            $query = mysqli_query($conexion, $sql);
            return $query;
        }

        function ejecutarConsultaSimpleFila($sql)
        {
            global $conexion;
            $query = mysqli_query($conexion, $sql);
            $row = mysqli_fetch_array($query);
            return $row;
        }
    }
} else {
    return "Error al conexion";
}
