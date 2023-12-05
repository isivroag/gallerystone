<?php
$pagina = "rptasistencia";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$inicio = (isset($_GET['inicio'])) ? $_GET['inicio'] : date("Y-m-d");
$fin = (isset($_GET['fin'])) ? $_GET['fin'] : date("Y-m-d");


$fechaInicio = new DateTime($inicio);
$fechaFin = new DateTime($fin);

// Calcular el número de días entre las fechas
$intervalo = $fechaInicio->diff($fechaFin);
$numDias = $intervalo->days;
$numDias = $numDias;




$conexion = $objeto->connect();

$consulta = "SELECT * FROM personal where estado_per=1 order by id_per";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);



$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
    .borde-purple {
        border-left: 3px solid #6f42c1 !important;
        border-right: 3px solid #6f42c1 !important;
    }

    .borde-verde {
        border-left: 3px solid #28a745 !important;
        border-right: 3px solid #28a745 !important;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-gradient-orange">
                <h4 class="card-title text-center">REPORTE DE ASISTENCIA</h4>
            </div>

            <div class="card-body">

                <div class="card">
                    <div class="card-header bg-gradient-orange">
                        Filtro por rango de Fecha
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-2">
                                <div class="form-group input-group-sm">
                                    <label for="inicio" class="col-form-label">Fecha Inicio:</label>
                                    <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $inicio ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
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
                                    <thead class="text-center bg-gradient-orange">
                                        <tr>
                                            <th class="text-center">PERSONAL</th>
                                            <?php
                                            while ($fechaInicio <= $fechaFin) {
                                                echo '<th class="text-center">' . date('d M y', strtotime($fechaInicio->format('Y-m-d'))) . '</th>';
                                                $fechaInicio->add(new DateInterval('P1D'));
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $row) {
                                            echo '<tr><th>' . $row['nom_per'] . '</th>';
                                            $idper = $row['id_per'];
                                      
                                            $consultap="call sp_verfechas('$inicio','$fin','$idper')";
                                            $resultadop = $conexion->prepare($consultap);
                                            $resultadop->execute();
                                            $datap = $resultadop->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($datap as $rowp) {
                                                $tipo = $rowp['tipo'];
                                                $tipon = $rowp['tipon'];
                                                switch ($tipo) {
                                                    case '0':
                                                        $icono = "<i class='text-info fa-solid fa-circle-exclamation '></i>";
                                                        break;
                                                    case '1':
                                                        $icono = "<i class='text-success fa-solid fa-circle-check '></i>";
                                                        break;
                                                    case '2':
                                                        $icono = "<i class='text-danger fa-solid fa-circle-xmark '></i>";
                                                        break;
                                                    case '3':
                                                        $icono = "<i class='text-warning fa-solid fa-clock '></i>";
                                                        break;
                                                }
                                                echo '<td>' . $icono . ' <span>' . $tipon . '</span></td>';
                                            }


/*

                                            while ($fechaInicio <= $fechaFin) {
                                                $consultap = "select * from asistencia where fecha = '$cfecha' and id_per = '$idper'";
                                                $resultadop = $conexion->prepare($consultap);
                                                $resultadop->execute();
                                                if ($resultado->rowCount() > 0) {
                                                    $datap = $resultadop->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($datap as $rowp) {
                                                        $tipo = $rowp['tipo'];
                                                        $tipon = $rowp['tipon'];
                                                    }
                                                } 

                                                switch ($tipo) {
                                                    case '0':
                                                        $icono = "<i class='text-info fa-solid fa-circle-exclamation '></i>";
                                                        break;
                                                    case '1':
                                                        $icono = "<i class='text-success fa-solid fa-circle-check '></i>";
                                                        break;
                                                    case '2':
                                                        $icono = "<i class='text-danger fa-solid fa-circle-xmark '></i>";
                                                        break;
                                                    case '3':
                                                        $icono = "<i class='text-warning fa-solid fa-clock '></i>";
                                                        break;
                                                }


                                                echo '<td>' . $icono . '<span>' . $tipon . '</span></td>';
                                                $fechaInicio->add(new DateInterval('P1D'));
                                            }*/


                                            echo '</tr>';
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
<script src="fjs/rptasistencia.js?v=<?php echo (rand()); ?>"></script>
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