<?php
$pagina = "resultados";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);







?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
    .fill {
        border: none;
        border-bottom: 1px dotted #000;
        display: inline-block;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-purple text-light">
                <h1 class="card-title mx-auto">ESTADO DE RESULTADOS</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        <button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button>

                    </div>
                </div>

                <br>

                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-primary" style="margin:0px;padding:8px">

                                <h1 class="card-title  ">ESTADO DE RESULTADOS</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="form-group row justify-content-sm-center">
                                    <div class="col-sm-12 form-group">
                                        <div class="card-header " style="margin:0px;padding:8px">

                                            <h1 class="card-title bg-gradient-success ">INGRESOS</h1>
                                        </div>
                                        <div class="row justify-content-between m-2">
                                            <div>
                                                <label for="nombre" class="col-form-label">PARTIDA DE INGRESOS: </label>
                                            </div>

                                            <div class="col-sm-6 fill"></div>

                                            <div class="col-sm-4">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-between m-2">
                                            <div>
                                                <label for="nombre" class="col-form-label">PARTIDA DE INGRESOS 2: </label>
                                            </div>

                                            <div class="col-sm-6 fill"></div>

                                            <div class="col-sm-4">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-header " style="margin:0px;padding:8px">

                                            <h1 class="card-title bg-gradient-purple">EGRESOS</h1>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>
                        <!-- Formulario Agrear Item -->


                    </div>


                </form>

            </div>

        </div>

        <!-- /.card -->

    </section>






    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src=""></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>