<?php
$pagina = "ordenobra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$message = "";
$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$idarea = (isset($_GET['idarea'])) ? $_GET['idarea'] : '';
$tokenid = md5($_SESSION['s_usuario']);


if (isset($_GET['folio'])) {
    $folio = $_GET['folio'];
    $consulta = "SELECT * FROM generador WHERE folio_gen='$folio'";
    $resultadobpres = $conexion->prepare($consulta);
    $resultadobpres->execute();
    if ($resultadobpres->rowCount() >= 1) {
        $databpres = $resultadobpres->fetchAll(PDO::FETCH_ASSOC);
        foreach ($databpres as $dtbpres) {
            $foliotmp = $dtbpres['folio_tmp'];
            $generador = $dtbpres['folio_gen'];
        }
        $consulta = "SELECT * FROM vtmpgen WHERE folio_gen='$foliotmp'";
    }
} else {
    $consulta = "SELECT * FROM vtmpgen WHERE estado_gen='1' and id_area='$idarea' and tokenid='$tokenid'";
    $generador = 0;
}



$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio = $dt['folio_gen'];
        $idarea = $dt['id_area'];
        $idord = $dt['id_ord'];
        $frente = $dt['nom_frente'];
        $supervisor = $dt['supervisor'];
        $colocador = $dt['colocador'];
        $fecha = $dt['fecha'];
        $inicio = $dt['inicio'];
        $fin = $dt['fin'];
        $nombre = $dt['descripcion'];
        $area = $dt['area'];
    }
} else {
    if ($idarea != '') {
        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO tmp_gen (tokenid,id_area,estado_gen,fecha,inicio,fin) VALUES('$tokenid','$idarea','1','$fecha','$fecha','$fecha')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();

        $consultatmp = "SELECT * FROM vtmpgen WHERE tokenid='$tokenid' and estado_gen='1' and id_area='$idarea' ORDER BY folio_gen DESC LIMIT 1";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
        foreach ($datatmp as $dt) {

            $folio = $dt['folio_gen'];
            $idarea = $dt['id_area'];
            $idord = $dt['id_ord'];
            $frente = $dt['nom_frente'];
            $supervisor = $dt['supervisor'];
            $colocador = $dt['colocador'];
            $fecha = $dt['fecha'];
            $inicio =  $dt['inicio'];;
            $fin =  $dt['fin'];;
            $nombre = "";
            $area = "";
        }
    } else {
        $folio = "";
        $idarea = "";
        $idord = "";
        $frente = "";
        $supervisor = "";
        $colocador = "";
        $fecha = "";
        $inicio = "";
        $fin = "";
        $nombre = "";
        $area = "";
    }
}

$message = "";


/*
if ($id != "") {

    $consultatmp = "SELECT * FROM vtmp_gen WHERE tokenid='$tokenid' and estado_gen='1' and id_frente='$frente' ORDER BY id_gen DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $dt) {
        $folioorden = $dt['id_ord'];
        $id = $dt['id_gen'];
        $frente = $dt['id_frente'];
        $zona = $dt['nom_frente'];
        $supervisor = $dt['supervisor_frente'];
        $colocador = $dt['colocador_frente'];
        $idgen = "";
        $area = $dt['area'];
        $nombre = $dt['descripcion'];
        $inicio = $dt['inicio'];
        $fin = $dt['fin'];
    }

   
} else {
    if ($frente != '') {
        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO tmp_gen (tokenid,id_frente,estado_gen,fecha) VALUES('$tokenid','$frente','1','$fecha')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();

        $consultatmp = "SELECT * FROM vtmp_gen WHERE tokenid='$tokenid' and estado_gen='1' and id_frente='$frente' ORDER BY id_gen DESC LIMIT 1";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $dt) {
            $folioorden = $dt['id_ord'];
            $id = $dt['id_gen'];
            $frente = $dt['id_frente'];
            $zona = $dt['nom_frente'];
            $supervisor = $dt['supervisor_frente'];
            $colocador = $dt['colocador_frente'];
            $idgen = "";
            $area = "";
            $nombre = "";
            $inicio = date('Y-m-d');
            $fin = date('Y-m-d');
        }
    }else{
        $folioorden = "";
        $id = "";
        $frente ="";
        $zona ="";
        $supervisor = "";
        $colocador = "";
        $idgen = "";
        $area = "";
        $nombre = "";
        $fecha = date('Y-m-d');
        $inicio = date('Y-m-d');
        $fin = date('Y-m-d');
    }
}
*/

