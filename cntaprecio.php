<?php
$pagina = "precio";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$id_item = $_GET['id'];


$consulta = "SELECT * FROM vprecio WHERE id_item='$id_item' ORDER BY id_precio";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consultam = "SELECT id_item,clave_item,nom_item FROM item WHERE id_item='$id_item' ORDER BY id_item";
$resultadom = $conexion->prepare($consultam);
$resultadom->execute();
$datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);

$consultau = "SELECT * FROM umedida ORDER BY id_umedida";
$resultadou = $conexion->prepare($consultau);
$resultadou->execute();
$datau = $resultadou->fetchAll(PDO::FETCH_ASSOC);

foreach ($datam as $dtm) {
    $clave_item = $dtm['clave_item'];
    $nom_item = $dtm['nom_item'];
}


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
        <div class="card ">
            <div class="card-header bg-gradient-orange text-light">
                <h1 class="card-title mx-auto">Precios</h1>
            </div>

            <div class="card-body">


                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>
                <div class="container-fluid">
                    <div class="row justify-content-sm-center bg-gradient-orange py-2 px-3 mt-4" disabled>
                        <div class="col-sm-3 ">
                            <label for="iditem" class="col-form-label">Id Item: </label>
                            <input type="text" class="form-control" name="iditem" id="iditem" value="<?php echo $id_item ?>" disabled>
                        </div>
                        <div class="col-sm-3 ">
                            <label for="clavemat" class="col-form-label">Clave Item: </label>
                            <input type="text" class="form-control" name="clavemat" id="clavemat" value="<?php echo $clave_item ?>" disabled>
                        </div>
                        <div class="col-sm-3 ">
                            <label for="nommat" class="col-form-label">Descripción: </label>
                            <input type="text" class="form-control" name="nommat" id="nommat" value="<?php echo $nom_item ?>" disabled>
                        </div>

                    </div>

                    <div class="row ">
                        <div class="col-lg-12 ">
                            <div class="table-responsive ">
                                <br>
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-orange">
                                        <tr>
                                            <th>Id Precio</th>
                                            <th>Id U.Medida</th>
                                            <th>U.Medida</th>
                                            <th>Formato</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_precio'] ?></td>
                                                <td><?php echo $dat['id_umedida'] ?></td>
                                                <td><?php echo $dat['nom_umedida'] ?></td>
                                                <td><?php echo $dat['formato'] ?></td>
                                                <td><?php echo $dat['monto'] ?></td>

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
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title" id="exampleModalLabel">NUEVO UNIDAD/PRECIO</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body row">

                                
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="unidad" class="col-form-label">Formato:</label>
                                        <input type="text" class="form-control" name="unidad" id="unidad" autocomplete="off" placeholder="Formato">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm auto">
                                        <label for="umedida" class="col-form-label">Unidad de Medida:</label>
                                        <select class="form-control" name="umedida" id="umedida">
                                            <?php
                                            foreach ($datau as $dtu) {
                                            ?>
                                                <option id="<?php echo $dtu['id_umedida'] ?>" value="<?php echo $dtu['id_umedida'] ?>"> <?php echo $dtu['nom_umedida'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="precio" class="col-form-label">Precio:</label>
                                        <input type="text" class="form-control" name="precio" id="precio" autocomplete="off" placeholder="Precio">
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
<script src="fjs/precio.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>