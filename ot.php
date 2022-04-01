<?php
$pagina = "orden";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';


if ($folio != "") {
    $folioorden = $folio;
    $objeto = new conn();
    $conexion = $objeto->connect();


    $consulta = "SELECT *  FROM ordentrabajo WHERE folio_orden='$folioorden'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if ($resultado->rowCount() == 0) {
        $consulta = "INSERT INTO ordentrabajo(folio_orden,mapaurl,estado_ot) VALUES ('$folioorden','img/nd.png','0')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
    }






    $tokenid = md5($_SESSION['s_usuario']);

    $consulta = "SELECT * FROM vot where folio_orden='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);



    foreach ($data as $dt) {
        $folioorden = $dt['folio_ord'];


        $foliofis = $dt['folio_fisico'];
        $foliovta = $dt['folio_vta'];


        $fecha = $dt['fecha_ord'];
        $fechalim = $dt['fecha_limite'];
        $nomclie = $dt['nombre'];
        $concepto = $dt['concepto_vta'];
        $ubicacion = $dt['ubicacion'];
        $notas = $dt['notas'];
        $mapaurl = $dt['mapaurl'];
        $idot = $dt['id_ot'];
        $material = $dt['material_ot'];
        $moldura = $dt['moldura_ot'];
        $zoclo = $dt['zoclo_ot'];
        $superficie = $dt['superficie_ot'];
        $tipo = $dt['tipos_ot'];
        $obs = $dt['obs_ot'];



        $consultadet = "SELECT * FROM vdetalle_vta where folio_vta='$foliovta' GROUP BY id_item order by id_reg";
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);


        $consultad = "SELECT * FROM det_ot where id_ot='$folioorden' order by id_reg";
        $resultadod = $conexion->prepare($consultad);
        $resultadod->execute();
        $datad = $resultadod->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    $folio = "";
    $folioorden = "";
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">ORDEN DE TRABAJO</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">

                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-secondary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        <button id="btnVer" name="btnVer" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-file-pdf" aria-hidden="true"></i> Preview</button>


                    </div>
                </div>

                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content" disab>

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                <h1 class="card-title ">DATOS</h1>
                            </div>

                            <div class="card-body " style="margin:0px;padding:10px;">
                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folioorden" class="col-form-label">Folio Orden:</label>
                                            <input type="hidden" class="form-control" name="idot" id="idot" value="<?php echo   $idot; ?>" disabled>
                                            <input type="text" class="form-control" name="folioorden" id="folioorden" value="<?php echo   $folioorden; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="foliof" class="col-form-label">Folio Fisico:</label>

                                            <input type="text" class="form-control" name="foliof" id="foliof" value="<?php echo   $foliofis; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="foliov" class="col-form-label">Folio Venta:</label>

                                            <input type="text" class="form-control" name="foliov" id="foliov" value="<?php echo   $foliovta; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fechaini" class="col-form-label">Fecha Inicio:</label>

                                            <input type="date" class="form-control" name="fechaini" id="fechaini" value="<?php echo   $fecha; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fechacol" class="col-form-label">Fecha Prog. de Col.:</label>

                                            <input type="date" class="form-control" name="fechacol" id="fechacol" value="<?php echo   $fechalim; ?>">
                                        </div>
                                    </div>
                                </div>



                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-10">
                                        <div class="form-group">

                                            <label for="concepto" class="col-form-label">Concepto:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="concepto" id="concepto" value="<?php echo $concepto ?>" disabled>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="form-group">

                                            <label for="ubicacion" class="col-form-label">Ubicación:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="ubicacion" id="ubicacion" value="<?php echo $ubicacion ?>" disabled>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-10">
                                        <table name="tablaD" id="tablaD" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                            <thead class="text-center bg-gradient-secondary">
                                                <tr>
                                                    <th>Materiales</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                foreach ($datadet as $datdet) {
                                                ?>
                                                    <tr>

                                                        <td><?php echo $datdet['nom_item'] ?></td>


                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-10">
                                        <div class="card">
                                            <div class="card-header bg-gradient-secondary" style="margin:0px;padding:8px">
                                                <h1 class="card-title">Detalle OT</h1>
                                                <div class="card-tools" style="margin:0px;padding:0px;">
                                                    <button type="button" id="btnadetalle" class="btn bg-gradient-secondary btn-sm">
                                                        <i class="fas fa-folder-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <table name="tabladet" id="tabladet" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                    <thead class="text-center bg-gradient-secondary">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Concepto</th>
                                                            <th>Medida</th>
                                                            <th>Acciones</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        foreach ($datad as $datd) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $datd['id_reg'] ?></td>
                                                                <td><?php echo $datd['concepto'] ?></td>
                                                                <td><?php echo $datd['medida'] ?></td>
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
                                    <!--
                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="moldura" class="col-form-label">Moldura:</label>
                                            <div class="input-group input-group-sm">



                                                <input type="text" class="form-control" name="moldura" id="moldura" value="<?php echo $moldura ?>">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="zoclo" class="col-form-label">Zoclo:</label>
                                            <div class="input-group input-group-sm">



                                                <input type="text" class="form-control" name="zoclo" id="zoclo" value="<?php echo $zoclo ?>">

                                            </div>

                                        </div>
                                    </div>-->

                                </div>
                                <div class="row justify-content-center">
                                    <!-- Cargar Plano -->
                                    <div class="col-sm-10">
                                        <div class="card">
                                            <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                                <h1 class="card-title ">Despiece</h1>
                                                <div class="card-tools" style="margin:0px;padding:0px;">
                                                    <button type="button" id="btnAddplano" class="btn bg-gradient-secondary btn-sm">
                                                        <i class="fas fa-folder-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn bg-gradient-secondary btn-sm " href="#extra" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                        <i class="fas fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>
                                            <div class="card-body" id="extra">
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-12 text-center">
                                                        <img class="img-responsive img-fluid pad" id="mapa" src="<?php echo $mapaurl ?>" alt="Photo" style="max-width: 780;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class=" row justify-content-sm-center">
                                    <div class="col-sm-3">


                                        <div class="form-group input-group-sm auto">
                                            <label for="superficie" class="col-form-label">Superificie de Colocación:</label>
                                            <select class="form-control" name="superficie" id="superficie">
                                                <option id="losa" value="Losa" <?php echo ($superficie == 'Losa') ? "selected" : "" ?>> Losa</option>
                                                <option id="madera" value="Madera" <?php echo ($superficie == 'Madera') ? "selected" : "" ?>> Madera</option>
                                                <option id="tubos" value="Tubos" <?php echo ($superficie == 'Tubos') ? "selected" : "" ?>> Tubos</option>
                                                <option id="estructura" value="Estructura" <?php echo ($superficie == 'Estructura') ? "selected" : "" ?>> Estructura</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="tipo" class="col-form-label">Tipo de Servicio:</label>
                                            <select class="form-control" name="tipo" id="tipo" <?php ?>>
                                                <option id="PRODUCCION" value="Producción" <?php echo ($tipo == 'Producción') ? "selected" : "" ?>> Producción</option>
                                                <option id="TRANSFORMACIÓN" value="Transformación" <?php echo ($tipo == 'Transformación') ? "selected" : "" ?>> Transformación</option>
                                                <option id="COLOCACIÓN" value="Colocación" <?php echo ($tipo == 'Colocación') ? "selected" : "" ?>> Colocación</option>

                                            </select>

                                        </div>
                                    </div>
                                </div>






                                <div class=" row justify-content-sm-center">
                                    <div class="col-sm-10">

                                        <div class="form-group">
                                            <label for="obs" class="col-form-label">Observaciones:</label>
                                            <textarea rows="2" class="form-control" name="obs" id="obs"><?php echo $obs ?></textarea>
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
            <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-secondary">
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


    <section>
        <div class="modal fade" id="modalMAPA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">Subir Archivo</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formMapa" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-12">



                                    <div class="form-group">
                                        <label for="exampleInputFile">Subir Archivo</label>
                                        <div class="input-group">
                                            <div class="custom-file">

                                                <input type="file" class="custom-file-input" name="archivo" id="archivo">

                                                <label class="custom-file-label" for="archivo">Elegir Archivo</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" id="upload">Subir</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                    </div>




                    </form>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="modal fade" id="modalCom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Detalle OT</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formCom" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-9">
                                    <div class="form-group input-group-sm">
                                        <label for="conceptocom" class="col-form-label">Concepto:</label>
                                        <input type="text" class="form-control" name="conceptocom" id="conceptocom" autocomplete="off" placeholder="Concepto">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="cantcom" class="col-form-label">Cantidad:</label>
                                        <input type="text" class="form-control" name="cantcom" id="cantcom" autocomplete="off" placeholder="Cantidad">
                                    </div>
                                </div>
                            </div>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                        <button type="button" id="btnGuardarcom" name="btnGuardarcom" class="btn btn-success" value="btnGuardarcom"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <section>
        <div class="modal fade" id="modalmed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Detalle OT</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formmed" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-9">
                                    <div class="form-group input-group-sm">
                                        <label for="conceptocom2" class="col-form-label">Concepto:</label>
                                        <input type="hidden" class="form-control" name="idreg" id="idreg" autocomplete="off" disabled>
                                        <input type="text" class="form-control" name="conceptocom2" id="conceptocom2" autocomplete="off" placeholder="Concepto" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="medidacom" class="col-form-label">Medida:</label>
                                        <input type="text" class="form-control" name="medidacom" id="medidacom" autocomplete="off" placeholder="Cantidad">
                                    </div>
                                </div>
                            </div>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                        <button type="button" id="btnGuardarmed" name="btnGuardarmed" class="btn btn-success" value="btnGuardarmed"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/ot.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>