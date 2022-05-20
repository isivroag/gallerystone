<?php
$pagina = "cntaliberaciones";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fechahome = (isset($_GET['fecha'])) ? strtotime($_GET['fecha']) : strtotime(date("Y-m-d"));
$meshome = date("m", $fechahome);
$yearhome = date("Y", $fechahome);



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



$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


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
                  <table name="tablalibproyantes" id="tablalibproyantes" class="tablasdetalles table table-striped table-sm table-bordered no-wraped table-condensed w-auto mx-auto" style="width:90%">
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




    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaliberaciones.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>