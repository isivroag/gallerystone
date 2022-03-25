<?php
$pagina = "supendidos";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
if ($_SESSION['s_rol'] == '3' or $_SESSION['s_rol'] == '2' ) {
  $consulta = "SELECT * FROM vpres where edo_pres='1' and  estado_pres='SUSPENDIDO' order by folio_pres";
} else {
  $consulta = "SELECT * FROM vpres where edo_pres='1' and estado_pres='RECHAZADO'  AND estado_pres='SUSPENDIDO' order by folio_pres";
}

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
.swal-wide{
    width:850px !important;
}

td.details-control {
    background: url('img/details_open.png') no-repeat center center ;

    cursor: pointer;
}
tr.details td.details-control {
    background: url('img/details_close.png') no-repeat center center;

    
}
.borderless td,
    .borderless th {
        border: none;
    }
    .bg1{
      background-color: rgba(25,151,6,.6)!important;
      color: white;
    }
    .bg2{
      background-color: rgba(52,78,253,.85)!important;
      color: white;
    }
    .bg3{
      background-color: rgba(79,3,210,.6)!important;
      color: white;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card ">
      <div class="card-header bg-gradient-orange text-light">
        <h4 class="card-title text-center">Presupuestos</h4>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">

            <button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
          </div>
        </div>
        <br>
        <div class="container-fluid">
       
          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table name="tablaV" id="tablaV" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto " style="font-size:15px;">
                  <thead class="text-center bg-gradient-orange">
                    <tr>
                    <th></th>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                      <th>Ubicación</th>
                      <th>Vendedor</th>
                      <th>Realizado</th>
                      <th>Total</th>
                      <th>Estado</th>
                      <th>Tipo</th>
                      
                      <th>Acciones</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr class="">
                        <td></td>
                        <td><?php echo $dat['folio_pres'] ?></td>
                        <td><?php echo $dat['fecha_pres'] ?></td>
                        <td><?php echo $dat['nombre'] ?></td>
                        <td><?php echo $dat['concepto_pres'] ?></td>
                        <td><?php echo $dat['ubicacion'] ?></td>
                        <td><?php echo $dat['vendedor'] ?></td>
                        <td><?php echo $dat['usuario'] ?></td>
                        <td class="text-right"><?php echo "$ " . number_format($dat['gtotal'], 2) ?></td>
                        <td><?php echo $dat['estado_pres']?>
                        <td><?php echo $dat['tipop']?>
                        
                
                            </td>


                       
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

      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>




  <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/rptsuspendidos.js?v=<?php echo (rand()); ?>"></script>
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