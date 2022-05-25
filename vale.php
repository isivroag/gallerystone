<?php
$pagina = "vale";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);
$usuario=$_SESSION['s_nombre'];

if ($folio != "") {

    $opcion = 2;
    $consulta = "SELECT * FROM vale where folio_vale='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio = $dt['folio_vale'];

        $fecha = $dt['fecha_vale'];
        $usuario_entrega = $dt['usuario_entrega'];
        $usuario_recibe = $dt['usuario_recibe'];
        $fecha_cierre = $dt['fecha_cierre'];
        $firma_entregado = $dt['firma_entregado'];
        $firma_recibido = $dt['firma_recibido'];
        $obs=$dt['obs'];
    }





    $message = "";
} else {

    $opcion=1;

    $consultatmp = "SELECT * FROM vale WHERE estado_vale='0' ORDER BY folio_vale DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    if ($resultadotmp->rowCount() >= 1) {
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    } else {

        // INSERTAR FOLIO NUEVO

        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO vale (fecha_vale,estado,fecha_cierre,usuario) 
        VALUES('$fecha','INICIADO','2000-01-01','$usuario')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();


        $consultatmp = "SELECT * FROM vale WHERE estado_vale='0' and estado='INICIADO' ORDER BY folio_vale DESC LIMIT 1";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    }




    foreach ($datatmp as $dt) {
        $folio = $dt['folio_vale'];

        $fecha = $dt['fecha_vale'];
        $usuario_entrega = $dt['usuario_entrega'];
        $usuario_recibe = $dt['usuario_recibe'];
        $fecha_cierre = $dt['fecha_cierre'];
        $firma_entregado = $dt['firma_entregado'];
        $firma_recibido = $dt['firma_recibido'];
        $obs=$dt['obs'];
    }

}

$cntades = "SELECT * FROM herramienta where estado_her=1 order by id_her";
$resdes = $conexion->prepare($cntades);
$resdes->execute();
$datades = $resdes->fetchAll(PDO::FETCH_ASSOC);



