<?php
$pagina = "cxp";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$message="";
$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);

if ($folio != "") {

    $opcion = 2;
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


    //BUSCAR CUENTA ABIERTA


    $consultatmp = "SELECT * FROM cxp WHERE tokenid='$tokenid' and estado='0' and tipo='CXPMATERIAL' and estado_cxp=1 ORDER BY folio_cxp DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    if ($resultadotmp->rowCount() >= 1) {
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    } else {

        // INSERTAR FOLIO NUEVO

        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO cxp (tokenid,fecha,fecha_limite,tipo,subtotal,iva,total,saldo) VALUES('$tokenid','$fecha','$fecha','CXPMATERIAL','0','0','0','0')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();


        $consultatmp = "SELECT * FROM cxp WHERE tokenid='$tokenid' and estado='0' and tipo='CXPMATERIAL' ORDER BY folio_cxp DESC LIMIT 1";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    }





    foreach ($datatmp as $dt) {

        $folio =  $dt['folio_cxp'];;
        $opcion = 1;
        $fecha =   $dt['fecha'];;
        $fecha_limite =  $dt['fecha_limite'];;
        $id_prov = "";
        $nombre = "";
        $id_partida = "";
        $nom_partida = "";
        $concepto = "";
        $facturado = "0";
        $referencia = "";
        $subtotal = 0;
        $total = 0;
        $iva = 0;
        $saldo = 0;
    }
}

$consultac = "SELECT * FROM proveedor WHERE estado_prov=1 ORDER BY id_prov";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

$consultacon = "SELECT * FROM partida WHERE estado_partida=1 ORDER BY id_partida";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);

$cntamat = "SELECT * FROM vmaterial where estado_mat=1  order by id_mat";
$resmat = $conexion->prepare($cntamat);
$resmat->execute();
$datamat = $resmat->fetchAll(PDO::FETCH_ASSOC);

$consultam = "SELECT id_item,clave_item,nom_item,claveinv FROM item WHERE estado_item=1 and tipo_item='Material' ORDER BY id_item";
$resultadom = $conexion->prepare($consultam);
$resultadom->execute();
$dataitem = $resultadom->fetchAll(PDO::FETCH_ASSOC);

$consultau = "SELECT * FROM umedida WHERE estado_umedida=1 ORDER BY id_umedida";
$resultadou = $conexion->prepare($consultau);
$resultadou->execute();
$datau = $resultadou->fetchAll(PDO::FETCH_ASSOC);

