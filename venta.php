<?php
$pagina = "venta";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

if ($folio != "") {
  $objeto = new conn();
  $conexion = $objeto->connect();
  $tokenid = md5($_SESSION['s_usuario']);

  $consulta = "SELECT * FROM venta where folio_vta='$folio'";

  $resultado = $conexion->prepare($consulta);
  $resultado->execute();


  $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

  foreach ($data as $dt) {
    $folio = $dt['folio_vta'];

    $fecha = $dt['fecha_vta'];
    $idclie = $dt['id_clie'];
    $concepto = $dt['concepto_vta'];
    $ubicacion = $dt['ubicacion'];
    $subtotal = $dt['subtotal'];
    $descuento = $dt['descuento'];
    $gtotal = $dt['gtotal'];
    $total = $dt['total'];
    $iva = $dt['iva'];
    $saldo = $dt['saldo'];
  }

  if ($idclie != 0) {
    $consultapros = "SELECT nombre,correo FROM cliente where id_clie='$idclie'";

    $resultadopros = $conexion->prepare($consultapros);
    $resultadopros->execute();
    if ($resultado->rowCount() >= 1) {
      $datapros = $resultadopros->fetchAll(PDO::FETCH_ASSOC);
      foreach ($datapros as $dtp) {
        $prospecto = $dtp['nombre'];
        $correo = $dtp['correo'];
      }
    } else {
      $prospecto = "";
      $correo = "";
    }
  } else {
    $prospecto = "";
    $correo = "";
  }



  $message = "";



  $consultac = "SELECT * FROM cliente order by id_cliente";
  $resultadoc = $conexion->prepare($consultac);
  $resultadoc->execute();
  $datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

  $consultacon = "SELECT * FROM vconceptos order by id_concepto";
  $resultadocon = $conexion->prepare($consultacon);
  $resultadocon->execute();
  $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);
  $consultadet = "SELECT * FROM vdetalle_vta where folio_vta='$folio' order by id_reg";
  $resultadodet = $conexion->prepare($consultadet);
  $resultadodet->execute();
  $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);
} else {
  $folio = "";

  $fecha = "";
  $idclie = "";
  $concepto = "";
  $ubicacion = "";
  $subtotal = "";
  $descuento = "";
  $gtotal = "";
  $total = "";
  $iva = "";
  $prospecto = "";
  $correo = "";
  $saldo = "";
}


?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<link rel="stylesheet" href="plugins/fullcalendar/main.css">
<link rel="stylesheet" href="plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-bootstrap/main.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugns/datatables-responsive/css/responsive.bootstrap4.min.css">

<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
<!--Datetimepicker Bootstrap -->

