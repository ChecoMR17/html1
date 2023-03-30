<?php
session_start();
if (isset($_SESSION['Id_Empleado'])) {
    include "../global/Header.php";
?>
    <title>Usuarios</title>
    </head>

    <body>
        <?php include "../global/menu.php"; ?>
        <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row" id="Agregar_Usuarios" name="Agregar_Usuarios">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                <h1 class="alert alert-primary rounded-pill" role="alert">Alta de empleados</h1>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1" hidden>
                <label for="Id">Id</label>
                <input type="text" class="form-control form-control-sm" id="Id" name="Id" readonly>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Nombre">Nombre <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="Nombre" name="Nombre" maxlength="20" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="A_Paterno">Apellido paterno <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="A_Paterno" name="A_Paterno" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="A_Materno">Apellido materno <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="A_Materno" name="A_Materno" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="Genero">Genero <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm selectpicker" title="-------------------------" name="Genero" id="Genero" required>
                    <option class="text-dark" value="Masculino">Masculino</option>
                    <option class="text-dark" value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="FRC">RFC</label>
                <input type="text" class="form-control form-control-sm" id="FRC" name="FRC" maxlength="13" minlength="13">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Curp">Curp</label>
                <input type="text" class="form-control form-control-sm" id="Curp" name="Curp" maxlength="18" minlength="18">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="N_Seguro"> Nº seguro social</label>
                <input type="text" class="form-control form-control-sm" id="N_Seguro" name="N_Seguro" maxlength="11" minlength="11">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Correo">Correo <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-sm" id="Correo" name="Correo" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="Celular">Celular <span class="text-danger">*</span></label>
                <input type="tel" pattern="[0-9]{10}" title="El numero telefónico debe tener 10 dígitos" class="form-control form-control-sm" id="Celular" name="Celular" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="Telefono">Teléfono </label>
                <input type="tel" pattern="[0-9]{10}" title="El numero telefónico debe tener 10 dígitos" class="form-control form-control-sm" id="Telefono" name="Telefono">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="F_Ingreso"> Fecha de ingreso <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-sm" id="F_Ingreso" name="F_Ingreso" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label for="Observaciones"> Observaciones</label>
                <textarea name="Observaciones" id="Observaciones" rows="3" class="form-control"></textarea>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-3">
                <h1 class="alert alert-success rounded-pill" role="alert">Domicilio</h1>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Estado">Estado <span class="text-danger">*</span></label>
                <select name="Estado" id="Estado" class="form-control form-control-sm" onchange="Buscar_Municipios()" title="-------------------------" data-live-search="true" required></select>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Municipio">Municipio <span class="text-danger">*</span></label>
                <select name="Municipio" id="Municipio" class="form-control form-control-sm" title="-------------------------" data-live-search="true" required></select>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label for="Calle">Calle <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="Calle" name="Calle" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="N_Exterior"> N° Exterior <span class="text-danger">*</span></label>
                <input type="number" step="0.001" class="form-control form-control-sm" id="N_Exterior" name="N_Exterior" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="N_Interior"> N° Interior</label>
                <input type="number" step="0.001" class="form-control form-control-sm" id="N_Interior" name="N_Interior">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label for="Colonia">Colonia <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="Colonia" name="Colonia" required>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label for="CP"> Código postal <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm" id="CP" name="CP" required>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                <button type="reset" class="btn btn-outline-secondary btn-sm mr-2" id="Btn_Limpiar_AE">Limpiar <i class="fa-solid fa-broom"></i></button>
                <button type="submit" class="btn btn-outline-primary btn-sm">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-end d-flex mt-3">
                <button type="button" class="btn btn-warning btn-sm mr-2" onclick="Mostrar_Lista_Usuarios()" data-toggle="modal" data-target="#Alta_Usuarios">Alta de usuarios <i class="fas fa-users"></i></button>
            </div>

            <!--div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-end d-flex mt-3">
            <button type="button" class="btn btn-warning btn-sm mr-2" onclick="Mostrar_Lista_Empleados()" data-toggle="modal" data-target="#Alta_Areas">Alta de areas y puestos <i class="fa-solid fa-building"></i></button>
        </div-->
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive mt-4">
                <table class="table table-hover table-sm" id="Tbl_Empleados">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>CORREO</th>
                            <th>TELÉFONO</th>
                            <th>CELULAR</th>
                            <th>DIRECCIÓN</th>
                            <th>OBSERVACIONES</th>
                            <th>STATUS</th>
                            <th>--------</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="Alta_Usuarios" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-primary" id="">Alta de usuarios <i class="fa-solid fa-users"></i></h4>
                        <button type="button" class="close" data-dismiss="modal" onclick="Boton_Limpiar_UE()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row" id="Form_Usuarios" name="Form_Usuarios">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" hidden>
                                <label for="Id_Usuario">Id</label>
                                <input type="text" class="form-control form-control-sm" id="Id_Usuario" name="Id_Usuario" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <label for="Nombre_Emp">Nombre <span class="text-danger">*</span></label>
                                <select name="Nombre_Emp" id="Nombre_Emp" class="form-control form-control-sm" title="-------------------------" data-live-search="true" required></select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="Nombre_Usuario">Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="Nombre_Usuario" name="Nombre_Usuario" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="Contraseña">Contraseña <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="Contraseña" name="Contraseña" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="Rol">Rol <span class="text-danger">*</span></label>
                                <select name="Rol" id="Rol" class="form-control form-control-sm selectpicker" title="-------------------------" data-live-search="true" required>
                                    <option class="text-dark" value="0">Admin</option>
                                    <option class="text-dark" value="1">Vendedor</option>
                                    <option class="text-dark" value="2">Técnico</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                                <button type="reset" class="btn btn-outline-secondary btn-sm mr-2" onclick="Boton_Limpiar_UE()" id="Btn_Limpiar_UE">Limpiar <i class="fa-solid fa-broom"></i></button>
                                <button type="submit" class="btn btn-outline-primary btn-sm">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive mt-4">
                                <table class="table table-hover table-sm" id="Tbl_Usuarios">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>NOMBRE</th>
                                            <th>USUARIO</th>
                                            <th>CORREO</th>
                                            <th>ROL</th>
                                            <th>STATUS</th>
                                            <th>--------</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <!--div class="modal fade" id="Alta_Areas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="">Areas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row" id="Form_Areas" name="Form_Areas">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1" hidden>
                            <label for="Id_Area">Id</label>
                            <input type="text" class="form-control form-control-sm" id="Id_Area" name="Id_Area" readonly>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                            <label for="Nombre_Area">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="Nombre_Area" name="Nombre_Area" required>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                            <label for="Encargado_Area">Encargado(a)</label>
                            <input type="text" class="form-control form-control-sm" id="Encargado_Area" name="Encargado_Area">
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                            <button type="reset" class="btn btn-outline-secondary btn-sm mr-2" id="Btn_L_A">Limpiar <i class="fa-solid fa-broom"></i></button>
                            <button type="submit" class="btn btn-outline-primary btn-sm">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive mt-4">
                            <table class="table table-hover table-sm" id="Tbl_Areas">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre</th>
                                        <th>Encargado</th>
                                        <th>Status</th>
                                        <th>----------</th>
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
    </div-->

        <!-- Modal -->
        <!--div class="modal fade" id="Alta_Puestos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="">Areas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row" id="Form_Areas" name="Form_Areas">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1" hidden>
                            <label for="Id_Area">Id</label>
                            <input type="text" class="form-control form-control-sm" id="Id_Area" name="Id_Area" readonly>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                            <label for="Nombre_Area">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="Nombre_Area" name="Nombre_Area" required>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                            <label for="Encargado_Area">Encargado(a)</label>
                            <input type="text" class="form-control form-control-sm" id="Encargado_Area" name="Encargado_Area">
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                            <button type="reset" class="btn btn-outline-secondary btn-sm mr-2" id="Btn_L_A">Limpiar <i class="fa-solid fa-broom"></i></button>
                            <button type="submit" class="btn btn-outline-primary btn-sm">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive mt-4">
                            <table class="table table-hover table-sm" id="Tbl_Puestos">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre</th>
                                        <th>Encargado</th>
                                        <th>Status</th>
                                        <th>----------</th>
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
    </div-->

        <?php include "../global/Fooder.php"; ?>
        <script src="../js/Empleados.js"></script>
    </body>

    </html>

<?php
} else {
    header("location:../index.php");
}
?>