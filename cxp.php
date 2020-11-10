<?php
$pagina = "cxp";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);

if ($folio != "") {

  $opcion=2;
  $consulta = "SELECT * FROM vcxp where folio_cxp='$folio'";

  $resultado = $conexion->prepare($consulta);
  $resultado->execute();


  $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

  foreach ($data as $dt) {
    $folio = $dt['folio_cxp'];

    $fecha = $dt['fecha'];
    $fecha_limite = $dt['fecha_limite'];
    $id_prov = $dt['id_prov'];
    $nombre = $dt['nombre'];
    $id_partida = $dt['id_partida'];
    $nom_partida = $dt['nom_partida'];
    $concepto = $dt['concepto'];
    $facturado = $dt['facturado'];
    $referencia = $dt['referencia'];
    $subtotal = $dt['subtotal'];
    $total = $dt['total'];
    $iva = $dt['iva'];
    $saldo = $dt['saldo'];
  }





  $message = "";
} else {
  $folio = "";
  $opcion=1;
  $fecha =  date('Y-m-d');
  $fecha_limite = date('Y-m-d');
  $id_prov = "";
  $nombre = "";
  $id_partida = "";
  $nom_partida = "";
  $concepto = "";
  $facturado = "";
  $referencia = "";
  $subtotal = 0;
  $total = 0;
  $iva = 0;
  $saldo = 0;
}

$consultac = "SELECT * FROM proveedor order by id_prov";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

$consultacon = "SELECT * FROM partida order by id_partida";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header bg-gradient-purple text-light">
        <h1 class="card-title mx-auto">Cuentas Por Pagar</h1>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">

          <button id="btnNuevo" type="button" class="btn bg-gradient-purple btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>

          </div>
        </div>

        <br>


        <!-- Formulario Datos de Cliente -->
        <form id="formDatos" action="" method="POST">


          <div class="content" disab>

            <div class="card card-widget" style="margin-bottom:0px;">

              <div class="card-header bg-gradient-purple " style="margin:0px;padding:8px">
               
                <h1 class="card-title ">Datos Cuentas Por Pagar</h1>
              </div>

              <div class="card-body" style="margin:0px;padding:1px;">

                <div class="row justify-content-sm-center">

                  <div class="col-lg-5">
                    <div class="form-group">
                      <input type="hidden" class="form-control" name="tokenid" id="tokenid" value="<?php echo $tokenid; ?>">
                      <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo $opcion; ?>">
                      <input type="hidden" class="form-control" name="id_prov" id="id_prov" value="<?php echo $id_prov; ?>">
                      <label for="nombre" class="col-form-label">Proveedor:</label>

                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>" disabled>
                        <span class="input-group-append">
                          <button id="bproveedor" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                          <button id="bproveedorplus" type="button" class="btn btn-success "><i class="fas fa-plus-square"></i></button>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group input-group-sm">
                      <label for="fecha" class="col-form-label">Fecha:</label>
                      <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                    </div>
                  </div>




                  <div class="col-lg-2">
                    <div class="form-group input-group-sm">
                      <label for="folior" class="col-form-label">Folio:</label>
                      <input type="hidden" class="form-control" name="folio" id="folio" value="<?php echo $folio; ?>">
                      <input type="text" class="form-control" name="folior" id="folior" value="<?php echo   $folio; ?>">
                    </div>
                  </div>

                  <div class="col-lg-5">
                    <div class="form-group">

                      <input type="hidden" class="form-control" name="id_partida" id="id_partida" value="<?php echo $id_partida; ?>">
                      <label for="partida" class="col-form-label">Partida:</label>

                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control" name="partida" id="partida" value="<?php echo $nom_partida; ?>" disabled>
                        <span class="input-group-append">
                          <button id="bpartida" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                          <button id="bpartidaplus" type="button" class="btn btn-success "><i class="fas fa-plus-square"></i></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group ">


                      <label for="fechal" class="col-form-label">Crédito /Fecha Limite:</label>

                      <div class="input-group input-group-sm">

                        <span class="input-group-prepend input-group-text">
                          <input type="checkbox" class="" name="ccredito" id="ccredito">
                        </span>


                        <input type="date" class="form-control" name="fechal" id="fechal" value="<?php echo $fecha_limite; ?>" disabled>
                      </div>


                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group input-group-sm">
                      <label for="referencia" class="col-form-label">Facturado / No. Fact /Ref:</label>
                      <div class="input-group input-group-sm">

                        <span class="input-group-prepend input-group-text">
                          <input type="checkbox" class="" name="cfactura" id="cfactura">
                        </span>


                        <input type="text" class="form-control" name="referencia" id="referencia" value="<?php echo  $referencia; ?>">
                      </div>

                    </div>
                  </div>


                </div>

                <div class=" row justify-content-sm-center">
                  <div class="col-sm-9">

                    <div class="form-group">
                      <label for="concepto" class="col-form-label">Concepto:</label>
                      <textarea rows="2" class="form-control" name="concepto" id="concepto"><?php echo $concepto; ?></textarea>
                    </div>

                  </div>



                </div>

                <div class="row justify-content-sm-center">
                <div class=" offset-lg-0 col-lg-2 ">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="cmanual" name="cmanual">
                      <label class="custom-control-label" for="cmanual">Calculo Manual</label>
                    </div>
                  </div>

                  <div class=" offset-lg-4 col-lg-2 ">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input " id="cinverso" name="cinverso">
                      <label class="custom-control-label" for="cinverso">Calculo Inverso</label>
                    </div>
                  </div>

                </div>

                <div class="row justify-content-sm-center" style="padding:5px 0px;margin-bottom:5px">

                  <div class="col-lg-3 ">

                    <label for="subtotal" class="col-form-label ">Subtotal:</label>

                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-dollar-sign"></i>
                        </span>
                      </div>

                      <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>">
                    </div>
                  </div>

                  <div class="col-lg-3 ">
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

                  <div class="col-lg-3 ">
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

                </div>

              </div>


            </div>
            <!-- Formulario Agrear Item -->


          </div>


        </form>


        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>

    </div>

    <!-- /.card -->

  </section>


  <section>
    <div class="container">
      <div class="modal fade" id="modalProspecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-purple">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR PROSPECTO</h5>

            </div>
            <br>
            <div class="table-hover table-responsive w-auto " style="padding:10px">
              <table name="tablaC" id="tablaC" class="table table-sm table-striped text-nowrap table-bordered table-condensed " style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>RFC</th>
                    <th>Proveedor</th>

                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($datac as $datc) {
                  ?>
                    <tr>
                      <td><?php echo $datc['id_prov'] ?></td>
                      <td><?php echo $datc['rfc'] ?></td>
                      <td><?php echo $datc['nombre'] ?></td>


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
  </section>



  <section>
    <div class="container">

      <!-- Default box -->
      <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-purple">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTO</h5>

            </div>
            <br>
            <div class="table-hover table-responsive w-auto" style="padding:15px">
              <table name="tablaCon" id="tablaCon" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Partida</th>
                    <th>Seleccionar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($datacon as $datc) {
                  ?>
                    <tr>
                      <td><?php echo $datc['id_partida'] ?></td>
                      <td><?php echo $datc['nom_partida'] ?></td>
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
  </section>




  <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cxp.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>