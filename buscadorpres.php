<?php
$pagina = "buscadorpres";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$foliovta = 0;

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
if ($folio != null) {





    //BUSCAR PRESUPUESTO

    $consulta = "SELECT * FROM vpres where folio_pres='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {


        $tmp_pres = $dt['folio_tmp'];
        $fecha = $dt['fecha_pres'];
        $idpros = $dt['id_pros'];
        $concepto = $dt['concepto_pres'];
        $ubicacion = $dt['ubicacion'];
        $subtotal = $dt['subtotal'];
        $descuento = $dt['descuento'];
        $gtotal = $dt['gtotal'];
        $total = $dt['total'];
        $iva = $dt['iva'];
        $notas = $dt['notas'];
        $vendedor = $dt['vendedor'];
        $tipo_proy = $dt['tipop'];

        $estado_pres = $dt['estado_pres'];
    }

    if ($idpros != 0) {
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
            $correo = "";
        }
    } else {
        $prospecto = "";
        $correo = "";
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

   


    $consulta = "SELECT * FROM vventa where folio_pres='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {

        $foliovta = $dt['folio_vta'];

        $fechavta = $dt['fecha_vta'];
        $idclie = $dt['id_clie'];
        $cliente = $dt['nombre'];
        $totalvta = $dt['gtotal'];
        $saldovta = $dt['saldo'];
        $estado_vta = $dt['estado_vta'];
    }


    $consulta = "SELECT * FROM pagocxc where folio_vta='$foliovta' and estado_pagocxc=1";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $datap = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $totalpagos = 0;
    foreach ($datap as $rowpagos) {
        $totalpagos += $rowpagos['monto'];
    }

    $consultadet = "SELECT * FROM vorden where folio_vta='$foliovta'";
    $resultadodet = $conexion->prepare($consultadet);
    $resultadodet->execute();
    $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);

    foreach ($datadet as $rowpagos) {
        $folioorden = $rowpagos['folio_ord'];
        $edoorden=$rowpagos['edo_ord'];
        $fechaini=$rowpagos['fecha_ord'];
        $fechafin=$rowpagos['fecha_limite'];
        $fechalib=$rowpagos['fecha_liberacion'];
    }

    $consultadet = "SELECT * FROM vdetalle_pres where folio_pres='$folio' order by id_reg";
    $resultadodet = $conexion->prepare($consultadet);
    $resultadodet->execute();
    $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);
    //BUSCAR LLAMADAS
    //BUSCAR VENTA
    //BUSCAR PAGOS
    //BUSCAR ORDEN
    //BUSCAR OT
    //BUSCAR COLOCACION

    /*  $consulta = "Select ";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $dataingresos = $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
*/
} else {
}





