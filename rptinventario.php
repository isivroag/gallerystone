<?php
$pagina = "rptinventario";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$consulta = "SELECT * FROM vconsumible WHERE estado_cons=1 and contenidot<=minimo ORDER BY id_cons";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta2 = "SELECT * FROM vdesechable WHERE estado_des=1 and cant_des<= minimo ORDER BY id_des";
$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);



$consultau = "SELECT * FROM medida WHERE estado_medida=1 ORDER BY id_medida";
$resultadou = $conexion->prepare($consultau);
$resultadou->execute();
$datau = $resultadou->fetchAll(PDO::FETCH_ASSOC);

$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
    .div_carga {
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

    .cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    .textoc {
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
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">Insumos e Insumos de Desgaste en punto de Reorden</h1>
            </div>

            <div class="card-body">
                <div class="div_carga">

                    <img class="cargador" src="img/loader.gif" />
                    <span class=" textoc" id=""><strong>Cargando...</strong></span>
                </div>

                <div class="row">

                </div>
                <br>
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h1 class="card-title">INSUMOS</h1>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-lg-12 ">
                                    <div class="table-responsive ">
                                        <br>
                                        <table name="tablaV1" id="tablaV1" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                            <thead class="text-center bg-gradient-secondary">
                                                <tr>
                                                    <th>Id </th>
                                                    <th>Clave</th>
                                                    <th>Descripcion</th>
                                                    <th>U.Medida</th>
                                                    <th>Id U.Medida</th>
                                                    <th>Cantidad</th>
                                                    <th>Presentacion</th>
                                                    <th>Contenido Cerrado</th>
                                                    <th>Contenido Abierto</th>
                                                    <th>Contenido Total</th>
                                                    <th>Ubicacion</th>
                                                    <th>Obs</th>
                                                    <th>tarjeta</th>
                                                    <th>valortarjeta</th>
                                                    <th>Costo</th>
                                                    <th>minimo</th>
                                                    <th>maximo</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $dat) {
                                                ?>
                                                    <tr>

                                                        <td><?php echo $dat['id_cons'] ?></td>
                                                        <td><?php echo $dat['clave_cons'] ?></td>
                                                        <td><?php echo $dat['nom_cons'] ?></td>
                                                        <td><?php echo $dat['nom_umedida'] ?></td>
                                                        <td><?php echo $dat['id_umedida'] ?></td>
                                                        <td><?php echo $dat['cant_cons'] ?></td>
                                                        <td><?php echo $dat['presentacion'] ?></td>
                                                        <td><?php echo $dat['contenidon'] ?></td>
                                                        <td><?php echo $dat['contenidoa'] ?></td>
                                                        <td><?php echo $dat['contenidot'] ?></td>
                                                        <td><?php echo $dat['ubi_cons'] ?></td>
                                                        <td><?php echo $dat['obs_cons'] ?></td>
                                                        <td><?php echo $dat['tarjeta'] ?></td>
                                                        <td><?php echo $dat['valortarjeta'] ?></td>
                                                        <td><?php echo $dat['costo_cons'] ?></td>
                                                        <td><?php echo $dat['minimo'] ?></td>
                                                        <td><?php echo $dat['maximo'] ?></td>

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
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h1 class="card-title">INSUMOS DE DESGASTE</h1>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <div class="table-responsive ">
                                        <br>
                                        <table name="tablaV2" id="tablaV2" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                            <thead class="text-center bg-gradient-secondary">
                                                <tr>
                                                    <th>Id </th>
                                                    <th>Clave </th>
                                                    <th>Descripcion</th>
                                                    <th>U.Medida</th>
                                                    <th>Id U.Medida</th>
                                                    <th>Cantidad</th>
                                                    <th>Usos por Unidad</th>
                                                    <th>Total Usos</th>
                                                    <th>Ubicacion</th>
                                                    <th>Obs</th>
                                                    <th>tarjeta</th>
                                                    <th>valortarjeta</th>
                                                    <th>minimo</th>
                                                    <th>maximo</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data2 as $dat) {
                                                ?>
                                                    <tr>

                                                        <td><?php echo $dat['id_des'] ?></td>
                                                        <td><?php echo $dat['clave_des'] ?></td>
                                                        <td><?php echo $dat['nom_des'] ?></td>
                                                        <td><?php echo $dat['nom_umedida'] ?></td>
                                                        <td><?php echo $dat['id_umedida'] ?></td>
                                                        <td><?php echo $dat['cant_des'] ?></td>
                                                        <td><?php echo $dat['usos'] ?></td>
                                                        <td><?php echo $dat['totalusos'] ?></td>
                                                        <td><?php echo $dat['ubi_des'] ?></td>
                                                        <td><?php echo $dat['obs_des'] ?></td>
                                                        <td><?php echo $dat['tarjeta'] ?></td>
                                                        <td><?php echo $dat['valortarjeta'] ?></td>
                                                        <td><?php echo $dat['minimo'] ?></td>
                                                        <td><?php echo $dat['maximo'] ?></td>

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
                </div>

            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>



</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/rptinventario.js?v=<?php echo (rand()); ?>"></script>
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