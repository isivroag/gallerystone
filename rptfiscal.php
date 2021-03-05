<?php
$pagina = "resumenventa";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$mesactual = (isset($_GET['mes'])) ? $_GET['mes'] : date("m");
$yearactual = (isset($_GET['ejercicio'])) ? $_GET['ejercicio'] : date("Y");

$consulta = "CALL sp_resumenvta('$yearactual','$mesactual')";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$fecha = date('Y-m-d');
$message = "";



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
      <div class="card-header bg-green">
        <h4 class="card-title text-center">RESUMEN RELACION VENTAS-PAGOS</h4>
      </div>

      <div class="card-body">
      <div class="row">
        <div class="col-lg-12">


          <div class="card-header bg-gradient-green">
            Selector de Período
          </div>
          <div class="card-body p-0">
            <div class="row justify-content-center">
              <div class="col-lg-2">
                <div class="form-group input-group-sm">
                  <label for="mes" class="col-form-label">MES:</label>
                  <select class="form-control" name="mes" id="mes" value="<?php echo $mesactual ?>">
                    <option id="01" value="01" <?php echo ($mesactual == '01') ? "selected" : "" ?>>ENERO</option>
                    <option id="02" value="02" <?php echo ($mesactual == '02') ? "selected" : "" ?>>FEBRERO</option>
                    <option id="03" value="03" <?php echo ($mesactual == '03') ? "selected" : "" ?>>MARZO</option>
                    <option id="04" value="04" <?php echo ($mesactual == '04') ? "selected" : "" ?>>ABRIL</option>
                    <option id="05" value="05" <?php echo ($mesactual == '05') ? "selected" : "" ?>>MAYO</option>
                    <option id="06" value="06" <?php echo ($mesactual == '06') ? "selected" : "" ?>>JUNIO</option>
                    <option id="07" value="07" <?php echo ($mesactual == '07') ? "selected" : "" ?>>JULIO</option>
                    <option id="08" value="08" <?php echo ($mesactual == '08') ? "selected" : "" ?>>AGOSTO</option>
                    <option id="09" value="09" <?php echo ($mesactual == '09') ? "selected" : "" ?>>SEPTIEMBRE</option>
                    <option id="10" value="10" <?php echo ($mesactual == '10') ? "selected" : "" ?>>OCTUBRE</option>
                    <option id="11" value="11" <?php echo ($mesactual == '11') ? "selected" : "" ?>>NOVIEMBRE</option>
                    <option id="12" value="12" <?php echo ($mesactual == '12') ? "selected" : "" ?>>DICIEMBRE</option>

                  </select>
                </div>
              </div>

              <div class="col-lg-2">
                <div class="form-group input-group-sm">
                  <label for="ejercicio" class="col-form-label">EJERCICIO:</label>
                  <input type="text" class="form-control" name="ejercicio" id="ejercicio" value="<?php echo $yearactual ?>">
                </div>
              </div>

              <div class="col-lg-2 align-self-end text-center">
                <div class="form-group input-group-sm">
                  <button id="btnconsulta" name="btnconsulta" type="button" class="btn bg-gradient-success btn-ms form-control"><i class="fas fa-search"></i> Consultar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="row">
          <div class="col-lg-12">

            <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
          </div>
        </div>
        <br>

        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-12">
              <div class="">
                <table name="tablaV" id="tablaV" class="table table-hover table-sm table-striped table-responsive table-bordered table-condensed w-auto mx-auto" style="width:90%">
                  <thead class="text-center bg-gradient-success">
                    <tr>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                      <th>Total</th>
                      <th>Saldo Actual</th>
                      <th>Pgos Ant.</th>
                      <th>Efectivo</th>
                      <th>Fiscal</th>
                      <th>Pgos Post.</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['folio_vta'] ?></td>
                        <td><?php echo $dat['fecha_vta'] ?></td>
                        <td><?php echo $dat['nombre'] ?></td>
                        <td><?php echo $dat['concepto_vta'] ?></td>

                        <td class="text-right"><?php echo "$ " . number_format($dat['gtotal'], 2) ?></td>
                        <td class="text-right"><?php echo "$ " . number_format($dat['saldo'], 2) ?></td>
                        <td class="text-right"><?php echo "$ " . number_format($dat['pagosant'], 2) ?></td>
                        <td class="text-right"><?php echo "$ " . number_format($dat['efectivo'], 2) ?></td>
                        <td class="text-right"><?php echo "$ " . number_format($dat['facturar'], 2) ?></td>
                        <td class="text-right"><?php echo "$ " . number_format($dat['pagospost'], 2) ?></td>
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
    <div class="container">


      <!-- Default box -->
      <div class="modal fade" id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">Resumen de Pagos</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Metodo</th>
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
    <div class="modal fade" id="modalcan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-danger">
            <h5 class="modal-title" id="exampleModalLabel">CANCELAR VENTA</h5>
          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formcan" action="" method="POST">
              <div class="modal-body row">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="motivo" class="col-form-label">Motivo de Cancelacioón:</label>
                    <textarea rows="3" class="form-control" name="motivo" id="motivo" placeholder="Motivo de Cancelación"></textarea>
                    <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha ?>">
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
            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
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
<script src="fjs/rptfiscal.js"></script>
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





