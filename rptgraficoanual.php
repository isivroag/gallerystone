<?php
$pagina = 'home';
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";
$fechahome=(isset($_GET['fecha'])) ? strtotime($_GET['fecha']) : strtotime(date("Y-m-d"));
$meshome = date("m",$fechahome);
$yearhome = date("Y",$fechahome);

include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
date_default_timezone_set('America/Mexico_City');

$mesarreglo = array(
  "", "ENERO",
  "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"
);
//$mesactual = $mesarreglo[date('n')];
$mesactual = $mesarreglo[date('m',$meshome)];
$m = $meshome;
$y = $yearhome ;

if (date("D") == "Mon") {
  $iniciosemana = date("Y-m-d",$fechahome);
} else {
  $iniciosemana = date( date("Y-m-d",$fechahome), strtotime('last Monday', time()));
}

$finsemana = date( date("Y-m-d",$fechahome), strtotime('next Sunday', time()));


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




$consulta = "SELECT * FROM vpres WHERE estado_pres<>'ACEPTADO' AND estado_pres <>'RECHAZADO' AND edo_pres=1 order by fecha_pres";
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




$consultac = "SELECT * FROM viewcitav WHERE (DATE(fecha)between '$iniciosemana' and '$finsemana') and estado_citav='1' order by fecha";

$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);


$consultaing = "SELECT SUM(monto) AS monto FROM vpagocxc WHERE month(fecha)='$m' AND YEAR(fecha)='$y' AND estado_pagocxc=1";
$resultadoing = $conexion->prepare($consultaing);
$resultadoing->execute();
$dataing = $resultadoing->fetchAll(PDO::FETCH_ASSOC);




$consultametros = "CALL sp_graficametros('$y','$m')";
$resultadometros = $conexion->prepare($consultametros);
$resultadometros->execute();
$datametros = $resultadometros->fetchAll(PDO::FETCH_ASSOC);


$totaling = 0;
foreach ($dataing as $reging) {
  $totaling += $reging['monto'];
}



?>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- ABRE HEADER -->
  <section class="container-fluid card">
    <div class="card-header bg-gradient-orange">
      <h1>GRAFICO ANUAL</h1>
    </div>
  </section>
  <!-- CIERRA HEADER -->
  <!-- ABRE EL CONTENIDO DE HOME -->
  <?php if ($_SESSION['s_rol'] != '4' && $_SESSION['s_rol'] != '5') { ?>

    <section class="content">
      <div class="container-fluid">

        <!--CARDS ENCABEZADO -->
        <div class="row justify-content-center">
              <div class="col-lg-2">
                <div class="form-group input-group-sm">
                  <label for="fechahome" class="col-form-label">Fecha de Consulta:</label>
                  <input type="date" class="form-control" name="fechahome" id="fechahome" value="<?php echo  date('Y-m-d', $fechahome) ?>">
                </div>
              </div>

              

              <div class="col-lg-1 align-self-end text-center">
                <div class="form-group input-group-sm">
                  <button id="btnHome" name="btnHome" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                </div>
              </div>
            </div>


     
        <!-- Graficas-->
        <section>
          <div class="row justify-content-center">

        
       
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
                    <div class="row justify-content-center mt-5 pt-3">
                    <div class="col-sm-12 my-auto">
                      <div class="table-responsive">
                        <table id="tabla" name="tabla" class="table table-responsive table-bordered table-hover table-sm table-responsive-sm" style="font-size: 14px;">
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
                              $ting=0;
                              foreach ($datacon as $dcon) {
                                  $ting+=$dcon['ingreso'];
                                echo '<td class="text-right">$ ' . number_format($dcon['ingreso'], 2) . '</td>';
                              } ?>
                                <td class="text-right">$<?php echo  number_format($ting) ?></td>
                            </tr>
                            <tr>
                              <td>Egresos</td>
                              <?php 
                               $teg=0;
                              foreach ($datacon as $dcon) {
                                $teg+=$dcon['egreso'];
                                echo '<td class="text-right">$ ' . number_format($dcon['egreso'], 2) . '</td>';
                              } ?>
                              <td class="text-right">$<?php echo  number_format($teg, 2) ?></td>
                            </tr>
                            <tr>
                              <td><b>Resultado</b></td>
                              <?php 
                              $tot=0;
                              foreach ($datacon as $dcon) {
                                  $tot+=$dcon['resultado'];
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
            <?php }?>
 
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
   



      <!-- CIERRA TABLEROS -->

    </section>
  <?php } ?>
  <!-- CIERRA EL CONTENIDO DE HOME -->

</div>


<?php
include_once 'templates/footer.php';
?>
<script src="fjs/rptgraficoanual.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>

<script>
  $(function() {





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