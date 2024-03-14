<?php
$pagina = "ordencto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$fechaActual = new DateTime();
$fechaInicioMesAnterior = new DateTime();
$fechaInicioMesAnterior->modify('first day of last month');

$fechaFinalMesEnCurso = new DateTime();
$fechaFinalMesEnCurso->modify('last day of this month');

$inicioMesAnterior = $fechaInicioMesAnterior->format('Y-m-d');
$finalMesEnCurso = $fechaFinalMesEnCurso->format('Y-m-d');


$inicio = (isset($_GET['inicio'])) ? $_GET['inicio'] : $inicioMesAnterior;
$fin = (isset($_GET['fin'])) ? $_GET['fin'] : $finalMesEnCurso;



$consulta = "SELECT * FROM vorden WHERE estado_ord=1 and edo_ord<>'PENDIENTE' and avance<=90 and edo_ord<>'LIBERADO' and tipop='PROYECTO' or (fecha_liberacion BETWEEN '$inicio' AND '$fin') ORDER BY folio_ord";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$fecha = date('Y-m-d');
$message = "";

$consulta = "SELECT * FROM personal where estado_per=1 order by id_per";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataper = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<style>
  td.editable {

    cursor: pointer;
  }
</style>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card ">
      <div class="card-header bg-secondary">
        <h4 class="card-title text-center">ORDENES DE SERVICIO</h4>
      </div>

      <div class="card-body">



      <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-gradient-secondary ">
                                Filtro por rango de Fecha
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="form-group input-group-sm">
                                            <label for="inicio" class="col-form-label">Fecha Inicio:</label>
                                            <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $inicio ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group input-group-sm">
                                            <label for="fin" class="col-form-label">Fecha Final:</label>
                                            <input type="date" class="form-control" name="fin" id="fin" value="<?php echo $fin ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 align-self-end text-center">
                                        <div class="form-group input-group-sm">
                                            <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                  
                </div>
        </div>
      

        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-secondary">
                    <tr>
                      <th>Folio</th>
                      <th>Folio Vta</th>
                      <th>Folio Doc</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                   
                      <th>Fecha Inst.</th>
                      <th>Tipo</th>
                      <th>Progreso</th>
                      <th>Estado</th>
                      <th>Cto Nom</th>
                      <th>Cto Mat</th>
                      <th>Cto Ins</th>
                      <th>Cto Insd</th>
                      <th>Cto Total</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['folio_ord'] ?></td>
                        <td><?php echo $dat['folio_vta'] ?></td>
                        <td><?php echo $dat['folio_fisico'] ?></td>
                        <td><?php echo $dat['fecha_ord'] ?></td>
                        <td><?php echo $dat['nombre'] ?></td>
                        <td><?php echo $dat['concepto_vta'] ?></td>
                        
                        <td><?php echo $dat['fecha_limite'] ?></td>
                        <td><?php echo $dat['tipop'] ?></td>
                        <td><?php echo $dat['avance'] ?></td>
                        <td><?php echo $dat['edo_ord'] ?></td>
                        <td class="text-right"><?php echo number_format($dat['importenom'],3) ?></td>
                        <td class="text-right"><?php echo number_format($dat['ctomat'],3) ?></td>
                        <td class="text-right"><?php echo number_format($dat['ctoins'],3) ?></td>
                        <td class="text-right"><?php echo number_format($dat['ctoinsd'],3) ?></td>
                        <td class="text-right"><?php echo number_format($dat['costotal'],3) ?></td>
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



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaordencto.js?v=<?php echo (rand()); ?>"></script>
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
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/locale/es.js"></script>