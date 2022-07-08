<?php
$pagina = "herramienta";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$consulta = "SELECT * FROM vherramienta WHERE estado_her=1 ORDER BY id_her";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


$consultau = "SELECT * FROM personal WHERE estado_per=1 ORDER BY id_per";
$resultadou = $conexion->prepare($consultau);
$resultadou->execute();
$datau = $resultadou->fetchAll(PDO::FETCH_ASSOC);





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
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">Detalle de Herramientas</h1>
            </div>

            <div class="card-body">


                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-secondary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>
                <div class="container-fluid">

                    <div class="row ">
                        <div class="col-lg-12 ">
                            <div class="table-responsive ">
                                <br>
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-secondary">
                                        <tr>
                                            <th>Id </th>
                                            <th>Clave </th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Ubicacion</th>
                                            <th>Id Per</th>
                                            <th>Responsable</th>
                                            <th>Obs</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>

                                                <td><?php echo $dat['id_her'] ?></td>
                                                <td><?php echo $dat['clave_her'] ?></td>
                                                <td><?php echo $dat['nom_her'] ?></td>
                                                <td><?php echo $dat['cant_her'] ?></td>
                                                <td><?php echo $dat['ubi_her'] ?></td>
                                                <td><?php echo $dat['id_per'] ?></td>
                                                <td><?php echo $dat['nom_per'] ?></td>
                                                <td><?php echo $dat['obs_her'] ?></td>
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">NUEVA HERRAMIENTA</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="clave_her" class="col-form-label">Clave:</label>
                                        <input type="text" class="form-control" name="clave_her" id="clave_her" autocomplete="off" placeholder="Clave">
                                    </div>
                                </div>

                                <div class="col-sm-9">
                                    <div class="form-group input-group-sm">
                                        <label for="nom_her" class="col-form-label">Descripción:</label>
                                        <input type="text" class="form-control" name="nom_her" id="nom_her" autocomplete="off" placeholder="Descripción">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="ubicacion" class="col-form-label">Ubicación:</label>
                                        <input type="text" class="form-control" name="ubicacion" id="ubicacion" autocomplete="off" placeholder="ubicacion">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="cantidad" class="col-form-label">Cant:</label>
                                        <input type="text" class="form-control" name="cantidad" id="cantidad" autocomplete="off" placeholder="Cantidad">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm auto">
                                        <label for="responsable" class="col-form-label">Responsable:</label>
                                        <select class="form-control" name="responsable" id="responsable">
                                            <?php
                                            foreach ($datau as $dtu) {
                                            ?>
                                                <option id="r<?php echo $dtu['id_per'] ?>" value="<?php echo $dtu['id_per'] ?>"> <?php echo $dtu['nom_per'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="obs" class="col-form-label">Observaciones:</label>
                                        <textarea rows="2" class="form-control" name="obs" id="obs" placeholder="Observaciones"></textarea>
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

    <section>
        <div class="modal fade" id="modalMOV" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">MOVIMIENTOS DE INVENTARIO</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formMov" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="id" class="col-form-label">ID:</label>
                                        <input type="text" class="form-control" name="id" id="id" autocomplete="off" placeholder="ID" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">


                                    <div class="form-group input-group-sm">
                                        <label for="extact" class="col-form-label">Existencia Actual:</label>
                                        <input type="text" class="form-control text-right" name="extact" id="extact" value="" placeholder="Existencia Actual" disabled>
                                    </div>
                                </div>



                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="nombrep" class="col-form-label">Herramienta:</label>
                                        <input type="text" class="form-control" name="nombrep" id="nombrep" autocomplete="off" placeholder="Nombre/Descripción" disabled>
                                    </div>
                                </div>



                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="descripcion" class="col-form-label">Descripción del Movimiento:</label>
                                        <textarea rows="2" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción del Movimiento"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm auto">
                                        <label for="tipomov" class="col-form-label">Tipo Movimiento:</label>
                                        <select class="form-control" name="tipomov" id="tipomov">
                                            <option id="Inventario Inicial" value="Inventario Inicial"> Inventario Inicial</option>
                                            <option id="Entrada" value="Entrada"> Entrada</option>
                                            <option id="Salida" value="Salida"> Salida</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="montomov" class="col-form-label">Cantidad Movimiento:</label>
                                        <input type="text" class="form-control text-right" name="montomov" id="montomov" value="" placeholder="Cantidad Movimiento">
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
                                <button type="submit" id="btnGuardarM" name="btnGuardarM" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaherramienta.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>