$consultac = "SELECT * FROM personal WHERE estado_per=1 ORDER BY id_per";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datau = $resultadoc->fetchAll(PDO::FETCH_ASSOC);



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
                <h1 class="card-title mx-auto">Vale de Entrega/Recepción de Herramienta</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">

                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-purple btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>


                    </div>
                </div>

                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content" disab>

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-purple " style="margin:0px;padding:8px">

                                <h1 class="card-title ">Información General</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                        <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo $opcion; ?>">
                                            <label for="folio" class="col-form-label">Folio:</label>

                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo $folio; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha Cierre:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo "2000-01-01"; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Entregado:</label>
                                            <input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo $firma_entregado; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Recibido:</label>
                                            <input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo $firma_recibido; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-sm-center">


                                    <div class="col-lg-3">
                                        <div class="form-group input-group-sm auto">
                                            <label for="umedida" class="col-form-label">Creado Por (ENTREGA):</label>
                                            <select class="form-control" name="umedida" id="umedida">
                                                <?php
                                                foreach ($datau as $dtu) {
                                                ?>
                                                    <option id="<?php echo $dtu['id_per'] ?>" value="<?php echo $dtu['nom_per'] ?>"> <?php echo $dtu['nom_per'] ?></option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group input-group-sm auto">
                                            <label for="umedida" class="col-form-label">Recibido Por:</label>
                                            <select class="form-control" name="umedida" id="umedida">
                                                <?php
                                                foreach ($datau as $dtu) {
                                                ?>
                                                    <option id="<?php echo $dtu['id_per'] ?>" value="<?php echo $dtu['nom_per'] ?>"> <?php echo $dtu['nom_per'] ?></option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>



                                </div>

                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="concepto" class="col-form-label">Observaciones:</label>
                                            <textarea rows="2" class="form-control" name="concepto" id="concepto"><?php echo $obs; ?></textarea>
                                        </div>

                                    </div>



                                </div>

                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-12">
                                        <div class="card borde-titulazul">

                                            <div class="card-header fondopur " style="margin:0px;padding:8px">
                                                <div class="card-tools" style="margin:0px;padding:0px;">


                                                </div>
                                                <h1 class="card-title text-light">Herramienta</h1>
                                                <div class="card-tools" style="margin:0px;padding:0px;">


                                                </div>
                                            </div>

                                            <div class="card-body" style="margin:0px;padding:3px;">

                                                <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                                                    <div class="card-header " style="margin:0px;padding:8px;">

                                                        <button type="button" class="btn bg-gradient-purple btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                            Agregar Herramienta <i class="fas fa-plus"></i>
                                                        </button>

                                                    </div>

                                                    <div class="card-body " style="margin:0px;padding:2px 5px;">
                                                        <div class="row justify-content-sm-center">

                                                            <div class="col-lg-4">
                                                                <div class="input-group input-group-sm">

                                                                    <input type="hidden" class="form-control" name="idinsumodes" id="idinsumodes">




                                                                    <label for="insumodes" class="col-form-label">Herramienta:</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text" class="form-control" name="insumodes" id="insumodes" disabled>
                                                                        <span class="input-group-append">
                                                                            <button id="btnInsumodes" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                                        </span>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label for="clavedes" class="col-form-label">Clave:</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" name="clavedes" id="clavedes" disabled>
                                                                </div>
                                                            </div>



                                                            <div class="col-lg-2">
                                                                <label for="cantidadides" class="col-form-label">Cantidad:</label>
                                                                <div class="input-group input-group-sm">
                                                                <input type="hidden" class="form-control" name="cantidaddisponible" id="cantidaddisponible" disabled>
                                                                    <input type="text" class="form-control" name="cantidadides" id="cantidadides" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-1 justify-content-center">
                                                                <label for="" class="col-form-label">Acción:</label>
                                                                <div class="input-group-append input-group-sm justify-content-center d-flex">
                                                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Agregar Item">
                                                                        <button type="button" id="btnagregarides" name="btnagregarides" class="btn btn-sm bg-gradient-orange" value="btnGuardari"><i class="fas fa-plus-square"></i></button>
                                                                    </span>
                                                                    <span class="d-inline-block" tabindex="1" data-toggle="tooltip" title="Limpiar">
                                                                        <button type="button" id="btlimpiarides" name="btlimpiarides" class="btn btn-sm bg-gradient-purple" value="btnlimpiari"><i class="fas fa-brush"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="row">

                                                    <div class="col-lg-12 mx-auto">
                                                        <div class="table-responsive" style="padding:5px;">
                                                            <table name="tablaDetIndes" id="tablaDetIndes" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                                <thead class="text-center bg-gradient-purple">
                                                                    <tr>
                                                                        <th>Id</th>
                                                                        <th>Id Herramienta</th>
                                                                        <th>Clave </th>
                                                                        <th>Herramienta </th>
                                                                        <th>Cantidad</th>
                                                                        <th>Obs</th>
                                                                        
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $consultadeto = "SELECT * FROM vvale_detalle where folio_vale='$folio' and estado_reg=1 order by id_reg";
                                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                                    $resultadodeto->execute();
                                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($datadeto as $rowdet) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $rowdet['id_reg'] ?></td>
                                                                            <td><?php echo $rowdet['id_her'] ?></td>
                                                                            <td><?php echo $rowdet['clave_her'] ?></td>
                                                                            <td><?php echo $rowdet['nom_her'] ?></td>
                                                                            <td><?php echo $rowdet['cantidad_her'] ?></td>
                                                                            <td><?php echo $rowdet['obs'] ?></td>
                                                                            
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

        <!-- Default box -->
        <div class="modal fade" id="modalDes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-md" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title" id="exampleModalLabel">BUSCAR HERRAMIENTA</h5>

                    </div>
                    <br>
                    <div class="table-hover table-responsive w-auto" style="padding:15px">
                        <table name="tablaDes" id="tablaDes" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                            <thead class="text-center bg-gradient-primary">
                                <tr>

                                    <th>Id Herramienta</th>
                                    <th>Clave</th>
                                    <th>Herramienta</th>
                                    <th>Cantidad</th>
                                    <th>Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($datades as $datd) {
                                ?>
                                    <tr>

                                        <td><?php echo $datd['id_her'] ?></td>
                                        <td><?php echo $datd['clave_her'] ?></td>
                                        <td><?php echo $datd['nom_her'] ?></td>
                                        <td><?php echo $datd['cant_her'] ?></td>
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
<script src="fjs/vale.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>