<!-- CODIGO PHP-->
<?php
$pagina = "presupuesto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);
$consulta = "SELECT * FROM vtmppres where estado_pres='1' and tokenid='$tokenid'";

$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() >= 1) {
  $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

  foreach ($data as $dt) {
    $folio = $dt['folio_pres'];

    $fecha = $dt['fecha_pres'];
    $idpros = $dt['id_pros'];
    $concepto = $dt['concepto_pres'];
    $ubicacion = $dt['ubicacion'];
  }

  $consultapros = "SELECT nombre,correo FROM prospecto where id_pros='$idpros'";

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
  }
} else {
  $fecha = date('Y-m-d');
  $consultatmp = "INSERT INTO tmp_pres (tokenid,estado_pres,fecha_pres) VALUES('$tokenid','1','$fecha')";
  $resultadotmp = $conexion->prepare($consultatmp);
  $resultadotmp->execute();

  $consultatmp = "SELECT folio_pres FROM vtmppres where tokenid='$tokenid' and estado_pres='1' ORDER BY folio_pres DESC LIMIT 1";
  $resultadotmp = $conexion->prepare($consultatmp);
  $resultadotmp->execute();
  $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
  foreach ($datatmp as $dt) {
    $folio = $dt['folio_pres'];
    $idpros = "";
    $prospecto = "";
    $concepto = "";
    $ubicacion = "";
    $correo = "";
  }
}



$message = "";



$consultac = "SELECT * FROM prospecto order by id_pros";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

$consultacon = "SELECT * FROM vconceptos order by id_concepto";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);

