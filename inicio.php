<?php
$pagina = 'home';
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";
$fechahome = (isset($_GET['fecha'])) ? strtotime($_GET['fecha']) : strtotime(date("Y-m-d"));
$meshome = date("m", $fechahome);
$yearhome = date("Y", $fechahome);

include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
date_default_timezone_set('America/Mexico_City');


/*FECHA INICIO DE SEMANA */
$diaInicio = "Monday";
$diaFin = "Sunday";
$fechafun = date('Y-M-d');
$strFecha = strtotime($fechafun);

$fechaInicio = date('Y-m-d', strtotime('last ' . $diaInicio, $strFecha));
$fechaFin = date('Y-m-d', strtotime('next ' . $diaFin, $strFecha));

if (date("l", $strFecha) == $diaInicio) {
  $fechaInicio = date("Y-m-d", $strFecha);
}
if (date("l", $strFecha) == $diaFin) {
  $fechaFin = date("Y-m-d", $strFecha);
}
/*FIN FECHA INICIO DE SEMANA */
$mesarreglo = array(
  "", "ENERO",
  "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"
);
$mesactual = $mesarreglo[date('n')];
//$mesactual = $mesarreglo[date('m', $meshome)];
$m = $meshome;
$y = $yearhome;

if (date("D") == "Mon") {
  $iniciosemana = date("Y-m-d", $fechahome);
} else {
  $iniciosemana = date(date("Y-m-d", $fechahome), strtotime('last Monday', time()));
}

$finsemana = date(date("Y-m-d", $fechahome), strtotime('next Sunday', time()));


$cntacon = "SELECT consulta2.ejercicio,mes.id_mes, mes.nom_mes,ifnull(consulta2.ingreso,0) AS ingreso,ifnull(consulta1.egreso,0) AS egreso, (ifnull(consulta2.ingreso,0)-ifnull(consulta1.egreso,0)) AS resultado
FROM mes
left JOIN
(SELECT YEAR(fecha) AS ejercicio,MONTH(fecha) AS idmes, monthname(fecha) AS mes,SUM(monto)AS ingreso FROM pagocxc WHERE estado_pagocxc=1 and year(fecha)='$y' GROUP BY YEAR(fecha),MONTH(fecha) order by year(fecha),MONTH(fecha)) AS consulta2
ON 
mes.id_mes=consulta2.idmes
LEFT JOIN 
(SELECT year(fecha) as ejercicio,MONTH(fecha) AS idmes,monthname(fecha) as mes,SUM(total) AS egreso FROM vcxp where estado_cxp=1 and year(fecha)='$y' GROUP BY year(fecha),MONTH(fecha) order by year(fecha),MONTH(fecha)) AS consulta1
ON mes.id_mes=consulta1.idmes";
$rescon = $conexion->prepare($cntacon);
$rescon->execute();
$datacon = $rescon->fetchAll(PDO::FETCH_ASSOC);




$consulta = "SELECT * FROM vpres WHERE estado_pres<>'ACEPTADO' AND estado_pres <>'RECHAZADO' AND estado_pres<>'SUSPENDIDO' AND edo_pres=1 order by fecha_pres";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$totalpres = 0;
$montpres = 0;
foreach ($data as $regd) {
  $totalpres += 1;
  $montpres += $regd['gtotal'];
}

$consultav = "SELECT * FROM vventa WHERE estado_vta=1 and month(fecha_vta)='$m' and year(fecha_vta)='$y'";
$resultadov = $conexion->prepare($consultav);
$resultadov->execute();
$datav = $resultadov->fetchAll(PDO::FETCH_ASSOC);

$totalvta = 0;
$montvta = 0;
foreach ($datav as $regv) {
  $totalvta += 1;
  $montvta += $regv['gtotal'];
}

$consultaml = "SELECT vendedor,SUM(cantidadML+cantidadConv) AS mlvendido FROM vconversionvta WHERE month(fecha_vta)='$m' AND year(fecha_vta)='$y' GROUP BY vendedor";
$resultadoml = $conexion->prepare($consultaml);
$resultadoml->execute();
$dataml = $resultadoml->fetchAll(PDO::FETCH_ASSOC);

$consultavtav = "SELECT vendedor,SUM(gtotal) AS total FROM vventa WHERE month(fecha_vta)='$m' AND year(fecha_vta)='$y' AND estado_vta=1 AND tipo_proy=1 GROUP BY vendedor";
$resultadvtav = $conexion->prepare($consultavtav);
$resultadvtav->execute();
$datavtav = $resultadvtav->fetchAll(PDO::FETCH_ASSOC);

$consultaml2 = "SELECT vendedor,SUM(cantidadML+cantidadConv) AS mlvendido FROM vconversionvtaobr WHERE month(fecha_vta)='$m' AND year(fecha_vta)='$y' GROUP BY vendedor";
$resultadoml2 = $conexion->prepare($consultaml2);
$resultadoml2->execute();
$dataml2 = $resultadoml2->fetchAll(PDO::FETCH_ASSOC);

$consultavtav2 = "SELECT vendedor,SUM(gtotal) AS total FROM vventa WHERE month(fecha_vta)='$m' AND year(fecha_vta)='$y' AND estado_vta=1 AND tipo_proy=2 GROUP BY vendedor";
$resultadvtav2 = $conexion->prepare($consultavtav2);
$resultadvtav2->execute();
$datavtav2 = $resultadvtav2->fetchAll(PDO::FETCH_ASSOC);




$consultac = "SELECT * FROM viewcitav WHERE year(fecha)= '$y' and month(fecha)='$m' and estado_citav='1' order by fecha";

$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);


$consultaing = "SELECT SUM(monto) AS monto FROM vpagocxc WHERE month(fecha)='$m' AND YEAR(fecha)='$y' AND estado_pagocxc=1";
$resultadoing = $conexion->prepare($consultaing);
$resultadoing->execute();
$dataing = $resultadoing->fetchAll(PDO::FETCH_ASSOC);




