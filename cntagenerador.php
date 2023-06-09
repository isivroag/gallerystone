<?php
$pagina = "ordenobra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();


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

    $consultagen = "SELECT * FROM v_resgenerador where id_ord='$folioorden'";

    $resultadogen = $conexion->prepare($consultagen);
    $resultadogen->execute();


    $datagen = $resultadogen->fetchAll(PDO::FETCH_ASSOC);
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
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">Consulta de Generadores</h1>
            </div>

            <div class="card-body">

                <div class="container-fluid">

                    <div class="card card-widget " style="margin-bottom:0px;">

                        <div class="card-header bg-gradient-success " style="margin:0px;padding:8px">

                            <h1 class="card-title ">Datos Generales de Orden # <?php echo $folioorden; ?></h1>
                            <div class="card-tools" style="margin:0px;padding:0px;">

                                <button type="button" class="btn bg-gradient-success btn-sm " href="#cuerpo" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>


                        <div class="card-body" id="cuerpo" style="margin:0px;padding:1px;">

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
                                        <label for="folior" class="col-form-label">Folio Vta:</label>

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

                </div>
                <br>
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header bg-gradient-secondary">
                            Filtro por rango de Fecha
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Desde:</label>
                                        <input type="date" class="form-control" name="inicio" id="inicio">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fecha" class="col-form-label">Hasta:</label>
                                        <input type="date" class="form-control" name="final" id="final">
                                    </div>
                                </div>

                                <div class="col-lg-1 align-self-end text-center">
                                    <div class="form-group input-group-sm">
                                        <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">

                        <div class="card-header bg-gradient-secondary">
                            Generadores
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <button id="btnestimacion" name="btnestimacion" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-file-invoice"></i> Estimación</button>

                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <form action="" id="formdatos">
                                            <input type="text" id="texto">
                                            <button type="submit" id="aceptar">Aceptar</button>

                                            <table name="tablaV" id="tablaV" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto " style="font-size:15px;">
                                                <thead class="text-center bg-gradient-secondary">
                                                    <tr>
                                                        <th></th>
                                                        <th>Folio</th>
                                                        <th>Id Frente</th>
                                                        <th>Frente</th>
                                                        <th>Id Area</th>
                                                        <th>Area</th>
                                                        <th>Fecha Reg</th>
                                                        <th>Inicio </th>
                                                        <th>Fin</th>
                                                        <th>Costo</th>
                                                        <th>Precio Clie</th>
                                                        <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($datagen as $rowg) {
                                                    ?>
                                                        <tr class="">
                                                            <td></td>
                                                            <td><?php echo $rowg['folio_gen'] ?></td>
                                                            <td><?php echo $rowg['id_frente'] ?></td>
                                                            <td><?php echo $rowg['nom_frente'] ?></td>
                                                            <td><?php echo $rowg['id_area'] ?></td>
                                                            <td><?php echo $rowg['area'] ?></td>
                                                            <td><?php echo $rowg['fecha'] ?></td>
                                                            <td><?php echo $rowg['inicio'] ?></td>
                                                            <td><?php echo $rowg['fin'] ?></td>
                                                            <td class="text-right"><?php echo  number_format($rowg['costo_gen'], 2) ?></td>
                                                            <td class="text-right"><?php echo  number_format($rowg['pp_gen'], 2) ?></td>
                                                            
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>

                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right">TOTALES</th>
                                                        <th class="text-right"></th>
                                                        <th class="text-right"></th>
                                                    </tr>


                                                </tfoot>

                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>




</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntagenerador.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>