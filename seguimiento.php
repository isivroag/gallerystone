<?php
$pagina = 'home';
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";



include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


if (date("D") == "Mon") {
    $iniciosemana = date("Y-m-d");
} else {
    $iniciosemana = date("Y-m-d", strtotime('last Monday', time()));
}

$finsemana = date("Y-m-d", strtotime('next Sunday', time()));
$fecha=date('Y-m-d');


$consulta = "SELECT * FROM vllamada WHERE fecha_llamada<='$fecha' ORDER BY fecha_llamada";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta1 = "SELECT * FROM vllamada WHERE fecha_llamada BETWEEN '$iniciosemana' and '$finsemana' ORDER BY fecha_llamada";
$resultado1 = $conexion->prepare($consulta1);
$resultado1->execute();
$data2 = $resultado1->fetchAll(PDO::FETCH_ASSOC);

$consulta2 = "SELECT * FROM vllamada WHERE fecha_llamada > '$finsemana' ORDER BY fecha_llamada";
$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data3 = $resultado2->fetchAll(PDO::FETCH_ASSOC);



?>

<style>
  .bg1{
      background-color: rgba(25,151,6,.6)!important;
      color: white;
    }
    .bg2{
      background-color: rgba(52,78,253,.85)!important;
      color: white;
    }
    .bg3{
      background-color: rgba(79,3,210,.6)!important;
      color: white;
    }
</style>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-gradient-orange text-light">
                <h4 class="card-title text-center">SEGUIMIENTO DE PRESUPUESTOS</h4>
            </div>

            <div class="card-body">
                <div class="card-header bg-gradient-orange text-light text-center">
                    <div class="text-center">
                        <h4 class="card-title ">LLAMADAS DE SEGUMIENTO PROGRAMADAS HASTA EL DIA DE HOY (<?php echo date("Y-m-d"); ?>)</h4>
                    </div>

                </div>


                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaA" id="tablaA" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px">
                                    <thead class="text-center bg-gradient-orange">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Tel. Movil</th>
                                            <th>Tel. Fijo</th>
                                            <th>Proyecto</th>
                                            <th># Llamada</th>
                                            <th>Fecha Programada</th>
                                            <th>Nota</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_pres'] ?></td>
                                                <td><?php echo $dat['fecha_pres'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['cel'] ?></td>
                                                <td><?php echo $dat['tel'] ?></td>
                                                <td><?php echo $dat['concepto_pres'] ?></td>
                                                <td><?php echo $dat['desc_llamada'] ?></td>
                                                <td><?php echo $dat['fecha_llamada'] ?></td>
                                                <td><?php echo $dat['nota_ant'] ?></td>

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


            <div class="card-body">
                <div class="card-header bg-gradient-purple text-light text-center">
                    <div class="text-center">
                        <h4 class="card-title ">LLAMADAS DE SEGUMIENTO PROGRAMADAS ESTA SEMANA (<?php echo "DEL " . $iniciosemana . " AL " . $finsemana; ?>)</h4>
                    </div>

                </div>


                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaB" id="tablaB" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px">
                                    <thead class="text-center bg-gradient-purple">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Tel. Movil</th>
                                            <th>Tel. Fijo</th>
                                            <th>Proyecto</th>
                                            <th># Llamada</th>
                                            <th>Fecha Programada</th>
                                            <th>Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data2 as $dat2) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat2['folio_pres'] ?></td>
                                                <td><?php echo $dat2['fecha_pres'] ?></td>
                                                <td><?php echo $dat2['nombre'] ?></td>
                                                <td><?php echo $dat2['cel'] ?></td>
                                                <td><?php echo $dat2['tel'] ?></td>
                                                <td><?php echo $dat2['concepto_pres'] ?></td>
                                                <td><?php echo $dat2['desc_llamada'] ?></td>
                                                <td><?php echo $dat2['fecha_llamada'] ?></td>
                                                <td><?php echo $dat2['nota_ant'] ?> </td>

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

            <div class="card-body">
                <div class="card-header bg-lightblue text-light text-center">
                    <div class="text-center">
                        <h4 class="card-title ">LLAMADAS PROGRAMADAS PARA FECHAS POSTERIORES AL <?php echo  $finsemana; ?></h4>
                    </div>

                </div>


                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaC" id="tablaC" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px">
                                    <thead class="text-center bg-lightblue">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Tel. Movil</th>
                                            <th>Tel. Fijo</th>
                                            <th>Proyecto</th>
                                            <th># Llamada</th>
                                            <th>Fecha Programada</th>
                                            <th>Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data3 as $dat3) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat3['folio_pres'] ?></td>
                                                <td><?php echo $dat3['fecha_pres'] ?></td>
                                                <td><?php echo $dat3['nombre'] ?></td>
                                                <td><?php echo $dat3['cel'] ?></td>
                                                <td><?php echo $dat3['tel'] ?></td>
                                                <td><?php echo $dat3['concepto_pres'] ?></td>
                                                <td><?php echo $dat3['desc_llamada'] ?></td>
                                                <td><?php echo $dat3['fecha_llamada'] ?></td>
                                                <td><?php echo $dat3['nota_ant'] ?> </td>

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

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>

</div>

<?php
include_once 'templates/footer.php';
?>
<script src="fjs/seguimiento.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>