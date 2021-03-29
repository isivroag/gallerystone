<?php
$pagina = "cobranza";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$mes = (isset($_GET['mes'])) ? $_GET['mes'] : date("m");
$ejercicio = (isset($_GET['ejercicio'])) ? $_GET['ejercicio'] : date("Y");
$concepto = (isset($_GET['concepto'])) ? $_GET['concepto'] : date("Y");

$consulta = "SELECT folio_cxp,nombre,concepto,total FROM vcxp WHERE month(fecha)='$mes' and year(fecha)='$ejercicio' and estado_cxp=1 and nom_partida='$concepto'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$message = "";
$total = 0;
foreach ($data as $reg) {
    $total += $reg['total'];
}


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
            <div class="card-header bg-gradient-purple">
                <h4 class="card-title text-center">DETALLE DE EGRESOS POR <b> <?php echo $concepto?></b> </h4>
            </div>

            <div class="card-body">
            <div class="row">
                    <div class="col-sm-12">
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <h4>CONCEPTO: <b> <?php echo $concepto ?></b></h4>

                            </div>
                            <div class="col-sm-2">
                                <h4>MONTO:<b><?php echo "$ " . number_format($total, 2) ?></b></h4>
                            </div>
                        </div>
                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                    </div>
                </div>
                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-purple">
                                        <tr>
                                            <th>Folio CXP</th>
                                            <th>Proveedor</th>
                                            <th>Concepto</th>
                                            <th>Monto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_cxp'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['concepto'] ?></td> 
                                                <td class="text-right"><?php echo "$ " . number_format($dat['total'], 2) ?></td>
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

            <div class="card-footer bg-gradient-purple">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <h4>CONCEPTO: <b> <?php echo $concepto ?></b></h4>

                            </div>
                            <div class="col-sm-2">
                                <h4>MONTO:<b><?php echo "$ " . number_format($total, 2) ?></b></h4>
                            </div>
                        </div>
                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

    </section>



    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/detalleegr.js"></script>
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