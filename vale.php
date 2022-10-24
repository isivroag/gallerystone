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
$usuario = $_SESSION['s_nombre'];

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
        $obs = $dt['obs'];
        $orden = $dt['folio_orden'];
    }





    $message = "";
} else {

    $opcion = 1;

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
        $obs = $dt['obs'];
        $orden = $dt['folio_orden'];
    }
}

$cntades = "SELECT * FROM herramienta where estado_her=1 order by id_her";
$resdes = $conexion->prepare($cntades);
$resdes->execute();
$datades = $resdes->fetchAll(PDO::FETCH_ASSOC);


$cntades = "SELECT * FROM desechable where estado_des=1 order by id_des";
$resdes = $conexion->prepare($cntades);
$resdes->execute();
$datains = $resdes->fetchAll(PDO::FETCH_ASSOC);


$consultac = "SELECT * FROM personal WHERE estado_per=1 ORDER BY id_per";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datau = $resultadoc->fetchAll(PDO::FETCH_ASSOC);


$cntacaja = "SELECT * FROM cajah WHERE estado_cajah=1 and bloqueado=0 ORDER BY id_cajah";
$rescaja = $conexion->prepare($cntacaja);
$rescaja->execute();
$datacaja = $rescaja->fetchAll(PDO::FETCH_ASSOC);



