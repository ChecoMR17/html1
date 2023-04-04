<?php session_start();
if (!isset($_SESSION['Id_Empleado'])) {
    header("location:../../../../index.php");
}
include "../../../global/conexion.php";
$Fecha_Actual = date("Y-m-d");
$Num_OT = base64_decode($_GET['Num_OT']);
$Datos_OT = ejecutarConsultaSimpleFila("SELECT O.Id,concat_ws(' ',C.Nombre,C.Apellido_P ,C.Apellido_M) AS Cliente,Ob.Nombre_Obra AS Obra,CC.Nombre AS Clasificacion,O.Prioridad
,O.Proyecto,E1.Nombre,M1.Nombre,Ob.Colonia,Ob.Calle,Ob.N_Exterior,Ob.N_Interior,Ob.Codigo_P,concat_ws(' ',CC.Nombre,CC.Apellido_P,CC.Apellido_M) AS Contacto,CC.Telefono,CC.Celular,CC.Correo_C,CC.Correo_P ,O.Prioridad,O.Fecha_Inicio,O.Fecha_Final,date_format(O.Fecha_Alta,'%Y-%m-%d') AS Fecha_Alta,date_format(O.Fecha_Ejecucion,'%Y-%m-%d')  AS Fecha_Ejecucion,O.Fecha_Inicio,O.Fecha_Final,O.Detalles,O.Status FROM Ordenes_Trabajo O
LEFT JOIN Clientes C on(O.Id_Cliente=C.Id)
LEFT JOIN Obras Ob ON (O.Id_Obra=Ob.Id)
LEFT JOIN Contactos_Clientes CC ON(O.Id_Contacto=CC.Id)
LEFT JOIN Estados E1 ON(Ob.Id_Estado=E1.Id_Estado)
LEFT JOIN Municipios M1 ON(Ob.Id_Municipios=M1.Id_Municipios)
LEFT JOIN Clasificaciones CL ON(Ob.Id_Clasificacion=CL.Id)
WHERE O.Id='$Num_OT';");

$Datos_OT['Telefono'] = ($Datos_OT['Telefono'] != '') ? ", " . $Datos_OT['Telefono'] : "";
$Telefonos = $Datos_OT['Celular'] . $Datos_OT['Telefono'];
$Datos_OT['Correo_P'] = ($Datos_OT['Correo_P'] != '') ? ", " . $Datos_OT['Correo_P'] : "";
$Correo = $Datos_OT['Correo_C'] . $Datos_OT['Correo_P'];
$Datos_OT['N_Exterior'] = ($Datos_OT['N_Exterior'] == "0") ? "S/N" : $Datos_OT['N_Exterior'];
$Datos_OT['N_Interior'] = ($Datos_OT['N_Interior'] != "0") ? ", # " . $Datos_OT['N_Interior'] . " " : "";
$Direccion = "C " . $Datos_OT['Calle'] . ", # " . $Datos_OT['N_Exterior'] . $Datos_OT['N_Interior'] . ", Loc. " . $Datos_OT['Colonia'] . ", CP. " . $Datos_OT['Codigo_P'] . ", " . $Datos_OT['Municipio'] . ", " . $Datos_OT['Estado'];

$Status = "";
$Marca_Agua = "";
$Prioridad = "";
if ($Datos_OT['Status'] == "A") {
    $Status = "Activo";
} else if ($Datos_OT['Status'] == "U") {
    $Status = "Ejecución";
} else if ($Datos_OT['Status'] == "C") {
    $Status = "Concluido";
} else if ($Datos_OT['Status'] == "B") {
    $Status = "Cancelado";
    $Marca_Agua = "backimg='../../../img/cancelado.jpg'";
}
if ($Datos_OT['Prioridad'] == "Alto") {
    $Prioridad = "<span class='text_danger'>Alto</span>";
} else if ($Datos_OT['Prioridad'] == "Mediano") {
    $Prioridad = "<span class='text_warning'>Mediano</span>";
} else if ($Datos_OT['Prioridad'] == "Bajo") {
    $Prioridad = "<span class='text_success'>Bajo</span>";
}

ob_start();
?>
<style>
    .text_Center {
        text-align: center;
    }

    .text_right {
        text-align: right;
    }

    .text_left {
        text-align: left;
    }

    .Color_Fondo {
        background-color: #b1c797;
    }

    .text_danger {
        color: #dc3545;
    }

    .text_warning {
        color: #ffc107;
    }

    .text_success {
        color: #28a745;
    }

    .text_info {
        background-color: #ffff99;
    }

    @media all {
        .page-break {
            display: none;
            page-break-after: avoid
        }
    }

    @media print {
        .page-break {
            display: block;
            page-break-before: always;
        }
    }
</style>
<page backtop="5mm" backbottom="10mm" backleft="0mm" backright="1mm" <?php echo $Marca_Agua; ?>>
    <div class="page-break" style="position: absolute;">

        <table border="0" align="left" cellspacing=0 cellpadding=0 class="">
            <tr>
                <td style="width: 150px;"><img src="../../../img/Logo.png" alt="Logo" width="150"></td>
                <td style="width: 400px;">
                    <h4>Automatización y Sistemas de Bombeo</h4>
                    Ingeniería aplicada a sistemas de bombeo y Tratamiento de aguas residuales
                </td>
                <td style="width:200px"></td>
            </tr>
            <tr>
                <td colspan="3" class="text_Center Color_Fondo">
                    <b>ORDEN DE TRABAJO</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text_right"><b>N° de orden de trabajo:</b> <?php echo $Num_OT; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_right"><b>Fecha:</b> <?php echo $Fecha_Actual; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Fecha de elaboración:</b><?php echo $Datos_OT['Fecha_Alta']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Fecha de ejecución:</b> <?php echo $Datos_OT['Fecha_Ejecucion']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="" style="height: 20px;"></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left text_info"><b>Datos del cliente</b></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Nombre: </b> <?php echo $Datos_OT['Cliente']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Obra: </b> <?php echo $Datos_OT['Obra']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Contacto: </b> <?php echo $Datos_OT['Contacto']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Teléfono: </b> <?php echo $Telefonos; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Email: </b> <?php echo $Correo; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="" style="height: 20px;"></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left text_info"><b>Datos de proyecto</b> </td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Proyecto: </b> <?php echo $Datos_OT['Proyecto']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Lugar: </b><?php echo $Direccion; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Clasificación:</b> <?php echo $Datos_OT['Clasificacion']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Prioridad:</b> <?php echo $Prioridad; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left"><b>Status:</b> <?php echo $Status; ?></td>
            </tr>
            <tr>
                <td class="text_left"><b>Fecha de inicio:</b> <?php echo $Datos_OT['Fecha_Inicio']; ?></td>
                <td colspan="2" class="text_left"> <b> Fecha final:</b> <?php echo $Datos_OT['Fecha_Final']; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text_Center"><b>Instrucciones de talladas</b></td>
            </tr>
            <tr>
                <td colspan="3" class="text_left" style="height: 150px;"> <?php echo nl2br($Datos_OT['Detalles']); ?></td>
            </tr>

        </table>
    </div>
</page>
<page_footer>
    <table align="left" border="0" cellspacing=0 cellpadding=0>
        <tr>
            <th style="width: 550px;">Privada Leona Vicario 10, Santa Rosa 30 centro, C.P.: 62772, Tlaltizapán Morelos.</th>
            <th style="width: 200px;" class="text_left">
                <a href="www.asbombeo.com" target="_blank" rel="noopener noreferrer">www.asbombeo.com</a> <br>
                <a href="ventas@asbombeo.com" target="_blank" rel="noopener noreferrer">ventas@asbombeo.com</a> <br>
                <a href="#" target="_blank" rel="noopener noreferrer">Teléfono: 734 108 96 80</a>

            </th>
        </tr>
    </table>
</page_footer>
<?php
$content = ob_get_clean();
require __DIR__ . '../../../../Library/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'LETTER', 'es', 'true', 'UTF-8');
$html2pdf->writeHTML($content);
$html2pdf->output('Orden de trabajo.pdf');
sqlsrv_close($conn);
?>