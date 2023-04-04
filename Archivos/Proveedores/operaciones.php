<?php
include "../../global/conexion.php";

$Id_Proveedores = isset($_POST['Id_Proveedores']) ? $_POST['Id_Proveedores'] : "";
$Nombre_Proveedores = isset($_POST['Nombre_Proveedores']) ? $_POST['Nombre_Proveedores'] : "";
$Ganancia = isset($_POST['Ganancia']) ? $_POST['Ganancia'] : "";
$salida = "";
switch ($_GET['op']) {
    case 'Guardar_Familias':
        if ($Id_Proveedores == "") {
            //VAlidamos que no exista
            $COUNT = ejecutarConsultaSimpleFila("SELECT COUNT(*) FROM Cat_Familias WHERE Desc_Fam='$Nombre_Proveedores'")[0];
            if ($COUNT == 0) {
                $query = ejecutarConsulta("INSERT INTO Cat_Familias(Desc_Fam,Ganancia) VALUES('$Nombre_Proveedores','$Ganancia')");
                echo $query ? 200 : 201;
            } else {
                echo 202;
            }
        } else {
            $query = ejecutarConsulta("UPDATE Cat_Familias SET Desc_Fam='$Nombre_Proveedores', Ganancia='$Ganancia' WHERE Id_Fam='$Id_Proveedores'");
            echo $query ? 200 : 201;
        }
        break;
    case 'Mostrar_Lista_Familias':
        $query = ejecutarConsulta("SELECT*FROM Cat_Familias;");
        while ($fila = mysqli_fetch_object($query)) {
            $Botones = '
            <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Modificar" onclick="Datos_Modificar_F(' . $fila->Id_Fam . ')"><i class="fa-solid fa-user-pen fa-beat"></i></button>
            ';

            $datos[] = array(
                "0" => "<div class='text-center'>$fila->Id_Fam</div>",
                "1" => "<div class='text-left'>$fila->Desc_Fam</div>",
                "2" => "<div class='text-left'>" . number_format($fila->Ganancia, 2) . " %</div>",
                "3" => "<div class='justify-content-center d-flex'>$Botones</div>"
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($datos), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($datos), //enviamos el total registros a visualizar
            "aaData" => $datos
        );
        //Enviamos los datos de la tabla 
        echo json_encode($results);
        break;
    case 'Datos_Modificar_F':
        $query = ejecutarConsultaSimpleFila("SELECT*FROM Cat_Familias WHERE Id_Fam='$Id_Proveedores'");
        echo json_encode($query);
        break;
    case 'Mostrar_Familias':
        $query = ejecutarConsulta("SELECT*FROM Cat_Familias");
        while ($fila = mysqli_fetch_object($query)) {
            $salida .= "<option class='text-dark' value='$fila->Id_Fam'>$fila->Desc_Fam</option>";
        }
        echo $salida;
        break;
}
