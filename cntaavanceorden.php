<?php
$pagina = "cntaavanceorden";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT edo_ord,COUNT(estado_ord) AS nordenes,tipop FROM vorden WHERE estado_ord=1 AND tipo_proy=1  and (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )
GROUP BY edo_ord,tipop ORDER BY COUNT(estado_ord) DESC LIMIT 1";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$filas = 0;
foreach ($data as $row) {
    $filas = $row['nordenes'];
}

$arreglo = array();


$consulta = "SELECT if(avance=90,'COLOCACION',edo_ord) AS edo_ord,COUNT(estado_ord) AS nordenes,tipop FROM vorden 
WHERE estado_ord=1 AND tipo_proy=1 AND (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )
GROUP BY if(avance=90,'COLOCACION',edo_ord),tipop ORDER BY tipo_proy,avance,edo_ord";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


$activo = 0;
$medicion = 0;
$corte = 0;
$ensamble = 0;
$pulido = 0;
$colocacion = 0;
$liberado = 0;
foreach ($data as $row) {
    $estado = $row['edo_ord'];

    switch ($estado) {
        case 'ACTIVO':
            $activo = $row['nordenes'];
            break;
        case 'MEDICION':
            $medicion = $row['nordenes'];
            break;
        case 'CORTE':
            $corte = $row['nordenes'];
            break;
        case 'ENSAMBLE':
            $ensamble = $row['nordenes'];
            break;
        case 'PULIDO':
            $pulido = $row['nordenes'];
            break;
        case 'COLOCACION':
            $colocacion = $row['nordenes'];
            break;
        case 'LIBERADO':
            $liberado = $row['nordenes'];
            break;
    }
}




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
        <div class="card">
            <div class="card-header bg-gradient-orange text-white">
                <h1 class="card-title mx-auto">AVANCE DE ORDENES</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <a href="help/rptpizarra/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a>
                    </div>
                </div>


                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%; font-size:12px">
                                    <thead class="text-center bg-gradient-orange text-white">
                                        <tr>
                                            <th>INICIO</th>
                                            <th>MEDICION</th>
                                            <th>CORTE</th>
                                            <th>ENSAMBLE</th>
                                            <th>PULIDO</th>
                                            <th>COLOCACION</th>
                                            <th>LIBERADO</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    for ($i = 0; $i < $filas; $i++) {
                                    ?>
                                        <tr>
                                            <?php
                                            if ($i < $activo) {
                                                $consulta = "SELECT folio_ord,folio_vta,nombre,concepto_vta,if(avance=90,'COLOCACION',edo_ord) as edo_ord,avance FROM vorden 
                                                WHERE edo_ord='ACTIVO' and estado_ord=1 AND tipo_proy=1 AND (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )";
                                                $resultado = $conexion->prepare($consulta);
                                                $resultado->execute();
                                                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                echo "
                                                    <td>
                                                        <div class='card '>
                                                            <div class='card-header bg-primary'>
                                                                <div class='row justify-content-center'>
                                                                    <div class='col-sm-6 text-center'>
                                                                        <span>ORDEN:<br>" . $data[$i]['folio_ord'] . " </span>
                                                                    </div>
                                                                  
                                                                
                                                                    <div class='col-sm-6 text-center'>
                                                                        <span>VTA:<br>" . $data[$i]['folio_vta'] . " </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='card-body justify-content-center m-0 p-2'>
                                                                <div class='row justify-content-center'>
                                                                <div class='col-sm-12 border-bottom'>
                                                                    <span><b>CLIENTE:</b><br>" . $data[$i]['nombre'] . " </span>
                                                                </div>
                                                                <div class='col-sm-12'>
                                                                    <span><b>PROYECTO:</b><br>" . $data[$i]['concepto_vta'] . " </span>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>";
                                            } else {
                                                echo "<td></td>";
                                            }

                                            if ($i < $medicion) {
                                                $consulta = "SELECT folio_ord,folio_vta,nombre,concepto_vta,if(avance=90,'COLOCACION',edo_ord) as edo_ord,avance FROM vorden 
                                                    WHERE edo_ord='MEDICION' and estado_ord=1 AND tipo_proy=1 AND (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )";
                                                $resultado = $conexion->prepare($consulta);
                                                $resultado->execute();
                                                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                echo "
                                                <td>
                                                    <div class='card '>
                                                        <div class='card-header bg-gradient-warning text-white'>
                                                            <div class='row justify-content-center'>
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>ORDEN:<br>" . $data[$i]['folio_ord'] . " </span>
                                                                </div>
                                                              
                                                            
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>VTA:<br>" . $data[$i]['folio_vta'] . " </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='card-body justify-content-center m-0 p-2'>
                                                            <div class='row justify-content-center'>
                                                            <div class='col-sm-12 border-bottom'>
                                                                <span><b>CLIENTE:</b><br>" . $data[$i]['nombre'] . " </span>
                                                            </div>
                                                            <div class='col-sm-12'>
                                                                <span><b>PROYECTO:</b><br>" . $data[$i]['concepto_vta'] . " </span>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>";
                                            } else {
                                                echo "<td></td>";
                                            }

                                            if ($i < $corte) {
                                                $consulta = "SELECT folio_ord,folio_vta,nombre,concepto_vta,if(avance=90,'COLOCACION',edo_ord) as edo_ord,avance FROM vorden 
                                                        WHERE edo_ord='CORTE' and estado_ord=1 AND tipo_proy=1 AND (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )";
                                                $resultado = $conexion->prepare($consulta);
                                                $resultado->execute();
                                                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                echo "
                                                <td>
                                                    <div class='card '>
                                                        <div class='card-header bg-gradient-secondary text-white'>
                                                            <div class='row justify-content-center'>
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>ORDEN:<br>" . $data[$i]['folio_ord'] . " </span>
                                                                </div>
                                                              
                                                            
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>VTA:<br>" . $data[$i]['folio_vta'] . " </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='card-body justify-content-center m-0 p-2'>
                                                            <div class='row justify-content-center'>
                                                            <div class='col-sm-12 border-bottom'>
                                                                <span><b>CLIENTE:</b><br>" . $data[$i]['nombre'] . " </span>
                                                            </div>
                                                            <div class='col-sm-12'>
                                                                <span><b>PROYECTO:</b><br>" . $data[$i]['concepto_vta'] . " </span>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>";
                                            } else {
                                                echo "<td></td>";
                                            }

                                            if ($i < $ensamble) {
                                                $consulta = "SELECT folio_ord,folio_vta,nombre,concepto_vta,if(avance=90,'COLOCACION',edo_ord) as edo_ord,avance FROM vorden 
                                                            WHERE edo_ord='ENSAMBLE' and estado_ord=1 AND tipo_proy=1 AND (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )";
                                                $resultado = $conexion->prepare($consulta);
                                                $resultado->execute();
                                                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                echo "
                                                <td>
                                                    <div class='card '>
                                                        <div class='card-header bg-gradient-info text-white'>
                                                            <div class='row justify-content-center'>
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>ORDEN:<br>" . $data[$i]['folio_ord'] . " </span>
                                                                </div>
                                                              
                                                            
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>VTA:<br>" . $data[$i]['folio_vta'] . " </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='card-body justify-content-center m-0 p-2'>
                                                            <div class='row justify-content-center'>
                                                            <div class='col-sm-12 border-bottom'>
                                                                <span><b>CLIENTE:</b><br>" . $data[$i]['nombre'] . " </span>
                                                            </div>
                                                            <div class='col-sm-12'>
                                                                <span><b>PROYECTO:</b><br>" . $data[$i]['concepto_vta'] . " </span>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>";
                                            } else {
                                                echo "<td></td>";
                                            }
                                            if ($i < $pulido) {
                                                $consulta = "SELECT folio_ord,folio_vta,nombre,concepto_vta,if(avance=90,'COLOCACION',edo_ord) as edo_ord,avance FROM vorden 
                                                                WHERE edo_ord='PULIDO' and estado_ord=1 AND tipo_proy=1 AND (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )";
                                                $resultado = $conexion->prepare($consulta);
                                                $resultado->execute();
                                                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                echo "
                                                <td>
                                                    <div class='card '>
                                                        <div class='card-header bg-gradient-purple text-white'>
                                                            <div class='row justify-content-center'>
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>ORDEN:<br>" . $data[$i]['folio_ord'] . " </span>
                                                                </div>
                                                              
                                                            
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>VTA:<br>" . $data[$i]['folio_vta'] . " </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='card-body justify-content-center m-0 p-2'>
                                                            <div class='row justify-content-center'>
                                                            <div class='col-sm-12 border-bottom'>
                                                                <span><b>CLIENTE:</b><br>" . $data[$i]['nombre'] . " </span>
                                                            </div>
                                                            <div class='col-sm-12'>
                                                                <span><b>PROYECTO:</b><br>" . $data[$i]['concepto_vta'] . " </span>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>";
                                            } else {
                                                echo "<td></td>";
                                            }
                                            if ($i < $colocacion) {
                                                $consulta = "SELECT folio_ord,folio_vta,nombre,concepto_vta,if(avance=90,'COLOCACION',edo_ord) as edo_ord,avance FROM vorden 
                                                WHERE if(avance=90,'COLOCACION',edo_ord)='COLOCACION' and estado_ord=1 AND tipo_proy=1 AND (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )";
                                                $resultado = $conexion->prepare($consulta);
                                                $resultado->execute();
                                                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                echo "
                                                <td>
                                                    <div class='card '>
                                                        <div class='card-header bg-gradient-orange text-white'>
                                                            <div class='row justify-content-center'>
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>ORDEN:<br>" . $data[$i]['folio_ord'] . " </span>
                                                                </div>
                                                              
                                                            
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>VTA:<br>" . $data[$i]['folio_vta'] . " </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='card-body justify-content-center m-0 p-2'>
                                                            <div class='row justify-content-center'>
                                                            <div class='col-sm-12 border-bottom'>
                                                                <span><b>CLIENTE:</b><br>" . $data[$i]['nombre'] . " </span>
                                                            </div>
                                                            <div class='col-sm-12'>
                                                                <span><b>PROYECTO:</b><br>" . $data[$i]['concepto_vta'] . " </span>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>";
                                            } else {
                                                echo "<td></td>";
                                            }
                                            if ($i < $liberado) {
                                                $consulta = "SELECT folio_ord,folio_vta,nombre,concepto_vta,if(avance=90,'COLOCACION',edo_ord) as edo_ord,avance FROM vorden 
                                                    WHERE edo_ord='LIBERADO' and estado_ord=1 AND tipo_proy=1 AND (avance<100 OR fecha_liberacion >= DATE_SUB(CURDATE(),INTERVAL 1 MONTH) )";
                                                $resultado = $conexion->prepare($consulta);
                                                $resultado->execute();
                                                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                echo "
                                                <td>
                                                    <div class='card '>
                                                        <div class='card-header bg-gradient-success text-white'>
                                                            <div class='row justify-content-center'>
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>ORDEN:<br>" . $data[$i]['folio_ord'] . " </span>
                                                                </div>
                                                              
                                                            
                                                                <div class='col-sm-6 text-center'>
                                                                    <span>VTA:<br>" . $data[$i]['folio_vta'] . " </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='card-body justify-content-center m-0 p-2'>
                                                            <div class='row justify-content-center'>
                                                            <div class='col-sm-12 border-bottom'>
                                                                <span><b>CLIENTE:</b><br>" . $data[$i]['nombre'] . " </span>
                                                            </div>
                                                            <div class='col-sm-12'>
                                                                <span><b>PROYECTO:</b><br>" . $data[$i]['concepto_vta'] . " </span>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>";
                                            } else {
                                                echo "<td></td>";
                                            }


                                            ?>


                                        </tr>
                                    <?php   }   ?>

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


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaavanceorden.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>