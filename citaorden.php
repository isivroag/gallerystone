<?php
$pagina = "citamed";
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vcitamed order by id";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$fecha = strtotime(date("Y-m-d"));

$mesactual = date("m", $fecha);
$yearactual = date("Y", $fecha);

$consulta2 = "SELECT * FROM vcitamed where month(start) ='$mesactual' and year(start)='$yearactual' order by id";
$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);



$consultaorden = "SELECT * FROM vorden WHERE estado_ord=1 and edo_ord<>'PENDIENTE' and edo_ord<>'LIBERADO' and tipop='PROYECTO' and avance=0 and date(fecha_plantilla)='2000-01-01' ORDER BY folio_ord";
$resultadoorden = $conexion->prepare($consultaorden);
$resultadoorden->execute();
$dataorden = $resultadoorden->fetchAll(PDO::FETCH_ASSOC);

$message = "";

$consulta = "SELECT * FROM personal where estado_per=1 order by id_per";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataper = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- fullCalendar -->
<link rel="stylesheet" href="plugins/fullcalendar/main.css">

<link rel="stylesheet" href="plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-bootstrap/main.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">



<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
<!--Datetimepicker Bootstrap -->

<!--
<link rel="stylesheet" href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
-->
<!--tempusdominus-bootstrap-4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css">

<style>
    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    #div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    #cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="card">
        <div class="card-header bg-gradient-secondary light">
            <h2 class="card-title mx-auto">Calendario de Citas para toma de Plantilla</h2>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-12">
                    <button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    <a href="help/calendariop/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a><!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->

                </div>
            </div>
            <br>
            <div class="row">

                <!-- /.col -->
                <div class="col-md-8 mx-auto">
                    <div class="card card-primary">

                        <div class="card-body p-0">

                            <div id="div_carga">

                                <img id="cargador" src="img/loader.gif" />
                                <span class=" " id="textoc"><strong>Cargando...</strong></span>

                            </div>
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                            <!--
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <div class="table-hover table-responsive w-auto" style="padding:15px">

                                        <table name="tablacitas" id="tablacitas" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                            <thead class="text-center bg-secondary">
                                                <tr>
                                                    <th>Folio</th>


                                                    <th>Fecha Programada</th>
                                                    <th>Cliente</th>
                                                    <th>Proyecto</th>
                                                    <th>Fecha Atencion</th>
                                                    <th>Responsable</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data2 as $dat) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $dat['folio_ord'] ?></td>


                                                        <td><?php echo $dat['start'] ?></td>
                                                        <td><?php echo $dat['title'] ?></td>
                                                        <td><?php echo $dat['descripcion'] ?></td>
                                                        <td><?php echo $dat['end'] ?></td>
                                                        <td><?php echo $dat['responsable'] ?></td>
                                                        <td><?php echo $dat['estado_cita'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalorden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-secondary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR ORDEN</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaorden" id="tablaorden" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-secondary">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Folio Vta</th>

                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Proyecto</th>

                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dataorden as $dat) {
                                    ?>
                                        <tr>
                                            <td><?php echo $dat['folio_ord'] ?></td>
                                            <td><?php echo $dat['folio_vta'] ?></td>

                                            <td><?php echo $dat['fecha_ord'] ?></td>
                                            <td><?php echo $dat['nombre'] ?></td>
                                            <td><?php echo $dat['concepto_vta'] ?></td>
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
    </section>




    <section>
        <div class="modal fade" id="modalFecha2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">Fecha de Toma de Plantilla</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formFecha" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="folioorden" id="folioorden">
                                        <input type="hidden" class="form-control" name="foliocita" id="foliocita">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">

                                        <label for="nombre" class="col-form-label">Cliente:</label>

                                        <div class="input-group">

                                            <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" placeholder="Cliente" disabled>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="concepto" class="col-form-label">Concepto Cita</label>
                                        <input type="text" class="form-control" name="concepto" id="concepto" autocomplete="off" placeholder="Concepto de Cita" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="fecha" class="col-form-label">Fecha Y Hora:</label>

                                        <div class="input-group date" id="datetimepicker1" data-date-format="YYYY-MM-DD HH:mm:00" data-target-input="nearest">
                                            <input type="text" id="fecha" name="fecha" class="form-control datetimepicker-input " data-target="#datetimepicker1" autocomplete="off" placeholder="Fecha y Hora">
                                            <div class="input-group-append " data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                <div class="input-group-text btn-primary"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="responsable" class="col-form-label">Responsable:</label>
                                        <select class="form-control" name="responsable" id="responsable" autocomplete="off" placeholder="responsable">
                                            <?php
                                            foreach ($dataper as $dtvend) {
                                            ?>
                                                <option id="<?php echo $dtvend['nom_per'] ?>" value="<?php echo $dtvend['nom_per'] ?>" <?php echo $dtvend['nom_per'] ?>> <?php echo $dtvend['nom_per'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>



                            </div>



                            <?php
                            if ($message != "") {
                            ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <span class="badge "><?php echo ($message); ?></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>

                                </div>

                            <?php
                            }
                            ?>
                            <div class="modal-footer">
                                <button type="button" id="btnCancelarf" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</button>

                                <button type="button" id="btnAtendido" name="btnAtendido" class="btn btn-primary" value="btnAtendido"><i class="fa-solid fa-circle-check"></i> Atendido</button>
                                <button type="button" id="btnGuardarf" name="btnGuardarf" class="btn btn-success" value="btnGuardarf"><i class="far fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/citamed.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<!-- jQuery UI -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/fullcalendar/main.min.js"></script>
<script src='plugins/fullcalendar/locales-all.js'></script>
<script src='plugins/fullcalendar/locales/es.js'></script>
<script src="plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="plugins/fullcalendar-interaction/main.min.js"></script>
<script src="plugins/fullcalendar-bootstrap/main.js"></script>


<!--Datetimepicker Bootstrap -->
<!--
<script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script src="plugins/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
-->
<!--tempusdominus-bootstrap-4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/locale/es.js"></script>