<?php
$pagina = "resumenobra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);


$mesactual = (isset($_GET['mes'])) ? $_GET['mes'] : date("m");
$yearactual = (isset($_GET['ejercicio'])) ? $_GET['ejercicio'] : date("Y");



$consulta = "SELECT * FROM vventa WHERE estado_vta=1 and tipo_proy=2 order by folio_vta";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $datavta = $resultado->fetchAll(PDO::FETCH_ASSOC);
}





?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
    .fill {
        border: none;
        border-bottom: 3px dotted #000;
        display: inline-block;
    }

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
            <div class="card-header bg-orange  ">
                <h1 class="card-title text-light ">DETALLES DE OBRA</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <div class="card-header bg-gradient-green">
                            Selector de Período
                        </div>
                        <div class="card-body p-0">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="mes" class="col-form-label">MES:</label>
                                        <select class="form-control" name="mes" id="mes" value="<?php echo $mesactual ?>">
                                            <option id="01" value="01" <?php echo ($mesactual == '01') ? "selected" : "" ?>>ENERO</option>
                                            <option id="02" value="02" <?php echo ($mesactual == '02') ? "selected" : "" ?>>FEBRERO</option>
                                            <option id="03" value="03" <?php echo ($mesactual == '03') ? "selected" : "" ?>>MARZO</option>
                                            <option id="04" value="04" <?php echo ($mesactual == '04') ? "selected" : "" ?>>ABRIL</option>
                                            <option id="05" value="05" <?php echo ($mesactual == '05') ? "selected" : "" ?>>MAYO</option>
                                            <option id="06" value="06" <?php echo ($mesactual == '06') ? "selected" : "" ?>>JUNIO</option>
                                            <option id="07" value="07" <?php echo ($mesactual == '07') ? "selected" : "" ?>>JULIO</option>
                                            <option id="08" value="08" <?php echo ($mesactual == '08') ? "selected" : "" ?>>AGOSTO</option>
                                            <option id="09" value="09" <?php echo ($mesactual == '09') ? "selected" : "" ?>>SEPTIEMBRE</option>
                                            <option id="10" value="10" <?php echo ($mesactual == '10') ? "selected" : "" ?>>OCTUBRE</option>
                                            <option id="11" value="11" <?php echo ($mesactual == '11') ? "selected" : "" ?>>NOVIEMBRE</option>
                                            <option id="12" value="12" <?php echo ($mesactual == '12') ? "selected" : "" ?>>DICIEMBRE</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="ejercicio" class="col-form-label">EJERCICIO:</label>
                                        <input type="text" class="form-control" name="ejercicio" id="ejercicio" value="<?php echo $yearactual ?>">
                                    </div>
                                </div>

                                <div class="col-lg-2 align-self-end text-center">
                                    <div class="form-group input-group-sm">
                                        <button id="btnconsulta" name="btnconsulta" type="button" class="btn bg-gradient-success btn-ms form-control"><i class="fas fa-search"></i> Consultar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget " style="margin-bottom:0px;">

                            <div class="card-header  " style="margin:0px;padding:3px 8px">

                                <h3 class=" text-center">OBRAS</h3>
                            </div>
                            <div class="card-body">
                                <?php foreach ($datavta as $row) {
                                    $idvta = $row['folio_vta'];
                                    $idclie = $row['id_clie'];
                                    $cliente = $row['nombre'];
                                    $concepto = $row['concepto_vta'];
                                    $total = $row['gtotal'];
                                    $saldo = $row['saldo'];


                                    $consultapagom = "SELECT * FROM pagocxc WHERE estado_pagocxc=1 and folio_vta='$idvta' and month(fecha)='$mesactual' and year(fecha)='$yearactual' order by folio_pagocxc";
                                    $resultadopagom = $conexion->prepare($consultapagom);
                                    if ($resultadopagom->execute()) {
                                        $datapagom = $resultadopagom->fetchAll(PDO::FETCH_ASSOC);
                                    }
                                    $pagosm = 0;
                                    foreach ($datapagom as $rowpm) {
                                        $pagosm += $rowpm['monto'];
                                    }

                                    $consultapago = "SELECT * FROM pagocxc WHERE estado_pagocxc=1 and folio_vta='$idvta' order by folio_pagocxc";
                                    $resultadopago = $conexion->prepare($consultapago);
                                    if ($resultadopago->execute()) {
                                        $datapago = $resultadopago->fetchAll(PDO::FETCH_ASSOC);
                                    }
                                    $pagos = 0;
                                    foreach ($datapago as $rowp) {
                                        $pagos += $rowp['monto'];
                                    }


                                ?>

                                    <div class="card card-outline card-primary collapsed-card">
                                        <div class="card-header">


                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" ><i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <div class="row justify-content-center form-group">
                                                <div class="col-sm-1 ">
                                                    <label for="idvta" class="col-form-label">Folio: </label>
                                                    <input type="text" class="form-control form-control-sm" name="idvta" id="idvta" value="<?php echo $idvta ?>" disabled>
                                                </div>
                                                <div class="col-sm-3 ">
                                                    <label for="cliente" class="col-form-label">Cliente: </label>
                                                    <input type="hidden" class="form-control form-control-sm" name="idclie" id="idclie" value="<?php echo $idclie ?>" disabled>
                                                    <input type="text" class="form-control form-control-sm" name="cliente" id="cliente" value="<?php echo $cliente ?>" disabled>
                                                </div>

                                                <div class="col-sm-3 ">
                                                    <label for="concepto" class="col-form-label">Concepto: </label>
                                                    <input type="text" class="form-control form-control-sm" name="concepto" id="concepto" value="<?php echo $concepto ?>" disabled>
                                                </div>
                                                <div class="col-sm-1 ">
                                                    <label for="total" class="col-form-label">Total: </label>
                                                    <input type="text" class="form-control form-control-sm text-right" name="total" id="total" value="<?php echo '$ ' . number_format($total, 2) ?>" disabled>
                                                </div>
                                                <div class="col-sm-1 ">
                                                    <label for="cobro" class="col-form-label">Pagos Rec.: </label>
                                                    <input type="text" class="form-control form-control-sm text-right" name="cobro" id="cobro" value="<?php echo '$ ' . number_format($pagos, 2) ?>" disabled>
                                                </div>
                                                <div class="col-sm-1 ">
                                                    <label for="saldo" class="col-form-label">Saldo Actual: </label>
                                                    <input type="text" class="form-control form-control-sm text-right" name="saldo" id="saldo" value="<?php echo '$ ' . number_format($saldo, 2) ?>" disabled>
                                                </div>
                                                <div class="col-sm-1 ">
                                                    <label for="pagosm" class="col-form-label">Pagos este Mes: </label>
                                                    <input type="text" class="form-control form-control-sm text-right" name="pagosm" id="pagosm" value="<?php echo '$ ' . number_format($pagosm, 2) ?>" disabled>
                                                </div>

                                            </div>



                                        </div>


                                        <div class="card-body collapse">
                                            <div class="row justify-content-center">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table name="tabla<?php echo $idvta ?>" id="tabla<?php echo $idvta ?>" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                                            <thead class="text-center bg-gradient-primary">
                                                                <tr>
                                                                    <th>Folio Vta</th>
                                                                    <th>Proyecto/Concepto</th>
                                                                    <th>Folio Pago</th>
                                                                    <th>Fecha</th>
                                                                    <th>Concepto</th>
                                                                    <th>Monto</th>
                                                                    <th>Metodo</th>
                                                                    <th>Sol. Fact</th>
                                                                    <th>Facturar</th>
                                                                    <th># Fact</th>
                                                                    <th>Fecha Fact</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($datapago as $dat) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $dat['folio_vta'] ?></td>

                                                                        <td><?php echo $dat['concepto'] ?></td>
                                                                        <td><?php echo $dat['folio_pagocxc'] ?></td>
                                                                        <td><?php echo $dat['fecha'] ?></td>
                                                                        <td><?php echo $dat['concepto'] ?></td>
                                                                        <td class="text-right"><?php echo "$ " . number_format($dat['monto'], 2) ?></td>
                                                                        <td><?php echo $dat['metodo'] ?></td>
                                                                        <td><?php echo $dat['fcliente'] ?></td>
                                                                        <td><?php echo $dat['facturado'] ?></td>
                                                                        <td><?php echo $dat['factura'] ?></td>
                                                                        <td><?php echo $dat['fecha_fact'] ?></td>

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
                                <?php } ?>
                            </div>





                        </div>


                    </div>
                    <!-- Formulario Agrear Item -->



                </form>

            </div>
    </section>
</div>

<!-- /.card -->








<!-- /.content -->




<?php include_once 'templates/footer.php'; ?>
<script src=""></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
    $(document).ready(function() {
        $("#btnconsulta").click(function() {
            mes = $("#mes").val();
            ejercicio = $("#ejercicio").val();
            window.location.href = "rptresobra.php?mes=" + mes + "&ejercicio=" + ejercicio;

        });
    });
</script>