<?php
$pagina = "presupuesto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

$objeto = new conn();
$conexion = $objeto->connect();


$consulta = "SELECT * FROM presupuesto";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount() >= 1) {
  $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

  foreach ($data as $dt) {
    $fechaini = $dt['fecha_pres'];
  }
}



$consulta = "SELECT * FROM notaspres where folio_pres='$folio'order by id_nota";
$resultado = $conexion->prepare($consulta);
$resultado->execute();


$data2 = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  

 

  <!-- Main content -->
  <div class="card">
  <div class="card-header bg-gradient-orange text-light">
        <h1 class="card-title mx-auto">Historial dePresupuestos</h1>
      </div>

    <div class="card-body">

      <!-- Timelime example  -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <div class="timeline">


            <?php
            foreach ($data2 as $dt2) {

              $opcion = $dt2['estado'];
              switch ($opcion) {
                case 0:

                  echo "<div class='time-label'>";
                  echo "<span class='bg-danger'>" . $dt2['fecha'] . "</span>";
                  echo "</div>";
                  echo "<div>";
                  echo "<i class='fas fa-times-circle bg-danger'></i>";
                  echo "<div class='timeline-item'>";
                  echo "<h3 class='timeline-header'><a href='#'>Rechazado Por: " .$dt2['usuario']." </a>" . $opcion = $dt2['nota'] . "</h3>";
                  echo "</div>";
                  echo "</div>";


                  break;
                case 1:
                  
                  echo "<div class='time-label'>";
                  echo "<span class='bg-warning'>" . $dt2['fecha'] . "</span>";
                  echo "</div>";
                  echo "<div>";
                  echo "<i class='fas fa-keyboard bg-warning'></i>";
                  echo "<div class='timeline-item'>";
                  echo "<h3 class='timeline-header'><a href='#'>Creado Por: " .$dt2['usuario']." </a><br>" . $opcion = $dt2['nota'] . "</h3>";
                  echo "</div>";
                  echo "</div>";
                  break;
                case 2:
                  
                  echo "<div class='time-label'>";
                  echo "<span class='bg-blue'>" . $dt2['fecha'] . "</span>";
                  echo "</div>";
                  echo "<div>";
                  echo "<i class='fas fa-envelope bg-blue'></i>";
                  echo "<div class='timeline-item'>";
                  echo "<h3 class='timeline-header'><a href='#'>Enviado Por: " .$dt2['usuario']." </a><br>" . $opcion = $dt2['nota'] . "</h3>";
                  echo "</div>";
                  echo "</div>";
                  break;
                case 3:
                  
                  echo "<div class='time-label'>";
                  echo "<span class='bg-success'>" . $dt2['fecha'] . "</span>";
                  echo "</div>";
                  echo "<div>";
                  echo "<i class='fas fa-dollar-sign bg-success'></i>";
                  echo "<div class='timeline-item'>";
                  echo "<h3 class='timeline-header'><a href='#'>Aceptado Por: " .$dt2['usuario']." </a><br>" . $opcion = $dt2['nota'] . "</h3>";
                  echo "</div>";
                  echo "</div>";
                  break;
                case 4:
                  
                  echo "<div class='time-label'>";
                  echo "<span class='bg-purple'>" . $dt2['fecha'] . "</span>";
                  echo "</div>";
                  echo "<div>";
                  echo "<i class='fas fa-pause-circle bg-purple'></i>";
                  echo "<div class='timeline-item'>";
                  echo "<h3 class='timeline-header'><a href='#'>En Espera Por: " .$dt2['usuario']." </a><br>" . $opcion = $dt2['nota'] . "</h3>";
                  echo "</div>";
                  echo "</div>";
                  break;

                  case 5:
                  
                    echo "<div class='time-label'>";
                    echo "<span class='bg-lightblue'>" . $dt2['fecha'] . "</span>";
                    echo "</div>";
                    echo "<div>";
                    echo "<i class='fas fa-edit bg-lightblue'></i>";
                    echo "<div class='timeline-item'>";
                    echo "<h3 class='timeline-header'><a href='#'>Editado Por: " .$dt2['usuario']." </a><br>" . $opcion = $dt2['nota'] . "</h3>";
                    echo "</div>";
                    echo "</div>";
                    break;
              }
              
            }
            ?>
            <div>
              <i class="fas fa-clock bg-info"></i>
            </div>
          </div>


            
          </div>
        </div>
        <!-- /.col -->
      </div>
    </div>
    <!-- /.timeline -->

  </section>
  <!-- /.content -->
</div>

<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntapresupuesto.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>