<?php
$pagina = "nomorden";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fechaActual = new DateTime();
$fechaInicioMesAnterior = new DateTime();
$fechaInicioMesAnterior->modify('first day of last month');

$fechaFinalMesEnCurso = new DateTime();
$fechaFinalMesEnCurso->modify('last day of this month');

$inicioMesAnterior = $fechaInicioMesAnterior->format('Y-m-d');
$finalMesEnCurso = $fechaFinalMesEnCurso->format('Y-m-d');


$inicio = (isset($_GET['inicio'])) ? $_GET['inicio'] : $inicioMesAnterior;
$fin = (isset($_GET['fin'])) ? $_GET['fin'] : $finalMesEnCurso;


$vcons = 0;
if ($inicio == '' && $fin == '') {
    $vcons = 1;
}
if ($vcons == 0) {
    $consulta = "SELECT * from vorden2 where (avance>0 AND avance<100) or fecha_liberacion BETWEEN '$inicio' AND '$fin' ORDER BY avance ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
}

$consultacto = "SELECT * from mlcosto where estado='1'";
$resultadocto = $conexion->prepare($consultacto);
$resultadocto->execute();
$datacto = $resultadocto->fetchAll(PDO::FETCH_ASSOC);
$costoml = 0;
foreach ($datacto as $rowc) {
    $costoml = $rowc['costo'];
}


?>

<style>
    td.editable {

        cursor: pointer;
    }
</style>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-lightblue ">
                <h4 class="card-title text-center">ORDENES DE SERVICIO</h4>
            </div>

            <div class="card-body">



                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-gradient-lightblue ">
                                Filtro por rango de Fecha
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="form-group input-group-sm">
                                            <label for="inicio" class="col-form-label">Fecha Inicio:</label>
                                            <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $inicio ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group input-group-sm">
                                            <label for="fin" class="col-form-label">Fecha Final:</label>
                                            <input type="date" class="form-control" name="fin" id="fin" value="<?php echo $fin ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 align-self-end text-center">
                                        <div class="form-group input-group-sm">
                                            <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-header bg-gradient-lightblue ">
                                Costo por Metro Lineal
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="form-group input-group-sm">
                                            <label for="costoml" class="col-form-label">Costo ML:</label>
                                            <input type="text" class="form-control" name="costoml" id="costoml" value="<?php echo $costoml ?>">
                                        </div>
                                    </div>


                                    <div class="col-lg-3 align-self-end text-center">
                                        <div class="form-group input-group-sm">
                                            <button id="btnDefinir" name="btnDefinir" type="button" class="btn bg-gradient-success btn-ms"><i class="fa-regular fa-floppy-disk"></i> Definir</button>
                                        </div>
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
                                    <thead class="text-center bg-lightblue ">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Folio Vta</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Proyecto</th>
                                            <th>Liberacion</th>
                                            <th>Tipo</th>
                                            <th>Progreso</th>
                                            <th>Estado</th>
                                            <th>ML</th>
                                            <th>Importe Vta</th>
                                            <th>Importe Nom</th>
                                            <th>VAL ML</th>
                                            <th>Costo ML</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($vcons == 0) {
                                            foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?php echo $row['folio_ord'] ?></td>
                                                    <td><?php echo $row['folio_vta'] ?></td>
                                                    <td><?php echo $row['fecha_ord'] ?></td>
                                                    <td><?php echo $row['nombre'] ?></td>
                                                    <td><?php echo $row['concepto_vta'] ?></td>
                                                    <td><?php echo $row['fecha_liberacion'] ?></td>
                                                    <td><?php echo $row['tipop'] ?></td>
                                                    <td><?php echo $row['avance'] ?></td>
                                                    <td><?php echo $row['edo_ord'] ?></td>
                                                    <td><?php echo $row['metros'] ?></td>
                                                    <td><?php echo number_format($row['gtotal'], 2) ?></td>
                                                    <td><?php echo number_format($row['importenom'], 2) ?></td>
                                                    <td><?php echo number_format($row['mlfinal'], 2) ?></td>
                                                    <td><?php echo number_format($row['costoml'], 2) ?></td>
                                                    <td></td>
                                                </tr>
                                        <?php }
                                        } ?>
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
    <div class="modal fade" id="modalImporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-lightblue ">
                    <h5 class="modal-title" id="exampleModalLabel">Importe Destinado a calculo de nomina</h5>

                </div>
                <div class="card card-widget" style="margin: 10px;">
                    <form id="formImporte" action="" method="POST">
                        <div class="modal-body row justify-content-center">

                            <div class="col-sm-4">
                                <div class="form-group input-group-sm">
                                    <label for="costoml2" class="col-form-label ">Costo ML:</label>
                                    <input type="text" class="form-control text-right" name="costoml2" id="costoml2">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group input-group-sm">
                                    <label for="mlorden" class="col-form-label ">ML:</label>
                                    <input type="text" class="form-control text-right" name="mlorden" id="mlorden">
                                    <input type="hidden" class="form-control text-right" name="mlorigen" id="mlorigen">
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <div class="form-group input-group-sm">
                                    <input type="hidden" class="form-control" name="folioorden" id="folioorden">
                                    <input type="hidden" class="form-control" name="total" id="total">


                                    <label for="importenom" class="col-form-label text-right">Importe:</label>

                                    <input type="text" class="form-control text-right" name="importenom" id="importenom">
                                </div>
                            </div>


                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnGuardarimp" name="btnGuardarimp" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section>

    </section>




    <!-- /.content -->
</div>
<!-- Resumen de Pagos -->



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/nomorden.js?v=<?php echo (rand()); ?>"></script>
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
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/locale/es.js"></script>