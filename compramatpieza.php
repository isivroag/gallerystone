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


    $consultatmp = "SELECT * FROM cxp WHERE tokenid='$tokenid' and estado='0' and tipo='CXPPIEZA' and estado_cxp=1 ORDER BY folio_cxp DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    if ($resultadotmp->rowCount() >= 1) {
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    } else {

        // INSERTAR FOLIO NUEVO

        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO cxp (tokenid,fecha,fecha_limite,tipo,subtotal,iva,total,saldo) VALUES('$tokenid','$fecha','$fecha','CXPPIEZA','0','0','0','0')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();


        $consultatmp = "SELECT * FROM cxp WHERE tokenid='$tokenid' and estado='0' and tipo='CXPPIEZA' ORDER BY folio_cxp DESC LIMIT 1";
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




$cntamatpieza = "SELECT * FROM vmaterialpieza where estado_mat=1 and m2_mat>0 order by id_mat";
$resmatpieza = $conexion->prepare($cntamatpieza);
$resmatpieza->execute();
$datamatpieza = $resmatpieza->fetchAll(PDO::FETCH_ASSOC);
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
        border-left: rgb(233,71,146);
        border-style: outset;
        ;
    }

    .fondopur {
        background-color: rgba(233,71,146, .8);
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
            <div class="card-header bg-gradient-pink text-light">
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

                            <div class="card-header bg-gradient-pink " style="margin:0px;padding:8px">

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
                <div class="card borde-titulpur">

                    <div class="card-header bg-gradient-pink " style="margin:0px;padding:8px">
                        <div class="card-tools" style="margin:0px;padding:0px;">


                        </div>
                        <h1 class="card-title text-light">MATERIAL PIEZA</h1>
                        <div class="card-tools" style="margin:0px;padding:0px;">


                        </div>
                    </div>

                    <div class="card-body" style="margin:0px;padding:3px;">

                        <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                            <div class="card-header " style="margin:0px;padding:8px;">



                                <div class="row">

                                    <div class="col-sm-2">
                                        <button type="button" class="btn bg-pink btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            Agregar Material Pieza<i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body " style="margin:0px;padding:2px 5px;">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-5">
                                        <div class="input-group input-group-sm">

                                            <input type="hidden" class="form-control" name="clavematp" id="clavematp">
                                            <input type="hidden" class="form-control" name="iditemp" id="iditemp">




                                            <label for="material" class="col-form-label">Material Pieza:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="materialp" id="materialp" disabled>
                                                <span class="input-group-append">
                                                    <button id="btnMaterialp" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="clavep" class="col-form-label">Clave:</label>
                                        <div class="input-group input-group-sm">

                                            <input type="text" class="form-control" name="clavep" id="clavep" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="formatop" class="col-form-label">Formato:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="formatop" id="formatop" disabled>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row justify-content-sm-center">

                                 

                                    <div class="col-sm-1">
                                        <input type="hidden" class="form-control" name="id_umedidap" id="id_umedidap">
                                        <label for="nom_umedidap" class="col-form-label">U Medida:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control " name="nom_umedidap" id="nom_umedidap" disabled>
                                        </div>
                                    </div>





                                    <div class="col-sm-1">
                                        <label for="cantidaddisp" class="col-form-label">Cantidad Disp:</label>
                                        <div class="input-group input-group-sm">

                                            <input type="text" class="form-control" name="cantidaddisp" id="cantidaddisp" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="m2disp" class="col-form-label">M2 Disp:</label>
                                        <div class="input-group input-group-sm">

                                            <input type="text" class="form-control" name="m2disp" id="m2disp" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <label for="cantidadp" class="col-form-label">Cantidad:</label>
                                        <div class="input-group input-group-sm">

                                            <input type="text" class="form-control" name="cantidadp" id="cantidadp" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <label for="m2p" class="col-form-label">M2:</label>
                                        <div class="input-group input-group-sm">

                                            <input type="text" class="form-control" name="m2p" id="m2p" disabled>
                                        </div>
                                    </div>

                                    
                                    <div class="col-sm-2">
                                        <label for="costou" class="col-form-label">Costo:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="costou" id="costou" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-1 justify-content-center">
                                        <label for="" class="col-form-label">Acción:</label>
                                        <div class="input-group-append input-group-sm justify-content-center d-flex">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Agregar Item">
                                                <button type="button" id="btnagregarp" name="btnagregarp" class="btn btn-sm bg-gradient-orange" value="btnGuardar"><i class="fas fa-plus-square"></i></button>
                                            </span>
                                            <span class="d-inline-block" tabindex="1" data-toggle="tooltip" title="Limpiar">
                                                <button type="button" id="btlimpiarp" name="btlimpiarp" class="btn btn-sm bg-gradient-pink" value="btnlimpiar"><i class="fas fa-brush"></i></button>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="row">

                            <div class="col-lg-12 mx-auto">

                                <div class="table-responsive" style="padding:5px;">

                                    <table name="tablaDetp" id="tablaDetp" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                        <thead class="text-center bg-pink">
                                            <tr>
                                                <th>Id</th>
                                                <th>Id Item</th>
                                                <th>Id Material</th>
                                                <th>Clave</th>
                                                <th>Material</th>
                                                <th>Formato</th>
                                               
                                                <th>Id Umedida</th>
                                                <th>U. Medida</th>

                                                <th>Cantidad</th>
                                                <th>M2</th>
                                                <th>IMPORTE</th>
                                                <th>Acciones</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $consultadeto = "SELECT * FROM vdetallecxp_matpieza where folio_cxp='$folio' and estado_reg=1 order by id_reg";
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
                                                  
                                                    <td><?php echo $rowdet['id_umedida'] ?></td>
                                                    <td><?php echo $rowdet['nom_umedida'] ?></td>

                                                    <td class="text-center"><?php echo $rowdet['cant_mat'] ?></td>
                                                    <td class="text-center"><?php echo $rowdet['m2_mat'] ?></td>
                                                    <td class="text-right"><?php echo $rowdet['subtotal'] ?></td>
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
                        <div class="modal-header bg-gradient-pink">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PROVEEDOR</h5>

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
                        <div class="modal-header bg-gradient-pink">
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

    <!-- TABLA DESECHABLES -->
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
                                        <th>Herramienta</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datades as $datd) {
                                    ?>
                                        <tr>

                                            <td><?php echo $datd['id_her'] ?></td>
                                            <td><?php echo $datd['nom_her'] ?></td>
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
    <!-- TERMINA DESECHABLES -->
    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalMatp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-pink">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR MATERIAL PIEZA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaMatp" id="tablaMatp" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-pink">
                                    <tr>

                                        <th>Id Item</th>
                                        <th>Id Material</th>
                                        <th>Clave</th>
                                        <th>Material</th>
                                        <th>Formato</th>

                                        <th>M2 Disp</th>
                                        <th>Id Umedida</th>
                                        <th>U. Medida</th>
                                        <th>Ubicación</th>
                                        <th>Cant Disp</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datamatpieza as $datc) {
                                    ?>
                                        <tr>

                                            <td><?php echo $datc['id_item'] ?></td>
                                            <td><?php echo $datc['id_mat'] ?></td>
                                            <td><?php echo $datc['clave_item'] ?></td>
                                            <td><?php echo $datc['nom_item'] ?></td>
                                            <td><?php echo $datc['nom_mat'] ?></td>

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
    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/compramatpieza.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>