/*
$consultametros = "CALL sp_graficametros('$y','$m')";
$resultadometros = $conexion->prepare($consultametros);
$resultadometros->execute();
$datametros = $resultadometros->fetchAll(PDO::FETCH_ASSOC);
*/

//m2vendidos
$cons1 = "SELECT * FROM vconversionvta WHERE YEAR(fecha_vta)='$y' AND MONTH(fecha_vta)='$m'";
$res1 = $conexion->prepare($cons1);
$res1->execute();
$dat1 = $res1->fetchAll(PDO::FETCH_ASSOC);
$mvendidosn = 0;
foreach ($dat1 as $reg1) {
  $mvendidosn += $reg1['cantidadML'];
}

//m2vendidosejecutados
$cons1 = "SELECT SUM(vconversionvta.cantidadML) AS mlejecutadosmes FROM  vconversionvta JOIN (
  SELECT * FROM v_rptorden where year(fecha_liberacion)='$y' AND MONTH(fecha_liberacion)='$m' and nom_umedida='ML'
  ) AS consulta
  ON vconversionvta.folio_vta=consulta.folio_vta
  WHERE year(vconversionvta.fecha_vta)='$y' AND MONTH(vconversionvta.fecha_vta)='$m'
  GROUP BY vconversionvta.folio_vta";
$res1 = $conexion->prepare($cons1);
$res1->execute();
$dat1 = $res1->fetchAll(PDO::FETCH_ASSOC);
$mejecutadosmesn = 0;
foreach ($dat1 as $reg1) {
  $mejecutadosmesn += $reg1['mlejecutadosmes'];
}


//m2ejecutados
$cons1 = "SELECT * FROM v_rptorden where year(fecha_liberacion)='$y' AND MONTH(fecha_liberacion)='$m' and nom_umedida='ML'";
$res1 = $conexion->prepare($cons1);
$res1->execute();
$dat1 = $res1->fetchAll(PDO::FETCH_ASSOC);
$mejecutadosn = 0;
foreach ($dat1 as $reg1) {
  $mejecutadosn += $reg1['cantidad'];
}


$totaling = 0;
foreach ($dataing as $reging) {
  $totaling += $reging['monto'];
}


$consultamed = "SELECT * from vcitamed where estado_cita='1' and year(start)='$y' and month(start)='$m' order by start";
$res2 = $conexion->prepare($consultamed);
$res2->execute();
$datacitam = $res2->fetchAll(PDO::FETCH_ASSOC);



if (date("D") == "Mon") {
  $isemana = date("Y-m-d");
} else {
  $isemana = date("Y-m-d", strtotime('last Monday', time()));
}

$fsemana = date("Y-m-d", strtotime('next Sunday', time()));



$consultais = "SELECT * FROM vllamada WHERE fecha_llamada BETWEEN '$isemana' and '$fsemana' ORDER BY fecha_llamada";
$resultadois = $conexion->prepare($consultais);
$resultadois->execute();
$datais = $resultadois->fetchAll(PDO::FETCH_ASSOC);

$consultafs = "SELECT * FROM vllamada WHERE fecha_llamada > '$fsemana' ORDER BY fecha_llamada";
$resultadofs = $conexion->prepare($consultafs);
$resultadofs->execute();
$datafs = $resultadofs->fetchAll(PDO::FETCH_ASSOC);



if ($_SESSION['s_rol'] != '2' || $_SESSION['s_rol'] != '3') {
  $cntastat = "SELECT vendedor,ejercicio,mes,
                presaceptados,ROUND((presaceptados/npres)*100,2) AS porpresaceptados,aceptados,ROUND((aceptados/totalpres)*100,2) AS portotalaceptados,
                presrechazados,ROUND((presrechazados/npres)*100,2) AS porpresrechazados,rechazados,ROUND((rechazados/totalpres)*100,2) AS portotalrechazados,
                presotros,ROUND((presotros/npres)*100,2) AS porotros,otros,ROUND((otros/totalpres)*100,2) AS portotalotros,
                npres,totalpres
                FROM vestadisticas2 WHERE ejercicio='$y' and mes='$m' ";
  $resstat = $conexion->prepare($cntastat);
  $resstat->execute();
  $datastat = $resstat->fetchAll(PDO::FETCH_ASSOC);
} else if ($_SESSION['s_rol'] != '1') {
  $cntastat = "SELECT vendedor,ejercicio,mes,
                presaceptados,ROUND((presaceptados/npres)*100,2) AS porpresaceptados,aceptados,ROUND((aceptados/totalpres)*100,2) AS portotalaceptados,
                presrechazados,ROUND((presrechazados/npres)*100,2) AS porpresrechazados,rechazados,ROUND((rechazados/totalpres)*100,2) AS portotalrechazados,
                presotros,ROUND((presotros/npres)*100,2) AS porotros,otros,ROUND((otros/totalpres)*100,2) AS portotalotros,
                npres,totalpres
                FROM vestadisticas2 WHERE ejercicio='$y' and mes='$m' ";
  $resstat = $conexion->prepare($cntastat);
  $resstat->execute();
  $datastat = $resstat->fetchAll(PDO::FETCH_ASSOC);
} else {
  $datastat = null;
}






