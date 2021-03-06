<?php
$pagina = "ordenobra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$id = (isset($_GET['id'])) ? $_GET['id'] : '';

if ($id != "") {
    $objeto = new conn();
    $conexion = $objeto->connect();
    $tokenid = md5($_SESSION['s_usuario']);

    $consulta = "SELECT * FROM vareas where id_area='$id'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);



    foreach ($data as $dt) {
        $folioorden = $dt['id_ord'];
        $mapaurl = $dt['mapaurl'];



        $nombre = $dt['nom_frente'];
        $area = $dt['area'];
        $supervisor = $dt['supervisor'];
        $colocador = $dt['colocador'];
    }

    $message = "";
} else {
    $folioorden = '';



    $nombre = '';
    $area = '';
    $supervisor = '';
    $colocador = '';
}


?>



<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
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
                <h1 class="card-title mx-auto">DETALLE FRENTE /AREA</h1>
            </div>


            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <button id="btnregresar" type="button" class="btn bg-gradient-secondary btn-ms" data-toggle="modal"><i class="fas fa-angle-double-left text-light"></i><span class="text-light"> Regresar a Ordenes</span></button>
                    </div>
                </div>
                <br>




                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget " style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                <h1 class="card-title ">Datos Frente</h1>

                            </div>


                            <div class=" card-body" id="cuerpo" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center compact ">

                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folioorden" class="col-form-label">Folio Orden:</label>
                                            <input type="text" class="form-control form-control-sm" name="folioorden" id="folioorden" value="<?php echo   $folioorden; ?>" disabled>

                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group">

                                            <label for="nombre" class="col-form-label">Frente:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre; ?>" disabled>

                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="area" class="col-form-label">Area:</label>
                                            <input type="text" class="form-control form-control-sm" name="area" id="area" value="<?php echo $area; ?>" disabled>
                                        </div>
                                    </div>




                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="idarea" class="col-form-label">ID Area:</label>

                                            <input type="text" class="form-control form-control-sm" name="idarea" id="idarea" value="<?php echo   $id; ?>" disabled>
                                        </div>
                                    </div>

                                </div>

                                <div class=" row justify-content-sm-center">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="supervisor" class="col-form-label">Supervisor:</label>
                                            <input type="text" class="form-control form-control-sm" name="supervisor" id="supervisor" disabled value="<?php echo $supervisor; ?>">
                                        </div>

                                    </div>

                                    <div class="col-sm-5">

                                        <div class="form-group">
                                            <label for="colocador" class="col-form-label">Colocador:</label>
                                            <input type="text" class="form-control form-control-sm" name="colocador" id="colocador" disabled value="<?php echo $colocador; ?>">
                                        </div>

                                    </div>



                                </div>



                            </div>


                        </div>
                        <!-- Formulario Agrear Item -->

                        <!-- Tabla -->
                        <div class="content" style="padding:5px 0px;">

                            <div class="card card-widget">
                                <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                    <h1 class="card-title ">Detalle</h1>

                                </div>

                                <div class="card-body" style="margin:0px;padding:3px;">



                                    <div class="card">
                                        <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                            <h1 class="card-title ">Conceptos</h1>
                                            <div class="card-tools" style="margin:0px;padding:0px;">
                                                <button type="button" id="btnAddcom" class="btn bg-gradient-secondary btn-sm">
                                                    <i class="fas fa-folder-plus"></i>
                                                </button>
                                                <button type="button" class="btn bg-gradient-secondary btn-sm " href="#extra" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="card-body" id="extra">
                                            <div class="col-sm-auto">
                                                <table name="tablaD" id="tablaD" class=" table table-sm table-striped  table-hover table-bordered table-condensed text-nowrap compact" style="width:100%;">
                                                    <thead class="text-center bg-gradient-secondary">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Id</th>
                                                            <th>Concepto</th>
                                                            <th>Cantidad Presupuesto</th>
                                                            <th>Generado</th>
                                                            <th>Pendiente</th>
                                                            <th>Acciones</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $consultad = "SELECT * FROM detalle_area where id_area='$id' and estado_detalle=1 order by id_reg";

                                                        $resultadod = $conexion->prepare($consultad);
                                                        $resultadod->execute();


                                                        $datad = $resultadod->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($datad as $rowd) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $rowd['id_reg'] ?></td>
                                                                <td><?php echo $rowd['id_concepto'] ?></td>
                                                                <td><?php echo $rowd['nom_concepto'] ?></td>
                                                                <td><?php echo $rowd['cantidad'] ?></td>
                                                                <td><?php echo $rowd['generado'] ?></td>
                                                                <td><?php echo $rowd['pendiente'] ?></td>
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

                                    <div class="card">
                                        <div class="card-header bg-gradient-lightblue " style="margin:0px;padding:8px">

                                            <h1 class="card-title ">Generadores</h1>
                                            <div class="card-tools" style="margin:0px;padding:0px;">
                                                <button type="button" id="btnAddgen" class="btn bg-gradient-lightblue btn-sm">
                                                    <i class="fas fa-folder-plus"></i>
                                                </button>
                                                <button type="button" class="btn bg-gradient-lightblue btn-sm " href="#extra" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="card-body" id="extra">
                                            <div class="col-sm-auto">
                                                <table name="tablaG" id="tablaG" class=" table compact table-sm table-striped  table-hover table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                    <thead class="text-center bg-gradient-lightblue">
                                                        <tr>
                                                            <th>Folio Gen</th>
                                                            <th>Fecha</th>
                                                            <th>Descripcion</th>
                                                            <th>Area</th>
                                                            <th>Inicio</th>
                                                            <th>Fin</th>
                                                            <th>Costo</th>
                                                            <th>Cliente</th>
                                                            <th>Acciones</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $consultad = "SELECT * FROM generador where id_area='$id' and estado_gen=1 order by folio_gen";

                                                        $resultadod = $conexion->prepare($consultad);
                                                        $resultadod->execute();


                                                        $datad = $resultadod->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($datad as $rowd) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $rowd['folio_gen'] ?></td>
                                                                <td><?php echo $rowd['fecha'] ?></td>
                                                                <td><?php echo $rowd['descripcion'] ?></td>
                                                                <td><?php echo $rowd['area'] ?></td>
                                                                <td><?php echo $rowd['inicio'] ?></td>
                                                                <td><?php echo $rowd['fin'] ?></td>
                                                                <td class='text-right'><?php echo '$ ' . number_format($rowd['costo_gen'], 2) ?></td>
                                                                <td class='text-right'><?php echo '$ ' . number_format($rowd['pp_gen'], 2) ?></td>
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

                                    <!-- Cargar Plano
                                    <div class="card">
                                        <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                            <h1 class="card-title ">Plano</h1>
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
                                                <div class="col-sm-8 text-center">
                                                    <img class="img-responsive img-fluid pad" id="mapa" src="<?php echo $mapaurl ?>" alt="Photo" style="max-width: 500;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
 -->



                                </div>

                            </div>

                        </div>
                        <!-- Formulario totales -->

                    </div>





                </form>


                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>

        </div>

        <!-- /.card -->

    </section>



    <section>
        <div class="modal fade" id="modalCom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Concepto</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formCom" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-10">
                                    <div class="form-group input-group-sm auto">
                                        <label for="concepto" class="col-form-label">Concepto:</label>
                                        <select class="form-control" name="concepto" id="concepto">
                                            <?php
                                            $consultac = "SELECT id_concepto,nom_concepto FROM detalle_conceptosobra where id_orden='$folioorden' and estado_detalle=1 order by id_concepto";
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

                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="cantcom" class="col-form-label">Cantidad:</label>
                                        <input type="text" class="form-control" name="cantcom" id="cantcom" autocomplete="off" placeholder="Cantidad">
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

                    </form>
                </div>
            </div>
        </div>
    </section>





</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/detallefrente.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>