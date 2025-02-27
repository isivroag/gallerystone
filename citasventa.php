<?php
$pagina = "citav";
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vcitav order by folio_citav";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);



$message = "";



?>
<!-- fullCalendar -->
<link rel="stylesheet" href="plugins/fullcalendar/main.css">
<link rel="stylesheet" href="plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-bootstrap/main.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
<!--Datetimepicker Bootstrap -->

<!--
<link rel="stylesheet" href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
-->
<!--tempusdominus-bootstrap-4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css">

<style>
  .punto {
    height: 20px !important;
    width: 20px !important;

    border-radius: 50% !important;
    display: inline-block !important;
    text-align: center;
    font-size: 15px;
  }

  #div_carga {
    position: absolute;
    /*top: 50%;
    left: 50%;
    */

    width: 100%;
    height: 100%;
    background-color: rgba(60, 60, 60, 0.5);
    display: none;

    justify-content: center;
    align-items: center;
    z-index: 3;
  }

  #cargador {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -25px;
    margin-left: -25px;
  }

  #textoc {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: 120px;
    margin-left: 20px;


  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="card">
    <div class="card-header bg-gradient-green light">
      <h2 class="card-title mx-auto">Calendario de Citas de Instalación</h2>
    </div>
    <div class="card-body">

      <div class="row">
        <div class="col-lg-12">
        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
        <a href="help/citasventa/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a>
        </div>
      </div>
      <br>
      <div class="row">

        <!-- /.col -->
        <div class="col-md-8 mx-auto">
          <div class="card card-primary">

            <div class="card-body p-0">

              <div id="div_carga">

                <img id="cargador" src="img/loader.gif" />
                <span class=" " id="textoc"><strong>Cargando...</strong></span>

              </div>
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>




  <section>
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-green">
            <h5 class="modal-title" id="exampleModalLabel">Agendar Cita-Instalación</h5>

          </div>
          <form id="formDatos" action="" method="POST">
            <div class="modal-body row">


              <div class="col-sm-12">
                <div class="form-group">
                  <input type="hidden" class="form-control" name="folio" id="folio">
                  <input type="hidden" class="form-control" name="id_pros" id="id_pros">
                  <label for="nombre" class="col-form-label">Cliente:</label>

                  <div class="input-group">

                    <input type="text" class="form-control" name="nom_pros" id="nom_pros" autocomplete="off" placeholder="Prospecto">

                  </div>
                </div>
              </div>



              <div class="col-sm-8">
                <div class="form-group">
                  <label for="concepto" class="col-form-label">Concepto Cita</label>
                  <input type="text" class="form-control" name="concepto" id="concepto" autocomplete="off" placeholder="Concepto de Cita">
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="fecha" class="col-form-label">Fecha Y Hora:</label>

                  <div class="input-group date" id="datetimepicker1" data-date-format="YYYY-MM-DD HH:mm:00" data-target-input="nearest">
                    <input type="text" id="fecha" name="fecha" class="form-control datetimepicker-input " data-target="#datetimepicker1" autocomplete="off" placeholder="Fecha y Hora">
                    <div class="input-group-append " data-target="#datetimepicker1" data-toggle="datetimepicker">
                      <div class="input-group-text btn-primary"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                  <!--
                  <div class="input-group date form_datetime" data-date="" data-date-format="yyyy-mm-dd HH:ii:00" data-link-field="dtp_input1">
                        <input class="form-control" type="text" value="" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                    <input type="hidden" id="dtp_input1" value="" /><br/>
                    -->
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="obs" class="col-form-label">Observaciones:</label>
                  <textarea class="form-control" name="obs" id="obs" rows="3" autocomplete="off" placeholder="Observaciones"></textarea>
                </div>
              </div>




            </div>


            <?php
            if ($message != "") {
            ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <span class="badge "><?php echo ($message); ?></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>

              </div>

            <?php
            }
            ?>
            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>




  <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/citav.js?version=1"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<!-- jQuery UI -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/fullcalendar/main.min.js"></script>
<script src='plugins/fullcalendar/locales-all.js'></script>
<script src='plugins/fullcalendar/locales/es.js'></script>
<script src="plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="plugins/fullcalendar-interaction/main.min.js"></script>
<script src="plugins/fullcalendar-bootstrap/main.js"></script>


<!--Datetimepicker Bootstrap -->
<!--
<script src="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script src="plugins/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
-->
<!--tempusdominus-bootstrap-4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/locale/es.js"></script>