$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<div class="content-wrapper">



    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">BUSCADOR</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header bg-gradient-secondary">
                                DATOS DE BUSQUEDA
                            </div>

                            <div class="card-body ">
                                <div class="row justify-content-center mb-3">
                                    <div class="col-sm-3">
                                        <div class="input-group input-group-sm">
                                            <label for="folio" class="col-form-label">BUSCAR:</label>
                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="folio" id="folio" placeholder="BUSCAR POR FOLIO PRESUPUESTO" value="<?php echo $folio; ?>">

                                                <span class="input-group-append">
                                                    <button id="bbuscar" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>

                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <?php

                             if ($folio != null) { 
                        ?>


                        <section class="content">

                            <!-- Default box -->
                            <div class="card">
                                <div class="card-header bg-gradient-orange text-light">
                                    <h1 class="card-title mx-auto">DETALLE DE INFORMACION</h1>
                                </div>

                                <div class="card-body">



                                    <div class="card">
                                        <div class="card-header bg-gradient-orange">
                                            INFORMACION GENERAL
                                        </div>
                                        <div class="card-body">
                                            <div class="row justify-content-sm-center  pb-0">



                                                <div class="col-sm-1 ">
                                                    <div class="form-group input-group-sm">
                                                        <label for="tipo_proy" class="col-form-label">Tipo Proyecto:</label>
                                                        <input type="text" class="form-control" name="tipo_proy" id="tipo_proy" value="<?php echo $tipo_proy; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">

                                                    <div class="form-group input-group-sm">
                                                        <label for="vendedor" class="col-form-label">Vendedor:</label>
                                                        <input type="text" class="form-control" name="vendedor" id="vendedor" value="<?php echo   $vendedor; ?>" disabled>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="form-group input-group-sm">
                                                        <label for="fecha" class="col-form-label">Fecha:</label>
                                                        <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>" disabled>
                                                    </div>
                                                </div>


                                                <div class="col-sm-1">
                                                    <div class="form-group input-group-sm">
                                                        <label for="folior" class="col-form-label">Folio Pres:</label>
                                                        <input type="text" class="form-control" name="folior" id="folior" value="<?php echo   $folio; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group input-group-sm">
                                                        <label for="estado" class="col-form-label">Estado:</label>
                                                        <input type="text" class="form-control" name="estado" id="estado" value="<?php echo   $estado_pres; ?>" disabled>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row justify-content-sm-center">

                                                <div class="col-lg-8">
                                                    <div class="form-group">


                                                        <label for="nombre" class="col-form-label">Prospecto:</label>

                                                        <div class="input-group input-group-sm">

                                                            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $prospecto; ?>" disabled>
                                                            <span class="input-group-append">
                                                                <!--<button id="bcliente" type="button" class="btn btn-primary "><i class="fas fa-search" d></i></button>-->
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>





                                            </div>

                                            <div class=" row justify-content-sm-center">
                                                <div class="col-sm-8">

                                                    <div class="form-group input-group-sm">
                                                        <label for="proyecto" class="col-form-label">Descripcion del Proyecto:</label>
                                                        <textarea rows="1" class="form-control" name="proyecto" id="proyecto" disabled><?php echo $concepto; ?></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class=" row justify-content-sm-center">
                                                <div class="col-sm-8">

                                                    <div class="form-group input-group-sm">
                                                        <label for="ubicacion" class="col-form-label">Ubicación:</label>
                                                        <textarea rows="1" class="form-control" name="ubicacion" id="ubicacion" disabled><?php echo $ubicacion; ?></textarea>
                                                    </div>

                                                </div>

                                            </div>

                                            <!-- modificacion Agregar notas a presupuesto-->
                                            <div class="row justify-content-sm-center">
                                                <div class="col-sm-8">
                                                    <div class="form-group input-group-sm">
                                                        <label for="notas" class="col-form-label">Notas:</label>
                                                        <textarea rows="1" class="form-control" name="notas" id="notas" disabled><?php echo $notas; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-sm-center">

                                            </div>



                                            <div class="row justify-content-sm-center" style="padding:5px 0px;">

                                                <div class="col-sm-6">

                                                </div>

                                                <div class="col-sm-2 ">
                                                    <label for="total" class="col-form-label ">Gran Total:</label>

                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>
                                                        </div>

                                                        <input type="text" class="form-control text-right" name="gtotal" id="gtotal" value="<?php echo number_format($gtotal, 2); ?>" disabled>
                                                    </div>


                                                </div>


                                            </div>



                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header bg-gradient-orange">
                                            DETALLE DE CONCEPTOS
                                        </div>
                                        <div class="card-body">

                                            <div class="row justify-content-sm-center">
                                                <div class="col-lg-12 mx-auto">

                                                    <div class="table-responsive" style="padding:5px;">

                                                        <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                            <thead class="text-center bg-gradient-primary">
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Concepto</th>
                                                                    <th>Descripcion</th>
                                                                    <th>Formato</th>
                                                                    <th>Cantidad</th>
                                                                    <th>U. Medida</th>
                                                                    <th>P.U.</th>
                                                                    <th>Monto</th>

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


                                    <?php
                                    if ($foliovta != 0) {
                                    ?>

                                        <div class="card">
                                            <div class="card-header bg-gradient-success">
                                                INFORMACION GENERAL VENTA
                                            </div>
                                            <div class="card-body">
                                                <div class="row justify-content-sm-center  pb-0">

                                                    <div class="col-sm-1">
                                                        <div class="form-group input-group-sm">
                                                            <label for="foliovta" class="col-form-label">Folio Vta:</label>
                                                            <input type="text" class="form-control" name="foliovta" id="foliovta" value="<?php echo   $foliovta; ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">

                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-group input-group-sm">
                                                            <label for="fechavta" class="col-form-label">Fecha:</label>
                                                            <input type="date" class="form-control" name="fechavta" id="fechavta" value="<?php echo $fechavta; ?>" disabled>
                                                        </div>
                                                    </div>





                                                    <div class="col-sm-2">
                                                        <div class="form-group input-group-sm">
                                                            <label for="estadovta" class="col-form-label">Estado:</label>
                                                            <input type="text" class="form-control" name="estadovta" id="estadovta" value="<?php echo ($estado_vta == 1) ? "ACTIVO" : "CANCELADO"; ?>" disabled>
                                                        </div>
                                                    </div>



                                                </div>
                                                <div class="row justify-content-sm-center">
                                                    <div class="col-sm-1">
                                                        <div class="form-group input-group-sm">
                                                            <label for="folioorden" class="col-form-label">Folio Orden:</label>
                                                            <input type="text" class="form-control" name="folioorden" id="folioorden" value="<?php echo   $folioorden; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                    <div class="form-group input-group-sm">
                                                        <label for="fecha" class="col-form-label">Fecha Orden:</label>
                                                        <input type="date" class="form-control" name="fechaord" id="fechaord" value="<?php echo $fechaini; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group input-group-sm">
                                                        <label for="fecha" class="col-form-label">Fecha Limite:</label>
                                                        <input type="date" class="form-control" name="fechalim" id="fechalim" value="<?php echo $fechafin; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group input-group-sm">
                                                        <label for="fecha" class="col-form-label">Fecha Liberación:</label>
                                                        <input type="date" class="form-control" name="fechalib" id="fechalib" value="<?php echo $fechalib; ?>" disabled>
                                                    </div>
                                                </div>

                                                    <div class="col-sm-1">
                                                        <div class="form-group input-group-sm">
                                                            <label for="edoorden" class="col-form-label">Estado Orden:</label>
                                                            <input type="text" class="form-control" name="edoorden" id="edoorden" value="<?php echo   $edoorden; ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-sm-center">

                                                    <div class="col-lg-8">
                                                        <div class="form-group">


                                                            <label for="nombrecliente" class="col-form-label">Cliente:</label>

                                                            <div class="input-group input-group-sm">

                                                                <input type="text" class="form-control" name="nombrecliente" id="nombrecliente" value="<?php echo $cliente; ?>" disabled>
                                                                <span class="input-group-append">
                                                                    <!--<button id="bcliente" type="button" class="btn btn-primary "><i class="fas fa-search" d></i></button>-->
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>





                                                </div>





                                                <div class="row justify-content-sm-center" style="padding:5px 0px;">

                                                <div class="col-sm-2"></div>


                                                    <div class="col-sm-2 ">
                                                        <label for="gtotalvta" class="col-form-label ">Total:</label>

                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-dollar-sign"></i>
                                                                </span>
                                                            </div>

                                                            <input type="text" class="form-control text-right" name="gtotalvta" id="gtotalvta" value="<?php echo number_format($totalvta, 2); ?>" disabled>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-2 ">
                                                        <label for="pagos" class="col-form-label ">Pagos:</label>

                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-dollar-sign"></i>
                                                                </span>
                                                            </div>

                                                            <input type="text" class="form-control text-right" name="pagos" id="pagos" value="<?php echo number_format($totalpagos, 2); ?>" disabled>
                                                        </div>


                                                    </div>

                                                    <div class="col-sm-2 ">
                                                        <label for="saldo" class="col-form-label ">Saldo:</label>

                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-dollar-sign"></i>
                                                                </span>
                                                            </div>

                                                            <input type="text" class="form-control text-right" name="saldo" id="saldo" value="<?php echo number_format($saldovta, 2); ?>" disabled>
                                                        </div>


                                                    </div>
                                                </div>



                                            </div>
                                        </div>


                                        <div class="card">
                                        <div class="card-header bg-gradient-success">
                                            DETALLE DE PAGOS
                                        </div>
                                        <div class="card-body">

                                            <div class="row justify-content-sm-center">
                                                <div class="col-lg-12 mx-auto">

                                                    <div class="table-responsive" style="padding:5px;">

                                                        <table name="tablaP" id="tablaP" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                            <thead class="text-center bg-gradient-success">
                                                                <tr>
                                                                    <th>Folio</th>
                                                                    <th>Fecha</th>
                                                                    <th>Concepto</th>
                                                                    <th>Monto</th>
                                                                    <th>Metodo</th>
                                                                   

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($datap as $datdet) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $datdet['folio_pagocxc'] ?></td>
                                                                        <td><?php echo $datdet['fecha'] ?></td>
                                                                        <td><?php echo $datdet['concepto'] ?></td>
                                                                        <td class="text-right"><?php echo number_format($datdet['monto']) ?></td>
                                                                        <td><?php echo $datdet['metodo'] ?></td>


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

                                    <?php } ?>
                                </div>
                                <!-- /.card-body -->

                                <!-- /.card-footer-->
                            </div>
                            <!-- /.card -->

                        </section>




                        <?php } 
                        ?>
                    </div>
                </div>

            </div>
        </div>




    </section>






</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/buscadorpres.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>