<!--
<link rel="stylesheet" href="plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
-->
<!--tempusdominus-bootstrap-4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css">



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header bg-gradient-green">
        <h1 class="card-title mx-auto">Venta</h1>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">
            <button id="btnPagar" name="btnPagar" type="button" class="btn bg-gradient-primary btn-ms"><i class="fas fa-dollar-sign"></i> Pagar</button>
            <button id="btnCal" name="btnCal" type="button" class="btn bg-gradient-info btn-ms" data-toggle="modal"><i class="far fa-calendar-alt text-light"></i><span class="text-light"> Instalación</span></button>
          </div>
        </div>

        <br>


        <!-- Formulario Datos de Cliente -->
        <form id="formDatos" action="" method="POST">


          <div class="content">

            <div class="card card-widget" style="margin-bottom:0px;">

              <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">
                <div class="card-tools" style="margin:0px;padding:0px;">


                </div>
                <h1 class="card-title ">Datos de la Venta</h1>
              </div>

              <div class="card-body" style="margin:0px;padding:1px;">

                <div class="row justify-content-sm-center">

                  <div class="col-lg-5">
                    <div class="form-group">
                      <input type="hidden" class="form-control" name="tokenid" id="tokenid" value="<?php echo $tokenid; ?>">
                      <input type="hidden" class="form-control" name="id_pros" id="id_pros" value="<?php echo $idclie; ?>">
                      <label for="nombre" class="col-form-label">Cliente:</label>

                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $prospecto; ?>" disabled>

                      </div>
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group input-group-sm">
                      <label for="correo" class="col-form-label">Email:</label>
                      <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $correo; ?>" disabled>
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group input-group-sm">
                      <label for="fecha" class="col-form-label">Fecha:</label>
                      <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>" disabled>
                    </div>
                  </div>


                  <div class="col-lg-1">
                    <div class="form-group input-group-sm">
                      <label for="folior" class="col-form-label">Folio:</label>

                      <input type="text" class="form-control" name="folior" id="folior" value="<?php echo   $folio; ?>" disabled>
                    </div>
                  </div>

                </div>

                <div class=" row justify-content-sm-center">
                  <div class="col-sm-6">

                    <div class="form-group">
                      <label for="proyecto" class="col-form-label">Descripcion del Proyecto:</label>
                      <textarea rows="2" class="form-control" name="proyecto" id="proyecto" disabled><?php echo $concepto; ?></textarea>
                    </div>

                  </div>

                  <div class="col-sm-5">

                    <div class="form-group">
                      <label for="ubicacion" class="col-form-label">Ubicación:</label>
                      <textarea rows="2" class="form-control" name="ubicacion" id="ubicacion" disabled><?php echo $ubicacion; ?></textarea>
                    </div>

                  </div>

                </div>

              </div>


            </div>
            <!-- Formulario Agrear Item -->

            <!-- Tabla -->
            <div class="content" style="padding:5px 0px;">

              <div class="card card-widget">
                <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">
                  <div class="card-tools" style="margin:0px;padding:0px;">
                  </div>
                  <h1 class="card-title ">Detalle</h1>
                </div>

                <div class="card-body" style="margin:0px;padding:3px;">

                  <div class="row">

                    <div class="col-lg-12 mx-auto">

                      <div class="table-responsive" style="padding:5px;">

                        <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                          <thead class="text-center bg-gradient-green">
                            <tr>
                              <th>Id</th>
                              <th>Concepto</th>
                              <th>Descripcion</th>
                              <th>Formato</th>
                              <th>Cantidad</th>
                              <th>U. Medida</th>
                              <th>P.U.</th>
                              <th>Monto</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            foreach ($datadet as $datdet) {
                            ?>
                              <tr>
                                <td><?php echo $datdet['id_reg'] ?></td>
                                <td><?php echo $datdet['nom_concepto'] ?></td>
                                <td><?php echo $datdet['nom_item'] ?></td>
                                <td><?php echo $datdet['formato'] ?></td>
                                <td><?php echo $datdet['cantidad'] ?></td>
                                <td><?php echo $datdet['nom_umedida'] ?></td>
                                <td><?php echo $datdet['precio'] ?></td>
                                <td><?php echo $datdet['total'] ?></td>


                              </tr>
                            <?php
                            }
                            ?>

                          </tbody>
                        </table>

                      </div>

                    </div>

                  </div>

                  <div class="row justify-content-sm-end" style="padding:5px 0px;">

                    <div class="col-lg-2 ">

                      <label for="subtotal" class="col-form-label ">Subtotal:</label>

                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>

                        <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>" disabled>
                      </div>
                    </div>

                    <div class="col-lg-2 ">
                      <label for="iva" class="col-form-label">IVA:</label>

                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>

                        <input type="text" class="form-control text-right" name="iva" id="iva" value="<?php echo $iva; ?>" disabled>
                      </div>
                    </div>

                    <div class="col-lg-2 ">
                      <label for="total" class="col-form-label ">Total:</label>

                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>

                        <input type="text" class="form-control text-right" name="total" id="total" value="<?php echo $total; ?>" disabled>
                      </div>


                    </div>

                    <div class="col-lg-2 ">
                      <label for="total" class="col-form-label ">Descuento:</label>

                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>

                        <input type="text" class="form-control text-right" name="descuento" id="descuento" value="<?php echo $descuento; ?>" disabled>
                      </div>


                    </div>

                    <div class="col-lg-2 ">
                      <label for="gtotal" class="col-form-label ">Gran Total:</label>

                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>

                        <input type="text" class="form-control text-right" name="gtotal" id="gtotal" value="<?php echo $gtotal; ?>" disabled>
                      </div>


                    </div>
                    <div class="col-lg-2 ">
                      <label for="saldo" class="col-form-label ">Saldo:</label>

                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>

                        <input type="text" class="form-control text-right" name="saldo" id="saldo" value="<?php echo $saldo; ?>" disabled>
                      </div>


                    </div>

                  </div>


                </div>

              </div>

            </div>
            <!-- Formulario totales -->

          </div>


        </form>


        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>

    </div>

    <!-- /.card -->

  </section>

  <section>
    <div class="modal fade" id="modalCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-green">
            <h5 class="modal-title" id="exampleModalLabel">Agendar Cita-Instalacion</h5>

          </div>
          <form id="formCita" action="" method="POST">
            <div class="modal-body row">


              <div class="col-sm-12">
                <div class="form-group">
                  <input type="hidden" class="form-control" name="folio" id="folio">
                  <input type="hidden" class="form-control" name="id_cliec" id="id_cliec" value="<?php echo $idclie; ?>">
                  <label for="nombre" class="col-form-label">Cliente:</label>

                  <div class="input-group">

                    <input type="text" class="form-control" name="nom_cliec" id="nom_cliec" value="<?php echo $prospecto; ?>" autocomplete="off" placeholder="Cliente" disabled>

                  </div>
                </div>
              </div>



              <div class="col-sm-8">
                <div class="form-group">
                  <label for="concepto" class="col-form-label">Concepto Cita</label>
                  <input type="text" class="form-control" name="concepto" value="<?php echo $concepto; ?>" id="concepto" autocomplete="off" placeholder="Concepto de Cita" disabled>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="fechac" class="col-form-label">Fecha Y Hora:</label>

                  <div class="input-group date" id="datetimepicker1" data-date-format="YYYY-MM-DD HH:mm:00" data-target-input="nearest">
                    <input type="text" id="fechac" name="fechac" class="form-control datetimepicker-input " data-target="#datetimepicker1" autocomplete="off" value="<?php echo date("Y-m-d", strtotime($fecha . "+ 15 days")) . ' 12:00:00' ?>" placeholder="Fecha y Hora">
                    <div class="input-group-append " data-target="#datetimepicker1" data-toggle="datetimepicker">
                      <div class="input-group-text btn-primary"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="obs" class="col-form-label">Observaciones:</label>
                  <textarea class="form-control" name="obs" id="obs" rows="3" autocomplete="off" placeholder="Observaciones"><?php echo $ubicacion; ?></textarea>
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
              <button type="button" id="btnGuardarcita" name="btnGuardarcita" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>


  <section>
    <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-green">
            <h5 class="modal-title" id="exampleModalLabel">Pagos</h5>

          </div>
          <form id="formPago" action="" method="POST">
            <div class="modal-body">
              <div class="row justify-content-sm-between">

                <div class="col-sm-3">
                  <div class="form-group input-group-sm">
                    <label for="foliovp" class="col-form-label">Folio Venta:</label>
                    <input type="text" class="form-control" name="foliovp" id="foliovp" value="<?php echo $folio; ?>" disabled>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group input-group-sm">
                    <label for="fechavp" class="col-form-label ">Fecha:</label>
                    <input type="text" id="fechavp" name="fechavp" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="Fecha">
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="conceptovp" class="col-form-label">Concepto Pago</label>
                    <input type="text" class="form-control" name="conceptovp" id="conceptovp" autocomplete="off" placeholder="Concepto de Pago">
                  </div>
                </div>
              </div>

              <div class="row justify-content-sm-center">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="obsvp" class="col-form-label">Observaciones:</label>
                    <textarea class="form-control" name="obsvp" id="obsvp" rows="3" autocomplete="off" placeholder="Observaciones"></textarea>
                  </div>
                </div>
              </div>

              <div class="row justify-content-sm-center">

                <div class="col-lg-4 ">
                  <label for="saldovp" class="col-form-label ">Saldo:</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control text-right" name="saldovp" id="saldovp" value="<?php echo $saldo; ?>" disabled>
                  </div>
                </div>

                <div class="col-lg-4">
                  <label for="montopago" class="col-form-label">Pago:</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                      </span>

                    </div>
                    <input type="text" id="montopago" name="montopago" class="form-control text-right" autocomplete="off" placeholder="Monto del Pago">
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="input-group-sm">
                    <label for="metodo" class="col-form-label">Metodo de Pago:</label>
                    
                    <select class="form-control" name="metodo" id="metodo">
                      <option id="Efectivo" value="Efectivo">Efectivo</option>
                      <option id="Transferencia" value="Transferencia">Transferencia</option>
                      <option id="Cheque" value="Cheque">Cheque</option>
                      <option id="Tarjeta de Crédito" value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                      <option id="Tarjeta de Debito" value="Tarjeta de Debito">Tarjeta de Debito</option>

                    </select>
                  </div>
                </div>

              </div>

            </div>





            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" id="btnGuardarvp" name="btnGuardarvp" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>







</div>

<script>
  //  window.addEventListener('beforeunload', function(event) {
  // Cancel the event as stated by the standard.
  //   event.preventDefault();

  // Chrome requires returnValue to be set.
  //event.returnValue = "";
  //});
</script>

<?php include_once 'templates/footer.php'; ?>
<script src="fjs/venta.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script src="plugins/jquery-ui/jquery-ui.min.js"></script>

<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/fullcalendar/main.min.js"></script>
<script src='plugins/fullcalendar/locales-all.js'></script>
<script src='plugins/fullcalendar/locales/es.js'></script>
<script src="plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="plugins/fullcalendar-interaction/main.min.js"></script>
<script src="plugins/fullcalendar-bootstrap/main.js"></script>

<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/locale/es.js"></script>