?>



<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">
<style>
    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    #div_carga {
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

    #cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc {
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

            <div id="div_carga">

                <img id="cargador" src="img/loader.gif" />
                <span class=" " id="textoc"><strong>Cargando...</strong></span>

            </div>

            <div class="card-header bg-gradient-secondary">
                <h1 class="card-title mx-auto">GENERADOR</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">


                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-primary btn-ms" data-toggle="modal"><i class="fas fa-envelope-square"></i> Enviar</button>-->
                    </div>
                </div>
                <br>

                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget " style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                <h1 class="card-title ">Datos Generales</h1>

                            </div>


                            <div class=" card-body" id="cuerpo" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center px-2">

                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folioorden" class="col-form-label">Folio Orden:</label>
                                            <input type="text" class="form-control" name="folioorden" id="folioorden" value="<?php echo   $idord; ?>" disabled>
                                            <input type="hidden" class="form-control form-control-sm" name="idarea" id="idarea" value="<?php echo   $idarea; ?>" disabled>

                                        </div>
                                    </div>



                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="area" class="col-form-label">Frente:</label>
                                            <input type="text" class="form-control form-control-sm" name="area" id="area" value="<?php echo $frente; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group">
                                            <label for="supervisor" class="col-form-label">Supervisor:</label>
                                            <input type="text" class="form-control form-control-sm" name="supervisor" id="supervisor" disabled value="<?php echo $supervisor; ?>">
                                        </div>

                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group">
                                            <label for="colocador" class="col-form-label">Colocador:</label>
                                            <input type="text" class="form-control form-control-sm" name="colocador" id="colocador" disabled value="<?php echo $colocador; ?>">
                                        </div>

                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="idgen" class="col-form-label">ID Generador:</label>
                                            <input type="hidden" class="form-control form-control-sm" name="foliogen" id="foliogen" value="<?php echo   $generador; ?>" disabled>
                                            <input type="text" class="form-control form-control-sm" name="idgen" id="idgen" value="<?php echo   $folio; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fechagen" class="col-form-label">Fecha Gen:</label>
                                            <input type="date" class="form-control form-control-sm" name="fechagen" id="fechagen" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>


                                </div>

                                <div class=" row justify-content-sm-center px-2">


                                    <div class="col-lg-5">
                                        <div class="form-group">

                                            <label for="nombre" class="col-form-label">Descripcion:</label>
                                            <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre; ?>">

                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group input-group-sm">
                                            <label for="areacol" class="col-form-label">Area Colocacion:</label>
                                            <input type="text" class="form-control form-control-sm" name="areacol" id="areacol" value="<?php echo $area; ?>" disabled>
                                        </div>
                                    </div>



                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fechaini" class="col-form-label">Fecha Inicio:</label>
                                            <input type="date" class="form-control form-control-sm" name="fechaini" id="fechaini" value="<?php echo $inicio ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fechafin" class="col-form-label">Fecha Final:</label>
                                            <input type="date" class="form-control form-control-sm" name="fechafin" id="fechafin" value="<?php echo $fin ?>">
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
                                                <table name="tablaD" id="tablaD" class=" table table-sm table-striped  table-hover table-bordered table-condensed text-nowrap mx-auto" style="width:100%;">
                                                    <thead class="text-center bg-gradient-secondary">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Id</th>
                                                            <th>Concepto</th>
                                                            <th>Cantidad </th>
                                                            <th>Acciones</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        $consultad = "SELECT * FROM detalle_tmpgen where folio_gen='$folio' and estado_detalle=1 order by id_reg";
                                                        $resultadod = $conexion->prepare($consultad);
                                                        $resultadod->execute();
                                                        if ($resultadod->rowCount() >= 1) {
                                                            $datad = $resultadod->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($datad as $rowd) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $rowd['id_reg'] ?></td>
                                                                    <td><?php echo $rowd['id_concepto'] ?></td>
                                                                    <td><?php echo $rowd['nom_concepto'] ?></td>
                                                                    <td><?php echo $rowd['cantidad'] ?></td>

                                                                    <td></td>
                                                                </tr>
                                                        <?php
                                                            }
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
                                            $consultac = "SELECT * FROM detalle_area where id_area='$idarea' and estado_detalle=1 order by id_concepto";
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






</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/generador.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>