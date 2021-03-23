<?php
$pagina = 'home';
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";



include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


if (date("D")=="Mon"){
  $iniciosemana = date("Y-m-d");
} else {
  $iniciosemana = date("Y-m-d", strtotime('last Monday', time()));
}

$finsemana = date("Y-m-d",strtotime('next Sunday', time()));



$consulta = "SELECT * FROM vpres WHERE estado_pres<>'ACEPTADO' AND estado_pres <>'RECHAZADO' order by fecha_pres";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


$consultac = "SELECT * FROM viewcitav WHERE (DATE(fecha)between'$iniciosemana' and '$finsemana') and estado_citav='1' order by fecha";

$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ERP GALLERY STONE</h1>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!--CARDS ENCABEZADO -->

      <!--
      <div class="row">
        <div class="col-lg-3 col-6">
         
          <div class="small-box bg-info">
            <div class="inner">
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
        <div class="col-lg-3 col-6">
         
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
        <div class="col-lg-3 col-6">
       
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
        <div class="col-lg-3 col-6">
     
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
      </div>
-->
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
                              <td><?php echo $dat['estado_pres']?></td>
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
                Citas de instalaciones del <?php echo $iniciosemana." al ".$finsemana?>
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
      <!-- Default box -->

      <!-- /.card -->

  </section>
  <!-- /.content -->
</div>


<?php
include_once 'templates/footer.php';
?>
<script src="fjs/cards.js"></script>