<?php

$host = "localhost";
$user = "fab";
$password = "f";
$BD = "Test";
$port = "3306";
$conexion = mysqli_connect($host, $user, $password, $BD, $port);
date_default_timezone_set('America/Mexico_City');
if ($conexion) {
    if (!function_exists('ejecutarConsulta')) {
        function ejecutarConsulta($sql){
            global $conexion;
            $query = mysqli_query($conexion, $sql);
            return $query;
        }

        function ejecutarConsultaSimpleFila($sql){
            global $conexion;
            $query = mysqli_query($conexion, $sql);
            $row = mysqli_fetch_array($query);
            return $row;
        }
    }
} else {
    return "Error al conectar";
}
