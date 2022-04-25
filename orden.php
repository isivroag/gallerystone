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

    $consultau = "SELECT * FROM umedida WHERE estado_umedida=1 ORDER BY id_umedida";
    $resultadou = $conexion->prepare($consultau);
    $resultadou->execute();
    $datau = $resultadou->fetchAll(PDO::FETCH_ASSOC);

    $consultacom = "SELECT * FROM complemento_ord WHERE id_ord='$folioorden' ORDER BY id_reg";
    $resultadocom = $conexion->prepare($consultacom);
    $resultadocom->execute();
    $datacom = $resultadocom->fetchAll(PDO::FETCH_ASSOC);



    $cntamat = "SELECT * FROM vmaterial where estado_mat=1 and m2_mat>0 order by id_mat";
    $resmat = $conexion->prepare($cntamat);
    $resmat->execute();
    $datamat = $resmat->fetchAll(PDO::FETCH_ASSOC);


    $cntains = "SELECT * FROM vconsumible where estado_cons=1 and tarjeta=0 order by id_cons";
    $resins = $conexion->prepare($cntains);
    $resins->execute();
    $datains = $resins->fetchAll(PDO::FETCH_ASSOC);

    $cntainstar = "SELECT * FROM vconsumible where estado_cons=1 and tarjeta=1 order by id_cons";
    $resinstar = $conexion->prepare($cntainstar);
    $resinstar->execute();
    $datainstar = $resinstar->fetchAll(PDO::FETCH_ASSOC);


    $cntades = "SELECT * FROM vdesechable where estado_des=1 order by id_des";
    $resdes = $conexion->prepare($cntades);
    $resdes->execute();
    $datades = $resdes->fetchAll(PDO::FETCH_ASSOC);
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
        border-left: rgb(0, 123, 255);
        border-style: outset;
        ;
    }

    .fondoazul {
        background-color: rgba(0, 123, 255, .8);
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


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-secondary">
                <h1 class="card-title mx-auto">ORDEN</h1>
            </div>

            <div class="card-body">



                <br>
                <div class="div_carga">

                    <img class="cargador" src="img/loader.gif" />
                    <span class=" textoc" id=""><strong>Cargando...</strong></span>
                </div>


                <!-- INICIO FORM -->
                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget collapsed-card" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-success " style="margin:0px;padding:8px">
                                <div class="card-tools" style="margin:0px;padding:0px;">


                                </div>
                                <h1 class="card-title ">Datos de la Venta</h1>
                                <div class="card-tools" style="margin:0px;padding:0px;">

                                    <button type="button" class="btn bg-gradient-success btn-sm " href="#cuerpo" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
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

                            <div class="card  ">
                                <div class="card-header bg-gradient-secondary" style="margin:0px;padding:8px">

                                    <h1 class="card-title ">DETALLE DE ORDEN</h1>

                                </div>

                                <div class="card-body" style="margin:0px;padding:3px;">

                                    <div class="card  borde-titulogris">
                                        <div class="card-header fondogris " style="margin:0px;padding:8px;">
                                            <h1 class="card-title ">Dellate Principal</h1>
                                            <div class="card-tools " style="margin:0px;padding:0px;">
                                                <button type="button" class="btn bg-secondary btn-sm " href="#principal" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                            </div>

                                        </div>
                                        <div class="card-body" id="pricipal">
                                            <div class="col-lg-12 mx-auto">

                                                <div class="table-responsive" style="padding:2px;">

                                                    <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%; font-size:15px">
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

                                    <div class="card  borde-titulogris">
                                        <div class="card-header fondogris " style="margin:0px;padding:8px">

                                            <h1 class="card-title ">Detalle Complementario</h1>
                                            <div class="card-tools" style="margin:0px;padding:0px;">
                                                <button type="button" id="btnAddcom" class="btn bg-gradient-secondary btn-sm">
                                                    <i class="fas fa-folder-minus"></i>
                                                </button>
                                                <button type="button" class="btn bg-gradient-secondary btn-sm " href="#extra" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="card-body" id="extra">
                                            <div class="col-lg-auto">
                                                <table name="tablaD" id="tablaD" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                    <thead class="text-center bg-gradient-secondary">
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Concepto</th>
                                                            <th>Cantidad</th>
                                                            <th>U. Medida</th>
                                                            <th>Acciones</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        foreach ($datacom as $datcom) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $datcom['id_reg'] ?></td>
                                                                <td><?php echo $datcom['concepto_com'] ?></td>
                                                                <td><?php echo $datcom['cant_com'] ?></td>
                                                                <td><?php echo $datcom['nom_umedida'] ?></td>
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
                        <!-- Formulario totales -->

                    </div>

                    <div class="card">

                        <div class="card-header bg-gradient-primary m-1" style="margin:0px;padding:8px; ">

                            <h1 class="card-title ">DETALLE DE INVENTARIO</h1>
                            <div class="card-tools" style="margin:0px;padding:0px;">

                                <button type="button" class="btn bg-gradient-primary btn-sm " href="#inventario" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>

                        <div class="card-body" id="inventario" style="padding:8px">


                            <!-- MATERIALES USADOS-->
                            <div class="card borde-titulazul" style="margin-bottom:5px;">

                                <div class="card-header  fondoazul " style="margin:0px;padding:8px">

                                    <h1 class="card-title text-light" sytle="padding:auto">Materiales </h1>
                                    <div class="card-tools" style="margin:0px;padding:0px;">


                                    </div>
                                </div>

                                <div class="card-body" style="margin:0px;padding:3px;">

                                    <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                                        <div class="card-header " style="margin:0px;padding:8px;">



                                            <div class="row">

                                                <div class="col-sm-2">
                                                    <button type="button" class="btn bg-gradient-primary btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
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

                                                <table name="tablaDet" id="tablaDet" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                    <thead class="text-center bg-gradient-primary">
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Id Item</th>
                                                            <th>Id Material</th>
                                                            <th>Clave</th>
                                                            <th>Material</th>
                                                            <th>Formato</th>
                                                            <th>Largo</th>
                                                            <th>Alto</th>
                                                            <th>Ancho</th>
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
                                                        $consultadeto = "SELECT * FROM vdetalle_ord2 where folio_ord='$folioorden' and estado_deto=1 order by id_reg";
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
                                                                <td><?php echo $rowdet['alto_mat'] ?></td>
                                                                <td><?php echo $rowdet['ancho_mat'] ?></td>
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
                            <!-- TERMINA MATERIALES USADOS -->


                            <!-- INSUMOS USADOS-->
                            <div class="card card-widget borde-titulinfo" style="margin-bottom:5px;">

                                <div class="card-header fondoinfo " style="margin:0px;padding:8px">
                                    <div class="card-tools" style="margin:0px;padding:0px;">


                                    </div>
                                    <h1 class="card-title text-light">Insumos</h1>

                                </div>

                                <div class="card-body accordion" id="addinsumo" style="margin:0px;padding:3px;">

                                    <div class="row justify-content-between " style="margin:2px;padding:5px;">


                                        <div class="col-sm-2">
                                            <button type="button" id="btnaddinsumoi" class="btn bg-gradient-info btn-sm" data-toggle="collapse" aria-expanded="false" aria-controls="addinsumoin" href='#addinsumoin'>
                                                Agregar Insumo <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btnaddinsumotar" class="btn bg-gradient-primary btn-sm" data-toggle="collapse" aria-expanded="false" aria-controls="addinsumotar" href='#addinsumotar'>
                                                Agregar Tarjeta de Costo <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>


                                    <div class="row justify-content-sm-center collapse" id="addinsumoin" data-parent="#addinsumo">

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

                                        <div class="col-lg-1">
                                            <input type="hidden" class="form-control" name="id_umedida" id="id_umedida">
                                            <label for="nom_umedidain" class="col-form-label">U Medida:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control " name="nom_umedidain" id="nom_umedidain" disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="cantidadi" class="col-form-label">Cantidad:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="cantidaddisi" id="cantidaddisi">
                                                <input type="text" class="form-control" name="cantidadi" id="cantidadi" disabled>
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
                                    <div class="row justify-content-sm-center collapse" id="addinsumotar" data-parent="#addinsumo">
                                        <div class="col-sm-5">

                                        </div>
                                        <div class="col-sm-2">
                                            <label for="mlbase1" class="col-form-label">ML Base de Calculo:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control " name="mlbase1" id="mlbase1">
                                                <span class="input-group-append">
                                                <button type="button" id="btncalculartar" name="btncalculartar" class="btn btn-sm bg-gradient-success" value="btncalculartar"><i class="fa-solid fa-calculator"></i></button>
                                                </span>
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-5">

                                        </div>

                                        <!-- primera tarjeta con cuadros de texto
                                        <?php
                                        foreach ($datainstar as $rowinstar) {
                                        ?>
                                            <div class="col-sm-4">

                                            </div>
                                            <div class="col-sm-2">
                                                <label for="in<?php echo $rowinstar['id_cons'] ?>" class="col-form-label"><?php echo $rowinstar['nom_cons'] ?></label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control " name="in<?php echo $rowinstar['id_cons'] ?>" id="in<?php echo $rowinstar['id_cons'] ?>" disabled value="<?php echo $rowinstar['valortarjeta'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-sm-2">
                                                <label for="valorin<?php echo $rowinstar['id_cons'] ?>" class="col-form-label">VALOR CALCULADO <?php echo $rowinstar['nom_cons'] ?></label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control " name="valorin<?php echo $rowinstar['id_cons'] ?>" id="valorin<?php echo $rowinstar['id_cons'] ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">

                                            </div>
                                        <?php
                                        }
                                        ?>
-->

                                        <!-- SEGUNDA TARJETA CON TABLA-->
                                        <div class="col-sm-6">
                                            <div class="table-responsive" style="padding:5px;">

                                                <table name="tablatarin" id="tablatarin" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                    <thead class="text-center bg-gradient-primary">
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Insumo</th>
                                                            <th>Valor *ML</th>
                                                            <th>id Unidad</th>
                                                            <th>UMedida</th>
                                                            <th>Valor Calculado</th>
                                                            <th>Disponible</th>
                                                            <th>Acciones</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                     
                                                        foreach ($datainstar as $rowdet) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $rowdet['id_cons'] ?></td>
                                                                <td><?php echo $rowdet['nom_cons'] ?></td>
                                                                <td><?php echo $rowdet['valortarjeta'] ?></td>
                                                                <td><?php echo $rowdet['id_umedida'] ?></td>
                                                                <td><?php echo $rowdet['nom_umedida'] ?></td>
                                                                <td>0</td>
                                                                <td><?php echo $rowdet['contenidoa'] ?></td>
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

                                <div class="row">

                                    <div class="col-lg-12 mx-auto">

                                        <div class="table-responsive" style="padding:5px;">

                                            <table name="tablaDetIn" id="tablaDetIn" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                <thead class="text-center bg-gradient-info">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Id Insumo</th>

                                                        <th>Material</th>


                                                        <th>U. Medida</th>

                                                        <th>Cantidad</th>
                                                        <th>Acciones</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $consultadeto = "SELECT * FROM vconsumibleord where folio_ord='$folioorden' and estado_detalle=1 order by id_reg";
                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                    $resultadodeto->execute();
                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($datadeto as $rowdet) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $rowdet['id_reg'] ?></td>
                                                            <td><?php echo $rowdet['id_cons'] ?></td>
                                                            <td><?php echo $rowdet['nom_cons'] ?></td>

                                                            <td><?php echo $rowdet['nom_umedida'] ?></td>

                                                            <td><?php echo $rowdet['cantidad'] ?></td>
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
                            <!-- TERMINA INSUMOS USADOS -->

                            <!-- INSUMOS DESECHABLES-->
                            <div class="card card-widget borde-titulpur" style="margin-bottom:5px;">

                                <div class="card-header fondopur " style="margin:0px;padding:8px">
                                    <div class="card-tools" style="margin:0px;padding:0px;">


                                    </div>
                                    <h1 class="card-title text-light">Insumos de Desgaste</h1>
                                    <div class="card-tools" style="margin:0px;padding:0px;">


                                    </div>
                                </div>

                                <div class="card-body" style="margin:0px;padding:3px;">

                                    <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                                        <div class="card-header " style="margin:0px;padding:8px;">

                                            <button type="button" class="btn bg-gradient-purple btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                Agregar Insumo de Desgaste <i class="fas fa-plus"></i>
                                            </button>

                                        </div>

                                        <div class="card-body " style="margin:0px;padding:2px 5px;">
                                            <div class="row justify-content-sm-center">

                                                <div class="col-lg-4">
                                                    <div class="input-group input-group-sm">

                                                        <input type="hidden" class="form-control" name="idinsumodes" id="idinsumodes">




                                                        <label for="insumodes" class="col-form-label">Insumo:</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control" name="insumodes" id="insumodes" disabled>
                                                            <span class="input-group-append">
                                                                <button id="btnInsumodes" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                            </span>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <input type="hidden" class="form-control" name="id_umedidades" id="id_umedidades">
                                                    <label for="nom_umedidaindes" class="col-form-label">U Medida:</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control " name="nom_umedidaindes" id="nom_umedidaindes" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label for="cantidadides" class="col-form-label">Cantidad:</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="hidden" class="form-control" name="cantidaddisides" id="cantidaddisides">
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
                                                            <th>Id Insumo</th>

                                                            <th>Material</th>


                                                            <th>U. Medida</th>

                                                            <th>Cantidad</th>
                                                            <th>Acciones</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $consultadeto = "SELECT * FROM vdesechableord where folio_ord='$folioorden' and estado_detalle=1 order by id_reg";
                                                        $resultadodeto = $conexion->prepare($consultadeto);
                                                        $resultadodeto->execute();
                                                        $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($datadeto as $rowdet) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $rowdet['id_reg'] ?></td>
                                                                <td><?php echo $rowdet['id_des'] ?></td>
                                                                <td><?php echo $rowdet['nom_des'] ?></td>

                                                                <td><?php echo $rowdet['nom_umedida'] ?></td>

                                                                <td><?php echo $rowdet['cantidad'] ?></td>
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
                            <!-- TERMINA INSUMOS DESECHABLES -->
                        </div>
                    </div>

                </form>
                <!-- TERMINA FORM -->

            </div>

        </div>

        <!-- /.card -->

    </section>
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
                            <table name="tablaMat" id="tablaMat" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center">
                                    <tr>

                                        <th>Id Item</th>
                                        <th>Id Material</th>
                                        <th>Clave</th>
                                        <th>Material</th>
                                        <th>Formato</th>
                                        <th>Largo</th>
                                        <th>Alto</th>
                                        <th>Ancho</th>
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
                                            <td><?php echo $datc['alto_mat'] ?></td>
                                            <td><?php echo $datc['ancho_mat'] ?></td>
                                            <td><?php echo $datc['m2_mat'] ?></td>
                                            <td><?php echo $datc['id_umedida'] ?></td>
                                            <td><?php echo $datc['nom_umedida'] ?></td>
                                            <td><?php echo $datc['ubi_mat'] ?></td>
                                            <td><?php echo $datc['m2_mat'] ?></td>
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
                                <thead class="text-center">
                                    <tr>

                                        <th>Id Insumo</th>
                                        <th>Insumo</th>
                                        <th>U. Medida</th>
                                        <th>Cantidad Abierta Disp.</th>
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


                                            <td><?php echo $datc['nom_umedida'] ?></td>

                                            <td><?php echo $datc['contenidoa'] ?></td>
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




    <section>
        <div class="modal fade" id="modalCom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Detalle Complementario</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formCom" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="concepto" class="col-form-label">Concepto:</label>
                                        <input type="text" class="form-control" name="concepto" id="concepto" autocomplete="off" placeholder="Concepto">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="cantcom" class="col-form-label">Cantidad:</label>
                                        <input type="text" class="form-control" name="cantcom" id="cantcom" autocomplete="off" placeholder="Cantidad">
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm auto">
                                        <label for="umedida" class="col-form-label">Unidad:</label>
                                        <select class="form-control" name="umedida" id="umedida">
                                            <?php
                                            foreach ($datau as $dtu) {
                                            ?>
                                                <option id="<?php echo $dtu['nom_umedida'] ?>" value="<?php echo $dtu['nom_umedida'] ?>"> <?php echo $dtu['nom_umedida'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
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
                        <button type="button" id="btnGuardarcom" name="btnGuardarcom" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- TABLA DESECHABLES -->
    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalDes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR INSUMO DE DESGASTE</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaDes" id="tablaDes" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center">
                                    <tr>

                                        <th>Id Insumo</th>
                                        <th>Insumo</th>
                                        <th>U. Medida</th>
                                        <th>Usos Disp.</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datades as $datd) {
                                    ?>
                                        <tr>

                                            <td><?php echo $datd['id_des'] ?></td>
                                            <td><?php echo $datd['nom_des'] ?></td>


                                            <td><?php echo $datd['nom_umedida'] ?></td>

                                            <td><?php echo $datd['totalusos'] ?></td>
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
        <div class="modal fade" id="modalredimensionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Material Sobrante</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formredimensionar" action="" method="POST">
                            <div class="modal-body ">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="hidden" class="form-control" name="idmatred" id="idmatred" autocomplete="off" placeholder="idmatred" disabled>
                                        <input type="hidden" class="form-control" name="tipored" id="tipored" autocomplete="off" placeholder="tipored" disabled>

                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="checkbox" id="chpedaceria">
                                            <label for="chpedaceria" class="custom-control-label">El Material Sobrante será considerado como Pedacería</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row" id="divmedidas" name="divmedidas">

                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="largoant" class="col-form-label">Largo Anterior:</label>
                                            <input type="text" class="form-control" name="largoant" id="largoant" autocomplete="off" placeholder="largoant" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="altoant" class="col-form-label">Alto Anterior:</label>
                                            <input type="text" class="form-control" name="altoant" id="altoant" autocomplete="off" placeholder="altoant" disabled>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="validador" class="col-form-label">M2 Restantes:</label>
                                            <input type="text" class="form-control" name="m2restantes" id="m2restantes" autocomplete="off" placeholder="m2" disabled>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="largonuevo" class="col-form-label">Largo Anterior:</label>
                                            <input type="text" class="form-control" name="largonuevo" id="largonuevo" autocomplete="off" placeholder="largonuevo" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="altonuevo" class="col-form-label">Alto Anterior:</label>
                                            <input type="text" class="form-control" name="altonuevo" id="altonuevo" autocomplete="off" placeholder="altonuevo" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="validador" class="col-form-label">M2 Restantes:</label>
                                            <input type="text" class="form-control" name="validador" id="validador" autocomplete="off" placeholder="m2">
                                        </div>
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
                        <button type="button" id="btnguardarredimensionar" name="btnguardarredimensionar" class="btn btn-success" value="btnguardarredimensionar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="modalconfirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-info">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar Agregar Insumo</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formconfirmar" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                    <input type="hidden" class="form-control" name="idconstar" id="idconstar" autocomplete="off" placeholder="Concepto">
                                    <input type="hidden" class="form-control" name="tipoconstar" id="tipoconstar" autocomplete="off" placeholder="Concepto">
                                        <label for="conceptotar" class="col-form-label">Concepto:</label>
                                        <input type="text" class="form-control" name="conceptotar" id="conceptotar" autocomplete="off" placeholder="Concepto" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="existenciastar" class="col-form-label">Disponible:</label>
                                        <input type="text" class="form-control" name="existenciastar" id="existenciastar" autocomplete="off" placeholder="Cantidad" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="cantidadtar" class="col-form-label">Cantidad:</label>
                                        <input type="text" class="form-control" name="cantidadtar" id="cantidadtar" autocomplete="off" placeholder="Cantidad">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="unidadtar" class="col-form-label">U Medida:</label>
                                        <input type="hidden" class="form-control" name="idunidadtar" id="idunidadtar" autocomplete="off" placeholder="Cantidad" >
                                        <input type="text" class="form-control" name="unidadtar" id="unidadtar" autocomplete="off" placeholder="Cantidad" disabled>
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
                        <button type="button" id="btnguardarconfirmacion" name="btnguardarconfirmacion" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
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
<script src="fjs/orden.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>