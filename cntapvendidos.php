<?php
$pagina = "pvendidos";

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




$consulta = "SELECT COUNT(folio_vta) AS nventas,SUM(cantidadML)+SUM(cantidadConv) AS cantidadvendida,SUM(gtotal) AS montovendido,id_item,nom_item,year(fecha_vta) AS ejercicio,
MONTH(fecha_vta) AS mes 
FROM vproductovendido WHERE month(fecha_vta)='$mesactual' and year(fecha_vta)='$yearactual' GROUP BY year(fecha_vta),month(fecha_vta),id_item";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);









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
                <h1 class="card-title text-light ">REPORTE DE PRODUCTOS VENDIDOS</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <a href="help/rptprodvend/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a>
                    </div>
                </div>
                <br>

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

                            <div class="card-header bg-green " style="margin:0px;padding:8px">

                                <h3 class="card-title ">DETALLE</h3>
                            </div>

                            <div class="card-body ">
                                <div class="container-fluid">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                                    <thead class="text-center bg-green">
                                                        <tr>
                                                            <th>ID MATERIAL</th>
                                                            <th>MATERIAL</th>
                                                            <th># DE VENTAS</th>
                                                            <th>ML VENDIDOS</th>
                                                            <th>MONTO DE VENTA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($data as $dat) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $dat['id_item'] ?></td>
                                                                <td><?php echo $dat['nom_item'] ?></td>
                                                                <td class="text-center"><?php echo $dat['nventas'] ?></td>
                                                                <td class="text-right"><?php echo number_format($dat['cantidadvendida'], 2) ?></td>
                                                                <td class="text-right"><?php echo number_format($dat['montovendido'], 2) ?></td>
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
                    <!-- Formulario Agrear Item -->


            </div>


            </form>

        </div>
    </section>
</div>

<!-- /.card -->








<!-- /.content -->




<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntapvendidos.js?v=<?php echo (rand()); ?>"></script>
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
            window.location.href = "cntapvendidos.php?mes=" + mes + "&ejercicio=" + ejercicio;

        });
    });
</script>