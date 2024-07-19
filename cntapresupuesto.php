<?php
$pagina = "presupuesto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
//if ($_SESSION['s_rol'] == '3' or $_SESSION['s_rol'] == '1' OR $_SESSION['s_rol'] == '2' ) {
  $consulta = "SELECT * FROM vpres where edo_pres='1' and  estado_pres<>'SUSPENDIDO' and estado_pres<>'RECHAZADO' and estado_pres<>'ACEPTADO'and tipo_proy=1 order by folio_pres";
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
        <h4 class="card-title text-center">Presupuestos</h4>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">

            <button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
            <a href="help/presupuesto/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a>
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
                  <input type="date" class="form-control" name="inicio" id="inicio">
                </div>
              </div>

              <div class="col-lg-2">
                <div class="form-group input-group-sm">
                  <label for="fecha" class="col-form-label">Hasta:</label>
                  <input type="date" class="form-control" name="final" id="final">
                  <input type="hidden" class="form-control" name="tipo_proy" id="tipo_proy" value=1>
                </div>
              </div>

              <div class="col-lg-1 align-self-end text-center">
                <div class="form-group input-group-sm">
                  <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-check">
                <input class="form-check-input" name="ctodos" id="ctodos" type="checkbox" checked="">
                <label class="form-check-label">Incluir presupuestos rechazados</label>
              </div>
            </div>
          </div>
        </div>
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
                      <th>CRM</th>
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
                        
                        <?php
                        /*
                        switch ($dat['estado_pres']) {
                              case 0:
                                echo "<span class='bg-danger'> RECHAZADO </span>";
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
                            }*/?>
                            </td>


                        <td></td>
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
          <div class="modal-header bg-gradient-danger">
            <h5 class="modal-title" id="exampleModalLabel">PRESUPUESTO RECHAZADO</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formllamada" action="" method="POST">
              <div class="modal-body row">


                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="estado" class="col-form-label">Estado:</label>
                    <select class="form-control" name="estado" id="estado">
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

  <section>
    <div class="modal fade" id="modalseguimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
      <div class="modal-content">
          <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel">LLAMADAS DE SEGUIMIENTO</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formSegumiento" action="" method="POST">
              <div class="modal-body row">

              <div class="col-sm-6">
                  <div class="form-group input-group-sm">
                    <label for="descllamada" class="col-form-label"># LLAMADA:</label>
                    <input type="text" class="form-control" name="descllamada" id="descllamada" autocomplete="off" placeholder="Llamada" disabled>
                    <input type="hidden" class="form-control" name="idllamada" id="idllamada" autocomplete="off" placeholder="ID">
                    <input type="hidden" class="form-control" name="folio_pres" id="folio_pres" autocomplete="off" placeholder="ID_PRES">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group input-group-sm">
                    <label for="fechallamada" class="col-form-label">FECHA SUGERIDA:</label>
                    <input type="date" class="form-control" name="fechallamada" id="fechallamada" autocomplete="off" placeholder="Fecha Sugerida">
                    
                  </div>
                </div>


                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="notallamada" class="col-form-label">Notas:</label>
                    <textarea rows="3" class="form-control" name="notallamada" id="notallamada" placeholder="Notas"></textarea>

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
            <button type="button" id="btnGllamada" name="btnGllamada" class="btn btn-success" ><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="modal fade" id="modalcierre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
      <div class="modal-content">
          <div class="modal-header bg-purple">
            <h5 class="modal-title" id="exampleModalLabel">CERRAR LLAMADA DE SEGUIMIENTO</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formCierre" action="" method="POST">
              <div class="modal-body row">

              <div class="col-sm-6">
                  <div class="form-group input-group-sm">
                    <label for="descllamadac" class="col-form-label"># LLAMADA:</label>
                    <input type="text" class="form-control" name="descllamadac" id="descllamadac" autocomplete="off" placeholder="Llamada" disabled>
                    <input type="hidden" class="form-control" name="idllamadac" id="idllamadac" autocomplete="off" placeholder="ID">
                    <input type="hidden" class="form-control" name="folio_presc" id="folio_presc" autocomplete="off" placeholder="ID_PRES">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group input-group-sm">
                    <label for="fechallamadac" class="col-form-label">FECHA ACTUAL:</label>
                    <input type="date" class="form-control" name="fechallamadac" id="fechallamadac" autocomplete="off" placeholder="Fecha Sugerida" disabled>
                    
                  </div>
                </div>


                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="notallamadac" class="col-form-label">NOTA DE CIERRE:</label>
                    <textarea rows="3" class="form-control" name="notallamadac" id="notallamadac" placeholder="Notas"></textarea>

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
            <button type="button" id="btnGCierre" name="btnGCierre" class="btn btn-success" ><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntapresupuesto.js?v=<?php echo (rand()); ?>"></script>
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