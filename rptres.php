<?php
$pagina = "resultados";

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

$consulta = "call sp_ingresos('$mesactual','$yearactual')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $dataingresos = $resultado->fetchAll(PDO::FETCH_ASSOC);
}


$consulta = "SELECT id_cuentaegr,nom_cuentaegr,SUM(total) AS total FROM vcxp WHERE month(fecha)='$mesactual' and year(fecha)='$yearactual' and estado_cxp=1 GROUP BY id_cuentaegr";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $datacuentas = $resultado->fetchAll(PDO::FETCH_ASSOC);
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
                <h1 class="card-title text-light ">ESTADO DE RESULTADOS</h1>
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

                            <div class="card-header bg-primary " style="margin:0px;padding:8px">

                                <h3 class=" ">ESTADO DE RESULTADOS</h3>
                            </div>

                            <div class="card-body mb-0 pb-0 " style="margin:0px;padding:1px;">

                                <div class="form-group row justify-content-sm-center mb-0">
                                    <div class="col-sm-12 form-group mb-0">
                                        <div class="  " style="margin:0px;padding:8px">
                                            <h4 class=" text-bold  ">INGRESOS</h4>
                                        </div>
                                        <?php
                                        $totalingresos = 0;
                                        foreach ($dataingresos as $reging) {
                                            $totalingresos += $reging['pagopro'];
                                        ?>
                                            <div class="row justify-content-center  mx-2">
                                                <div class="col-sm-3 pl-2">
                                                    <label for="<?php echo $reging['nom_t_concepto'] ?>" class="col-form-label"><a href="detalleing.php?<?php echo 'mes=' . $mesactual . '&ejercicio=' . $yearactual . '&concepto=' . $reging['nom_t_concepto'] ?>"><?php echo strtoupper($reging['nom_t_concepto']) ?>: </a></label>
                                                </div>

                                                

                                                <div class="col-sm-4">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control text-right bg-white" name="<?php echo $reging['nom_t_concepto'] ?>" id="<?php echo $reging['nom_t_concepto'] ?>" value="<?php echo number_format($reging['pagopro'], 2) ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class=" border-bootom">
                                            <div class="row justify-content-center" style="margin:0px;padding:8px;border-bottom: 2px solid lightgrey;">
                                                <div class="col-sm-3">
                                                    <h4 for="totaling" class=" text-bold">TOTAL INGRESOS: </h4>
                                                </div>



                                                <div class="col-sm-4 ">
                                                    <div class="input-group input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control text-right bg-white text-bold text-green" name="totaling" id="totaling" value="<?php echo number_format($totalingresos, 2) ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" " style="margin:0px;padding:8px">

                                            <h4 class="text-bold "><span class="bold">EGRESOS</span></h4>
                                        </div>

                                        <?php
                                        $totalegreso = 0;
                                        foreach ($datacuentas as $registro) {
                                            $totalegreso += $registro['total'];
                                            $cuetnaegr = $registro['id_cuentaegr'];

                                            $consultap = "SELECT nom_partida,sum(total) AS total FROM vcxp WHERE month(fecha)='$mesactual' and year(fecha)='$yearactual' and estado_cxp=1 and id_cuentaegr='$cuetnaegr' GROUP BY nom_partida";
                                            $resultadop = $conexion->prepare($consultap);
                                            if ($resultadop->execute()) {
                                                $dataegresosp = $resultadop->fetchAll(PDO::FETCH_ASSOC);
                                            }
                                        ?>
                                            <div class="row justify-content-center  mx-2">
                                                <div class="col-sm-3 pl-2  ">
                                                    <label for="<?php echo $registro['nom_cuentaegr'] ?>" class="col-form-label"><a data-toggle="collapse" href="#<?php echo 'det' . $registro['id_cuentaegr'] ?>" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo $registro['nom_cuentaegr'] ?>: </a></label>
                                                </div>

                                                

                                                <div class="col-sm-4">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>
                                                        </div>
                                                        <!--
                                                        <a href="detalleegr.php?<?php echo 'mes=' . $mesactual . '&ejercicio=' . $yearactual . '&concepto=' . $registro['nom_cuentaegr'] ?>">
                                                        -->
                                                        <input type="text" class="form-control text-right bg-white" name="<?php echo $registro['nom_cuentaegr'] ?>" id="<?php echo $registro['nom_cuentaegr'] ?>" value="<?php echo number_format($registro['total'], 2) ?>" disabled>
                                                    </div>
                                                </div>


                                            </div>
                                            
                                            <div class="collapse" id="<?php echo 'det' . $registro['id_cuentaegr'] ?>">
                                                <?php
                                                foreach ($dataegresosp as $regpartida) {
                                                ?>
                                                    <div class="row justify-content-center m-2" >
                                                        
                                                        
                                                        <div class="col-sm-2 pl-2  ">

                                                            <label for="<?php echo $regpartida['nom_partida'] ?>" class="col-form-label "><a href="detalleegr.php?<?php echo 'mes=' . $mesactual . '&ejercicio=' . $yearactual . '&concepto=' . $regpartida['nom_partida'] ?>"><?php echo $regpartida['nom_partida'] ?>: </a></label>
                                                        </div>

                                                        

                                                        <div class="col-sm-3">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-dollar-sign"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control text-right bg-white" name="<?php echo $regpartida['nom_partida'] ?>" id="<?php echo $regpartida['nom_partida'] ?>" value="<?php echo number_format($regpartida['total'], 2) ?>" disabled>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        <?php }
                                        ?>

                                        <div class="row justify-content-center " style="margin:0px;padding:8px">
                                            <div class="col-sm-3">
                                                <h4 class="text-bold">TOTAL EGRESOS: </h4>
                                            </div>



                                            <div class="col-sm-4">
                                                <div class="input-group input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control text-right bg-white text-bold" name="totaleg" id="totaleg" value="<?php echo number_format($totalegreso, 2) ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-between bg-primary mt-0" style="margin:0px;padding:8px">
                                    <div>
                                        <h3 class="text-bold"><?php echo ($totalingresos - $totalegreso) > 0 ? "UTILIDAD DEL PERIODO" : "PERDIDA DEL PERIODO" ?>: </h3>
                                    </div>



                                    <div class="col-sm-4">
                                        <div class="input-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right text-bold <?php echo ($totalingresos - $totalegreso) > 0 ? "bg-green" : "bg-red" ?> " name="resul" id="resul" value="<?php echo number_format(($totalingresos - $totalegreso), 2) ?>" disabled>
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
            window.location.href = "rptres.php?mes=" + mes + "&ejercicio=" + ejercicio;

        });
    });
</script>