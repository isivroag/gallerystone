<?php
$pagina = "cntarptorden";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$consulta = "SELECT * FROM vorden WHERE estado_ord=1 and edo_ord<>'PENDIENTE' ORDER BY folio_ord";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$fecha = date('Y-m-d');
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
        <div class="card ">
            <div class="card-header bg-secondary">
                <h4 class="card-title text-center">ORDENES DE SERVICIO</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <a href="help/consultaorden/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">


                        <div class="card-header bg-gradient-secondary">
                            Selector de Período
                        </div>
                        <div class="card-body p-0">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="tipof" class="col-form-label">Fecha de:</label>
                                        <select class="form-control" name="tipof" id="tipof" value="inicio">
                                            <option id="inicio" value="inicio" selected>Inicio</option>
                                            <option id="limite" value="limite">Limite</option>
                                            <option id="liberacion" value="liberacion">Liberación</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Desde:</label>
                                        <input type="date" class="form-control" name="ini" id="ini">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Hasta:</label>
                                        <input type="date" class="form-control" name="final" id="final">
                                    </div>
                                </div>

                                <div class="col-lg-2 align-self-end text-center">
                                    <div class="form-group input-group-sm">
                                        <button id="btnconsulta" name="btnconsulta" type="button" class="btn bg-gradient-success btn-ms form-control"><i class="fas fa-search"></i> Consultar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">

                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                    </div>
                </div>
                <br>

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-secondary">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Folio Vta</th>
                                            <th>Fecha Inicio</th>
                                            <th>Cliente</th>
                                            <th>Proyecto</th>
                                            <th>Fecha Inst.</th>
                                            <th>Tipo</th>
                                            <th>Progreso</th>
                                            <th>Estado</th>
                                            <th>Fecha Lib</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_ord'] ?></td>
                                                <td><?php echo $dat['folio_vta'] ?></td>
                                                <td><?php echo $dat['fecha_ord'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['concepto_vta'] ?></td>
                                                <td><?php echo $dat['fecha_limite'] ?></td>
                                                <td><?php echo $dat['tipop'] ?></td>
                                                <td><?php echo $dat['avance'] ?></td>
                                                <td><?php echo $dat['edo_ord'] ?></td>
                                                <td><?php echo ($dat['fecha_liberacion'] != '2000-01-01') ? $dat['fecha_liberacion'] : '' ?></td>
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

        </div>
        <!-- /.card -->

    </section>




    <!-- /.content -->
</div>
<!-- Resumen de Pagos -->



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntarptorden.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>