$cntaord = "SELECT * FROM vorden WHERE edo_ord='COLOCACION' ORDER BY folio_ord";
$resord = $conexion->prepare($cntaord);
$resord->execute();
$dataord = $resord->fetchAll(PDO::FETCH_ASSOC);



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-purple text-light">
                <h1 class="card-title mx-auto">Vale de Entrega/Recepción de Herramienta</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <?php //if ($opcion == 1) { 
                        ?>

                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>

                        <?php // } 
                        ?>
                    </div>
                </div>

                <br>



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
                                    <div class="col-sm-4">

                                    </div>




                                </div>
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folioord" class="col-form-label">Folio Orden:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="folioord" id="folioord" autocomplete="off" placeholder="Folio Orden" value="<?php echo $orden; ?>">
                                                <span class="input-group-append">
                                                    <button id="borden" type="button" class="btn btn-sm btn-secondary"><i class="fas fa-search" aria-hidden="true"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                            <input type="hidden" class="form-control" name="entregado" id="entregado" value="<?php echo $firma_entregado; ?>" disabled>
                                            <input type="hidden" class="form-control" name="recibido" id="recibido" value="<?php echo $firma_recibido; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fechac" class="col-form-label">Fecha Cierre:</label>
                                            <input type="date" class="form-control" name="fechac" id="fechac" value="<?php echo $fecha_cierre; ?>" disabled>
                                        </div>
                                    </div>

                                </div>
                                <div class="row justify-content-sm-center">

                                    <div class="col-lg-3">
                                        <div class="form-group input-group-sm auto">
                                            <label for="creador" class="col-form-label">Creado Por (ENTREGA):</label>
                                            <select class="form-control" name="creador" id="creador">
                                                <?php
                                                foreach ($datau as $dtu) {
                                                ?>
                                                    <option id="<?php echo $dtu['id_per'] ?>" value="<?php echo $dtu['nom_per'] ?>" <?php echo $dtu['nom_per'] == $usuario_entrega ? "selected " : "" ?>> <?php echo $dtu['nom_per'] ?></option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group input-group-sm auto">
                                            <label for="receptor" class="col-form-label">Recibido Por:</label>
                                            <select class="form-control" name="receptor" id="receptor">
                                                <?php
                                                foreach ($datau as $dtu) {
                                                ?>
                                                    <option id="<?php echo $dtu['id_per'] ?>" value="<?php echo $dtu['nom_per'] ?>" <?php echo $dtu['nom_per'] == $usuario_recibe ? "selected " : "" ?>> <?php echo $dtu['nom_per'] ?></option>

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
                                            <label for="obs" class="col-form-label">Observaciones:</label>
                                            <textarea rows="2" class="form-control" name="obs" id="obs"><?php echo $obs; ?></textarea>
                                        </div>

                                    </div>



                                </div>

                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-12">
                                        <div class="card borde-titulazul">

                                            <div class="card-header bg-purple " style="margin:0px;padding:8px">
                                                <div class="card-tools" style="margin:0px;padding:0px;">


                                                </div>
                                                <h1 class="card-title  text-light">DETALLE DE HERRAMIENTAS-INSUMOS</h1>
                                                <div class="card-tools" style="margin:0px;padding:0px;">


                                                </div>
                                            </div>

                                            <div class="card-body" style="margin:0px;padding:3px;">
                                                <?php if ($opcion) { ?>
                                                    <div class="card card-widget " style="margin:2px;padding:5px;">

                                                        <div class="card-body accordion" id="addinsumo" style=" margin:0px;padding:2px 5px;">
                                                            <div class="row justify-content-between " style="margin:2px;padding:5px;">
                                                                <button type="button" class="btn bg-gradient-purple btn-sm" data-toggle="collapse" aria-expanded="false" aria-controls="addinsumoin" href='#addinsumoin'>
                                                                    Agregar Herramienta <i class="fas fa-plus"></i>
                                                                </button>

                                                                <button type="button" class="btn bg-gradient-info btn-sm" data-toggle="collapse" aria-expanded="false" aria-controls="addinsumoin" href='#addinsumoin2'>
                                                                    Agregar Insumo <i class="fas fa-plus"></i>
                                                                </button>

                                                                <button type="button" id="btncaja" class="btn bg-gradient-primary btn-sm">
                                                                    Agregar Caja <i class="fas fa-plus"></i>
                                                                </button>

                                                            </div>


                                                            <div class="row justify-content-sm-center collapse" id="addinsumoin" data-parent="#addinsumo">

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

                                                            <div class="row justify-content-sm-center collapse" id="addinsumoin2" data-parent="#addinsumo">

                                                                <div class="col-lg-4">
                                                                    <div class="input-group input-group-sm">

                                                                        <input type="hidden" class="form-control" name="idinsumodes2" id="idinsumodes2">




                                                                        <label for="insumodes2" class="col-form-label">Insumo:</label>
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="text" class="form-control" name="insumodes2" id="insumodes2" disabled>
                                                                            <span class="input-group-append">
                                                                                <button id="btnInsumodes2" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                                            </span>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    <label for="clavedes2" class="col-form-label">Clave:</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text" class="form-control" name="clavedes2" id="clavedes2" disabled>
                                                                    </div>
                                                                </div>



                                                                <div class="col-lg-2">
                                                                    <label for="cantidadides2" class="col-form-label">Cantidad:</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="hidden" class="form-control" name="cantidaddisponible2" id="cantidaddisponible2" disabled>
                                                                        <input type="text" class="form-control" name="cantidadides2" id="cantidadides2" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-1 justify-content-center">
                                                                    <label for="" class="col-form-label">Acción:</label>
                                                                    <div class="input-group-append input-group-sm justify-content-center d-flex">
                                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Agregar Item">
                                                                            <button type="button" id="btnagregarides2" name="btnagregarides2" class="btn btn-sm bg-gradient-orange" value="btnGuardari2"><i class="fas fa-plus-square"></i></button>
                                                                        </span>
                                                                        <span class="d-inline-block" tabindex="1" data-toggle="tooltip" title="Limpiar">
                                                                            <button type="button" id="btlimpiarides2" name="btlimpiarides2" class="btn btn-sm bg-gradient-purple" value="btnlimpiari2"><i class="fas fa-brush"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                <?php } ?>

                                                <div class="row">

                                                    <div class="col-lg-12 mx-auto">
                                                        <div class="table-responsive" style="padding:5px;">
                                                            <table name="tablaDetIndes" id="tablaDetIndes" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                                <thead class="text-center bg-gradient-purple">
                                                                    <tr>
                                                                        <th>Reg</th>
                                                                        <th>Id</th>
                                                                        <th>Tipo</th>
                                                                        <th>Clave </th>
                                                                        <th>Herramienta/Insumo </th>
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
                                                                            <td><?php echo $rowdet['tipo'] ?></td>
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


            </div>


            </form>


        </div>





    </section>


    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalDes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-purple">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR HERRAMIENTA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaDes" id="tablaDes" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-purple">
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



    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalCaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR CAJA</h5>

                        </div>
                        <br>

                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaCaja" id="tablaCaja" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-primary">
                                    <tr>

                                        <th>Id Caja</th>
                                        <th>Clave</th>
                                        <th>Descripcion</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datacaja as $row) {
                                    ?>
                                        <tr>

                                            <td><?php echo $row['id_cajah'] ?></td>
                                            <td><?php echo $row['clave_cajah'] ?></td>
                                            <td><?php echo $row['nom_cajah'] ?></td>
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
            <div class="modal fade" id="modalOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-purple">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR ORDEN</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaOrden" id="tablaOrden" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-purple">
                                    <tr>

                                        <th>Folio Orden</th>
                                        <th>Cliente</th>
                                        <th>Proyecto</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dataord as $datord) {
                                    ?>
                                        <tr>

                                            <td><?php echo $datord['folio_ord'] ?></td>
                                            <td><?php echo $datord['nombre'] ?></td>
                                            <td><?php echo $datord['concepto_vta'] ?></td>
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
            <div class="modal fade" id="modalDes2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-info">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR INSUMOS</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaDes2" id="tablaDes2" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-info">
                                    <tr>

                                        <th>Id Insumo</th>
                                        <th>Clave</th>
                                        <th>Insumo</th>
                                        <th>Cantidad</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datains as $datd) {
                                    ?>
                                        <tr>

                                            <td><?php echo $datd['id_des'] ?></td>
                                            <td><?php echo $datd['clave_des'] ?></td>
                                            <td><?php echo $datd['nom_des'] ?></td>
                                            <td><?php echo $datd['cant_des'] ?></td>
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