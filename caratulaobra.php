<?php
$pagina = "ordenobra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

if ($folio != "") {
    $objeto = new conn();
    $conexion = $objeto->connect();
    $tokenid = md5($_SESSION['s_usuario']);

    $consulta = "SELECT * FROM vorden where folio_ord='$folio'";

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

<style>
    td.details-control {
        background: url('img/details_open.png') no-repeat center center;

        cursor: pointer;
    }

    tr.details td.details-control {
        background: url('img/details_close.png') no-repeat center center;


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
                <h1 class="card-title mx-auto">DETALLE DE OBRA</h1>
            </div>

            <div class="card-body">



                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget collapsed-card" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-success " style="margin:0px;padding:8px">
                                <div class="card-tools" style="margin:0px;padding:0px;">


                                </div>
                                <h1 class="card-title ">Datos Generales de Venta</h1>
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

                            <div class="card card-widget">
                                <div class="card-header bg-gradient-success " style="margin:0px;padding:8px">

                                    <h1 class="card-title ">Detalle de Orden</h1>

                                </div>

                                <div class="card-body" style="margin:0px;padding:3px;">

                                    <div class="card  ">
                                        <div class="card-header bg-gradient-success " style="margin:0px;padding:8px">
                                            <h1 class="card-title ">Dellate Principal</h1>
                                            <div class="card-tools" style="margin:0px;padding:0px;">
                                                <button type="button" class="btn bg-gradient-success btn-sm " href="#principal" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                            </div>

                                        </div>
                                        <div class="card-body" id="pricipal">
                                            <div class="col-lg-12 mx-auto">

                                                <div class="table-responsive" style="padding:5px;">

                                                    <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                        <thead class="text-center bg-gradient-success">
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
                                    <!--
                                    <div class="card">
                                        <div class="card-header bg-gradient-success " style="margin:0px;padding:8px">

                                            <h1 class="card-title ">Detalle Complementario</h1>
                                            <div class="card-tools" style="margin:0px;padding:0px;">
                                                <button type="button" id="btnAddcom" class="btn bg-gradient-success btn-sm">
                                                    <i class="fas fa-folder-plus"></i>
                                                </button>
                                                <button type="button" class="btn bg-gradient-success btn-sm " href="#extra" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="card-body" id="extra">
                                            <div class="col-lg-auto">
                                                <table name="tablaD" id="tablaD" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                    <thead class="text-center bg-gradient-success">
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

-->


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
                                <h1 class="card-title ">Frentes o Areas</h1>
                                <div class="card-tools" style="margin:0px;padding:0px;">
                                    <button type="button" id="btnAreas" class="btn bg-gradient-primary btn-sm">
                                        <i class="fas fa-folder-plus"></i>
                                    </button>


                                </div>
                            </div>

                            <div class="card-body" style="margin:0px;padding:3px;">



                                <div class="row">

                                    <div class="col-lg-10 mx-auto">

                                        <div class="table-responsive" style="padding:5px;">

                                            <table name="tablaDet" id="tablaDet" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                <thead class="text-center bg-gradient-primary">
                                                    <tr>
                                                        <th></th>
                                                        <th>Id</th>
                                                        <th>Frente</th>

                                                        <th>Acciones</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $consultadeto = "SELECT * FROM frente where id_ord='$folioorden' and estado_frente=1 order by id_frente";
                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                    $resultadodeto->execute();
                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($datadeto as $rowdet) {
                                                    ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><?php echo $rowdet['id_frente'] ?></td>
                                                            <td><?php echo $rowdet['nom_frente'] ?></td>

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

                    <?php if ($_SESSION['s_rol'] == '1' || $_SESSION['s_rol'] == '2' || $_SESSION['s_rol'] == '3') { ?>
                        <div class="content">
                            <div class="card card-widget" style="margin-bottom:0px;">

                                <div class="card-header bg-gradient-primary " style="margin:0px;padding:8px">
                                    <div class="card-tools" style="margin:0px;padding:0px;">


                                    </div>
                                    <h1 class="card-title ">Costos y Precios de Conceptos</h1>
                                    <div class="card-tools" style="margin:0px;padding:0px;">
                                        <button type="button" id="btnConceptos" class="btn bg-gradient-primary btn-sm">
                                            <i class="fas fa-folder-plus"></i>
                                        </button>


                                    </div>
                                </div>

                                <div class="card-body" style="margin:0px;padding:3px;">



                                    <div class="row">

                                        <div class="col-lg-10 mx-auto">

                                            <div class="table-responsive" style="padding:5px;">

                                                <table name="tablaConceptos" id="tablaConceptos" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                    <thead class="text-center bg-gradient-primary">
                                                        <tr>

                                                            <th>Id</th>

                                                            <th>Concepto</th>
                                                            <th>Costo</th>
                                                            <th>Precio Pub</th>
                                                            <th>Acciones</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $consultadeto = "SELECT * FROM detalle_conceptosobra where id_orden='$folioorden' and estado_detalle=1 order by id_concepto";
                                                        $resultadodeto = $conexion->prepare($consultadeto);
                                                        $resultadodeto->execute();
                                                        $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($datadeto as $rowdet) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $rowdet['id_reg'] ?></td>

                                                                <td><?php echo $rowdet['nom_concepto'] ?></td>
                                                                <td><?php echo $rowdet['costo_concepto'] ?></td>
                                                                <td><?php echo $rowdet['precio_concepto'] ?></td>

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
                    <?php } ?>


                    <div class="content">
                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-primary " style="margin:0px;padding:8px">
                                <div class="card-tools" style="margin:0px;padding:0px;">


                                </div>
                                <h1 class="card-title ">Presupuesto Volumenes</h1>
                                <div class="card-tools" style="margin:0px;padding:0px;">
                                 


                                </div>
                            </div>

                            <div class="card-body" style="margin:0px;padding:3px;">



                                <div class="row">

                                    <div class="col-lg-10 mx-auto">

                                        <div class="table-responsive" style="padding:5px;">

                                            <table name="tablaPres" id="tablaPres" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                <thead class="text-center bg-gradient-lightblue">
                                                    <tr>
                                                        <th rowspan="2">Volumenes</th>
                                                        <?php
                                                        $cntafrente = "SELECT id_frente,nom_frente FROM frente where id_ord='$folioorden' and estado_frente=1 order by id_frente";
                                                        $resfrente = $conexion->prepare($cntafrente);
                                                        $resfrente->execute();
                                                        $regfrente = $resfrente->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($regfrente as $rowfrente) {
                                                        ?>
                                                            <th><?php echo $rowfrente['nom_frente'] ?></th>
                                                        <?php } ?>
                                                        <th>SUMA</th>
                                                    </tr>
                                                    <tr>

                                                        <?php
                                                        foreach ($regfrente as $rowfrente) {

                                                            echo '<th>Cantidad</th>';
                                                        }
                                                        ?>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $consultadeto = "SELECT id_concepto,nom_concepto FROM detalle_conceptosobra where id_orden='$folioorden' and estado_detalle=1 order by id_concepto";
                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                    $resultadodeto->execute();
                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($datadeto as $rowdet) {
                                                        $id_concepto = $rowdet['id_concepto'];
                                                        $sumador = 0;

                                                        echo '<tr>';

                                                        echo '<td>' . $rowdet['nom_concepto'] . '</td>';


                                                        foreach ($regfrente as $rowfrente) {
                                                            $id_frente = $rowfrente['id_frente'];
                                                            $consultadeto = "SELECT cantidad, generado, pendiente FROM v_resumen1 where id_frente='$id_frente' and id_concepto='$id_concepto'";
                                                            $resultadodeto = $conexion->prepare($consultadeto);
                                                            $resultadodeto->execute();

                                                            $datadet = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($datadet as $rowreg) {
                                                                if ($rowreg['pendiente'] == 0) {
                                                                    $clase = " bg-green ";
                                                                } else {
                                                                    $clase = " bg-warning ";
                                                                }

                                                                echo '<td class="text-right">' . $rowreg['cantidad'] . '</td>';
                                                                $sumador += $rowreg['cantidad'];
                                                            }
                                                        }
                                                        echo '<td class="text-right bg-lightblue">' . number_format($sumador, 4) . '</td>';
                                                        echo '</tr>';
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

                    <div class="content">
                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-lightblue " style="margin:0px;padding:8px">
                                <div class="card-tools" style="margin:0px;padding:0px;">


                                </div>
                                <h1 class="card-title ">Resumen de Ejecución</h1>
                                <div class="card-tools" style="margin:0px;padding:0px;">



                                </div>
                            </div>

                            <div class="card-body" style="margin:0px;padding:3px;">



                                <div class="row">

                                    <div class="col-lg-10 mx-auto">
                                        <div class="card-title">
                                            <h2>Volumen</h2>
                                        </div>

                                        <div class="table-responsive" style="padding:5px;">

                                            <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                <thead class="text-center bg-gradient-lightblue">
                                                    <tr>
                                                        <th rowspan="2">Concepto</th>
                                                        <?php
                                                        $cntafrente = "SELECT id_frente,nom_frente FROM frente where id_ord='$folioorden' and estado_frente=1 order by id_frente";
                                                        $resfrente = $conexion->prepare($cntafrente);
                                                        $resfrente->execute();
                                                        $regfrente = $resfrente->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($regfrente as $rowfrente) {
                                                        ?>
                                                            <th colspan="3"><?php echo $rowfrente['nom_frente'] ?></th>
                                                        <?php } ?>
                                                        <th colspan="3">SUMA</th>
                                                        <th>%</th>
                                                    </tr>
                                                    <tr>

                                                        <?php
                                                        foreach ($regfrente as $rowfrente) {

                                                            echo '<th>Cantidad</th>';
                                                            echo '<th>Ejecutado</th>';
                                                            echo '<th>Pendiente</th>';
                                                        }
                                                        ?>
                                                        <th>Cantidad</th>
                                                        <th>Ejecutado</th>
                                                        <th>Pendiente</th>
                                                        <th>AVANCE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $consultadeto = "SELECT id_concepto,nom_concepto FROM detalle_conceptosobra where id_orden='$folioorden' and estado_detalle=1 order by id_concepto";
                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                    $resultadodeto->execute();
                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($datadeto as $rowdet) {
                                                        $id_concepto = $rowdet['id_concepto'];
                                                        $tcantidad = 0;
                                                        $tejecutado = 0;
                                                        $tpendiente = 0;

                                                        echo '<tr>';

                                                        echo '<td>' . $rowdet['nom_concepto'] . '</td>';


                                                        foreach ($regfrente as $rowfrente) {
                                                            $id_frente = $rowfrente['id_frente'];
                                                            $consultadeto = "SELECT cantidad, generado, pendiente FROM v_resumen1 where id_frente='$id_frente' and id_concepto='$id_concepto'";
                                                            $resultadodeto = $conexion->prepare($consultadeto);
                                                            $resultadodeto->execute();

                                                            $datadet = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($datadet as $rowreg) {
                                                                if ($rowreg['pendiente'] == 0) {
                                                                    $clase = " bg-green ";
                                                                } else {
                                                                    $clase = " bg-warning ";
                                                                }

                                                                echo '<td class="text-right">' . $rowreg['cantidad'] . '</td>';
                                                                echo '<td class="text-right">' . $rowreg['generado'] . '</td>';
                                                                echo '<td class="text-right' . $clase . '">' . $rowreg['pendiente'] . '</td>';

                                                                $tcantidad += $rowreg['cantidad'];
                                                                $tejecutado += $rowreg['generado'];
                                                                $tpendiente += $rowreg['pendiente'];
                                                            }
                                                        }
                                                        echo '<td class="text-right bg-secondary">' . number_format($tcantidad, 4) . '</td>';
                                                        echo '<td class="text-right bg-success">' . number_format($tejecutado, 4) . '</td>';
                                                        echo '<td class="text-right bg-warning">' . number_format($tpendiente, 4) . '</td>';
                                                        if ($tejecutado !=0  && $tcantidad !=0){
                                                            echo '<td class="text-right bg-lightblue">' . number_format(($tejecutado / $tcantidad) * 100, 2) . ' %</td>';
                                                        }
                                                        else{
                                                            echo '<td class="text-right bg-lightblue">' . number_format(0, 2) . ' %</td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-lg-10 mx-auto">
                                        <div class="card-title">
                                            <h2>Costo</h2>
                                        </div>

                                        <div class="table-responsive" style="padding:5px;">

                                            <table name="tablaResumenc" id="tablaResumenc" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                <thead class="text-center bg-gradient-lightblue">
                                                    <tr>
                                                        <th rowspan="2">Concepto</th>
                                                        <?php
                                                        $cntafrente = "SELECT id_frente,nom_frente FROM frente where id_ord='$folioorden' and estado_frente=1 order by id_frente";
                                                        $resfrente = $conexion->prepare($cntafrente);
                                                        $resfrente->execute();
                                                        $regfrente = $resfrente->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($regfrente as $rowfrente) {
                                                        ?>
                                                            <th colspan="3"><?php echo $rowfrente['nom_frente'] ?></th>
                                                        <?php } ?>

                                                    </tr>
                                                    <tr>

                                                        <?php
                                                        foreach ($regfrente as $rowfrente) {

                                                            echo '<th>Cantidad</th>';
                                                            echo '<th>Ejecutado</th>';
                                                            echo '<th>Pendiente</th>';
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $consultadeto = "SELECT id_concepto,nom_concepto,precio_concepto,costo_concepto FROM detalle_conceptosobra where id_orden='$folioorden' and estado_detalle=1 order by id_concepto";
                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                    $resultadodeto->execute();
                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($datadeto as $rowdet) {
                                                        $id_concepto = $rowdet['id_concepto'];
                                                        $precio = $rowdet['precio_concepto'];
                                                        $costo = $rowdet['costo_concepto'];


                                                        echo '<tr>';

                                                        echo '<td>' . $rowdet['nom_concepto'] . '</td>';


                                                        foreach ($regfrente as $rowfrente) {
                                                            $id_frente = $rowfrente['id_frente'];
                                                            $consultadeto = "SELECT cantidad, generado, pendiente FROM v_resumen1 where id_frente='$id_frente' and id_concepto='$id_concepto'";
                                                            $resultadodeto = $conexion->prepare($consultadeto);
                                                            $resultadodeto->execute();

                                                            $datadet = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($datadet as $rowreg) {

                                                                echo '<td class="text-right">$ ' . number_format($rowreg['cantidad'] * $costo, 2) . '</td>';
                                                                echo '<td class="text-right">$ ' . number_format($rowreg['generado'] * $costo, 2) . '</td>';
                                                                echo '<td class="text-right">$ ' . number_format($rowreg['pendiente'] * $costo, 2) . '</td>';
                                                            }
                                                        }

                                                        echo '</tr>';
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-lg-10 mx-auto">
                                        <div class="card-title">
                                            <h2>Cliente</h2>
                                        </div>

                                        <div class="table-responsive" style="padding:5px;">

                                            <table name="tablaResumenm" id="tablaResumenm" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                <thead class="text-center bg-gradient-lightblue">
                                                    <tr>
                                                        <th rowspan="2">Concepto</th>
                                                        <?php
                                                        $cntafrente = "SELECT id_frente,nom_frente FROM frente where id_ord='$folioorden' and estado_frente=1 order by id_frente";
                                                        $resfrente = $conexion->prepare($cntafrente);
                                                        $resfrente->execute();
                                                        $regfrente = $resfrente->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($regfrente as $rowfrente) {
                                                        ?>
                                                            <th colspan="3"><?php echo $rowfrente['nom_frente'] ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>

                                                        <?php
                                                        foreach ($regfrente as $rowfrente) {

                                                            echo '<th>Cantidad</th>';
                                                            echo '<th>Ejecutado</th>';
                                                            echo '<th>Pendiente</th>';
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $consultadeto = "SELECT id_concepto,nom_concepto,precio_concepto,costo_concepto FROM detalle_conceptosobra where id_orden='$folioorden' and nom_concepto LIKE '%M2%' and estado_detalle=1 order by id_concepto";
                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                    $resultadodeto->execute();
                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($datadeto as $rowdet) {
                                                        $id_concepto = $rowdet['id_concepto'];
                                                        $precio = $rowdet['precio_concepto'];
                                                        $costo = $rowdet['costo_concepto'];


                                                        echo '<tr>';

                                                        echo '<td>' . $rowdet['nom_concepto'] . '</td>';


                                                        foreach ($regfrente as $rowfrente) {
                                                            $id_frente = $rowfrente['id_frente'];
                                                            $consultadeto = "SELECT cantidad, generado, pendiente FROM v_resumen1 where id_frente='$id_frente' and id_concepto='$id_concepto'";
                                                            $resultadodeto = $conexion->prepare($consultadeto);
                                                            $resultadodeto->execute();

                                                            $datadet = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($datadet as $rowreg) {

                                                                echo '<td class="text-right">$ ' . number_format($rowreg['cantidad'] * $precio, 2) . '</td>';
                                                                echo '<td class="text-right">$ ' . number_format($rowreg['generado'] * $precio, 2) . '</td>';
                                                                echo '<td class="text-right">$ ' . number_format($rowreg['pendiente'] * $precio, 2) . '</td>';
                                                            }
                                                        }

                                                        echo '</tr>';
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

    <section>
        <div class="modal fade" id="modalCom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-success">
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


    <section>
        <div class="modal fade" id="modalFrente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Frente</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formFremte" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="nombrefrente" class="col-form-label">Nombre/Denominacion de Frente:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="nombrefrente" id="nombrefrente">
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
                        <button type="button" id="btnGuardarFrente" name="btnGuardarFrente" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="modalArea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-orange">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Area</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formArea" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-lg-12">
                                    <label for="nomfrentea" class="col-form-label">Frente:</label>
                                    <input type="hidden" class="form-control" name="idfrentea" id="idfrentea" disabled>


                                    <input type="text" class="form-control" name="nomfrentea" id="nomfrentea" disabled>

                                </div>

                                <div class="col-lg-12">
                                    <label for="area" class="col-form-label">Area:</label>


                                    <input type="text" class="form-control" name="area" id="area">

                                </div>

                                <div class="col-lg-12">
                                    <label for="supervisor" class="col-form-label">Supervisor:</label>


                                    <input type="text" class="form-control" name="supervisor" id="supervisor">

                                </div>

                                <div class="col-lg-12">

                                    <label for="colocador" class="col-form-label">Colocador:</label>

                                    <input type="text" class="form-control " name="colocador" id="colocador">

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
                        <button type="button" id="btnGuardarArea" name="btnGuardarFrente" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="modal fade" id="modalConceptos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Concepto</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formConceptos" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm auto">
                                        <label for="conceptod" class="col-form-label">Concepto:</label>
                                        <select class="form-control" name="conceptod" id="conceptod">
                                            <?php
                                            $consultac = "SELECT * FROM conceptos_gen where estado_concepto=1 order by id_concepto";
                                            $resultadoc = $conexion->prepare($consultac);
                                            $resultadoc->execute();
                                            $datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($datac as $dtc) {
                                            ?>
                                                <option id="Con<?php echo $dtc['nom_concepto'] ?>" value="<?php echo $dtc['id_concepto'] ?>"> <?php echo $dtc['nom_concepto'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="preciocon" class="col-form-label">Precio a Cliente:</label>
                                        <input type="text" class="form-control" name="preciocon" id="preciocon" autocomplete="off" placeholder="Precio Pub">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="costocon" class="col-form-label">Costo:</label>
                                        <input type="text" class="form-control" name="costocon" id="costocon" autocomplete="off" placeholder="Costo">
                                    </div>
                                </div>

                                
                                    <div class="col-sm-8">
                                        <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="chestimacion" id="chestimacion">
                                        <label class="form-check-label" for="chestimacion">
                                            Este Concepto se usara para generar las Estimaciones
                                        </label>
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
                                <button type="button" id="btnGuardarconcepto" name="btnGuardarconcepto" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
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
<script src="fjs/caratulaobra.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>