$consultadet = "SELECT * FROM vdetalle_tmp order by id_reg";
$resultadodet = $conexion->prepare($consultadet);
$resultadodet->execute();
$datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);



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
      <div class="card-header">
        <h1 class="card-title mx-auto">Presupuestos</h1>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">

            <button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square"></i> Nuevo</button>
            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
            <button id="btnNuevo" type="button" class="btn bg-gradient-primary btn-ms" data-toggle="modal"><i class="fas fa-envelope-square"></i> Enviar</button>
          </div>
        </div>

        <br>


        <!-- Formulario Datos de Cliente -->
        <form id="formDatos" action="" method="POST">


          <div class="content" disab>

            <div class="card card-widget" style="margin-bottom:0px;">

              <div class="card-header bg-gradient-orange " style="margin:0px;padding:8px">
                <div class="card-tools" style="margin:0px;padding:0px;">

                  <button id="btnGuardarHead" name="btnGuardarHead" type="button" class="btn bg-gradient-orange btn-sm">
                    <i class="far fa-save"></i>
                  </button>
                </div>
                <h1 class="card-title ">Datos del Presupuesto</h1>
              </div>

              <div class="card-body" style="margin:0px;padding:1px;">

                <div class="row justify-content-sm-center">

                  <div class="col-lg-5">
                    <div class="form-group">
                      <input type="hidden" class="form-control" name="tokenid" id="tokenid" value="<?php echo $tokenid; ?>">
                      <input type="hidden" class="form-control" name="id_pros" id="id_pros" value="<?php echo $idpros; ?>">
                      <label for="nombre" class="col-form-label">Prospecto:</label>

                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $prospecto; ?>" disabled>
                        <span class="input-group-append">
                          <button id="bcliente" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group input-group-sm">
                      <label for="correo" class="col-form-label">Email:</label>
                      <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $correo; ?>">
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group input-group-sm">
                      <label for="fecha" class="col-form-label">Fecha:</label>
                      <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                    </div>
                  </div>


                  <div class="col-lg-1">
                    <div class="form-group input-group-sm">
                      <label for="folio" class="col-form-label">Folio:</label>
                      <input type="text" class="form-control" name="folio" id="folio" value="<?php echo $folio; ?>">
                    </div>
                  </div>

                </div>

                <div class=" row justify-content-sm-center">
                  <div class="col-sm-6">

                    <div class="form-group">
                      <label for="proyecto" class="col-form-label">Descripcion del Proyecto:</label>
                      <textarea rows="2" class="form-control" name="proyecto" id="proyecto"><?php echo $concepto; ?></textarea>
                    </div>

                  </div>

                  <div class="col-sm-5">

                    <div class="form-group">
                      <label for="ubicacion" class="col-form-label">Ubicación:</label>
                      <textarea rows="2" class="form-control" name="ubicacion" id="ubicacion"><?php echo $ubicacion; ?></textarea>
                    </div>

                  </div>

                </div>

              </div>


            </div>
            <!-- Formulario Agrear Item -->
            <div class="content" style="padding-top:0px;">
              <div class="card card-widget " style="margin:2px;padding:5px;">

                <div class="card-header bg-gradient-orange" style="margin:0px;padding:8px;">
                  <h1 class="card-title" style="text-align:center;">Agregar Item</h1>
                  <div class="card-tools" style="margin:0px;padding:0px;">

                    <button type="button" class="btn bg-gradient-orange btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>

                <div class="card-body " style="margin:0px;padding:2px 5px;">
                  <div class="row justify-content-sm-center">

                    <div class="col-lg-5">
                      <div class="input-group input-group-sm">

                        <input type="hidden" class="form-control" name="claveconcepto" id="claveconcepto">
                        <input type="hidden" class="form-control" name="usomat" id="usomat">


                        <label for="concepto" class="col-form-label">Concepto:</label>
                        <div class="input-group input-group-sm">
                          <input type="text" class="form-control" name="concepto" id="concepto" disabled>
                          <span class="input-group-append">
                            <button id="bconcepto" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                          </span>
                        </div>

                      </div>
                    </div>
                    <div class="col-lg-2">
                      <label for="clave" class="col-form-label">Clave:</label>
                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control" name="clave" id="clave" disabled>
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">

                        <input type="hidden" class="form-control" name="clavemat" id="clavemat">
                        <label for="material" class="col-form-label">Material:</label>

                        <div class="input-group input-group-sm">
                          <input type="text" class="form-control" name="material" id="material" disabled>
                          <span class="input-group-append">
                            <button id="bmaterial" type="button" class="btn btn-sm btn-primary" disabled><i class="fas fa-search"></i></button>
                          </span>
                        </div>

                      </div>
                    </div>



                    <div class="col-lg-4">
                      <input type="hidden" class="form-control" name="idprecio" id="idprecio">
                      <label for="unidad" class="col-form-label">Formato o Servicio:</label>
                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control " name="unidad" id="unidad" disabled>
                        <span class="input-group-append">
                          <button id="bprecio" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                        </span>
                      </div>
                    </div>

                    <div class="col-lg-2">
                      <input type="hidden" class="form-control" name="id_umedida" id="id_umedida">
                      <label for="nom_umedida" class="col-form-label">U Medida:</label>
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control " name="nom_umedida" id="nom_umedida" disabled>
                      </div>
                    </div>

                    <div class="col-lg-2">
                      <label for="precio" class="col-form-label">P.U:</label>
                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control text-right" name="precio" id="precio" disabled>
                      </div>
                    </div>

                    <div class="col-lg-2">
                      <label for="cantidad" class="col-form-label">Cantidad:</label>
                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control" name="cantidad" id="cantidad" disabled>
                      </div>
                    </div>



                    <div class="col-lg-1 justify-content-center">
                      <label for="" class="col-form-label">Acción:</label>
                      <div class="input-group-append input-group-sm justify-content-center d-flex">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Agregar Item">
                          <button type="button" id="btnagregar" name="btnagregar" class="btn btn-sm bg-gradient-orange" value="btnGuardar"><i class="fas fa-plus-square"></i></button>
                        </span>
                        <span class="d-inline-block" tabindex="1" data-toggle="tooltip" title="Limpiar">
                          <button type="button" id="btlimpiar" name="btlimpiar" class="btn btn-sm bg-gradient-purple" value="btnlimpiar"><i class="fas fa-brush"></i></button>
                        </span>
                      </div>
                    </div>

                  </div>

                </div>

              </div>
            </div>
            <!-- Tabla -->
            <div class="content" style="padding:5px 0px;">

              <div class="card card-widget">

                <div class="card-body" style="margin:0px;padding:3px;">

                  <div class="row">

                    <div class="col-lg-12 mx-auto">

                      <div class="table-responsive" style="padding:5px;">

                        <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                          <thead class="text-center bg-gradient-orange">
                            <tr>
                              <th>Id</th>
                              <th>Concepto</th>
                              <th>Descripcion</th>
                              <th>Formato</th>
                              <th>Cantidad</th>
                              <th>U. Medida</th>
                              <th>P.U.</th>
                              <th>Monto</th>
                              <th>Acciones</th>
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

                  <div class="row justify-content-sm-end" style="padding:5px 0px;">

                    <div class="col-lg-2 ">

                      <label for="subtotal" class="col-form-label ">Subtotal:</label>

                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control class=" text-right"" name="subtotal" id="subtotal" disabled>
                      </div>
                    </div>

                    <div class="col-lg-2 ">
                      <label for="iva" class="col-form-label">IVA:</label>

                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control class=" text-right"" name="iva" id="iva" disabled>
                      </div>
                    </div>

                    <div class="col-lg-2 ">
                      <label for="total" class="col-form-label ">Total:</label>

                      <div class="input-group input-group-sm">

                        <input type="text" class="form-control class=" text-right"" name="total" id="total" disabled>
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
    <div class="container">
      <div class="modal fade" id="modalProspecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR PROSPECTO</h5>

            </div>
            <br>
            <div class="table-hover table-responsive w-auto " style="padding:10px">
              <table name="tablaC" id="tablaC" class="table table-sm table-striped text-nowrap table-bordered table-condensed " style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Calle</th>
                    <th>Num</th>
                    <th>Colonia</th>
                    <th>C.P.</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Telefono</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($datac as $datc) {
                  ?>
                    <tr>
                      <td><?php echo $datc['id_pros'] ?></td>
                      <td><?php echo $datc['nombre'] ?></td>
                      <td><?php echo $datc['correo'] ?></td>
                      <td><?php echo $datc['calle'] ?></td>
                      <td><?php echo $datc['num'] ?></td>
                      <td><?php echo $datc['col'] ?></td>
                      <td><?php echo $datc['cp'] ?></td>
                      <td><?php echo $datc['cd'] ?></td>
                      <td><?php echo $datc['edo'] ?></td>
                      <td><?php echo $datc['tel'] ?></td>
                      <td><?php echo $datc['cel'] ?></td>

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
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTO</h5>

            </div>
            <br>
            <div class="table-hover table-responsive w-auto" style="padding:15px">
              <table name="tablaCon" id="tablaCon" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Concepto</th>
                    <th>id Umedida</th>
                    <th>U. Medida</th>
                    <th>Cotiza Material</th>
                    <th>Seleccionar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($datacon as $datc) {
                  ?>
                    <tr>
                      <td><?php echo $datc['id_concepto'] ?></td>
                      <td><?php echo $datc['nom_concepto'] ?></td>
                      <td><?php echo $datc['id_umedida'] ?></td>
                      <td><?php echo $datc['nom_umedida'] ?></td>
                      <td><?php echo $datc['uso_mat'] ?></td>

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
      <div class="modal fade" id="modalMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR ITEM</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablaMat" id="tablaMat" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Clave</th>
                    <th>Descripcion</th>

                    <th>Seleccionar</th>
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
      <div class="modal fade" id="modalPrecio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR PRECIO</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablaP" id="tablaP" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Formato</th>
                    <th>Precio</th>
                    <th>Umedida</th>
                    <th>Seleccionar</th>
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



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/presupuesto.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>