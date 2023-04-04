<?php
include "../../global/conexion.php";
//Varibales
$Fecha_Actual = date("Y-m-d H:i:s");
$Id = isset($_POST['Id']) ? $_POST['Id'] : "";
$Cliente = isset($_POST['Cliente']) ? $_POST['Cliente'] : "";
$Obras = isset($_POST['Obras']) ? $_POST['Obras'] : "";
$Contactos = isset($_POST['Contactos']) ? $_POST['Contactos'] : "";
$Prioridad = isset($_POST['Prioridad']) ? $_POST['Prioridad'] : "";
$Proyecto = isset($_POST['Proyecto']) ? $_POST['Proyecto'] : "";
$Fecha_Inicio = isset($_POST['Fecha_Inicio']) ? $_POST['Fecha_Inicio'] : "";
$Fecha_Final = isset($_POST['Fecha_Final']) ? $_POST['Fecha_Final'] : "";
$Detalles = isset($_POST['Detalles']) ? $_POST['Detalles'] : "";
$Opciones_Status = !empty($_POST['Opciones_Status']) ? $_POST['Opciones_Status'] : "A";
$salida = "";
$datos = array();
switch ($_GET['op']) {
    case 'Guardar_Ordenes_Trabajo':
        if ($Id == "") { //Insert
            $query = ejecutarConsulta("INSERT INTO Ordenes_Trabajo(Id_Cliente,Id_Obra,Id_Contacto,Prioridad,Proyecto,Fecha_Inicio,Fecha_Final,Detalles,Fecha_Alta,Status) 
            VALUES('$Cliente','$Obras','$Contactos','$Prioridad','$Proyecto','$Fecha_Inicio','$Fecha_Final','$Detalles','$Fecha_Actual','$Opciones_Status')");
        } else {
            $query = ejecutarConsulta("UPDATE Ordenes_Trabajo SET Id_Cliente='$Cliente',Id_Obra='$Obras',Id_Contacto='$Contactos',Prioridad='$Prioridad',Proyecto='$Proyecto',Fecha_Inicio='$Fecha_Inicio',Fecha_Final='$Fecha_Final',Detalles='$Detalles',Fecha_Modificacion='$Fecha_Actual',Status='$Opciones_Status' WHERE Id='$Id'");
        }
        echo $query ? 200 : 201;
        break;
    case 'Mostrar_Clientes':
        $query = ejecutarConsulta("SELECT*FROM Clientes WHERE Status='A';");
        while ($fila = mysqli_fetch_object($query)) {
            $salida .= "<option class='text-dark' value='$fila->Id'>$fila->Nombre $fila->Apellido_P $fila->Apellido_M</option>";
        }
        echo $salida;
        break;
    case 'Buscar_Obras':
        $query = ejecutarConsulta("SELECT*FROM Obras WHERE Id_Cliente='$Cliente' AND Status='A';");
        while ($fila = mysqli_fetch_object($query)) {
            $salida .= "<option class='text-dark' value='$fila->Id'>$fila->Nombre_Obra</option>";
        }
        echo $salida;
        break;
    case 'Buscar_Contactos':
        $query = ejecutarConsulta("SELECT*FROM Contactos_Clientes WHERE Id_Cliente='$Cliente' AND Status='A';");
        while ($fila = mysqli_fetch_object($query)) {
            $salida .= "<option class='text-dark' value='$fila->Id'>$fila->Nombre $fila->Apellido_P $fila->Apellido_M</option>";
        }
        echo $salida;
        break;
    case 'Mostrar_Lista_OT':
        $query = ejecutarConsulta("SELECT O.Id,concat_ws(' ',C.Nombre,C.Apellido_P ,C.Apellido_M) AS Cliente,Ob.Nombre_Obra AS Obra,O.Proyecto,concat_ws(' ',CC.Nombre,CC.Apellido_P,CC.Apellido_M) AS Contacto, O.Prioridad,O.Fecha_Inicio,O.Fecha_Final,O.Detalles,O.Status FROM Ordenes_Trabajo O
        LEFT JOIN Clientes C on(O.Id_Cliente=C.Id)
        LEFT JOIN Obras Ob ON (O.Id_Obra=Ob.Id)
        LEFT JOIN Contactos_Clientes CC ON(O.Id_Contacto=CC.Id);");
        while ($fila = mysqli_fetch_object($query)) {
            $Botones = '';
            $status = "";
            $Prioridad = "";

            if ($fila->Status == 'A') {
                $status = '<div class="badge text-white bg-primary">Activo</div>';
                $Botones = '
                <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Modificar" onclick="Datos_Modificar(' . $fila->Id . ')"><i class="fa-solid fa-user-pen fa-beat"></i></button>
                <a type="button" class="btn btn-outline-secondary btn-sm mr-2" href="../Archivos/Ordenes/Formatos.php/Ordenes.php?Num_OT=' . base64_encode($fila->Id) . '" target="_blank" title="Imprimir pdf" onclick=""><i class="fa-regular fa-file-pdf fa-beat"></i></a>
                ';
            } else if ($fila->Status == 'U') {
                $status = '<div class="badge text-white bg-success">Ejecución</div>';
                $Botones = '
                <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Modificar" onclick="Datos_Modificar(' . $fila->Id . ')"><i class="fa-solid fa-user-pen fa-beat"></i></button>
                <a type="button" class="btn btn-outline-secondary btn-sm mr-2" href="../Archivos/Ordenes/Formatos.php/Ordenes.php?Num_OT=' . base64_encode($fila->Id) . '" target="_blank" title="Imprimir pdf" onclick=""><i class="fa-regular fa-file-pdf fa-beat"></i></a>
                ';
            } else if ($fila->Status == 'C') {
                $status = '<div class="badge text-white bg-secondary">Concluido</div>';
                $Botones = '
                <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Modificar" onclick="Datos_Modificar(' . $fila->Id . ')"><i class="fa-solid fa-user-pen fa-beat"></i></button>
                <a type="button" class="btn btn-outline-secondary btn-sm mr-2" href="../Archivos/Ordenes/Formatos.php/Ordenes.php?Num_OT=' . base64_encode($fila->Id) . '" target="_blank" title="Imprimir pdf" onclick=""><i class="fa-regular fa-file-pdf fa-beat"></i></a>
                ';
            } else if ($fila->Status == 'B') {
                $status = '<div class="badge text-white bg-danger">Cancelado</div>';
                $Botones = '
                <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Modificar" onclick="Datos_Modificar(' . $fila->Id . ')"><i class="fa-solid fa-user-pen fa-beat"></i></button>
                <a type="button" class="btn btn-outline-secondary btn-sm mr-2" href="../Archivos/Ordenes/Formatos.php/Ordenes.php?Num_OT=' . base64_encode($fila->Id) . '" target="_blank" title="Imprimir pdf" onclick=""><i class="fa-regular fa-file-pdf fa-beat"></i></a>
                ';
            }

            if ($fila->Prioridad == "Alto") {
                $Prioridad = '<div class="badge text-white bg-danger">Alto</div>';
            } else if ($fila->Prioridad == "Mediano") {
                $Prioridad = '<div class="badge text-white bg-warning">Mediano</div>';
            } else if ($fila->Prioridad == "Bajo") {
                $Prioridad = '<div class="badge text-white bg-success">Bajo</div>';
            }

            $Fechas = '<div class="alert alert-success" role="alert">
                <b>Fecha de inicio: </b> ' . $fila->Fecha_Inicio . ' <br>
                <b>Fecha final: </b> ' . $fila->Fecha_Final . '
            </div>';

            $datos[] = array(
                "0" => "<div class='text-center'>$fila->Id</div>",
                "1" => "<div class='text-left'>$fila->Cliente</div>",
                "2" => "<div class='text-left'>$fila->Obra</div>",
                "3" => "<div class='text-left'>$fila->Proyecto</div>",
                "4" => "<div class='text-left'>$fila->Contacto</div>",
                "5" => $Prioridad,
                "6" => "<div class='text-left'>$Fechas</div>",
                "7" => "<div class='text-left'>$fila->Detalles</div>",
                "8" => "<div class='text-center'>$status</div>",
                "9" => "<div class='d-flex justify-content-center'>$Botones</div>",
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
    case 'Datos_Modificar':
        $query = ejecutarConsultaSimpleFila("SELECT*FROM Ordenes_Trabajo WHERE Id='$Id'");
        echo json_encode($query);
        break;
    case 'Ejecucion_Ot':
        $query = ejecutarConsulta("UPDATE Ordenes_Trabajo SET Status='U', Fecha_Ejecucion='$Fecha_Actual',Fecha_Modificacion='$Fecha_Actual' WHERE Id='$Id'");
        echo $query ? 200 : 201;
        break;
}
