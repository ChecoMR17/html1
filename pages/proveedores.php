<?php
session_start();
if (isset($_SESSION['Id_Empleado'])) {
    include "../global/Header.php"; ?>
    <title>Proveedores</title>
    </head>

    <body>
        <?php include "../global/menu.php"; ?>
        <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row was-validated" id="Form_Proveedores" name="Form_Proveedores">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                <h1 class="alert alert-primary rounded-pill" role="alert">Alta de Proveedores <i class="fa-solid fa-people-carry-box fa-beat"></i></h1>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="Id">Id</label>
                <input type="text" class="form-control form-control-sm" id="Id" name="Id" readonly>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="T_Persona">Tipo de persona </label>
                <select name="T_Persona" id="T_Persona" class="form-control form-control-sm selectpicker " onchange="Validar_T_Cliente()" title="---------------------------" required>
                    <option class="text-dark" value="Persona física">Persona física</option>
                    <option class="text-dark" value="Persona moral">Persona moral</option>
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Nombre_Proveedor" id="Nombre_T">Nombre </label>
                <input type="text" class="form-control form-control-sm " id="Nombre_Proveedor" name="Nombre_Proveedor" maxlength="50" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 PF">
                <label for="Apellido_p">Apellido paterno </label>
                <input type="text" class="form-control form-control-sm " id="Apellido_p" name="Apellido_p" maxlength="50">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 PF">
                <label for="Apellido_M">Apellido materno </label>
                <input type="text" class="form-control form-control-sm " id="Apellido_M" name="Apellido_M" maxlength="50">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="RFC">FRC </label>
                <input type="text" class="form-control form-control-sm " id="RFC" name="RFC" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="C_Pago">Condiciones de pago</label>
                <select name="C_Pago" id="C_Pago" class="form-control form-control-sm selectpicker" title="--------------------">
                    <option class="text-dark" value="CONTADO">CONTADO</option>
                    <option class="text-dark" value="CRÉDITO">CRÉDITO</option>
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Giro">Giro </label>
                <input type="text" class="form-control form-control-sm " id="Giro" name="Giro" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Familias">Familias</label>
                <select name="Familias" id="Familias" class="form-control form-control-sm selectpicker" multiple='true' data-live-search="true" title="--------------------"></select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label for="Observaciones">Observaciones</label>
                <textarea name="Observaciones" id="Observaciones" rows="3" class="form-control form-control-sm"></textarea>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar <i class="fa-solid fa-floppy-disk fa-beat"></i></button>
                <button type="reset" class="btn btn-outline-secondary btn-sm" id="">Limpiar <i class="fa-solid fa-eraser fa-beat"></i></button>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-end d-flex mt-3">
                <button type="button" class="btn btn-warning btn-sm" id="" onclick="Mostrar_Lista_Familias()" data-toggle="modal" data-target="#Agregar_Familias">Agregar mas familias <i class="fa-solid fa-grip-lines fa-beat"></i></button>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive mt-4">
                <table class="table table-hover table-sm" id="Tbl_Clientes">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>RFC</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th></th>
                            <th>Status</th>
                            <th>--------</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="Agregar_Familias" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-primary" id="">Alta de familias</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Limpiar()"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row was-validated" id="Form_Familias" name="Form_Familias">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3" hidden>
                                <label for="Id_Proveedores">Id</label>
                                <input type="text" class="form-control form-control-sm" id="Id_Proveedores" name="Id_Proveedores" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                <label for="Nombre_Proveedores">Nombre</label>
                                <input type="text" class="form-control form-control-sm" id="Nombre_Proveedores" name="Nombre_Proveedores" maxlength="50" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="Ganancia">Ganancia</label>
                                <input type="number" step="0.001" class="form-control form-control-sm" id="Ganancia" name="Ganancia" value="30" min="1" max="100" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                                <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar <i class="fa-solid fa-floppy-disk fa-beat"></i></button>
                                <button type="reset" class="btn btn-outline-secondary btn-sm" id="Btn_Limpiar_Pr">Limpiar <i class="fa-solid fa-eraser fa-beat"></i></button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive mt-4">
                                <table class="table table-hover table-sm" id="Tbl_Familias">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Nombre</th>
                                            <th>Ganancia</th>
                                            <th>--------</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <?php include "../global/Fooder.php"; ?>
        <script src="../js/proveedores.js"></script>
    </body>

    </html>
<?php
} else {
    header("location:../index.php");
}
?>