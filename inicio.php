<?php
$pagina = 'home';
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";



include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
date_default_timezone_set('America/Mexico_City');

$mesarreglo = array(
  "", "ENERO",
  "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"
);
$mesactual = $mesarreglo[date('n')];

$m = date("m");
$y = date("Y");

if (date("D") == "Mon") {
  $iniciosemana = date("Y-m-d");
} else {
  $iniciosemana = date("Y-m-d", strtotime('last Monday', time()));
}

$finsemana = date("Y-m-d", strtotime('next Sunday', time()));



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


$totaling = 0;
foreach ($dataing as $reging) {
  $totaling += $reging['monto'];
}



?>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="container-fluid card">
    <div class="card-header bg-gradient-orange">
      <h1>ERP GALLERY STONE</h1>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!--CARDS ENCABEZADO -->


      <div class="row">
        <div class="col-lg-3 col-6">

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

        <div class="col-lg-3 col-6">

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

        <div class="col-lg-3 col-6">

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

        <div class="col-lg-3 col-6">

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
        <div class="row justify-content">

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

      <!--  TABLEROS-->
      <div class="row justify-content-center">
        <!-- Left col -->
        <div class="col-lg-8">
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


        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <div class="col-lg-8 col-8">

          <!-- Map card -->
          <div class="card">
            <div class="card-header  bg-gradient-success border-0">
              <h3 class="card-title">
                <i class="fas fa-calendar mr-1"></i>
                Citas de instalaciones del <?php echo $iniciosemana . " al " . $finsemana ?>
              </h3>
              <!-- card tools -->
              <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm daterange" data-toggle="tooltip" title="Date range">
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
                <table name="tablaC" id="tablaC" class="table table-striped table-sm table-bordered no-wraped table-condensed mx-auto" style="width:100%">
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
        <!-- right col -->
      </div>


  </section>
  <!-- /.content -->
</div>


<?php
include_once 'templates/footer.php';
?>
<script src="fjs/cards.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
  $(function() {




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





  });
</script>