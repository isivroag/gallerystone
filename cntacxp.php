<?php
$pagina = "cxp";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vcxp order by folio_cxp";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consultag = "SET lc_time_names = 'es_ES'";
$resultadog = $conexion->prepare($consultag);
$resultadog->execute();

$consultag = "SELECT SUM(total) AS total,monthname(fecha) as mes FROM vcxp GROUP BY MONTH(fecha) order by MONTH(fecha)";
$resultadog = $conexion->prepare($consultag);
$resultadog->execute();
$datag = $resultadog->fetchAll(PDO::FETCH_ASSOC);


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
    <div class="card ">
      <div class="card-header bg-gradient-purple text-light">
        <h4 class="card-title text-center">Cuentas por Pagar</h4>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">

            <button id="btnNuevo" type="button" class="btn bg-gradient-purple btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
          </div>
        </div>
        <br>
        <div class="container-fluid">
          <div class="card">
            <div class="card-header bg-gradient-purple">
              Filtro por rango de Fecha
            </div>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-lg-2">
                  <div class="form-group input-group-sm">
                    <label for="fecha" class="col-form-label">Desde:</label>
                    <input type="date" class="form-control" name="inicio" id="inicio">
                  </div>
                </div>

                <div class="col-lg-2">
                  <div class="form-group input-group-sm">
                    <label for="fecha" class="col-form-label">Hasta:</label>
                    <input type="date" class="form-control" name="final" id="final">
                  </div>
                </div>

                <div class="col-lg-1 align-self-end text-center">
                  <div class="form-group input-group-sm">
                    <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-purple">
                    <tr>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Proveedor</th>
                      <th>Concepto</th>
                      <th>Total</th>
                      <th>Saldo</th>
                      <th>Fecha Limite</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['folio_cxp'] ?></td>
                        <td><?php echo $dat['fecha'] ?></td>
                        <td><?php echo $dat['nombre'] ?></td>
                        <td><?php echo $dat['concepto'] ?></td>
                        <td class="text-right"><?php echo  number_format($dat['total'], 2) ?></td>
                        <td class="text-right"><?php echo  number_format($dat['saldo'], 2) ?></td>
                        <td><?php echo $dat['fecha_limite'] ?></td>
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
        <br>

        <div class="card ">
          <div class="card-header bg-lightblue color-palette border-0">
            <h3 class="card-title">
              <i class="fas fa-th mr-1"></i>
              Egresos
            </h3>

            <div class="card-tools">
              <button type="button" class="btn bg-lightblue btn-sm" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn bg-lightblue btn-sm" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-sm-7">
                <canvas class="chart bg-lightblue" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

              </div>
            </div>
          </div>
          <!-- /.card-body -->

          <!-- /.card-footer -->
        </div>

      </div>


      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>


  <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntacxp.js"></script>
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
<script src="plugins/chart.js/Chart.min.js"></script>
<script>
  $(function() {


    var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');
    //$('#revenue-chart').get(0).getContext('2d');



    var salesGraphChartData = {
      labels: [<?php foreach ($datag as $d) : ?> "<?php echo $d['mes'] ?>",
        <?php endforeach; ?>
      ],
      datasets: [{
        label: 'Egresos Totales Por Mes',
        fill: true,
        borderWidth: 2,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#efefef',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#efefef',
        pointBackgroundColor: '#efefef',
        data: [
          <?php foreach ($datag as $d) : ?>
            <?php echo $d['total']; ?>,
          <?php endforeach; ?>
        ]
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
          fontColor: '#efefef'
        }
      },
      scales: {
        xAxes: [{
          ticks: {
            fontColor: '#efefef',
          },
          gridLines: {
            display: false,
            color: '#efefef',
            drawBorder: true,
          }
        }],
        yAxes: [{
          ticks: {
            stepSize: 2500,
            fontColor: '#efefef',
            beginAtZero: true
          },
          gridLines: {
            display: true,
            color: '#efefef',
            drawBorder: true,
            zeroLineColor: '#efefef'
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var salesGraphChart = new Chart(salesGraphChartCanvas, {

      type: 'line',
      data: salesGraphChartData,
      options: salesGraphChartOptions
    })

  });
</script>