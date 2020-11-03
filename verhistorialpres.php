<?php
$pagina="historial";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';

$message="";



?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Historial de Presupuesto</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red"> 5/03/2020</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-envelope bg-blue"></i>
                <div class="timeline-item">
                  
                  <h3 class="timeline-header"><a href="#">Enviado</a> isivroag@hotmail.com</h3>

                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-phone bg-green"></i>
                <div class="timeline-item">
                  
                  <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-comments bg-yellow"></i>
                <div class="timeline-item">
                  
                  <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                  
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-green">4/09/2020</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div>
                <i class="fa fa-camera bg-purple"></i>
                <div class="timeline-item">
                 
                  <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                  
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-video bg-maroon"></i>

                <div class="timeline-item">
                  
                  <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>

                  
                </div>
              </div>
              <!-- END timeline item -->
              <div>
                <i class="fas fa-clock bg-gray"></i>
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