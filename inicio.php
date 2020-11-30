<?php
$pagina = 'home';
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";



include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vpres order by folio_pres";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


$consultac = "SELECT * FROM viewcitap WHERE DATE(fecha)='". date('Y-m-d')."' and estado_citap='1' order by fecha";

$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);
?>

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
      <div class="row">
        <!-- Left col -->
        <div class="col-lg-6 col-6">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card ">
            <div class="card-header bg-gradient-info boder-0">
              <h3 class="card-title">
                <i class="fas fa-money-check-alt mr-1"></i>
                Presupuestos Recientes
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-info btn-sm daterange" data-toggle="tooltip" title="Date range">
                  <i class="fas fa-money-check-alt"></i>
                </button>
                <button type="button" class="btn btn-info btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>

            </div><!-- /.card-header -->
            <div class="card-body">

              <div class="table-responsive" style="padding: 10px;">
                <table name="tablaV" id="tablaV" class="table table-striped table-sm no-wraped table-bordered table-condensed mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-info">
                    <tr>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Total</th>
                      
                    
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
                        <td class="text-right"><?php echo "$ ".number_format( $dat['gtotal'],2) ?></td>
                        
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>

            </div>

          </div><!-- /.card-body -->
        </div>


        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <div class="col-lg-6 col-6">

          <!-- Map card -->
          <div class="card">
            <div class="card-header  bg-gradient-primary border-0">
              <h3 class="card-title">
                <i class="fas fa-calendar mr-1"></i>
                Citas Presupuesto
              </h3>
              <!-- card tools -->
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <div class="card-body">
            <div class="table-responsive" style="padding: 10px;">
                <table name="tablaC" id="tablaC" class="table table-striped table-sm table-bordered no-wraped table-condensed mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-primary">
                    <tr>
                      <th>Folio</th>
                      <th>Fecha y Hora</th>
                      <th>Cliente</th>
                      <th>Concepto</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($datac as $datc) {
                    ?>
                      <tr>
                        <td><?php echo $datc['folio_citap'] ?></td>
                        <td><?php echo $datc['fecha'] ?></td>
                        <td><?php echo $datc['nombre'] ?></td>
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