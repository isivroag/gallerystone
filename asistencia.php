<?php
$pagina = "asistencia";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = (isset($_GET['fecha'])) ? $_GET['fecha'] : date('Y-m-d');



$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-lightblue text-light">
                <h1 class="card-title mx-auto">Registro de Asistencias</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <a href="help/asistencia/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a>
                    </div>
                </div>
                <br>


                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-gradient-lightblue">
                            Seleccionar Fecha de Asistencias
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Fecha:</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha ?>">
                                    </div>
                                </div>



                                <div class="col-lg-1 align-self-end text-center">
                                    <div class="form-group input-group-sm">
                                        <button id="btnconsulta" name="btnconsulta" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-lightblue">
                                        <tr>
                                            <th>Reg</th>
                                            <th>Id Per</th>
                                            <th>Nombre</th>
                                            <th>Id Asis</th>
                                            <th>Asistencia</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $consulta = "CALL sp_asistencia('$fecha')";
                                        $resultado = $conexion->prepare($consulta);
                                        $resultado->execute();
                                        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_reg'] ?></td>
                                                <td><?php echo $dat['id_per'] ?></td>
                                                <td><?php echo $dat['nom_per'] ?></td>
                                                <td><?php echo $dat['tipo'] ?></td>
                                                <td><?php echo $dat['tipon'] ?></td>
                                                <td></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>


    <section>
        <div class="modal fade" id="modalAsistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg   " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-lightblue">
                        <h5 class="modal-title" id="exampleModalLabel">Registro de Asistencia</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-7">

                                    <input type="hidden" class="form-control" name="idreg" id="idreg" autocomplete="off" placeholder="Nombre">
                                    <input type="hidden" class="form-control" name="idper" id="idper" autocomplete="off" placeholder="Nombre">
                                    <div class="form-group input-group-sm">
                                        <label for="nombre" class="col-form-label">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" placeholder="Nombre" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha2" class="col-form-label">Fecha:</label>
                                        <input type="date" class="form-control" name="fecha2" id="fecha2" value="<?php echo $fecha ?>" disabled>
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="tipo" class="col-form-label">Estado de Asistencia:</label>
                                        <select class="form-control" name="tipo" id="tipo">
                                            <option value="0">NR</option>
                                            <option value="1">ASISTENCIA</option>
                                            <option value="2">FALTA</option>
                                            <option value="3">RETARDO</option>
                                            <!-- NUEVAS OPCIONES 4 DIC 23-->
                                            <option value="4">FALTA JUSTIFICADA</option>
                                            <option value="5">NO CHECO</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/asistencia.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>