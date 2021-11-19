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


    $consultatmp = "SELECT * FROM cxp WHERE tokenid='$tokenid' and estado='0' and tipo='CXPINSUMO' ORDER BY folio_cxp DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    if ($resultadotmp->rowCount() >= 1) {
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    } else {

        // INSERTAR FOLIO NUEVO

        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO cxp (tokenid,fecha,fecha_limite,tipo,subtotal,iva,total,saldo) VALUES('$tokenid','$fecha','$fecha','CXPINSUMO','0','0','0','0')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();


        $consultatmp = "SELECT * FROM cxp WHERE tokenid='$tokenid' and estado='0' and tipo='CXPINSUMO' ORDER BY folio_cxp DESC LIMIT 1";
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

$cntains = "SELECT * FROM vconsumible where estado_cons=1 order by id_cons";
$resins = $conexion->prepare($cntains);
$resins->execute();
$datains = $resins->fetchAll(PDO::FETCH_ASSOC);

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
                            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>

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

                                            <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>"  onkeypress="return filterFloat(event,this);">
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

                                            <input type="text" class="form-control text-right" name="iva" id="iva" value="<?php echo $iva; ?>" disabled  onkeypress="return filterFloat(event,this);">
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

                                            <input type="text" class="form-control text-right" name="total" id="total" value="<?php echo $total; ?>" disabled  onkeypress="return filterFloat(event,this);">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>





                <!-- INSUMOS USADOS-->
                <div class="card card-widget borde-titulinfo" style="margin-bottom:5px;">

                    <div class="card-header fondoinfo " style="margin:0px;padding:8px">
                        <div class="card-tools" style="margin:0px;padding:0px;">


                        </div>
                        <h1 class="card-title text-light">DETALLE DE COMPRA DE INSUMOS</h1>
                        <div class="card-tools" style="margin:0px;padding:0px;">


                        </div>
                    </div>

                    <div class="card-body" style="margin:0px;padding:3px;">
                        <?php if ($opcion == 1) { ?>
                            <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                                <div class="card-header " style="margin:0px;padding:8px;">

                                    <button type="button" class="btn bg-gradient-info btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        Agregar Insumo <i class="fas fa-plus"></i>
                                    </button>

                                </div>

                                <div class="card-body " style="margin:0px;padding:2px 5px;">
                                    <div class="row justify-content-sm-center">

                                        <div class="col-lg-4">
                                            <div class="input-group input-group-sm">

                                                <input type="hidden" class="form-control" name="idinsumo" id="idinsumo">




                                                <label for="insumo" class="col-form-label">Insumo:</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" name="insumo" id="insumo" disabled>
                                                    <span class="input-group-append">
                                                        <button id="btnInsumo" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-2">

                                            <label for="presentacion" class="col-form-label">Presentación</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control " name="presentacion" id="presentacion" disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-1">
                                            <input type="hidden" class="form-control" name="id_umedida" id="id_umedida">
                                            <label for="nom_umedidain" class="col-form-label">U Medida:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control " name="nom_umedidain" id="nom_umedidain" disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="costou" class="col-form-label">Costo:</label>
                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="costou" id="costou" disabled  onkeypress="return filterFloat(event,this);">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="cantidadi" class="col-form-label">Cantidad:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="cantidaddisi" id="cantidaddisi">
                                                <input type="text" class="form-control" name="cantidadi" id="cantidadi" disabled  onkeypress="return filterFloat(event,this);">
                                            </div>
                                        </div>

                                        <div class="col-lg-1 justify-content-center">
                                            <label for="" class="col-form-label">Acción:</label>
                                            <div class="input-group-append input-group-sm justify-content-center d-flex">
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Agregar Item">
                                                    <button type="button" id="btnagregari" name="btnagregari" class="btn btn-sm bg-gradient-orange" value="btnGuardari"><i class="fas fa-plus-square"></i></button>
                                                </span>
                                                <span class="d-inline-block" tabindex="1" data-toggle="tooltip" title="Limpiar">
                                                    <button type="button" id="btlimpiari" name="btlimpiari" class="btn btn-sm bg-gradient-purple" value="btnlimpiari"><i class="fas fa-brush"></i></button>
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php  } ?>
                        <div class="row">

                            <div class="col-lg-12 mx-auto">

                                <div class="table-responsive" style="padding:5px;">

                                    <table name="tablaDetIn" id="tablaDetIn" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                        <thead class="text-center bg-gradient-info">
                                            <tr>
                                                <th>Id</th>
                                                <th>Id Insumo</th>
                                                <th>Material</th>
                                                <th>presentacion</th>
                                                <th>U. Medida</th>
                                                <th>Cantidad</th>
                                                <th>Costo</th>
                                                <th>Importe</th>
                                                <th>Acciones</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $consultadeto = "SELECT * FROM vdetallecxp_insumo where folio_cxp='$folio' and estado_reg=1 order by id_reg";
                                            $resultadodeto = $conexion->prepare($consultadeto);
                                            $resultadodeto->execute();
                                            $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($datadeto as $rowdet) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $rowdet['id_reg'] ?></td>
                                                    <td><?php echo $rowdet['id_cons'] ?></td>
                                                    <td><?php echo $rowdet['nom_cons'] ?></td>
                                                    <td class="text-center"><?php echo $rowdet['presentacion'] ?></td>
                                                    <td><?php echo $rowdet['nom_umedida'] ?></td>
                                                    <td class="text-center"><?php echo $rowdet['cant_cons'] ?></td>
                                                    <td class="text-center"><?php echo $rowdet['costo_cons'] ?></td>
                                                    <td class="text-center"><?php echo $rowdet['subtotal'] ?></td>
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
                <!-- TERMINA INSUMOS USADOS -->
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

    <!-- TABLA INSUMOS -->
    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalIns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR INSUMO</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaIns" id="tablaIns" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-primary">
                                    <tr>

                                        <th>Id Insumo</th>
                                        <th>Insumo</th>
                                        <th>Presentacion</th>
                                        <th>U. Medida</th>

                                        <th>Cantidad</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datains as $datc) {
                                    ?>
                                        <tr>

                                            <td><?php echo $datc['id_cons'] ?></td>
                                            <td><?php echo $datc['nom_cons'] ?></td>
                                            <td class="text-center"><?php echo $datc['presentacion'] ?></td>

                                            <td><?php echo $datc['nom_umedida'] ?></td>

                                            <td class="text-center"><?php echo $datc['cant_cons'] ?></td>
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

    <!-- TERMINA TABLA INSUMOS -->


    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/comprainsumo.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>