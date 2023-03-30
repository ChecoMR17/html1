<?php
include "../../global/conexion.php";
//Varibales
date_default_timezone_set('America/Mexico_City');
$Fecha_Actual = date("Y-m-d H:i:s");
$Id = isset($_POST['Id']) ? $_POST['Id'] : "";
$Nombre = isset($_POST['Nombre']) ? $_POST['Nombre'] : "";

$A_Paterno = isset($_POST['A_Paterno']) ? $_POST['A_Paterno'] : "";
$A_Materno = isset($_POST['A_Materno']) ? $_POST['A_Materno'] : "";

$Genero = isset($_POST['Genero']) ? $_POST['Genero'] : "";
$FRC = isset($_POST['FRC']) ? $_POST['FRC'] : "";
$Curp = isset($_POST['Curp']) ? $_POST['Curp'] : "";
$N_Seguro = isset($_POST['N_Seguro']) ? $_POST['N_Seguro'] : "";
$Correo = isset($_POST['Correo']) ? $_POST['Correo'] : "";
$Celular = isset($_POST['Celular']) ? $_POST['Celular'] : "";
$Telefono = isset($_POST['Telefono']) ? $_POST['Telefono'] : "";
$F_Ingreso = isset($_POST['F_Ingreso']) ? $_POST['F_Ingreso'] : "";
$Area = isset($_POST['Area']) ? $_POST['Area'] : "";
$Puesto = isset($_POST['Puesto']) ? $_POST['Puesto'] : "";
$D_Laborales = isset($_POST['D_Laborales']) ? $_POST['D_Laborales'] : "";
$Sueldo = isset($_POST['Sueldo']) ? $_POST['Sueldo'] : "";
$Observaciones = isset($_POST['Observaciones']) ? $_POST['Observaciones'] : "";

$Estado = isset($_POST['Estado']) ? $_POST['Estado'] : "";
$Municipio = isset($_POST['Municipio']) ? $_POST['Municipio'] : "";
$Calle = isset($_POST['Calle']) ? $_POST['Calle'] : "";
$N_Exterior = isset($_POST['N_Exterior']) ? $_POST['N_Exterior'] : 0;
$N_Interior = !empty($_POST['N_Interior']) ? $_POST['N_Interior'] : 0;
$Colonia = isset($_POST['Colonia']) ? $_POST['Colonia'] : "";
$Codigo_P = isset($_POST['CP']) ? $_POST['CP'] : "";


$Id_Usuario = isset($_POST['Id_Usuario']) ? $_POST['Id_Usuario'] : "";
$Nombre_Emp = isset($_POST['Nombre_Emp']) ? $_POST['Nombre_Emp'] : "";
$Nombre_Usuario = isset($_POST['Nombre_Usuario']) ? $_POST['Nombre_Usuario'] : "";
$Contraseña = isset($_POST['Contraseña']) ? $_POST['Contraseña'] : "";
$Rol = isset($_POST['Rol']) ? $_POST['Rol'] : "";


