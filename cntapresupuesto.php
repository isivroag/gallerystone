<?php
$pagina="presupuesto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
if ($_SESSION['s_rol'] == '2'){
  $consulta = "SELECT * FROM vpres order by folio_pres";
}
else{
  $consulta = "SELECT * FROM vpres where estado_pres<>0 order by folio_pres";
}

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
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-orange">
                    <tr>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
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
                        <td><?php echo $dat['concepto_pres'] ?></td>
                        
                        <td class="text-right"><?php echo "$ ".number_format( $dat['gtotal'],2) ?></td>
                        <td><?php  
                        switch ($dat['estado_pres']) {
                          case 0:
                            echo"<span class='bg-danger'> RECHAZADO </span>";
                            break;
                        
                          case 1:
                              echo "<span class='bg-warning'> PENDIENTE </span>";
                              break;
                          case 2:
                            echo "<span class='bg-primary'> ENVIADO </span>";
                            break;
                          case 3:
                            echo "<span class='bg-success'> ACEPTADO </span>";
                            break;
                          case 4:
                            echo "<span class='bg-purple'> EN ESPERA </span>";
                            break;
                            case 5:
                              echo "<span class='bg-lightblue'> EDITADO </span>";
                              break;
                            }

                          
                        
                        ?></td>
                       

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

  <section>
    <div class="modal fade" id="modalcall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-primary">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO PROSPECTO</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formllamada" action="" method="POST">
              <div class="modal-body row">


                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="estado" class="col-form-label">Estado:</label>

                    <select class="form-control" name="estado" id="estado">
                                        
                      <option id="3" value="3"> Aceptado</option>
                      <option id="4" value="4"> En Espera</option>
                      <option id="0" value="0"> Rechazado</option>


                    </select>
                    
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="nota" class="col-form-label">Notas:</label>
                    <textarea rows="3" class="form-control" name="nota" id="nota" placeholder="Notas"></textarea>
                    
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
            <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
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
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>