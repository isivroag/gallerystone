<?php
$pagina = "fichas";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vficha";


$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

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
            <div class="card-header bg-gradient-orange text-light">
                <h4 class="card-title text-center">Fichas de Clientes</h4>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                    </div>
                </div>
                <br>
                <div class="container-fluid">

                    <div class="row">
                        <?php
                        foreach ($data as $reg) {

                        ?>
                            <div class="col-lg-4">
                                <div class="card card-widget widget-user-2">
                                    <div class="widget-user-header bg-primary">
                                        <h3 class="widget-user-username"><?php echo $reg['nombre'] ?></h3>
                                    </div>
                                    <div class="card-footer p-2">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link vinculoa">
                                                    Presupuestos Activos <span class="float-right badge bg-primary"><?php echo $reg['activos'] ?></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link vinculov">
                                                    Presupuestos Aceptados <span class="float-right badge bg-success"><?php echo $reg['aceptados'] ?></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link vinculor">
                                                    Presupuestos Rechazados <span class="float-right badge bg-danger"><?php echo $reg['rechazados'] ?></span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>

    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
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