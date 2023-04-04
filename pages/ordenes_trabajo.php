<?php
session_start();
if (isset($_SESSION['Id_Empleado'])) {
    include "../global/Header.php"; ?>
    <title>Ordenes de trabajo</title>
    </head>

    <body>
        <?php include "../global/menu.php"; ?>
        <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-start d-flex row was-validated" id="Form_Ordenes_Trabajo">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                <h1 class="alert alert-primary rounded-pill" role="alert">Ordenes de trabajo <i class="fa-solid fa-person-digging fa-beat"></i></h1>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="Id">Folio</label>
                <input type="text" class="form-control form-control-sm" id="Id" name="Id" readonly>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label for="Cliente">Cliente </label>
                <select name="Cliente" id="Cliente" class="form-control form-control-sm " onchange="Buscar_Obras()" data-live-search="true" title="----------------------------------------------" required></select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label for="Obras">Obras </label>
                <select name="Obras" id="Obras" class="form-control form-control-sm " title="----------------------------------------------" required></select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label for="Contactos">Contactos</label>
                <select name="Contactos" id="Contactos" class="form-control form-control-sm " title="----------------------------------------------" required></select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Prioridad">Prioridad</label>
                <select name="Prioridad" id="Prioridad" class="form-control form-control-sm  selectpicker show-tick" title="----------------------------------------------" required>
                    <option class="text-danger" value="Alto">Alto</option>
                    <option class="text-warning" value="Mediano">Mediano</option>
                    <option class="text-success" value="Bajo">Bajo</option>
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-5">
                <label for="Proyecto">Proyecto</label>
                <input type="text" class="form-control form-control-sm " id="Proyecto" name="Proyecto" maxlength="200" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Fecha_Inicio">Fecha de inicio</label>
                <input type="date" class="form-control form-control-sm " id="Fecha_Inicio" name="Fecha_Inicio" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Fecha_Final">Fecha de final</label>
                <input type="date" class="form-control form-control-sm " id="Fecha_Final" name="Fecha_Final" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-3 justify-content-center d-flex mt-auto row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label for="Fecha_Inicio">Status</label>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Opciones_Status" id="S_Ejecucion" value="U">
                        <label class="form-check-label text-success" for="S_Ejecucion">En Ejecución</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Opciones_Status" id="S_Concluido" value="C" disabled>
                        <label class="form-check-label text-secondary" for="S_Concluido">Concluido</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Opciones_Status" id="S_Cancelado" value="B" disabled>
                        <label class="form-check-label text-danger" for="S_Cancelado">Cancelado</label>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label for="Detalles">Instrucciones detalladas</label>
                <textarea name="Detalles" id="Detalles" rows="5" class="form-control " maxlength="5000"></textarea>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar <i class="fa-solid fa-floppy-disk fa-beat"></i></button>
                <button type="reset" class="btn btn-outline-secondary btn-sm" id="" onclick="Limpiar_F_OT()">Limpiar <i class="fa-solid fa-eraser fa-beat"></i></button>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive mt-4">
                <table class="table table-hover table-sm" id="Tbl_Ordenes_Trabajo">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2">Folio</th>
                            <th rowspan="2">Cliente</th>
                            <th colspan="4">Datos de obra</th>
                            <th rowspan="2">Fechas</th>
                            <th rowspan="2">Detalles</th>
                            <th rowspan="2">Status</th>
                            <th rowspan="2">--------</th>
                        </tr>
                        <tr>
                            <th>Obra</th>
                            <th>Proyecto</th>
                            <th>Contacto</th>
                            <th>Prioridad</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </form>

        <?php include "../global/Fooder.php"; ?>
        <script src="../js/ot.js"></script>
    </body>

    </html>
<?php
} else {
    header("location:../index.php");
}
?>