<?php
$pagina = "movmat";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';



$objeto = new conn();
$conexion = $objeto->connect();







if (isset($_GET['fechaini'])) {
    $fechaini = $_GET['fechaini'];
} else {
    $fechaini = date('Y-m-d');
}
$consulta = "SELECT * FROM vmovimientosmat where estado_movp=1 and fecha_movp = '$fechaini'  order by fecha_movp desc,id_movp desc";
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
            <div class="card-header bg-gradient-secondary">
                <h4 class="card-title text-center">ULTIMOS MOVIMIENTOS DE MATERIAL</h4>
            </div>

            <div class="card-body">



                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header bg-gradient-gray">
                                Busqueda por Fecha
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $fechaini?>">
                                        </div>
                                    </div>

                                    

                                    <div class="col-lg-1 align-self-end text-center">
                                        <div class="form-group input-group-sm">
                                            <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
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
                                <table name="tablaV" id="tablaV" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px;">
                                    <thead class="text-center bg-gradient-secondary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Material</th>
                                            <th>Fecha</th>
                                            <th>Tipo Movimiento</th>
                                            <th>Descripción</th>
                                            <th>Exitencia Inicial</th>
                                            <th>Cantidad</th>
                                            <th>Existencia Final</th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $rowdata) {
                                        ?>
                                            <tr>
                                                <td><?php echo $rowdata['id_movp'] ?></td>
                                                <td><?php echo $rowdata['nom_item'] ?></td>
                                                <td><?php echo $rowdata['fecha_movp'] ?></td>
                                                <td><?php echo $rowdata['tipo_movp'] ?></td>
                                                <td><?php echo $rowdata['descripcion'] ?></td>
                                                <td><?php echo $rowdata['saldoini'] ?></td>
                                                <td><?php echo $rowdata['cantidad'] ?></td>
                                                <td><?php echo $rowdata['saldofin'] ?></td>

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


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/inventariomovmat.js?v=<?php echo (rand()); ?>"></script>
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