?>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- ABRE HEADER -->
  <section class="container-fluid card">
    <div class="card-header bg-gradient-orange">
      <h1>ERP GALLERY STONE </h1>
    </div>
  </section>
  <!-- CIERRA HEADER -->
  <!-- ABRE EL CONTENIDO DE HOME -->
  <?php if ($_SESSION['s_rol'] != '4' && $_SESSION['s_rol'] != '5') { ?>

    <section class="content">
      <div class="container-fluid">

        <!--CARDS ENCABEZADO -->
        <div class="row justify-content-center">
          <div class="col-sm-2">
            <div class="form-group input-group-sm">
              <label for="fechahome" class="col-form-label">Fecha de Consulta:</label>
              <input type="date" class="form-control" name="fechahome" id="fechahome" value="<?php echo  date('Y-m-d', $fechahome) ?>">
            </div>
          </div>



          <div class="col-sm-1 align-self-end text-center">
            <div class="form-group input-group-sm">
              <button id="btnHome" name="btnHome" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-3 col-6">

            <div class="small-box bg-gradient-orange text-white">
              <div class="inner">
                <h3><?php echo $totalpres ?></h3>

                <p># PRESUPUESTOS ACTIVOS</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-check-alt "></i>
              </div>
              <a href="cntapresupuesto.php" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-sm-3 col-6">

            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $totalvta ?></h3>

                <p># VENTAS DE <?php echo $mesactual ?></p>
              </div>
              <div class="icon">
                <i class="fas fa-cash-register"></i>
              </div>
              <a href="cntaventa.php" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-sm-3 col-6">

            <div class="small-box bg-gradient-warning text-white">
              <div class="inner">
                <h3><?php echo "$" . number_format($montpres, 2) ?></h3>

                <p>MONTO DE PRESUPUESTOS ACTIVOS</p>
              </div>
              <div class="icon">
                <i class="fas fa-search-dollar"></i>
              </div>
              <a href="cntapresupuesto.php" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-sm-3 col-6">

            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?php echo "$" . number_format($totaling, 2) ?></h3>

                <p>INGRESOS DEL MES</p>
              </div>
              <div class="icon">
                <i class="fas fa-dollar-sign"></i>
              </div>
              <a href="cntapagoscxc.php" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>


        <!-- Graficas-->

        <section>

          <div class="row justify-content-center">

            <!-- GRAFICA DE ML VENDIDOS-->
            <div class="col-sm-6">
              <div class="card ">
                <div class="card-header bg-gradient-success color-palette border-0">
                  <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    Metros Lineales Vendidos Proyectos
                  </h3>

                  <div class="card-tools">
                    <button type="button" class="btn bg-gradient-success btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>

                  </div>
                </div>
                <div class="card-body">
                  <div class="row justify-content">
                    <div class="col-sm-7">
                      <canvas class="chart " id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <div class="col-sm-5 my-auto">
                      <div class="table-responsive">
                        <table class="table table-responsive table-bordered table-hover table-sm">
                          <thead class="text-center">
                            <tr>
                              <th>Vendedor</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $totalml = 0;
                            foreach ($dataml as $rowml) {
                              $totalml += $rowml['mlvendido'];
                            ?>
                              <tr>
                                <td><?php echo $rowml['vendedor'] ?></td>
                                <td class="text-right"><?php echo $rowml['mlvendido'] ?></td>
                              </tr>
                            <?php } ?>

                          </tbody>
                          <tfoot>
                            <tr>
                              <td>ML VENDIDOS <?php echo $mesactual ?></td>
                              <td class="text-right text-bold"><?php echo $totalml ?></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <!-- /.card-footer -->
              </div>
            </div>
            <!-- GRAFICA DE VENTAS-->
            <div class="col-sm-6">
              <div class="card ">
                <div class="card-header bg-gradient-success color-palette border-0">
                  <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    Monto de Ventas Proyectos
                  </h3>

                  <div class="card-tools">
                    <button type="button" class="btn bg-gradient-success btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>

                  </div>
                </div>
                <div class="card-body">
                  <div class="row justify-content">
                    <div class="col-sm-7">
                      <canvas class="chart " id="line-chart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <div class="col-sm-5 my-auto">
                      <div class="table-responsive">
                        <table class="table table-responsive table-bordered table-hover table-sm">
                          <thead class="text-center">
                            <tr>
                              <th>Vendedor</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $totalvtasml = 0;
                            foreach ($datavtav as $rowml) {
                              $totalvtasml += $rowml['total'];
                            ?>
                              <tr>
                                <td><?php echo $rowml['vendedor'] ?></td>
                                <td class="text-right"><?php echo '$ ' . number_format($rowml['total'], 2) ?></td>
                              </tr>
                            <?php } ?>

                          </tbody>
                          <tfoot>
                            <tr>
                              <td>VENTAS <?php echo $mesactual ?></td>
                              <td class="text-right text-bold"><?php echo '$ ' . number_format($totalvtasml, 2) ?></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <!-- /.card-footer -->
              </div>
            </div>
            <?php if ($_SESSION['s_rol'] == '2' || $_SESSION['s_rol'] == '3') { ?>
              <!-- GRAFICA INGRESOS VS EGRESOS -->
              <div class="col-sm-12">
                <div class="card ">
                  <div class="card-header bg-gradient-success color-palette border-0">
                    <h3 class="card-title">
                      <i class="fas fa-th mr-1"></i>
                      Comparativo Ingresos vs Egresos
                    </h3>

                    <div class="card-tools">
                      <button type="button" class="btn bg-gradient-success btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>

                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row justify-content-center">
                      <div class="col-sm-12">
                        <canvas class="chart " id="resultados-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-sm-12 my-auto">
                          <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-hover table-sm table-responsive-sm">
                              <thead class="text-center bg-gradient-success">
                                <tr>
                                  <th>Concepto</th>
                                  <?php foreach ($datacon as $dcon) {
                                    echo '<th>' . $dcon['nom_mes'] . '</th>';
                                  } ?>

                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>Ingresos</td>
                                  <?php
                                  $ting = 0;
                                  foreach ($datacon as $dcon) {
                                    $ting += $dcon['ingreso'];
                                    echo '<td class="text-right">$ ' . number_format($dcon['ingreso'], 2) . '</td>';
                                  } ?>
                                  <td class="text-right">$<?php echo  number_format($ting, 2) ?></td>
                                </tr>
                                <tr>
                                  <td>Egresos</td>
                                  <?php
                                  $teg = 0;
                                  foreach ($datacon as $dcon) {
                                    $teg += $dcon['egreso'];
                                    echo '<td class="text-right">$ ' . number_format($dcon['egreso'], 2) . '</td>';
                                  } ?>
                                  <td class="text-right">$<?php echo  number_format($teg, 2) ?></td>
                                </tr>
                                <tr>
                                  <td><b>Resultado</b></td>
                                  <?php
                                  $tot = 0;
                                  foreach ($datacon as $dcon) {
                                    $tot += $dcon['resultado'];
                                    if ($dcon['resultado'] > 0) {
                                      echo '<td class="text-green text-right"><b>$ ' . number_format($dcon['resultado'], 2) . '</b></td>';
                                    } else if ($dcon['resultado'] == 0) {
                                      echo '<td class="text-center"><b>-</b></td>';
                                    } else {
                                      echo '<td class="text-danger text-right"><b>($ ' . number_format(abs($dcon['resultado']), 2) . ')</b></td>';
                                    }
                                  } ?>
                                  <td class="text-right">$<?php echo  number_format($tot, 2) ?></td>
                                </tr>
                              </tbody>

                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <!-- /.card-footer -->
                </div>
              </div>
              <!--FIN GRAFICA INGRESOS VS EGRESOS -->
            <?php } ?>
            <!--FIN GRAFICA COMPARATIVA ML -->
            <div class="col-sm-12">
              <div class="card ">
                <div class="card-header bg-gradient-success color-palette border-0">
                  <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    Analisis de Ventas-Producción
                  </h3>

                  <div class="card-tools">
                    <button type="button" class="btn bg-gradient-success btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>

                  </div>
                </div>
                <div class="card-body">
                  <div class="row justify-content">
                    <div class="col-sm-8">
                      <canvas class="chart " id="metros-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <div class="col-sm-4 my-auto">
                      <div class="table-responsive">
                        <table class="table table-responsive table-bordered table-hover table-sm">
                          <thead class="text-center">
                            <tr>
                              <th>CONCEPTO</th>
                              <th>ML</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            // foreach ($datametros as $rowmetros) {

                            ?>
                            <!--
                              <tr>
                                <td>ML VENDIDOS</td>
                                <td class="text-right"><?php echo $rowmetros['mlvendidos'] ?></td>
                              </tr>
                              <tr>
                                <td>ML VENDIDOS EJECUTADOS</td>
                                <td class="text-right"><?php echo $rowmetros['mlvendidoseje'] ?></td>
                              </tr>
                              <tr>
                                <td>ML EJECUTADOS </td>
                                <td class="text-right"><?php echo $rowmetros['mldelmes'] ?></td>
                              </tr>-->
                            <tr>
                              <td>ML VENDIDOS</td>
                              <td class="text-right"><?php echo $mvendidosn ?></td>
                            </tr>
                            <tr>
                              <td>ML VENDIDOS EJECUTADOS</td>
                              <td class="text-right"><?php echo $mejecutadosmesn ?></td>
                            </tr>
                            <tr>
                              <td>ML EJECUTADOS </td>
                              <td class="text-right"><?php echo $mejecutadosn ?></td>
                            </tr>
                            <?php // } 
                            ?>

                          </tbody>

                        </table>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- /.card-body -->

                <!-- /.card-footer -->
              </div>
            </div>

            <div class="col-sm-12">
              <div class="card ">
                <div class="card-header bg-gradient-primary color-palette border-0">
                  <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    Estadisticas de <?php echo $mesactual ?>
                  </h3>

                  <div class="card-tools">
                    <button type="button" class="btn bg-gradient-primary btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>

                  </div>
                </div>
                <div class="card-body">
                  <div class="row justify-content">

                    <div class="col-sm-12 my-auto">
                      <div class="table-responsive">
                        <table class="table table-responsive table-bordered table-hover table-sm">
                          <thead class="text-center ">
                            <tr>
                              <th>VENDEDOR</th>
                              <th class="bg-primary"># PRES</th>
                              <th class="bg-primary">$ PRES</th>
                              <th class="bg-success">#PRES. AC</th>
                              <th class="bg-success">% #PRES. AC</th>
                              <th class="bg-success">$PRES. AC</th>
                              <th class="bg-success">% $PRES. AC</th>
                              <th class="bg-gradient-warning text-light">#PRES. RCH</th>
                              <th class="bg-gradient-warning text-light">% #PRES. RCH</th>
                              <th class="bg-gradient-warning text-light">$PRES. RCH</th>
                              <th class="bg-gradient-warning text-light">% $PRES. RCH</th>
                              <th class="bg-info">#PRES. OTROS</th>
                              <th class="bg-info">% #PRES. OTROS</th>
                              <th class="bg-info">$PRES. OTROS</th>
                              <th class="bg-info">% $PRES. OTROS</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            foreach ($datastat as $rowstat) {
                            ?>

                              <tr>
                                <td><?php echo $rowstat['vendedor'] ?> </td>
                                <td class="bg-primary text-center"><?php echo $rowstat['npres'] ?> </td>
                                <td class="bg-primary text-right"><?php echo "$ " . number_format($rowstat['totalpres'], 2) ?> </td>

                                <td class="bg-success text-center"><?php echo $rowstat['presaceptados'] ?> </td>
                                <td class="bg-success text-center"><?php echo $rowstat['porpresaceptados'] . " %" ?> </td>
                                <td class="bg-success text-right"><?php echo  "$ " . number_format($rowstat['aceptados'], 2) ?> </td>
                                <td class="bg-success text-center"><?php echo $rowstat['portotalaceptados'] . " %" ?> </td>

                                <td class="bg-gradient-warning text-light text-center"><?php echo $rowstat['presrechazados'] ?> </td>
                                <td class="bg-gradient-warning text-light text-center"><?php echo $rowstat['porpresrechazados'] . " %" ?> </td>
                                <td class="bg-gradient-warning text-light text-right"><?php echo "$ " . number_format($rowstat['rechazados'], 2) ?> </td>
                                <td class="bg-gradient-warning text-light text-center"><?php echo $rowstat['portotalrechazados'] . " %" ?> </td>

                                <td class="bg-info text-center"><?php echo $rowstat['presotros'] ?> </td>
                                <td class="bg-info text-center"><?php echo $rowstat['porotros'] . " %" ?> </td>
                                <td class="bg-info text-right "><?php echo "$ " . number_format($rowstat['otros'], 2) ?> </td>
                                <td class="bg-info text-center"><?php echo $rowstat['portotalotros'] . " %" ?> </td>
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
                <!-- /.card-body -->

                <!-- /.card-footer -->
              </div>
            </div>
            <!--FIN GRAFICA COMPARATIVA ML -->

          </div>

        </section>
        <!-- GRAFICAS 2
      <section>
        <div class="row justify-content">


          <div class="col-sm-6">
            <div class="card ">
              <div class="card-header bg-gradient-success color-palette border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Metros Lineales Vendidos Obras
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-gradient-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                </div>
              </div>
              <div class="card-body">
                <div class="row justify-content">
                  <div class="col-sm-7">
                    <canvas class="chart " id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  <div class="col-sm-5 my-auto">
                    <div class="table-responsive">
                      <table class="table table-responsive table-bordered table-hover table-sm">
                        <thead class="text-center">
                          <tr>
                            <th>Vendedor</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $totalml2 = 0;
                          foreach ($dataml2 as $rowml2) {
                            $totalml2 += $rowml2['mlvendido'];
                          ?>
                            <tr>
                              <td><?php echo $rowml2['vendedor'] ?></td>
                              <td class="text-right"><?php echo $rowml2['mlvendido'] ?></td>
                            </tr>
                          <?php } ?>

                        </tbody>
                        <tfoot>
                          <tr>
                            <td>ML VENDIDOS <?php echo $mesactual ?></td>
                            <td class="text-right text-bold"><?php echo $totalml2 ?></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="col-sm-6">
            <div class="card ">
              <div class="card-header bg-gradient-success color-palette border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Monto de Ventas Obras
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-gradient-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                </div>
              </div>
              <div class="card-body">
                <div class="row justify-content">
                  <div class="col-sm-7">
                    <canvas class="chart " id="line-chart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  <div class="col-sm-5 my-auto">
                    <div class="table-responsive">
                      <table class="table table-responsive table-bordered table-hover table-sm">
                        <thead class="text-center">
                          <tr>
                            <th>Vendedor</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $totalvtasml2 = 0;
                          foreach ($datavtav2 as $rowml2) {
                            $totalvtasml2 += $rowml2['total'];
                          ?>
                            <tr>
                              <td><?php echo $rowml2['vendedor'] ?></td>
                              <td class="text-right"><?php echo '$ ' . number_format($rowml2['total'], 2) ?></td>
                            </tr>
                          <?php } ?>

                        </tbody>
                        <tfoot>
                          <tr>
                            <td>VENTAS <?php echo $mesactual ?></td>
                            <td class="text-right text-bold"><?php echo '$ ' . number_format($totalvtasml2, 2) ?></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </section>
-->
      </div>
      <!--  ABRE TABLEROS-->
      <div class="container-fluid">
        <div class="row justify-content-center">
          <!-- Left col -->
          <div class="col-sm-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card ">
              <div class="card-header bg-gradient-orange boder-0">
                <h3 class="card-title">
                  <i class="fas fa-money-check-alt mr-1"></i>
                  Presupuestos Pendientes
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-orange btn-sm daterange text-light" data-toggle="tooltip" title="Date range">
                    <i class="fas fa-money-check-alt"></i>
                  </button>
                  <button type="button" class="btn btn-orange btn-sm text-light" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>

              </div><!-- /.card-header -->

              <div class="card-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-12">

                      <div class="table-responsive" style="padding: 10px;">
                        <table name="tablaV" id="tablaV" class="table table-striped table-sm no-wraped table-bordered table-condensed mx-auto" style="width:100%">
                          <thead class="text-center bg-gradient-orange">
                            <tr>
                              <th>Folio</th>
                              <th>Fecha</th>
                              <th>Cliente</th>
                              <th>Total</th>
                              <th>Estado</th>
                              <th>Acciones</th>


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
                                <td class="text-right"><?php echo "$ " . number_format($dat['gtotal'], 2) ?></td>
                                <td><?php echo $dat['estado_pres'] ?></td>
                                <td></td>
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

            </div><!-- /.card-body -->
          </div>



        </div>
      </div>



      <!-- CIERRA TABLEROS -->

    </section>




    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">


          <!-- LIBERACIONES -->
          <div class="col-sm-12 col-12">


            <div class="card">
              <div class="card-header  bg-gradient-info border-0">
                <h3 class="card-title">
                  <i class="fas fa-calendar mr-1"></i>
                  Liberaciones
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-info btn-sm daterange" id="btncalmedir" data-toggle="tooltip" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button" class="btn btn-info btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>

              </div>
              <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-sm-12 text-center">
                    <h5>LIBERACIONES PROYECTOS ANTERIORES AL <?php echo $fechaInicio ?></h5>
                  </div>
                </div>

                <div class="table-responsive" style="padding: 10px;">
                  <table name="tablalibproyantes" id="tablalibproyantes" class="tablasdetalles table table-striped table-sm table-bordered no-wraped table-condensed mx-auto" style="width:100%">
                    <thead class="text-center bg-gradient-info">
                      <tr>
                        <th>Folio Vta</th>
                        <th>Folio Pres</th>
                        <th>Folio Orden</th>
                        <th>Cliente</th>
                        <th>Concepto</th>
                        <th>Fecha Lib</th>
                        <th>Total</th>
                        <th>Saldo</th>



                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      //CONSULTA LIBERACIONES CON SALDO
                      //ANTERIORES A ESTA SEMANA
                      $cntalib = "SELECT * FROM vliberacion_saldo where fecha_liberacion < '$fechaInicio' and estado_vta='1' and estado_ord='1' and tipo_proy='1' and edo_ord='LIBERADO' and saldo>'0'";
                      $reslib = $conexion->prepare($cntalib);
                      $reslib->execute();
                      $datalibproyantes = $reslib->fetchAll(PDO::FETCH_ASSOC);



                      foreach ($datalibproyantes as $datal) {
                      ?>
                        <tr>
                          <td><?php echo $datal['folio_vta'] ?></td>
                          <td><?php echo $datal['folio_pres'] ?></td>
                          <td><?php echo $datal['folio_ord'] ?></td>
                          <td><?php echo $datal['nombre'] ?></td>
                          <td><?php echo $datal['concepto_vta'] ?></td>
                          <td><?php echo $datal['fecha_liberacion'] ?></td>
                          <td class="text-right"><?php echo '$ ' . number_format($datal['gtotal'], 2) ?></td>
                          <td class="text-right"><?php echo '$ ' . number_format($datal['saldo'], 2) ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align:right">Total:</th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>

                      </tr>
                    </tfoot>
                  </table>
                </div>


                <div class="row justify-content-center">
                  <div class="col-sm-12 text-center">
                    <h5>LIBERACIONES PROYECTOS DE LA SEMANA DEL <?php echo $fechaInicio . ' AL ' . $fechaFin ?></h5>
                  </div>
                </div>

                <div class="table-responsive" style="padding: 10px;">
                  <table name="tablalibproyantes" id="tablalibproyantes" class="tablasdetalles table table-striped table-sm table-bordered no-wraped table-condensed mx-auto" style="width:100%">
                    <thead class="text-center bg-gradient-info">
                      <tr>
                        <th>Folio Vta</th>
                        <th>Folio Pres</th>
                        <th>Folio Orden</th>
                        <th>Cliente</th>
                        <th>Concepto</th>
                        <th>Fecha Lib</th>
                        <th>Total</th>
                        <th>Saldo</th>



                      </tr>
                    </thead>
                    <tbody>

                      <?php




                      $cntalib = "SELECT * FROM vliberacion_saldo where fecha_liberacion > '$fechaInicio' and estado_vta='1' and estado_ord='1' and tipo_proy='1' and edo_ord='LIBERADO' and saldo>'0'";
                      $reslib = $conexion->prepare($cntalib);
                      $reslib->execute();
                      $datalibproyactual = $reslib->fetchAll(PDO::FETCH_ASSOC);



                      foreach ($datalibproyactual as $datal) {
                      ?>
                        <tr>
                          <td><?php echo $datal['folio_vta'] ?></td>
                          <td><?php echo $datal['folio_pres'] ?></td>
                          <td><?php echo $datal['folio_ord'] ?></td>
                          <td><?php echo $datal['nombre'] ?></td>
                          <td><?php echo $datal['concepto_vta'] ?></td>
                          <td><?php echo $datal['fecha_liberacion'] ?></td>
                          <td class="text-right"><?php echo '$ ' . number_format($datal['gtotal'], 2) ?></td>
                          <td class="text-right"><?php echo '$ ' . number_format($datal['saldo'], 2) ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align:right">Total:</th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>

                      </tr>
                    </tfoot>
                  </table>
                </div>

                <div class="row justify-content-center">
                  <div class="col-sm-12 text-center">
                    <h5>LIBERACIONES OBRA ANTES DEL <?php echo $fechaInicio ?></h5>
                  </div>
                </div>

                <div class="table-responsive" style="padding: 10px;">
                  <table name="tablalibproyantes" id="tablalibproyantes" class="tablasdetalles table table-striped table-sm table-bordered no-wraped table-condensed mx-auto" style="width:100%">
                    <thead class="text-center bg-gradient-info">
                      <tr>
                        <th>Folio Vta</th>
                        <th>Folio Pres</th>
                        <th>Folio Orden</th>
                        <th>Cliente</th>
                        <th>Concepto</th>
                        <th>Fecha Lib</th>
                        <th>Total</th>
                        <th>Saldo</th>



                      </tr>
                    </thead>
                    <tbody>

                      <?php






                      $cntalib = "SELECT * FROM vliberacion_saldo where fecha_liberacion < '$fechaInicio' and estado_vta='1' and estado_ord='1' and tipo_proy='2' and edo_ord='LIBERADO' and saldo>'0'";
                      $reslib = $conexion->prepare($cntalib);
                      $reslib->execute();
                      $datalibobraantes = $reslib->fetchAll(PDO::FETCH_ASSOC);



                      foreach ($datalibobraantes as $datal) {
                      ?>
                        <tr>
                          <td><?php echo $datal['folio_vta'] ?></td>
                          <td><?php echo $datal['folio_pres'] ?></td>
                          <td><?php echo $datal['folio_ord'] ?></td>
                          <td><?php echo $datal['nombre'] ?></td>
                          <td><?php echo $datal['concepto_vta'] ?></td>
                          <td><?php echo $datal['fecha_liberacion'] ?></td>
                          <td class="text-right"><?php echo '$ ' . number_format($datal['gtotal'], 2) ?></td>
                          <td class="text-right"><?php echo '$ ' . number_format($datal['saldo'], 2) ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align:right">Total:</th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>

                      </tr>
                    </tfoot>
                  </table>
                </div>

                <div class="row justify-content-center">
                  <div class="col-sm-12 text-center">
                    <h5>LIBERACIONES OBRA DE LA SEMANA DEL <?php echo $fechaInicio . ' AL ' . $fechaFin ?></h5>
                  </div>
                </div>

                <div class="table-responsive" style="padding: 10px;">
                  <table name="tablalibproyantes" id="tablalibproyantes" class="tablasdetalles table table-striped table-sm table-bordered no-wraped table-condensed mx-auto" style="width:100%">
                    <thead class="text-center bg-gradient-info">
                      <tr>
                        <th>Folio Vta</th>
                        <th>Folio Pres</th>
                        <th>Folio Orden</th>
                        <th>Cliente</th>
                        <th>Concepto</th>
                        <th>Fecha Lib</th>
                        <th>Total</th>
                        <th>Saldo</th>



                      </tr>
                    </thead>
                    <tbody>

                      <?php





                      $cntalib = "SELECT * FROM vliberacion_saldo where fecha_liberacion > '$fechaInicio' and estado_vta='1' and estado_ord='1' and tipo_proy='2' and edo_ord='LIBERADO' and saldo>'0'";
                      $reslib = $conexion->prepare($cntalib);
                      $reslib->execute();
                      $datalibobraactual = $reslib->fetchAll(PDO::FETCH_ASSOC);

                      foreach ($datalibobraactual as $datal) {
                      ?>
                        <tr>
                          <td><?php echo $datal['folio_vta'] ?></td>
                          <td><?php echo $datal['folio_pres'] ?></td>
                          <td><?php echo $datal['folio_ord'] ?></td>
                          <td><?php echo $datal['nombre'] ?></td>
                          <td><?php echo $datal['concepto_vta'] ?></td>
                          <td><?php echo $datal['fecha_liberacion'] ?></td>
                          <td class="text-right"><?php echo '$ ' . number_format($datal['gtotal'], 2) ?></td>
                          <td class="text-right"><?php echo '$ ' . number_format($datal['saldo'], 2) ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align:right">Total:</th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>

                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <!-- /.card-body-->

            </div>

            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>


  <?php } ?>


  <section class="content">


    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-sm-12 col-12">
          <div class="card">
            <div class="card-header bg-gradient-purple text-light text-center">
              <div class="text-center">
                <h4 class="card-title ">LLAMADAS DE SEGUMIENTO PROGRAMADAS ESTA SEMANA (<?php echo "DEL " . $isemana . " AL " . $fsemana; ?>)</h4>
              </div>

            </div>
            <div class="card-body">




              <div class="table-responsive" style="padding: 10px;">
                <table name="tablalls" id="tablalls" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px">
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
                    foreach ($datais as $dat2) {
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

      <div class="row justify-content-center">
        <div class="col-sm-12 col-12">
          <div class="card">
            <div class="card-header bg-lightblue text-light text-center">
              <div class="text-center">
                <h4 class="card-title ">LLAMADAS PROGRAMADAS PARA FECHAS POSTERIORES AL <?php echo  $finsemana; ?></h4>
              </div>

            </div>
            <div class="card-body">



              <br>
              <div class="container-fluid">

                <div class="table-responsive">
                  <table name="tablallps" id="tablallps" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px">
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
                      foreach ($datafs as $dat3) {
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
      </div>
    </div>
  </section>


  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <!-- CITAS DE INSTALACION-->
        <div class="col-sm-12 col-12">

          <!-- Map card -->
          <div class="card">
            <div class="card-header  bg-gradient-success border-0">
              <h3 class="card-title">
                <i class="fas fa-calendar mr-1"></i>
                Citas de instalaciones de <?php echo $mesactual ?>
              </h3>
              <!-- card tools -->
              <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm daterange" id='btinstalacion' data-toggle="tooltip" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <div class="card-body">
              <div class="table-responsive" style="padding: 10px;">
                <table name="tablaIN" id="tablaIN" class="table table-striped table-sm table-bordered no-wraped table-condensed mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-success">
                    <tr>
                      <th>Folio</th>
                      <th>Fecha y Hora</th>
                      <th>Cliente</th>
                      <th>Cel</th>
                      <th>Ubicacion Proyecto</th>
                      <th>Concepto</th>


                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($datac as $datc) {
                    ?>
                      <tr>
                        <td><?php echo $datc['folio_citav'] ?></td>
                        <td><?php echo $datc['fecha'] ?></td>
                        <td><?php echo $datc['nombre'] ?></td>
                        <td><?php echo $datc['cel'] ?></td>
                        <td><?php echo $datc['ubicacion'] ?></td>
                        <td><?php echo $datc['concepto'] ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body-->

          </div>

          <!-- /.card -->
        </div>

        <!-- CALENDARIO DE TOMA DE PLANTILLAS-->
        <div class="col-sm-12 col-12">


          <div class="card">
            <div class="card-header  bg-gradient-primary border-0">
              <h3 class="card-title">
                <i class="fas fa-calendar mr-1"></i>
                Citas para toma de Plantillas Pendientes de <?php echo $mesactual ?>
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" id="btncalmedir" data-toggle="tooltip" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>

            </div>
            <div class="card-body">
              <div class="table-responsive" style="padding: 10px;">
                <table name="tablaC" id="tablaC" class="table table-striped table-sm table-bordered no-wraped table-condensed mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-primary">
                    <tr>
                      <th>Id</th>
                      <th>Orden</th>
                      <th>Fecha y Hora</th>
                      <th>Cliente</th>
                      <th>Concepto</th>
                      <th>Ubicación</th>
                      <th>Responsable</th>



                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($datacitam as $datcitam) {
                    ?>
                      <tr>
                        <td><?php echo $datcitam['id'] ?></td>
                        <td><?php echo $datcitam['folio_ord'] ?></td>
                        <td><?php echo $datcitam['start'] ?></td>
                        <td><?php echo $datcitam['title'] ?></td>
                        <td><?php echo $datcitam['descripcion'] ?></td>
                        <td><?php echo $datcitam['obs'] ?></td>
                        <td><?php echo $datcitam['responsable'] ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body-->

          </div>

          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>

  <!-- CIERRA EL CONTENIDO DE HOME -->

</div>


<?php
include_once 'templates/footer.php';
?>
<script src="fjs/cards.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
  $(function() {



    /*GRAFICA 1*/
    var barChartCanvas = $('#line-chart').get(0).getContext('2d')
    var barChartData = {
      labels: [<?php foreach ($dataml as $d) : ?> "<?php echo $d['vendedor'] ?>",
        <?php endforeach; ?>
      ],
      datasets: [{
        label: 'ML VENDIDOS <?php echo $mesactual ?>',



        data: [
          <?php foreach ($dataml as $d) : ?>
            <?php echo $d['mlvendido']; ?>,
          <?php endforeach; ?>
        ],
        backgroundColor: [

          'rgba(247, 103, 21, 0.5)',
          'rgba(199, 21, 247, 0.5)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [

          'rgb(247, 103, 21)',
          'rgb(199, 21, 247)',
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ],
        borderWidth: 1
      }]
    }


    var barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false,
      scales: {
        yAxes: [{
            ticks: {
              beginAtZero: true

            }
          }

        ]

      }
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
    /*TERMINA GRAFICA 1*/
    /*GRAFICA 2*/
    var barventas = $('#line-chart2').get(0).getContext('2d')
    var barventasdata = {
      labels: [<?php foreach ($datavtav as $d) : ?> "<?php echo $d['vendedor'] ?>",
        <?php endforeach; ?>
      ],
      datasets: [{
        label: 'VENTAS <?php echo $mesactual ?>',
        borderWidth: 2,
        lineTension: 2,

        data: [
          <?php foreach ($datavtav as $d) : ?>
            <?php echo $d['total']; ?>,
          <?php endforeach; ?>
        ],
        backgroundColor: [

          'rgba(247, 103, 21, 0.5)',
          'rgba(199, 21, 247, 0.5)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [

          'rgb(247, 103, 21)',
          'rgb(199, 21, 247)',
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ],
        borderWidth: 1
      }]
    }





    var barChart2 = new Chart(barventas, {
      type: 'bar',
      data: barventasdata,
      options: barChartOptions
    })
    /*GRAFICA 2*/

    /*GRAFICA METROS*/
    var barmetros = $('#metros-chart').get(0).getContext('2d')
    var barmetrosdata = {
      labels: ["ANALISIS DE VENTAS - PRODUCCION EN ML", ],
      datasets: [{
        label: 'ML VENDIDOS <?php echo $mesactual ?>',
        fill: true,
        borderWidth: 1,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#000000',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#A248FA',
        pointBackgroundColor: '#A248FA',

        data: [
          <?php //foreach ($datametros as $d) : 
          ?>
          <?php echo $mvendidosn; ?>
          <?php //echo $d['mlvendidos']; 
          ?>
          <?php //endforeach; 
          ?>
        ],
        backgroundColor: [

          'rgb(35, 148, 71)',
          'rgb(99, 121, 247)',
          'rgb(154, 16, 235)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [

          'rgb(35, 148, 71)',
          'rgb(99, 121, 247)',
          'rgb(154, 16, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ],
        borderWidth: 1
      }, {
        label: 'ML EJECUTADOS DE <?php echo $mesactual ?>',
        fill: true,
        borderWidth: 1,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#000000',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#A248FA',
        pointBackgroundColor: '#A248FA',

        data: [
          <?php //foreach ($datametros as $d) : 
          ?>
          <?php //echo $d['mlvendidoseje']; 
          ?>
          <?php echo $mejecutadosmesn; ?>
          <?php // endforeach; 
          ?>
        ],
        backgroundColor: [

          'rgb(34, 70, 165)',
          'rgb(99, 121, 247)',
          'rgb(154, 16, 235)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [

          'rgb(34, 70, 165)',
          'rgb(99, 121, 247)',
          'rgb(154, 16, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ],
        borderWidth: 1
      }, {
        label: 'ML EJECUTADOS TOTALES EN <?php echo $mesactual ?>',
        fill: true,
        borderWidth: 1,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#000000',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#A248FA',
        pointBackgroundColor: '#A248FA',

        data: [
          <?php //foreach ($datametros as $d) : 
          ?>
          <?php //echo $d['mldelmes']; 
          ?>
          <?php echo $mejecutadosn ?>
          <?php //endforeach; 
          ?>
        ],
        backgroundColor: [

          'rgb(243, 93, 41)',
          'rgb(99, 121, 247)',
          'rgb(154, 16, 235)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [

          'rgb(243, 93,41)',
          'rgb(99, 121, 247)',
          'rgb(154, 16, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ],
        borderWidth: 1
      }]
    }

    var metrosGraphChartOptions = {
      animationEnabled: true,
      theme: "light2",
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: true,
        position: 'bottom',
        labels: {
          fontColor: '#000000'
        }
      },
      scales: {
        xAxes: [{
          ticks: {
            fontColor: '#000000',
          },
          gridLines: {
            display: false,
            color: '#A248FA',
            drawBorder: true,
          }
        }],
        yAxes: [{
          ticks: {

            beginAtZero: true
          },
          gridLines: {
            display: true,
            color: '#A248FA',
            drawBorder: true,
            zeroLineColor: '#000000'
          }
        }]
      }
    }



    var barmetros = new Chart(barmetros, {
      type: 'bar',
      data: barmetrosdata,
      options: metrosGraphChartOptions
    })
    /*GRAFICA 2*/

    /*INGRESO VS EGRESOS */


    var salesGraphChartCanvas = $('#resultados-chart').get(0).getContext('2d')
    //$('#revenue-chart').get(0).getContext('2d');



    var salesGraphChartData = {
      labels: [<?php foreach ($datacon as $d) : ?> "<?php echo $d['nom_mes'] ?>",
        <?php endforeach; ?>
      ],
      datasets: [{
        label: 'Ingresos',
        fill: true,
        borderWidth: 1,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#000000',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#A248FA',
        pointBackgroundColor: '#A248FA',
        data: [
          <?php foreach ($datacon as $d) : ?>
            <?php echo $d['ingreso']; ?>,
          <?php endforeach; ?>
        ],
        backgroundColor: [

          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)'
        ],
        borderColor: [

          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)',
          'rgba(8, 148, 52)'
        ],
        borderWidth: 1

      }, {
        label: 'Egresos',
        fill: true,
        borderWidth: 1,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#000000',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#A248FA',
        pointBackgroundColor: '#A248FA',
        data: [
          <?php foreach ($datacon as $d) : ?>
            <?php echo $d['egreso']; ?>,
          <?php endforeach; ?>
        ],
        backgroundColor: [

          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)'
        ],
        borderColor: [

          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)',
          'rgba(153, 102, 255)'
        ],
        borderWidth: 1

      }]
    }

    var salesGraphChartOptions = {
      animationEnabled: true,
      theme: "light2",
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: true,
        position: 'bottom',
        labels: {
          fontColor: '#000000'
        }
      },
      scales: {
        xAxes: [{
          ticks: {
            fontColor: '#000000',
          },
          gridLines: {
            display: false,
            color: '#A248FA',
            drawBorder: true,
          }
        }],
        yAxes: [{
          ticks: {

            beginAtZero: true
          },
          gridLines: {
            display: true,
            color: '#A248FA',
            drawBorder: true,
            zeroLineColor: '#000000'
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var salesGraphChart = new Chart(salesGraphChartCanvas, {

      type: 'bar',
      data: salesGraphChartData,
      options: salesGraphChartOptions
    })

  });
</script>