<?php
$pagina = "item";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vitem WHERE estado_item=1 ORDER BY id_item";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consultai = "SELECT * FROM insumo WHERE estado_insumo =1 ORDER BY id_insumo";
$resultadoi = $conexion->prepare($consultai);
$resultadoi->execute();
$datai = $resultadoi->fetchAll(PDO::FETCH_ASSOC);

$consultaa = "SELECT * FROM acabado WHERE estado_acabado=1 ORDER BY id_acabado";
$resultadoa = $conexion->prepare($consultaa);
$resultadoa->execute();
$dataa = $resultadoa->fetchAll(PDO::FETCH_ASSOC);

$consultac = "SELECT * FROM color WHERE estado_color=1 ORDER BY id_color";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);



$message = "";



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
            <div class="card-header bg-gradient-orange text-light">
                <h1 class="card-title mx-auto">Catalago de Items (Materiales y Servicios)</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                        <a href="help/items/" target="_blank" rel="noopener"><button id="btnAyuda" type="button" class="btn bg-gradient-info btn-ms"><i class="fas fa-question-circle text-light"></i><span class="text-light"> Ayuda</span></button></a>
                    </div>
                </div>
                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto w-auto " style="width:100%">
                                    <thead class="text-center bg-gradient-orange">
                                        <tr>
                                            <th>Id Item</th>
                                            <th>Clave Item</th>
                                            <th>Descripcion</th>
                                            <th class="hide_column">Id Insumo</th>
                                            <th>clave Insumo</th>
                                            <th>Insumo</th>
                                            <th>Id Color</th>
                                            <th>Clave Color</th>
                                            <th>Color</th>
                                            <th>Id Acabado</th>
                                            <th>Clave Acabado</th>
                                            <th>Acabado</th>
                                            <th>Tipo</th>
                                            <th>Clave Inv</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_item'] ?></td>
                                                <td><?php echo $dat['clave_item'] ?></td>
                                                <td><?php echo $dat['nom_item'] ?></td>
                                                <td class="hide_column"><?php echo $dat['id_insumo'] ?></td>
                                                <td><?php echo $dat['clave_insumo'] ?></td>
                                                <td><?php echo $dat['nom_insumo'] ?></td>
                                                <td><?php echo $dat['id_color'] ?></td>
                                                <td><?php echo $dat['clave_color'] ?></td>
                                                <td><?php echo $dat['nom_color'] ?></td>
                                                <td><?php echo $dat['id_acabado'] ?></td>
                                                <td><?php echo $dat['clave_acabado'] ?></td>
                                                <td><?php echo $dat['nom_acabado'] ?></td>
                                                <td><?php echo $dat['tipo_item'] ?></td>
                                                <td><?php echo $dat['claveinv'] ?></td>
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
            <!-- /.card-body -->
           
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>


    <section>
        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title" id="exampleModalLabel">NUEVO ITEM</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body row">

                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="clave" class="col-form-label">Clave:</label>
                                        <input type="text" class="form-control" name="clave" id="clave" autocomplete="off" placeholder="Clave">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="claveinv" class="col-form-label">Clave Inventario:</label>
                                        <input type="text" class="form-control" name="claveinv" id="claveinv" autocomplete="off" placeholder="Clave">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="nombre" class="col-form-label">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" placeholder="Nombre">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm auto">
                                        <label for="insumo" class="col-form-label">Insumo:</label>
                                        <select class="form-control" name="insumo" id="insumo">
                                            <?php
                                            foreach ($datai as $dti) {
                                            ?>
                                                <option id="<?php echo $dti['id_insumo'] ?>" value="<?php echo $dti['id_insumo'] ?>"> <?php echo $dti['clave_insumo'] . ' ' . $dti['nom_insumo'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm auto">
                                        <label for="color" class="col-form-label">Color:</label>
                                        <select class="form-control" name="color" id="color">
                                            <?php
                                            foreach ($datac as $dtc) {
                                            ?>
                                                <option id="<?php echo $dtc['id_color'] ?>" value="<?php echo $dtc['id_color'] ?>"> <?php echo $dtc['clave_color'] . ' ' . $dtc['nom_color'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm auto">
                                        <label for="acabado" class="col-form-label">Acabado:</label>
                                        <select class="form-control" name="acabado" id="acabado">
                                            <?php
                                            foreach ($dataa as $dta) {
                                            ?>
                                                <option id="<?php echo $dta['id_acabado'] ?>" value="<?php echo $dta['id_acabado'] ?>"> <?php echo $dta['clave_acabado'] . ' ' . $dta['nom_acabado'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm auto">
                                        <label for="tipo" class="col-form-label">Tipo:</label>
                                        <select class="form-control" name="tipo" id="tipo">
                                            
                                            <option id="material" value="Material">Material</option>
                                            <option id="servicio" value="Servicio">Servicio</option>
                                            <option id="servicio" value="Producto">Producto</option>

                                            
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
                        <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/item.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>