$datos = array();
$salida = "";
switch ($_GET["op"]) {
    case 'Guardar_Actualizar_Empleados':
        if ($Id == "") { // Insert
            //Validamos que no exista
            $Count = ejecutarConsultaSimpleFila("SELECT COUNT(*) FROM Empleados WHERE Nombre='$Nombre' AND Apellido_P='$A_Paterno' AND Apellido_M='$A_Materno'")[0];
            if ($Count == 0) {
                $query = ejecutarConsulta("INSERT INTO Empleados (Nombre,Apellido_P,Apellido_M,Genero,RFC,Curp,N_Social,Correo,Celular,Telefono,Fecha_Ingreso,Fecha_alta,Observaciones,
                Dias_Laborales,Sueldo,Id_Estado,Id_Municipios,Colonia,Calle,N_Exterior,N_Interior,Codigo_P,Status) 
                VALUES ('$Nombre','$A_Paterno','$A_Materno','$Genero','$FRC','$Curp','$N_Seguro','$Correo','$Celular','$Telefono','$F_Ingreso','$Fecha_Actual',
                '$Observaciones','0','0','$Estado','$Municipio','$Colonia','$Calle','$N_Exterior','$N_Interior','$Codigo_P','A');");
                echo $query ? 200 : 201;
            } else {
                echo 202;
            }
        } else { // Update
            $query = ejecutarConsulta("UPDATE Empleados SET  Nombre='$Nombre',Apellido_P='$A_Paterno',Apellido_M='$A_Materno',Genero='$Genero',RFC='$FRC',Curp='$Curp',N_Social='$N_Seguro',Correo='$Correo',Celular='$Celular',Telefono='$Telefono',Fecha_Ingreso='$F_Ingreso', Fecha_Modificacion='$Fecha_Actual',Observaciones='$Observaciones',Id_Estado='$Estado',Id_Municipios='$Municipio',Colonia='$Colonia',Calle='$Calle',N_Exterior='$N_Exterior',N_Interior='$N_Interior',Codigo_P='$Codigo_P' WHERE Id_Empleado='$Id';");
            echo $query ? 200 : 201;
        }
        break;
    case 'Datos_A_Editar':
        $query = ejecutarConsultaSimpleFila("SELECT * FROM Empleados WHERE Id_Empleado='$Id'");
        echo json_encode($query);
        break;
    case 'Baja_Empleado':
        $query = ejecutarConsulta("UPDATE Empleados SET Status='B',Fecha_baja='$Fecha_Actual' WHERE Id_Empleado='$Id';");
        if ($query) {
            $sql = ejecutarConsulta("UPDATE User SET Status='B' WHERE Id_Empleado='$Id'");
            echo $sql ? 200 : 201;
        } else {
            echo 201;
        }
        break;
    case 'Reactivar_Empleado':
        $query = ejecutarConsulta("UPDATE Empleados SET Status='A',Fecha_Modificacion='$Fecha_Actual' WHERE Id_Empleado='$Id';");
        echo $query ? 200 : 201;
        break;
    case 'Mostrar_Tbl_Empleados';
        $query = ejecutarConsulta("SELECT EMP.*, E.Nombre AS Estado,M.Nombre AS Municipio FROM Empleados EMP
        LEFT JOIN Estados E ON(EMP.Id_Estado=E.Id_Estado)
        LEFT JOIN Municipios M ON(EMP.Id_Municipios=M.Id_Municipios)");
        while ($fila = mysqli_fetch_object($query)) {
            $Botones = '';
            $status = "";
            if ($fila->Status == "A") {
                $status = '<div class="col badge text-white bg-primary">Activo</div>';
                $Botones = '
                <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Modificar" onclick="Datos_A_Editar(' . $fila->Id_Empleado . ')"><i class="fa-solid fa-user-pen"></i></button>
                <button type="button" class="btn btn-outline-danger btn-sm" title="Baja" onclick="Baja_Empleado(' . $fila->Id_Empleado . ')"><i class="fa-solid fa-xmark"></i></button>
                ';
            } else {
                $status = '<div class="col badge text-white bg-danger">Baja</div>';
                $Botones = '
                <button type="button" class="btn btn-outline-success btn-sm mr-2" title="Reactivar Empleado" onclick="Reactivar_Empleado(' . $fila->Id_Empleado . ')" ><i class="fa-solid fa-check"></i></button>
                ';
            }
            $fila->N_Exterior = ($fila->N_Exterior == "0") ? "S/N" : $fila->N_Exterior;
            $fila->N_Interior = ($fila->N_Interior != "0") ? ", # " . $fila->N_Interior . " " : "";

            $Direccion = "C " . $fila->Calle . ", # " . $fila->N_Exterior . $fila->N_Interior . ", Loc. " . $fila->Colonia . ", CP. " . $fila->Codigo_P . ", " . $fila->Municipio . ", " . $fila->Estado;

            $datos[] = array(
                "0" => "<div class='text-left'>$fila->Nombre $fila->Apellido_P $fila->Apellido_M</div>",
                "1" => "<div class='text-left'>$fila->Correo</div>",
                "2" => "<div class='text-left'>$fila->Telefono</div>",
                "3" => "<div class='text-left'>$fila->Celular</div>",
                "4" => "<div class='text-left'>$Direccion</div>",
                "5" => "<div class='text-left'>$fila->Observaciones</div>",
                "6" => $status,
                "7" => "<div class='d-flex justify-content-center'>$Botones</div>",
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
    case 'Mostrar_Estados':
        $query = ejecutarConsulta("SELECT*FROM Estados ORDER BY Nombre ASC;");
        while ($fila = mysqli_fetch_object($query)) {
            $salida .= "<option class='text-dark' value='$fila->Id_Estado'>$fila->Nombre</option>";
        }
        echo $salida;
        break;
    case 'Buscar_Municipios':
        $query = ejecutarConsulta("SELECT*FROM Municipios WHERE Id_Estado='$Estado' ORDER BY Nombre ASC;");
        while ($fila = mysqli_fetch_object($query)) {
            $salida .= "<option class='text-dark' value='$fila->Id_Municipios'>$fila->Nombre</option>";
        }
        echo $salida;
        break;
    case 'Mostrar_Empleados':
        $query = ejecutarConsulta("SELECT*FROM Empleados WHERE Status='A'");
        while ($fila = mysqli_fetch_object($query)) {
            $salida .= "<option class='text-dark' value='$fila->Id_Empleado'>$fila->Nombre $fila->Apellido_P $fila->Apellido_M</option>";
        }
        echo $salida;
        break;
        /**------------------------------------ USUARIOS -------------------------------------- */
    case 'Guardar_Usuario':
        $pwd_hash = password_hash($Contraseña, PASSWORD_DEFAULT);
        if ($Id_Usuario == "") { // Insert
            // Validamos que el usuario no exista
            $Count = ejecutarConsultaSimpleFila("SELECT COUNT(*) FROM User WHERE Usuario='$Nombre_Usuario'")[0];
            if ($Count == 0) {
                $query = ejecutarConsulta("INSERT INTO User(Id_Empleado,Usuario,Contraseña,Rol,Fecha_Alta,Activo,Status) VALUES('$Nombre_Emp','$Nombre_Usuario','$pwd_hash','$Rol','$Fecha_Actual','0','A')");
                echo $query ? 200 : 201;
            } else {
                echo 202;
            }
        } else { // Update
            $query = ejecutarConsulta("UPDATE User SET Id_Empleado='$Nombre_Emp', Usuario='$Nombre_Usuario' , Contraseña='$pwd_hash', Rol='$Rol',Fecha_Modificacion='$Fecha_Actual' WHERE Id='$Id_Usuario'");
            echo $query ? 200 : 201;
        }
        break;
    case 'Datos_A_Editar_Usuarios':
        $query = ejecutarConsultaSimpleFila("SELECT*FROM User WHERE Id='$Id'");
        echo json_encode($query);
        break;
    case 'Baja_Usuario':
        $query = ejecutarConsulta("UPDATE User SET Status='B',Fecha_Baja='$Fecha_Actual' WHERE Id='$Id'");
        echo $query ? 200 : 201;
        break;
    case 'Reactivar_Usuario':
        $query = ejecutarConsulta("UPDATE User SET Status='A',Fecha_Modificacion='$Fecha_Actual' WHERE Id='$Id'");
        echo $query ? 200 : 201;
        break;
    case 'Mostrar_Lista_Usuarios';
        $query = ejecutarConsulta("SELECT U.*,E.Nombre,E.Apellido_P,E.Apellido_M,E.Correo FROM User U 
        LEFT JOIN Empleados E ON(U.Id_Empleado=E.Id_Empleado)");
        while ($fila = mysqli_fetch_object($query)) {
            $Botones = '';
            /**
             *  Roles
             *  0 => Admin
             *  1 => Vendedor
             *  2 => Técnico
             *  */
            $Rol = "";
            $Status = "";
            if ($fila->Rol == "0") {
                $Rol = '<div class="col badge text-white bg-secondary">Admin</div>';
            } else if ($fila->Rol == "1") {
                $Rol = '<div class="col badge text-white bg-info">Vendedor</div>';
            } else if ($fila->Rol == "2") {
                $Rol = '<div class="col badge text-white bg-success">Técnico</div>';
            }

            if ($fila->Status == "A") {
                $Status = '<div class="col badge text-white bg-primary">Activo</div>';
                $Botones = '
                <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Modificar" onclick="Datos_A_Editar_Usuarios(' . $fila->Id . ')"><i class="fa-solid fa-user-pen"></i></button>
                <button type="button" class="btn btn-outline-danger btn-sm" title="Baja" onclick="Baja_Usuario(' . $fila->Id . ')"><i class="fa-solid fa-xmark"></i></button>
                ';
            } else if ($fila->Status == "B") {
                $Status = '<div class="col badge text-white bg-danger">Baja</div>';
                $Botones = '
                <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Reactivar usuario" onclick="Reactivar_Usuario(' . $fila->Id . ')"><i class="fa-solid fa-check"></i></button>
                ';
            }
            $datos[] = array(
                "0" => "<div class='text-left'>$fila->Id</div>",
                "1" => "<div class='text-left'>$fila->Nombre $fila->Apellido_P $fila->Apellido_M</div>",
                "2" => "<div class='text-left'>$fila->Usuario</div>",
                "3" => "<div class='text-left'>$fila->Correo</div>",
                "4" => "<div class='text-left'>$Rol</div>",
                "5" => "<div class='text-left'>$Status</div>",
                "6" => "<div class='text-left'>$Botones</div>"
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

        /*
    case 'Guardar_Actualizar_Areas':
        if ($Id_Area == "") { //Insert
            // Validamos que aun no exista
            $Contar = ejecutarConsultaSimpleFila("SELECT COUNT(*) FROM Areas WHERE Nombre='$Nombre_Area' AND Status='A'")[0];
            if ($Contar == 0) {
                $query = ejecutarConsulta("INSERT INTO Areas(Nombre,Encargado_Area,Fecha_A,Status) VALUES('$Nombre_Area','$Encargado_Area','$Fecha_Actual','A')");
                echo $query ? 200 : 201;
            } else {
                echo 202;
            }
        } else { // Update
            $query = ejecutarConsulta("UPDATE Areas SET Nombre='$Nombre_Area', Encargado_Area='$Encargado_Area' WHERE Id='$Id_Area'");
            echo $query ? 200 : 201;
        }
        break;
    case 'Mostrar_Datos_Areas':
        $query = ejecutarConsultaSimpleFila("SELECT*FROM Areas WHERE Id='$Id'");
        echo json_encode($query);
        break;
    case 'Eliminar_Area':
        $query = ejecutarConsulta("UPDATE Areas SET Status='B' WHERE Id='$Id'");
        echo $query ? 200 : 201;
        break;
    case 'Mostrar_Tabla_Areas':
        $query = ejecutarConsulta("SELECT*FROM Areas WHERE Status='A'");
        while ($fila = mysqli_fetch_object($query)) {
            $Botones = '
                <button type="button" class="btn btn-outline-info btn-sm mr-2" title="Modificar dirección" onclick="Mostrar_Datos_Areas(' . $fila->Id . ')"><i class="fa-solid fa-pen-to-square"></i></button>
                <button type="button" class="btn btn-outline-success btn-sm mr-2" title="Agregar puestos" onclick="" data-toggle="modal" data-target="#Alta_Puestos"><i class="fa-solid fa-plus"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm" title="Eliminar dirección" onclick="Eliminar_Area(' . $fila->Id . ')"><i class="fa-solid fa-trash-can"></i></button>
                ';
            $datos[] = array(
                "0" => "<div class='text-left'>$fila->Id</div>",
                "1" => "<div class='text-left'>$fila->Nombre</div>",
                "2" => "<div class='text-left'>$fila->Encargado_Area</div>",
                "3" => "<div class='text-left'></div>",
                "4" => "<div class='d-flex justify-content-center'>$Botones</div>",
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($datos), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($datos), //enviamos el total registros a visualizar
            "aaData" => $datos
        );
        Enviamos los datos de la tabla 
        echo json_encode($results);
        break;*/
}
