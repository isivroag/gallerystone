<?php
$pagina = "orden";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

if ($folio != "") {
    $objeto = new conn();
    $conexion = $objeto->connect();
    $tokenid = md5($_SESSION['s_usuario']);

    $consulta = "SELECT * FROM vorden where folio_vta='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);



    foreach ($data as $dt) {
        $folioorden = $dt['folio_ord'];
        $folio = $dt['folio_vta'];


        $fecha = $dt['fecha_ord'];
        $fechalim = $dt['fecha_limite'];
        $nomclie = $dt['nombre'];
        $concepto = $dt['concepto_vta'];
        $ubicacion = $dt['ubicacion'];
        $notas = $dt['notas'];
    }





    $message = "";



    $consultadet = "SELECT * FROM vdetalle_vta where folio_vta='$folio' order by id_reg";
    $resultadodet = $conexion->prepare($consultadet);
    $resultadodet->execute();
    $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);

  



    $cntamat = "SELECT * FROM vmaterial order by id_mat";
    $resmat = $conexion->prepare($cntamat);
    $resmat->execute();
    $datamat = $resmat->fetchAll(PDO::FETCH_ASSOC);
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
    $vendedor = "";
}


?>



<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-secondary">
                <h1 class="card-title mx-auto">Venta</h1>
            </div>

            <div class="card-body">



                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget collapsed-card" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">
                                <div class="card-tools" style="margin:0px;padding:0px;">


                                </div>
                                <h1 class="card-title ">Datos de la Venta</h1>
                                <div class="card-tools" style="margin:0px;padding:0px;">

                                    <button type="button" class="btn bg-gradient-secondary btn-sm " href="#cuerpo" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="collapse card-body" id="cuerpo" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">

                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folioorden" class="col-form-label">Folio Orden:</label>

                                            <input type="text" class="form-control" name="folioorden" id="folioorden" value="<?php echo   $folioorden; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="form-group">

                                            <label for="nombre" class="col-form-label">Cliente:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nomclie; ?>" disabled>

                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fechalim" class="col-form-label">Fecha Limite:</label>
                                            <input type="date" class="form-control" name="fechalim" id="fechalim" value="<?php echo $fechalim; ?>" disabled>
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

                                    <div class="col-sm-11">
                                        <div class="form-group">
                                            <label for="notas" class="col-form-label">Notas:</label>
                                            <textarea rows="2" class="form-control" name="notas" id="notas" disabled><?php echo $notas; ?></textarea>
                                        </div>
                                    </div>

                                </div>



                            </div>


                        </div>
                        <!-- Formulario Agrear Item -->

                        <!-- Tabla -->
                        <div class="content" style="padding:5px 0px;">

                            <div class="card card-widget">
                                <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">
                                    <div class="card-tools" style="margin:0px;padding:0px;">
                                    </div>
                                    <h1 class="card-title ">Detalle</h1>
                                </div>

                                <div class="card-body" style="margin:0px;padding:3px;">

                                    <div class="row">

                                        <div class="col-lg-12 mx-auto">

                                            <div class="table-responsive" style="padding:5px;">

                                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                    <thead class="text-center bg-gradient-secondary">
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Concepto</th>
                                                            <th>Descripcion</th>
                                                            <th>Formato</th>
                                                            <th>Cantidad</th>
                                                            <th>U. Medida</th>


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

                        </div>
                        <!-- Formulario totales -->

                    </div>

                    <div class="content">
                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-primary " style="margin:0px;padding:8px">
                                <div class="card-tools" style="margin:0px;padding:0px;">


                                </div>
                                <h1 class="card-title ">Materiales Usados</h1>
                                <div class="card-tools" style="margin:0px;padding:0px;">


                                </div>
                            </div>

                            <div class="card-body" style="margin:0px;padding:3px;">

                                <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                                    <div class="card-header bg-gradient-primary" style="margin:0px;padding:8px;">

                                        <h1 class="card-title" style="text-align:center;">Agregar Material</h1>
                                        <div class="card-tools" style="margin:0px;padding:0px;">

                                            <button type="button" class="btn bg-gradient-primary btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body " style="margin:0px;padding:2px 5px;">
                                        <div class="row justify-content-sm-center">

                                            <div class="col-lg-4">
                                                <div class="input-group input-group-sm">

                                                    <input type="hidden" class="form-control" name="clavemat" id="clavemat">
                                                    <input type="hidden" class="form-control" name="iditem" id="iditem">




                                                    <label for="material" class="col-form-label">Material:</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control" name="material" id="material" disabled>
                                                        <span class="input-group-append">
                                                            <button id="btnMaterial" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
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
                                            <div class="col-lg-3">
                                                <label for="formato" class="col-form-label">Formato:</label>
                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="formato" id="formato" disabled>
                                                </div>
                                            </div>








                                            <div class="col-lg-1">
                                                <input type="hidden" class="form-control" name="id_umedida" id="id_umedida">
                                                <label for="nom_umedida" class="col-form-label">U Medida:</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control " name="nom_umedida" id="nom_umedida" disabled>
                                                </div>
                                            </div>



                                            <div class="col-lg-1">
                                                <label for="m2" class="col-form-label">M2:</label>
                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="m2" id="m2" disabled>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="largo" class="col-form-label">Largo:</label>
                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="largo" id="largo" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="ancho" class="col-form-label">Ancho:</label>
                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="ancho" id="ancho" disabled>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="alto" class="col-form-label">Alto:</label>
                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="alto" id="alto" disabled>
                                                </div>
                                            </div>


                                            <div class="col-lg-2">
                                                <label for="ubicacionm" class="col-form-label">Ubicacion:</label>
                                                <div class="input-group input-group-sm">

                                                    <input type="text" class="form-control" name="ubicacionm" id="ubicacionm" disabled>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="cantidad" class="col-form-label">Cantidad:</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="hidden" class="form-control" name="cantidaddis" id="cantidaddis">
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


                                <div class="row">

                                    <div class="col-lg-12 mx-auto">

                                        <div class="table-responsive" style="padding:5px;">

                                            <table name="tablaDet" id="tablaDet" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                <thead class="text-center bg-gradient-primary">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Id Item</th>
                                                        <th>Id Material</th>
                                                        <th>Clave</th>
                                                        <th>Material</th>
                                                        <th>Formato</th>
                                                        <th>Largo</th>
                                                        <th>Ancho</th>
                                                        <th>Alto</th>
                                                        <th>M2</th>
                                                        <th>Id Umedida</th>
                                                        <th>U. Medida</th>
                                                        <th>Ubicación</th>
                                                        <th>Cantidad</th>
                                                        <th>Acciones</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                      $consultadeto = "SELECT * FROM vdetalle_ord where folio_ord='$folioorden' and estado_deto=1 order by id_reg";
                                                      $resultadodeto = $conexion->prepare($consultadeto);
                                                      $resultadodeto->execute();
                                                      $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($datadeto as $rowdet) {
                                                    ?>
                                                        <tr>
                                                        <td><?php echo $rowdet['id_reg'] ?></td>
                                                            <td><?php echo $rowdet['id_item'] ?></td>
                                                            <td><?php echo $rowdet['id_mat'] ?></td>
                                                            <td><?php echo $rowdet['clave_item'] ?></td>
                                                            <td><?php echo $rowdet['nom_item'] ?></td>
                                                            <td><?php echo $rowdet['formato'] ?></td>
                                                            <td><?php echo $rowdet['largo_mat'] ?></td>
                                                            <td><?php echo $rowdet['ancho_mat'] ?></td>
                                                            <td><?php echo $rowdet['alto_mat'] ?></td>
                                                            <td><?php echo $rowdet['m2_mat'] ?></td>
                                                            <td><?php echo $rowdet['id_umedida'] ?></td>
                                                            <td><?php echo $rowdet['nom_umedida'] ?></td>
                                                            <td><?php echo $rowdet['ubi_mat'] ?></td>
                                                            <td><?php echo $rowdet['cant_mat'] ?></td>
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

            <!-- Default box -->
            <div class="modal fade" id="modalMat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR MATERIAL</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaMat" id="tablaMat" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center">
                                    <tr>

                                        <th>Id Item</th>
                                        <th>Id Material</th>
                                        <th>Clave</th>
                                        <th>Material</th>
                                        <th>Formato</th>
                                        <th>Largo</th>
                                        <th>Ancho</th>
                                        <th>Alto</th>
                                        <th>M2</th>
                                        <th>Id Umedida</th>
                                        <th>U. Medida</th>
                                        <th>Ubicación</th>
                                        <th>Cant. Disp.</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datamat as $datc) {
                                    ?>
                                        <tr>

                                            <td><?php echo $datc['id_item'] ?></td>
                                            <td><?php echo $datc['id_mat'] ?></td>
                                            <td><?php echo $datc['clave_item'] ?></td>
                                            <td><?php echo $datc['nom_item'] ?></td>
                                            <td><?php echo $datc['nom_mat'] ?></td>
                                            <td><?php echo $datc['largo_mat'] ?></td>
                                            <td><?php echo $datc['ancho_mat'] ?></td>
                                            <td><?php echo $datc['alto_mat'] ?></td>
                                            <td><?php echo $datc['m2_mat'] ?></td>
                                            <td><?php echo $datc['id_umedida'] ?></td>
                                            <td><?php echo $datc['nom_umedida'] ?></td>
                                            <td><?php echo $datc['ubi_mat'] ?></td>
                                            <td><?php echo $datc['cant_mat'] ?></td>
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
<script src="fjs/orden.js?v=<?php echo(rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>