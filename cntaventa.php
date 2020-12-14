<?php
$pagina="venta";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vventa order by folio_vta";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$message="";



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
      <div class="card-header bg-green">
        <h4 class="card-title text-center">VENTAS</h4>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">
            
            <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
          </div>
        </div>
        <br>
        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-success">
                    <tr>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                      <th>Total</th>
                      <th>Saldo</th>
                      
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['folio_vta'] ?></td>
                        <td><?php echo $dat['fecha_vta'] ?></td>
                        <td><?php echo $dat['nombre'] ?></td>
                        <td><?php echo $dat['concepto_vta'] ?></td>
                        
                        <td class="text-right"><?php echo "$ ".number_format( $dat['gtotal'],2) ?></td>
                        <td class="text-right"><?php echo "$ ".number_format( $dat['saldo'],2) ?></td>
                        
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
      <!-- /.card-body -->

    </div>
    <!-- /.card -->

  </section>

 
  <!-- /.content -->
</div>
<!-- Resumen de Pagos -->
<section>
  <div class="container">

    <!-- Default box -->
    <div class="modal fade" id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-md" role="document">
        <div class="modal-content w-auto">
          <div class="modal-header bg-gradient-primary">
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


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaventa.js"></script>
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