$consultaest = "SELECT * FROM estante WHERE estado_estante=1 ORDER BY id_estante";
$resultadoest = $conexion->prepare($consultaest);
$resultadoest->execute();
$dataest = $resultadoest->fetchAll(PDO::FETCH_ASSOC);



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<style>
    .borde-titulogris {
        border-left: grey;
        border-style: outset;
        ;
    }

    .fondogris {
        background-color: rgba(183, 185, 187, .8);
    }

    .borde-titulazul {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondoazul {
        background-color: rgba(117, 74, 195, 0.8);
    }

    .borde-titulinfo {
        border-left: rgb(23, 162, 184);
        border-style: outset;
        ;
    }

    .fondoinfo {
        background-color: rgba(23, 162, 184, .8);
    }

    .borde-titulpur {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondopur {
        background-color: rgba(117, 74, 195, .8);
    }




    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    .div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    .cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    .textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- FOMRULARIO ALTA CXP -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-purple text-light">
                <h1 class="card-title mx-auto">Cuentas Por Pagar</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($opcion == 1) { ?>
                            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar" <?php echo $opcion == 2 ? 'disabled' : '' ?>><i class="far fa-save"></i> Guardar</button>
                        <?php } ?>

                    </div>
                </div>

                <br>



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
                                                <?php if ($opcion == 1) { ?>
                                                    <span class="input-group-append">
                                                        <button id="bproveedor" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                                                        <button id="bproveedorplus" type="button" class="btn btn-success "><i class="fas fa-plus-square"></i></button>
                                                    </span>
                                                <?php } ?>
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
                                                <?php if ($opcion == 1) { ?>
                                                    <span class="input-group-append">
                                                        <button id="bpartida" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                                                        <button id="bpartidaplus" type="button" class="btn btn-success "><i class="fas fa-plus-square"></i></button>
                                                    </span>
                                                <?php } ?>
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
                                                    <input type="checkbox" class="" name="cfactura" id="cfactura" <?php echo ($facturado == 1 ? 'checked' : '') ?>>
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

                                            <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>" onkeypress="return filterFloat(event,this);">
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

                                            <input type="text" class="form-control text-right" name="iva" id="iva" value="<?php echo $iva; ?>" disabled onkeypress="return filterFloat(event,this);">
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

                                            <input type="text" class="form-control text-right" name="total" id="total" value="<?php echo $total; ?>" onkeypress="return filterFloat(event,this);" disabled>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>



                <!-- MATERIALES USADOS-->
                <div class="card borde-titulazul">

                    <div class="card-header  fondoazul ">

                        <h1 class="card-title text-light" sytle="padding:auto">DETALLE DE COMPRA DE MATERIALES </h1>
                        <div class="card-tools" style="margin:0px;padding:0px;">


                        </div>
                    </div>

                    <div class="card-body">
                        <?php if ($opcion == 1) { ?>
                            <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                                <div class="card-header " style="margin:0px;padding:8px;">



                                    <div class="row">

                                        <div class="col-sm-2">


                                       <!-- <button type="button" class="btn bg-gradient-purple btn-sm" <?php echo $opcion == 2 ? 'disabled' : '' ?> data-card-widget="collapse" data-toggle="tooltip" title="Collapse"> -->

                                            <button type="button" id="butonagregarmat" name="butonagregarmat" class="btn bg-gradient-purple btn-sm" <?php echo $opcion == 2 ? 'disabled' : '' ?> >
                                                Agregar Material <i class="fas fa-plus"></i>
                                            </button>

                                        </div>
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
                                            <label for="costou" class="col-form-label">Costo Unitario:</label>
                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="costou" id="costou" disabled onkeypress="return filterFloat(event,this);">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="cantidad" class="col-form-label">Cantidad:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="cantidaddis" id="cantidaddis">
                                                <input type="text" class="form-control" name="cantidad" id="cantidad" disabled onkeypress="return filterFloat(event,this);" value=1 disabled>
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
                        <?php } ?>

                        <div class="row">

                            <div class="col-lg-12 mx-auto">

                                <div class="table-responsive" style="padding:5px;">

                                    <table name="tablaDet" id="tablaDet" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                        <thead class="text-center bg-gradient-purple">
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
                                                <th>Costo</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                                <th>Acciones</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $consultadeto = "SELECT * FROM vdetallecxp_mat where folio_cxp='$folio' and estado_reg=1 order by id_reg";
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
                                                    <td><?php echo $rowdet['costo_mat'] ?></td>
                                                    <td><?php echo $rowdet['cant_mat'] ?></td>
                                                    <td><?php echo $rowdet['subtotal'] ?></td>
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
                <!-- TERMINA MATERIALES USADOS -->
            </div>

        </div>
    </section>
    <!-- TERMINA ALTA CXP -->

    <!-- INICIA TABLA PROVEEDOR-->
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
    <!-- TERMINA TABLA PROVEEDOR-->

    <!-- INICIA TABLA PARTIDA -->
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
    <!-- TERMINA TABLA PARTIDA -->

    <!--TABLA MATERIALES-->
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
                            <table name="tablaMat" id="tablaMat" class="table table-sm table-striped table-bordered table-condensed" style="width:100%; font-size:12px">
                                <thead class="text-center bg-primary">
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
    <!-- TERMINA TABLA MATERIALES -->


<!--Formulario Alta de Material-->
    <section>
        <div class="modal fade" id="modalalta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-purple">
                        <h5 class="modal-title" id="exampleModalLabel">NUEVA PIEZAS</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="frmalta" action="" method="POST">
                            <div class="modal-body row mb-0 pb-0">

                                <div class="col-sm-7">
                                    <div class="form-group input-group-sm">
                                        <label for="itemalta" class="col-form-label">Tipo de Material:</label>

                                        <input type="hidden" class="form-control" name="iditemalta" id="iditemalta" autocomplete="off" placeholder="Material">

                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="itemalta" id="itemalta" autocomplete="off" placeholder="Material">
                                            <span class="input-group-append">
                                                <button id="bitem" type="button" class="btn btn-sm bg-purple"><i class="fas fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="clave_alta" class="col-form-label">Clave:</label>
                                        <input type="text" class="form-control" name="clave_alta" id="clave_alta" autocomplete="off" placeholder="Clave">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="num_mat" class="col-form-label"># Placa:</label>
                                        <input type="text" class="form-control" name="num_mat" id="num_mat" autocomplete="off" placeholder="# Placa">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="nom_matalta" class="col-form-label">Descripción:</label>
                                        <input type="text" class="form-control" name="nom_matalta" id="nom_matalta" autocomplete="off" placeholder="Descripción">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm auto">
                                        <label for="umedidaalta" class="col-form-label">Unidad:</label>
                                        <select class="form-control" name="umedidaalta" id="umedidaalta">
                                            <?php
                                            foreach ($datau as $dtu) {
                                            ?>
                                                <option id="<?php echo $dtu['id_umedida'] ?>" value="<?php echo $dtu['id_umedida'] ?>"> <?php echo $dtu['nom_umedida'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="metrosalta" class="col-form-label">M2:</label>
                                        <input type="text" class="form-control" name="metrosalta" id="metrosalta" autocomplete="off" placeholder="Metros 2" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group input-group-sm auto">
                                        <label for="ubicacion" class="col-form-label">Ubicación:</label>
                                        <select class="form-control" name="ubicacion" id="ubicacion">
                                            <?php
                                            foreach ($dataest as $rowest) {
                                            ?>
                                                <option id="<?php echo $rowest['id_estante'] ?>" value="<?php echo $rowest['nom_estante'] ?>"> <?php echo $rowest['nom_estante'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="cantidadalta" class="col-form-label">Cant:</label>
                                        <input type="text" class="form-control" name="cantidadalta" id="cantidadalta" autocomplete="off" placeholder="Cantidad" value="0" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="largoalta" class="col-form-label">Largo:</label>
                                        <input type="text" class="form-control" name="largoalta" id="largoalta" autocomplete="off" placeholder="Largo" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="altoalta" class="col-form-label">Alto:</label>
                                        <input type="text" class="form-control" name="altoalta" id="altoalta" autocomplete="off" placeholder="Alto" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="anchoalta" class="col-form-label">Espesor:</label>
                                        <input type="text" class="form-control" name="anchoalta" id="anchoalta" autocomplete="off" placeholder="Ancho" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="obsalta" class="col-form-label">Observaciones:</label>
                                        <textarea rows="2" class="form-control" name="obsalta" id="obsalta" placeholder="Observaciones"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-0 pd-0">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-4">
                                <label for="costoualta" class="col-form-label">Costo Unitario:</label>
                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="costoualta" id="costoualta"  onkeypress="return filterFloat(event,this);">
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
                        <button type="button" id="btnGuardaralta" name="btnGuardaralta" class="btn btn-success" value="btnGuardaralta"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<!--Fin Formulario Alta de Material-->

<!--Tabla Busqueda Item-->
    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-secondary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR ITEM</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaitem" id="tablaitem" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Clave</th>
                                        <th>Descripcion</th>
                                        <th>Clave Inv</th>

                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($dataitem as $rowm)
                                {
                                ?>
                                <tr>
                                <td><?php echo $rowm['id_item']?></td>
                                <td><?php echo $rowm['clave_item']?></td>
                                <td><?php echo $rowm['nom_item']?></td>
                                <td><?php echo $rowm['claveinv']?></td>
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
                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </div>
    </section>
<!--Fin Tabla Busqueda Item-->
    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/compramat.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>