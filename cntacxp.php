<?php
$pagina = "cxp";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vcxp where estado_cxp='1' order by folio_cxp";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consultag = "SET lc_time_names = 'es_ES'";
$resultadog = $conexion->prepare($consultag);
$resultadog->execute();
$ejercicio=date('Y');

//$consultag = "SELECT SUM(total) AS total,monthname(fecha) as mes FROM vcxp where estado_cxp='1' GROUP BY MONTH(fecha) order by MONTH(fecha)";
$consultag = "SELECT SUM(total) AS total,monthname(fecha) as mes FROM vcxp where estado_cxp='1' and year(fecha)='$ejercicio 'GROUP BY year(fecha),MONTH(fecha) order by MONTH(fecha)";
$resultadog = $conexion->prepare($consultag);
$resultadog->execute();
$datag = $resultadog->fetchAll(PDO::FETCH_ASSOC);

$consultab = "SELECT * FROM banco order by id_banco";
$resultadob = $conexion->prepare($consultab);
$resultadob->execute();
$datab = $resultadob->fetchAll(PDO::FETCH_ASSOC);


$message = "";



?>

<style>
  .swal2-icon.swal2-question {
    border-color: #EF5350 !important;
    color: #EF5350 !important;
  }
</style>


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

            <button id="btnNuevo" type="button" class="btn bg-gradient-purple btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> General</span></button>
            <button id="btnNuevoM" type="button" class="btn btn-ms" data-toggle="modal" style="background-color: #F49FF1;"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Material</span></button>
            <button id="btnNuevoI" type="button" class="btn bg-gradient-success btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Insumo</span></button>
            <button id="btnNuevoD" type="button" class="btn bg-gradient-info btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Insumo Desgaste</span></button>
            <button id="btnNuevoH" type="button" class="btn bg-gradient-purple btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Herramienta</span></button>
            <button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button>
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
                      <th>Tipo</th>
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
                        <td class="currency text-right"><?php echo  $dat['total'] ?></td>
                        <td class="currency text-right"><?php echo  $dat['saldo'] ?></td>
                        <td><?php echo $dat['fecha_limite'] ?></td>
                        <td><?php echo $dat['tipo'] ?></td>
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
          <div class="card-header bg-gradient-purple color-palette border-0">
            <h3 class="card-title">
              <i class="fas fa-th mr-1"></i>
              Egresos
            </h3>

            <div class="card-tools">
              <button type="button" class="btn bg-gradient-purple btn-sm" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn bg-gradient-purple btn-sm" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-sm-7">
                <canvas class="chart " id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

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

  <section>
    <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-purple">
            <h5 class="modal-title" id="exampleModalLabel">Pago a Proveedores</h5>

          </div>
          <form id="formPago" action="" method="POST">
            <div class="modal-body">
              <div class="row justify-content-sm-between my-auto">

                <div class="col-sm-6 my-auto">
                  <div class="form-group input-group-sm">

                    <label for="banco" class="col-form-label">Banco Origen:</label>

                    <select class="form-control" name="banco" id="banco">
                      <?php
                      foreach ($datab as $regb) {
                      ?>
                        <option id="<?php echo $regb['id_banco'] ?>" value="<?php echo $regb['id_banco'] ?>"><?php echo $regb['nom_banco'] ?></option>
                      <?php
                      }
                      ?>

                    </select>
                  </div>
                </div>


                <div class="col-sm-3 my-auto">
                  <div class="form-group input-group-sm">
                    <label for="foliovp" class="col-form-label">Folio CXP:</label>
                    <input type="text" class="form-control" name="foliovp" id="foliovp" value="" disabled>
                  </div>
                </div>

                <div class="col-sm-3 my-auto">
                  <div class="form-group input-group-sm">
                    <label for="fechavp" class="col-form-label ">Fecha de Pago:</label>
                    <input type="date" id="fechavp" name="fechavp" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="Fecha">
                  </div>
                </div>

              </div>


              <div class="row justify-content-sm-center">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                  <input type="input" id="concepto" name="concepto" class="form-control" autocomplete="off" value=""  disabled>
                    <label for="obsvp" class="col-form-label">Observaciones:</label>
                    <textarea class="form-control" name="obsvp" id="obsvp" rows="3" autocomplete="off" placeholder="Observaciones"></textarea>
                  </div>
                </div>
              </div>

              <div class="row justify-content-sm-center">

                <div class="col-lg-4 ">
                  <label for="saldovp" class="col-form-label ">Saldo:</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control text-right" name="saldovp" id="saldovp" value="" disabled>
                  </div>
                </div>

                <div class="col-lg-4">
                  <label for="montopago" class="col-form-label">Pago:</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                      </span>

                    </div>
                    <input type="text" id="montopago" name="montopago" class="form-control text-right" autocomplete="off" placeholder="Monto del Pago">
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="input-group-sm">
                    <label for="metodo" class="col-form-label">Metodo de Pago:</label>

                    <select class="form-control" name="metodo" id="metodo">
                      <option id="Efectivo" value="Efectivo">Efectivo</option>
                      <option id="Transferencia" value="Transferencia">Transferencia</option>
                      <option id="Deposito" value="Deposito">Deposito</option>
                      <option id="Cheque" value="Cheque">Cheque</option>
                      <option id="Tarjeta de Crédito" value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                      <option id="Tarjeta de Debito" value="Tarjeta de Débito">Tarjeta de Debito</option>

                    </select>
                  </div>
                </div>

              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" id="btnGuardarvp" name="btnGuardarvp" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">


      <!-- Default box -->
      <div class="modal fade" id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-purple">
              <h5 class="modal-title" id="exampleModalLabel">Resumen de Pagos</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Metodo</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
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



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntacxp.js?v=<?php echo (rand()); ?>"></script>
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
        borderWidth: 1,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#000000',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#A248FA',
        pointBackgroundColor: '#A248FA',
        data: [
          <?php foreach ($datag as $d) : ?>
            <?php echo $d['total']; ?>,
          <?php endforeach; ?>
        ],  backgroundColor: [

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
            stepSize: 2000,
            fontColor: '#000000',
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