<?php
$pagina = "ensamble";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vorden WHERE estado_ord=1 and edo_ord='ENSAMBLE' and  edo_ord<>'LIBERADO' and tipop='PROYECTO' ORDER BY folio_ord";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$fecha = date('Y-m-d');
$message = "";



?>

<style>
  td.editable {

    cursor: pointer;

    
  }
  .tablapiezas{
   
  height: 100px;
  width: 100%;
  overflow-y: auto;

    

  }
</style>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card ">
      <div class="card-header bg-secondary">
        <h4 class="card-title text-center">CORTE</h4>
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
                  <thead class="text-center bg-secondary">
                    <tr>
                      <th>Folio</th>
                      <th>Folio Vta</th>
                      <th>Folio Doc</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                      <th>Ubicacion</th>

                      <th>Tipo</th>

                      <th>Estado</th>
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
                        <td><?php echo $dat['ubicacion'] ?></td>

                        <td><?php echo $dat['tipop'] ?></td>

                        <td><?php echo $dat['edo_ord'] ?></td>
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

  <section>
    <div class="modal fade" id="modalEtapa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-secondary">
            <h5 class="modal-title" id="exampleModalLabel">Estado de Colocación</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formEtapa" action="" method="POST">
              <div class="modal-body row">


                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <input type="hidden" class="form-control" name="foliolorden" id="foliolorden" autocomplete="off" placeholder="Nombre">



                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group input-group-sm auto">
                    <label for="etapa" class="col-form-label">Etapa de Colocación:</label>
                    <select class="form-control" name="etapa" id="etapa">
                      <option id="e1" value="DESCARGA">DESCARGA</option>
                      <option id="e2" value="PROTECCION">PROTECCION</option>
                      <option id="e3" value="COLOCACION">COLOCACION</option>
                      <option id="e4" value="LIMPIEZA">LIMPIEZA</option>
                      <option id="e5" value="ENTREGA">SUPERVISION Y ENTREGA</option>
                    </select>
                  </div>
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
            <button type="button" id="btnguardaestapa" name="btnguardaestapa" class="btn btn-success" value="btngliberar"><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>


  <section>
    <div class="modal fade" id="modalOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-success">
            <h5 class="modal-title" id="exampleModalLabel">Fecha de Liberación</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formOrden" action="" method="POST">
              <div class="modal-body row">


                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <input type="hidden" class="form-control" name="foliolorden" id="foliolorden" autocomplete="off" placeholder="Nombre">
                    <input type="hidden" class="form-control" name="foliolventa" id="foliolventa" autocomplete="off" placeholder="Nombre">
                    <label for="fechai" class="col-form-label">Fecha de Inicio:</label>
                    <input type="date" class="form-control" name="fechal" id="fechal" autocomplete="off" placeholder="Fecha">
                  </div>
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
            <button type="button" id="btngliberar" name="btngliberar" class="btn btn-success" value="btngliberar"><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">

      <!-- Default box -->
      <div class="modal fade" id="modalpiezas"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md " role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">PIEZAS ORDEN DE TRABAJO</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablapiezas" id="tablapiezas" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                <thead class="text-center bg-gradient-primary">
                  <tr>
                    <th>ID</th>
                    <th>ORDEN</th>
                    <th>CONCEPTO</th>
                    <th>MEDIDAS</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
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





  <!-- /.content -->
</div>
<!-- Resumen de Pagos -->



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaensamble.js?v=<?php echo (rand()); ?>"></script>
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
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>