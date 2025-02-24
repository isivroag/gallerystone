<?php
$pagina = "rptdiario";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$inicio = (isset($_GET['inicio'])) ? $_GET['inicio'] : '';
$fin = (isset($_GET['fin'])) ? $_GET['fin'] : '';
$conexion = $objeto->connect();

$consulta = "SELECT fecha,metodo,sum(monto) as monto from vpagocxc where estado_pagocxc=1 and fecha between '$inicio' and '$fin' group by metodo";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta2 = "SELECT fecha,metodo,sum(monto) as monto from pagocxp where estado_pagocxp=1 and fecha between '$inicio' and '$fin' group by metodo";
$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

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
                <h4 class="card-title text-center">FLUJO ECONOMICO</h4>
            </div>



            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                       
                        <a href="help/rptingdiarios/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a>
                    </div>
                </div>
                <br>

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

                    <div class="row justify-content-between">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header bg-gradient-green">
                                    INGRESOS
                                </div>
                                <div class="card-body">
                                    <?php
                                    $ingresos = 0;
                                    foreach ($data as $rowd) {
                                        $ingresos += $rowd['monto'];
                                    ?>
                                        <div class="row justify-content-center  mx-2">
                                            <div class="col-sm-3 pl-2">
                                                <label for="I-<?php echo $rowd['metodo'] ?>" class="col-form-label"><?php echo $rowd['metodo'] ?>:</label>
                                            </div>

                                            <div class="col-sm-1 fill"></div>

                                            <div class="col-sm-7">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control text-right bg-white" name="I-<?php echo $rowd['metodo'] ?>" id="<?php echo $rowd['metodo'] ?>" value="<?php echo number_format($rowd['monto'], 2) ?>" disabled>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary bingreso" value="<?php echo $rowd['metodo'] ?>"> <i class="fas fa-search"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }

                                    ?>
                                    <div class="row justify-content-center  mx-2 mt-2 pt-2 border-top border-success " style="border-width: 3px !important;">
                                        <div class="col-sm-3 pl-2 ">
                                            <label for="totali" class="col-form-label text-bold" style="font-size: large;">TOTAL INGRESOS:</label>
                                        </div>

                                        <div class="col-sm-1 fill"></div>

                                        <div class="col-sm-7">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control text-right bg-white bg-white text-bold text-green bg-green" style="font-size: medium;" name="totali" id="totali" value="<?php echo number_format($ingresos, 2) ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header bg-gradient-purple">
                                    EGRESOS
                                </div>
                                <div class="card-body">
                                    <?php
                                    $egresos = 0;
                                    foreach ($data2 as $rowd) {
                                        $egresos += $rowd['monto'];
                                    ?>
                                        <div class="row justify-content-center  mx-2">
                                            <div class="col-sm-3 pl-2">
                                                <label for="E-<?php echo $rowd['metodo'] ?>" class="col-form-label"><?php echo $rowd['metodo'] ?>:</label>
                                            </div>

                                            <div class="col-sm-1 fill"></div>

                                            <div class="col-sm-7">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control text-right bg-white" name="E-<?php echo $rowd['metodo'] ?>" id="<?php echo $rowd['metodo'] ?>" value="<?php echo number_format($rowd['monto'], 2) ?>" disabled>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary begreso" value="<?php echo $rowd['metodo'] ?>"> <i class="fas fa-search"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }

                                    ?>
                                    <div class="row justify-content-center  mx-2 mt-2 pt-2 border-top " style="border-color:#7c53c6 !important; border-width: 3px !important; ">
                                        <div class="col-sm-3 pl-2 ">
                                            <label for="totale" class="col-form-label text-bold" style="font-size: large;">TOTAL EGRESOS:</label>
                                        </div>

                                        <div class="col-sm-1 fill"></div>

                                        <div class="col-sm-7">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control text-right bg-white bg-white text-bold text-green bg-green" style="font-size: medium;" name="totale" id="totale" value="<?php echo number_format($egresos, 2) ?>" disabled>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header bg-gradient-orange">
                                    RESULTADO
                                </div>
                                <div class="card-body">

                                    <div class="row justify-content-center  mx-2 ">
                                        <div class="col-sm-3 pl-2 ">
                                            <label for="resultado" class="col-form-label text-bold" style="font-size: large;">RESULTADO:</label>
                                        </div>

                                        <div class="col-sm-1 fill"></div>

                                        <div class="col-sm-7">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control text-right text-bold <?php echo ($ingresos - $egresos) > 0 ? "bg-green" : "bg-red" ?> " style="font-size: medium;" name="resultado" id="resultado" value="<?php echo number_format($ingresos - $egresos, 2) ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

    </section>

    <section>
        <div class="container">


            <!-- Default box -->
            <div class="modal fade" id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl " role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-success">
                            <h5 class="modal-title" id="exampleModalLabel">Detalle de Ingresos</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center bg-gradient-success">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Concepto</th>
                                        <th>Cliente</th>
                                        <th>Proyecto/Obra</th>
                                        <th>Metodo</th>
                                        <th>Monto</th>
                                        <th>Factura</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="5">TOTAL</td>
                                        <td class="text-right"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                    </div>

                </div>
                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </div>
    </section>

    <section>
        <div class="container">


            <!-- Default box -->
            <div class="modal fade" id="modalResumen2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl " role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-purple">
                            <h5 class="modal-title" id="exampleModalLabel">Detalle de Egresos</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaResumen2" id="tablaResumen2" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center bg-gradient-purple">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Proveedor</th>
                                        <th>Concepto Pago</th>
                                        <th>Metodo</th>
                                        <th>Monto</th>
                                        <th>Referencia</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="4">TOTAL</td>
                                        <td class="text-right"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                    </div>

                </div>
                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </div>
    </section>

    <!-- /.content -->
</div>
<!-- Resumen de Pagos -->



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/rptcorte.js?v=<?php echo (rand()); ?>"></script>
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