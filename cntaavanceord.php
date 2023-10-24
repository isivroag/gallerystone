<?php
$pagina = "rptordenm2";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$inicio = (isset($_GET['inicio'])) ? $_GET['inicio'] : '';
$fin = (isset($_GET['fin'])) ? $_GET['fin'] : '';

//if ($_SESSION['s_rol'] == '3' or $_SESSION['s_rol'] == '1' OR $_SESSION['s_rol'] == '2' ) {
  $consulta = "SELECT ordenestado.id_orden,vorden.folio_vta,vorden.nombre,vorden.concepto_vta,vorden.edo_ord,vorden.avance,vorden.estado_ord,
  max(ordenestado.fecha_ini) as fecha_ini,ordenestado.descripcion,ordenestado.usuario 
  FROM ordenestado JOIN vorden ON ordenestado.id_orden=vorden.folio_ord where ordenestado.fecha_ini between '$inicio' and '$fin' and ordenestado.estado_reg='1' and vorden.estado_ord='1'
  group by ordenestado.id_orden order by vorden.avance,vorden.edo_ord,vorden.folio_vta ";
//} else {
//  $consulta = "SELECT * FROM vpres where edo_pres='1' and estado_pres<>'RECHAZADO' and estado_pres<>'ACEPTADO' AND estado_pres<>'SUSPENDIDO' and tipo_proy=1 order by folio_pres";
//}

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
        <h4 class="card-title text-center">Ordenes</h4>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">

            <button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
          </div>
        </div>
        <br>
        <div class="container-fluid">
        <div class="card">
          <div class="card-header bg-gradient-orange">
            Filtro por rango de Fecha
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-lg-2">
                <div class="form-group input-group-sm">
                  <label for="fecha" class="col-form-label">Desde:</label>
                  <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $inicio ?>">
                </div>
              </div>

              <div class="col-lg-2">
                <div class="form-group input-group-sm">
                  <label for="fecha" class="col-form-label">Hasta:</label>
                  <input type="date" class="form-control" name="final" id="final" value="<?php echo $fin ?>">
                 
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
                <table name="tablaV" id="tablaV" class="table table-hover table-sm table-striped table-bordered table-condensed  w-auto mx-auto " style="font-size:15px;">
                  <thead class="text-center bg-gradient-orange">
                    <tr>
                      <th></th>
                      <th>ORDEN</th>
                      <th>VENTA</th>
                      <th>CLIENTE</th>
                      <th>PROYECTO</th>
                      <th>ESTADO ACTUAL</th>
                      <th>FECHA INICIO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                      $avance=$dat['avance'];
                      $estado=$dat['edo_ord'];
                      if ($avance==90){
                        $estado="COLOCACION";
                      }

                      $color = '';
                      switch ($avance) {
                        case 0:
                          if ($estado == 'ACTIVO') {
                            $color = 'bg-gradient-primary';
                          } elseif ($estado == 'MEDICION') {
                            $color = 'bg-gradient-warning text-white';
                          } else {
                            $color = 'bg-gradient-warning text-white';
                          }
                          break;
                        case 5:
                          $color = 'bg-gradient-secondary';
                          break;
                        case 45:
                          $color = 'bg-gradient-info ';
                          break;
                        case 75:
                          $color = 'bg-gradient-purple';
                          break;
                        case 90:
                          $estado = 'COLOCACION';
                          $color = 'bg-gradient-orange';
                          break;
                        case 100:
                          $color = 'bg-gradient-success';
                          break;
                      }
                    ?>
                      <tr class="">
                        <td></td>
                        <td><?php echo $dat['id_orden'] ?></td>
                        <td><?php echo $dat['folio_vta'] ?></td>
                        <td><?php echo $dat['nombre'] ?></td>
                        <td><?php echo $dat['concepto_vta'] ?></td>
                        <td class="text-center <?php echo $color?>"><?php echo $estado ?></td>
                        <td class="text-center"><?php echo $dat['fecha_ini'] ?></td>
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


  </section>


  <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaavanceord.js?v=<?php echo (rand()); ?>"></script>
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