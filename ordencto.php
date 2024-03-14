<?php
$pagina = "ordencto";

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

                                                            <th>Cantidad</th>
                                                            <th>Costo Uni</th>
                                                            <th>Costo Tot</th>



                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $consultadeto = "SELECT * FROM vdetalle_ord2cto where folio_ord='$folioorden' and estado_deto=1 order by id_reg";
                                                        $resultadodeto = $conexion->prepare($consultadeto);
                                                        $resultadodeto->execute();
                                                        $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                        $totalmat = 0;
                                                        foreach ($datadeto as $rowdet) {
                                                            $totalmat += $rowdet['costo'];
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

                                                                <td class="text-center"><?php echo $rowdet['cant_mat'] ?></td>
                                                                <td class="text-right"><?php echo number_format($rowdet['costouni'], 3) ?></td>
                                                                <td class="text-right"><?php echo number_format($rowdet['costo']), 3 ?></td>

                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8"></div>
                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="totalmat" class="col-form-label">Importe Material:</label>

                                                <input type="text" class="form-control text-right" name="totalmat" id="totalmat" value="<?php echo   number_format($totalmat,3); ?>" disabled>
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
                                                        <th>Costo Uni</th>
                                                        <th>Costo</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $consultadeto = "SELECT * FROM vconsumibleord where folio_ord='$folioorden' and estado_detalle=1 order by id_reg";
                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                    $resultadodeto->execute();
                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    $totalinsumo=0;
                                                    foreach ($datadeto as $rowdet) {
                                                        $totalinsumo+=$rowdet['costo'];
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $rowdet['id_reg'] ?></td>
                                                            <td><?php echo $rowdet['id_cons'] ?></td>
                                                            <td><?php echo $rowdet['nom_cons'] ?></td>

                                                            <td><?php echo $rowdet['nom_umedida'] ?></td>

                                                            <td class="text-center"><?php echo $rowdet['cantidad'] ?></td>
                                                            <td class="text-right"><?php echo number_format($rowdet['costouni'], 3) ?></td>
                                                            <td class="text-right"><?php echo number_format($rowdet['costo'], 3) ?></td>

                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                </div>

                                <div class="row justify-content-center">
                                        <div class="col-sm-8"></div>
                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="totalins" class="col-form-label">Importe Insumos:</label>

                                                <input type="text" class="form-control text-right" name="totalins" id="totalins" value="<?php echo number_format($totalinsumo,3); ?>" disabled>
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
                                                        <th>Costo Uni</th>
                                                        <th>Costo</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $consultadeto = "SELECT * FROM vdesechableordcto where folio_ord='$folioorden' and estado_detalle=1 order by id_reg";
                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                    $resultadodeto->execute();
                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                    $totalinsumod=0;
                                                    foreach ($datadeto as $rowdet) {
                                                        $totalinsumod+=$rowdet['costo'];
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $rowdet['id_reg'] ?></td>
                                                            <td><?php echo $rowdet['id_des'] ?></td>
                                                            <td><?php echo $rowdet['nom_des'] ?></td>

                                                            <td><?php echo $rowdet['nom_umedida'] ?></td>

                                                            <td class="text-center"><?php echo $rowdet['cantidad'] ?></td>
                                                            <td class="text-right"><?php echo number_format($rowdet['ctouni'], 3) ?></td>
                                                            <td class="text-right"><?php echo number_format($rowdet['costo'], 3) ?></td>

                                                        </tr>
                                                    <?php
                                                    }
                                                    $cntaact = "call sp_actualizarctoorden('$folioorden','$totalmat','$totalinsumo','$totalinsumod')";
                                                    $resact = $conexion->prepare($cntaact);
                                                    $resact->execute();

                                                    ?>

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                </div>

                                <div class="row justify-content-center">
                                        <div class="col-sm-8"></div>
                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="totalinsumodes" class="col-form-label">Importe Insumos de Desgaste:</label>

                                                <input type="text" class="form-control text-right" name="totalinsumodes" id="totalinsumodes" value="<?php echo   number_format($totalinsumod,3); ?>" disabled>
                                            </div>
                                        </div>
                                    </div>


                            </div>
                            <!-- TERMINA INSUMOS DESECHABLES -->

                        </div>

                    </div>


                </form>
            </div>
            <!-- TERMINA FORM -->

        </div>



        <!-- /.card -->

    </section>
    <!--TABLA MATERIALES-->


    <!-- TERMINA TABLA INSUMOS -->






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
<script src="fjs/ordencto.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>