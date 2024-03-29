<?php
$pagina = "vale";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$primer = (isset($_GET['inicio'])) ? $_GET['inicio'] : date("Y-m-01");
$ultimo = (isset($_GET['fin'])) ? $_GET['fin'] : date("Y-m-t");

//$primer = date("Y-m-01");

// Obtener el último día del mes en curso
//$ultimo = date("Y-m-t");

$consulta = "SELECT * FROM vale WHERE estado_vale='1' and ((fecha_vale between '$primer' and '$ultimo') or estado<>'RECIBIDO')  ORDER BY folio_vale";
//$consulta = "SELECT * FROM vale WHERE estado_vale='1' ORDER BY folio_vale";
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

  .tablapiezas {

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
        <h4 class="card-title text-center">VALES DE ENTREGA/RECEPCION</h4>
      </div>

      <div class="card-body">



        <div class="row">
          <div class="col-lg-12">
            <button id="btnNuevo" type="button" class="btn bg-gradient-success btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
            <button id="btnPdf" name="btnPdf" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-file-pdf" aria-hidden="true"></i> Preview</button>
          </div>
        </div>
        <br>

        <div class="container-fluid">

        <div class="card">
            <div class="card-header bg-gradient-secondary">
              Filtro por rango de Fecha
            </div>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-lg-2">
                  <div class="form-group input-group-sm">
                    <label for="fecha" class="col-form-label">Desde:</label>
                    <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $primer ?>">
                  </div>
                </div>

                <div class="col-lg-2">
                  <div class="form-group input-group-sm">
                    <label for="fecha" class="col-form-label">Hasta:</label>
                    <input type="date" class="form-control" name="final" id="final" value="<?php echo $ultimo ?>">

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
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-secondary">
                    <tr>
                      <th>Folio</th>
                      <th>Folio Orden</th>
                      <th>Fecha</th>
                      <th>Usuario Inventario</th>
                      <th>Usuario Producción</th>
                      <th>Entregado</th>
                      <th>Devuelto</th>
                      <th>Estado</th>
                      <th>Fecha Cierre</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['folio_vale'] ?></td>
                        <td><?php echo $dat['folio_orden'] ?></td>
                        <td><?php echo $dat['fecha_vale'] ?></td>
                        <td><?php echo $dat['usuario_entrega'] ?></td>
                        <td><?php echo $dat['usuario_recibe'] ?></td>
                        <td><?php echo $dat['firma_entregado'] ?></td>
                        <td><?php echo $dat['firma_recibido'] ?></td>
                        <td><?php echo $dat['estado'] ?></td>
                        <td><?php echo $dat['fecha_cierre'] ?></td>


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
      <div class="modal fade" id="modalentrega" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md " role="document">
          <div class="modal-content">
            <div class="modal-header bg-gradient-info">
              <h5 class="modal-title" id="exampleModalLabel">DETALLE DE VALE(ENTREGA)</h5>

            </div>
            <br>
            <div class="table-hover table-responsive " style="padding:10px">
              <table name="tablac" id="tablac" class="table table-sm table-striped table-bordered table-condensed  w-auto mx-auto" style="width:100%">
                <thead class="text-center bg-gradient-info">
                  <tr>
                    <th>Reg</th>
                    <th>Id </th>
                    <th>Tipo</th>
                    <th>Clave </th>
                    <th>Descripcion </th>
                    <th>Cantidad</th>
                    <th>Obs</th>
                    <th>Estado</th>
                    <th>Acciones</th>
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


  <section>
    <div class="container">

      <!-- Default box -->
      <div class="modal fade" id="modalrecepcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md " role="document">
          <div class="modal-content ">
            <div class="modal-header bg-gradient-success">
              <h5 class="modal-title" id="exampleModalLabel">DETALLE DE VALE(RECEPCION)</h5>

            </div>
            <br>
            <div class="table-hover table-responsive  " style="padding:10px">
              <table name="tablad" id="tablad" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%">
                <thead class="text-center bg-gradient-success">
                  <tr>
                    <th>Reg</th>
                    <th>Id</th>
                    <th>Tipo</th>
                    <th>Clave </th>
                    <th>Descripcion </th>
                    <th>Cantidad</th>
                    <th>Obs</th>
                    <th>Estado</th>
                    <th>Vale</th>
                    <th>Recibido</th>
                    <th>Acciones</th>
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

  <section>
    <div class="modal fade" id="modalRegreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-success">
            <h5 class="modal-title" id="exampleModalLabel">RECEPCION DE ELEMENTOS</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formRegreso" action="" method="POST">
              <div class="modal-body row">


                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                  <input type="hidden" class="form-control" name="fregistro" id="fregistro" autocomplete="off" placeholder="Nombre">
                    <input type="hidden" class="form-control" name="foliovale" id="foliovale" autocomplete="off" placeholder="Nombre">
                    <input type="hidden" class="form-control" name="iditem" id="iditem" autocomplete="off" placeholder="Nombre">
                    <input type="hidden" class="form-control" name="tipoitem" id="tipoitem" autocomplete="off" placeholder="Nombre">
                    <label for="cantidad1" class="col-form-label">Cantidad Vale:</label>
                    <input type="text" class="form-control" name="cantidad1" id="cantidad1" autocomplete="off" placeholder="Cantidad">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                    <label for="cantidad2" class="col-form-label">Cantidad Restante:</label>
                    <input type="text" class="form-control" name="cantidad2" id="cantidad2" autocomplete="off" placeholder="Cantidad">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                    <label for="cantidadr" class="col-form-label">Cantidad Usada:</label>
                    <input type="text" class="form-control" name="cantidadr" id="cantidadr" autocomplete="off" placeholder="Cantidad" disabled>
                  </div>
                </div>
              
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="motivor" class="col-form-label">Motivo de Mov. Inventario:</label>
                    <textarea rows="2" class="form-control" name="motivor" id="motivor" autocomplete="off" placeholder="Motivo" ></textarea>
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
            <button type="button" id="btnregresarcant" name="btnregresarcant" class="btn btn-success" value="btnregresarcant"><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- Resumen de Pagos -->



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntavale.js?v=<?php echo (rand()); ?>"></script>
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