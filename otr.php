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
   






    $tokenid = md5($_SESSION['s_usuario']);

    $consulta = "SELECT * FROM ordentrabajo JOIN vorden ON ordentrabajo.folio_orden=vorden.folio_ord where folio_orden='$folio'";

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
                        <!--<button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>-->


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
                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folioorden" class="col-form-label">Folio Orden:</label>
                                            <input type="hidden" class="form-control" name="idot" id="idot" value="<?php echo   $idot; ?>" disabled>
                                            <input type="text" class="form-control" name="folioorden" id="folioorden" value="<?php echo   $folioorden; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="foliof" class="col-form-label">Folio Fisico:</label>

                                            <input type="text" class="form-control" name="foliof" id="foliof" value="<?php echo   $foliofis; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
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
                                            <label for="fechacol" class="col-form-label">Fecha Programada de Colocacion:</label>

                                            <input type="date" class="form-control" name="fechacol" id="fechacol" value="<?php echo   $fechalim; ?>">
                                        </div>
                                    </div>
                                </div>



                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-7">
                                        <div class="form-group">

                                            <label for="concepto" class="col-form-label">Concepto:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="concepto" id="concepto" value="<?php echo $concepto ?>" disabled>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="form-group">

                                            <label for="ubicacion" class="col-form-label">Ubicación:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="ubicacion" id="ubicacion" value="<?php echo $ubicacion ?>" disabled>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-7">
                                        <div class="form-group">


                                            <label for="material" class="col-form-label">Material:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="material" id="material" value="<?php echo $material ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-sm-center">



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
                                    </div>

                                </div>
                                <div class="row justify-content-center">
                                    <!-- Cargar Plano -->
                                    <div class="col-sm-7">
                                        <div class="card">
                                            <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                                <h1 class="card-title ">Despiece</h1>
                                                <div class="card-tools" style="margin:0px;padding:0px;">
                                                   <!-- <button type="button" id="btnAddplano" class="btn bg-gradient-secondary btn-sm">
                                                        <i class="fas fa-folder-plus"></i>
                                                    </button>-->
                                                    <button type="button" class="btn bg-gradient-secondary btn-sm " href="#extra" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                        <i class="fas fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>
                                            <div class="card-body" id="extra">
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-8 text-center">
                                                        <img class="img-responsive img-fluid pad" id="mapa" src="<?php echo $mapaurl ?>" alt="Photo" style="max-width: 500;">
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
                                            <select class="form-control" name="superficie" id="superficie" >
                                                <option id="losa" value="Losa"  <?php echo ($superficie == 'Losa') ? "selected" : "" ?>> Losa</option>
                                                <option id="madera" value="Madera"  <?php echo ($superficie == 'Madera') ? "selected" : "" ?>> Madera</option>
                                                <option id="tubos" value="Tubos"  <?php echo ($superficie == 'Tubos') ? "selected" : "" ?>> Tubos</option>
                                                <option id="estructura" value="Estructura"  <?php echo ($superficie == 'Estructura') ? "selected" : "" ?>> Estructura</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="tipo" class="col-form-label">Tipo de Servicio:</label>
                                            <select class="form-control" name="tipo" id="tipo" <?php ?>>
                                                <option id="PRODUCCION" value="Producción"  <?php echo ($tipo == 'Producción') ? "selected" : "" ?>> Producción</option>
                                                <option id="TRANSFORMACIÓN" value="Transformación"  <?php echo ($tipo == 'Transformación') ? "selected" : "" ?>> Transformación</option>
                                                <option id="COLOCACIÓN" value="Colocación"  <?php echo ($tipo == 'Colocación') ? "selected" : "" ?>> Colocación</option>
                                                
                                            </select>

                                        </div>
                                    </div>
                                </div>






                                <div class=" row justify-content-sm-center">
                                    <div class="col-sm-7">

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

    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/ot.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>