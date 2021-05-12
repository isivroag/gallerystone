<?php
$pagina = "inventario";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$consultains = "SELECT id_insumo,nom_insumo FROM vmaterial GROUP BY id_insumo";
$resultadoins = $conexion->prepare($consultains);
$resultadoins->execute();
$datains = $resultadoins->fetchAll(PDO::FETCH_ASSOC);


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
            <div class="card-header bg-gradient-secondary text-light">
                <h4 class="card-title text-center">Inventario</h4>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                    </div>
                </div>
                <br>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-secondary card-tabs">
                                <div class="card-header p-0 pt-1">

                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <?php
                                        $i = 1;
                                        foreach ($datains as $rowins) {

                                        ?>
                                            <li class="nav-item">
                                                <a class="nav-link  text-bold <?php echo ($i == 1 ? 'active' : '') ?>" id="<?php echo 'tab' . $rowins['nom_insumo'] ?>" data-toggle="pill" href="#<?php echo 'esp' . $rowins['nom_insumo'] ?>" role="tab" aria-controls="<?php echo 'esp' . $rowins['nom_insumo'] ?>" aria-selected="<?php echo ($i == 1 ? 'true' : 'false') ?>"><?php echo $rowins['nom_insumo'] ?></a>
                                            </li>
                                        <?php
                                            $i++;
                                        }
                                        ?>

                                    </ul>
                                </div>
                                <div class="card-body">

                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <?php
                                        $i = 1;
                                        foreach ($datains as $rowins) {

                                            $idinsumo = $rowins['id_insumo'];
                                            $consulta = "SELECT * FROM vmaterial where id_insumo='$idinsumo' order by id_mat";
                                            $resultado = $conexion->prepare($consulta);
                                            $resultado->execute();
                                            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                        ?>

                                            <div class="tab-pane fade  <?php echo ($i == 1 ? 'show active' : '') ?> " id="<?php echo 'esp' . $rowins['nom_insumo'] ?>" role="tabpanel" aria-labelledby="<?php echo 'tab' . $rowins['nom_insumo'] ?>">

                                                <div class="table-responsive">
                                                    <table name="" id="" class="tablaV table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px">
                                                        <thead class="text-center bg-gradient-secondary">
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Clave</th>
                                                                <th>Material</th>
                                                                <th>Formato</th>
                                                                <th>Largo</th>
                                                                <th>Ancho</th>
                                                                <th>Alto</th>
                                                                <th>Cant.</th>
                                                                <th>U. Medida</th>
                                                                <th>M2</th>
                                                                <th>Ubic.</th>
                                                                <th>Obs</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($data as $dat) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $dat['id_mat'] ?></td>
                                                                    <td><?php echo $dat['clave_item'] ?></td>
                                                                    <td><?php echo $dat['nom_item'] ?></td>
                                                                    <td><?php echo $dat['nom_mat'] ?></td>
                                                                    <td><?php echo $dat['largo_mat'] ?></td>
                                                                    <td><?php echo $dat['ancho_mat'] ?></td>
                                                                    <td><?php echo $dat['alto_mat'] ?></td>
                                                                    <td><?php echo $dat['cant_mat'] ?></td>
                                                                    <td><?php echo $dat['nom_umedida'] ?></td>
                                                                    <td><?php echo $dat['m2_mat'] ?></td>
                                                                    <td><?php echo $dat['ubi_mat'] ?></td>
                                                                    <td><?php echo $dat['obs_mat'] ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                ?>
                                    </div>
                                
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                        </div>
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
<script src="fjs/inventario.js"></script>
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