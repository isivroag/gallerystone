<?php
$pagina = "cortemat";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');

$consulta = "SELECT * FROM cortemat where estado_corte=1";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$folio = 0;
foreach ($data as $row) {
    $folio = $row['folio_corte'];
}

if ($folio == 0) {
    $consulta = "INSERT INTO cortemat(fecha,estado_corte) VALUES('$fecha','1') ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    $consulta = "SELECT * FROM cortemat where estado_corte=1 ORDER BY folio_corte DESC limit 1";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        $folio = $row['folio_corte'];
    }

    $consulta = "SELECT * FROM vmaterialcto WHERE estado_mat=1 and m2_mat > 0  ORDER BY id_mat";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $datamat = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach($datamat as $row){
        $id_mat=$row['id_mat'];
        $clave_mat=$row['clave_mat'];
        $id_item=$row['id_item'];
        $clave_item=$row['clave_item'];
        $nom_item=$row['nom_item'];
        $nom_mat=$row['nom_mat'];
        $largo_mat=$row['largo_mat'];
        $alto_mat=$row['alto_mat'];
        $ancho_mat=$row['ancho_mat'];
        $m2_mat=$row['m2_mat'];
        $id_umedida=$row['id_umedida'];
        $nom_umedida=$row['nom_umedida'];
        $costo=$row['costo'];
        $nlargo=0;
        $nalto=0;
        $nancho=0;
        $nm2=0;
        $dcosto=0;

        $consulta = "INSERT INTO cortemat_detalle (folio_corte,id_mat,clave_mat,id_item,clave_item,nom_item,nom_mat,largo_mat,alto_mat,ancho_mat,m2_mat,id_umedida,nom_umedida,
        costo,nlargo,nalto,nancho,nm2,dcosto) 
        VALUES ('$folio','$id_mat','$clave_mat','$id_item','$clave_item','$nom_item','$nom_mat','$largo_mat','$alto_mat','$ancho_mat','$m2_mat','$id_umedida','$nom_umedida',
        '$costo','$nlargo','$nalto','$nancho','$nm2','$dcosto')";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

    }
}


$consulta = "SELECT * FROM cortemat_detalle WHERE folio_corte='$folio' order by id_reg";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);




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
                <h1 class="card-title mx-auto">Corte de Materiales</h1>
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
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-light">
                                    <h1 class="card-title mx-auto">Datos Generales</h1>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-sm-1">
                                    <div class="form-group input-group-sm">
                                        <label for="foliocorte" class="col-form-label">Folio Operacion:</label>
                                        <input type="text" class="form-control" name="foliocorte" id="foliocorte" autocomplete="off" value="<?php echo $folio?>">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="claveact" class="col-form-label">Fecha:</label>
                                        <input type="date" class="form-control" name="fechan" id="fechan" autocomplete="off" value="<?php echo $fecha; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group input-group-sm">
                                        <label for="obs" class="col-form-label">Observaciones:</label>
                                        <input type="text" class="form-control" name="obs" id="obs" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-light">
                                    <h1 class="card-title mx-auto">Materiales</h1>
                                </div>
                                <div class="card-body m-0">
                                    <div class="table-responsive ">
                                        <br>
                                        <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                            <thead class="text-center bg-gradient-secondary">
                                                <tr>
                                                    <th>Id Reg</th>
                                                    <th>Id Mat</th>
                                                    <th>Clave </th>
                                                    <th>Id Mat </th>
                                                    <th>Material</th>
                                                    <th>Id U.Medida</th>
                                                    <th>U.Medida</th>
                                                    <th>Descripcion</th>
                                                    <th>Costo</th>
                                                    <th>Largo</th>
                                                    <th>Alto</th>
                                                    <th>Ancho</th>
                                                    <th>M2</th>
                                                    <th>N Largo</th>
                                                    <th>N Alto</th>
                                                    <th>N Ancho</th>
                                                    <th>N M2</th>
                                                    <th>Dif Cto</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $dat) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $dat['id_reg'] ?></td>
                                                        <td><?php echo $dat['id_mat'] ?></td>
                                                        <td><?php echo $dat['clave_mat'] ?></td>
                                                        <td><?php echo $dat['id_item'] ?></td>
                                                        <td><?php echo $dat['nom_item'] ?></td>
                                                        <td><?php echo $dat['id_umedida'] ?></td>
                                                        <td><?php echo $dat['nom_umedida'] ?></td>
                                                        <td><?php echo $dat['nom_mat'] ?></td>
                                                        <td><?php echo $dat['costo'] ?></td>
                                                        <td><?php echo $dat['largo_mat'] ?></td>
                                                        <td><?php echo $dat['alto_mat'] ?></td>
                                                        <td><?php echo $dat['ancho_mat'] ?></td>
                                                        <td><?php echo $dat['m2_mat'] ?></td>
                                                        <td><?php echo $dat['nlargo'] ?></td>
                                                        <td><?php echo $dat['nalto'] ?></td>
                                                        <td><?php echo $dat['nancho'] ?></td>
                                                        <td><?php echo $dat['nm2'] ?></td>
                                                        <td><?php echo $dat['dcosto'] ?></td>
                                                        
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
                </div>

            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>





    <section>
        <div class="modal fade" id="modalMOV" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">CORTE DE INVENTARIO</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formMov" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="id" class="col-form-label">ID:</label>
                                        <input type="text" class="form-control" name="id" id="id" autocomplete="off" placeholder="ID" disabled>
                                        <input type="hidden" class="form-control" name="idreg" id="idreg" autocomplete="off" placeholder="ID" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="claveact" class="col-form-label">Clave:</label>
                                        <input type="text" class="form-control" name="claveact" id="claveact" autocomplete="off" placeholder="Clave" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                <div class="form-group input-group-sm">
                                        <label for="costo" class="col-form-label">Costo:</label>
                                        <input type="text" class="form-control" name="costo" id="costo" autocomplete="off" placeholder="Clave" disabled>
                                    </div>
                                </div>





                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="nombrep" class="col-form-label">Material:</label>
                                        <input type="text" class="form-control" name="nombrep" id="nombrep" autocomplete="off" placeholder="Nombre/Descripción" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="nmaterial" class="col-form-label">Nombre/Descripción/Formato:</label>
                                        <input type="text" class="form-control" name="nmaterial" id="nmaterial" autocomplete="off" placeholder="Nombre/Descripción" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="largo" class="col-form-label">Largo:</label>
                                        <input type="text" class="form-control" name="largoact" id="largoact" autocomplete="off" placeholder="Largo" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="alto" class="col-form-label">Alto:</label>
                                        <input type="text" class="form-control" name="altoact" id="altoact" autocomplete="off" placeholder="Alto" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="ancho" class="col-form-label">Ancho:</label>
                                        <input type="text" class="form-control" name="anchoact" id="anchoact" autocomplete="off" placeholder="Ancho" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-8">

                                </div>
                                <div class="col-sm-4">


                                    <div class="form-group input-group-sm">
                                        <label for="extact" class="col-form-label">M2 Actuales:</label>
                                        <input type="text" class="form-control text-right" name="extact" id="extact" value="" placeholder="Medida Actual" disabled>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="largo" class="col-form-label">Nuevo Largo:</label>
                                        <input type="text" class="form-control" name="largon" id="largon" autocomplete="off" placeholder="Nuevo Largo">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="alto" class="col-form-label">Nuevo Alto:</label>
                                        <input type="text" class="form-control" name="alton" id="alton" autocomplete="off" placeholder="Nuevo Alto">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="ancho" class="col-form-label">Nuevo Ancho:</label>
                                        <input type="text" class="form-control" name="anchon" id="anchon" autocomplete="off" placeholder="Nuevo Ancho">
                                    </div>
                                </div>

                                <div class="col-sm-8">

                                </div>
                                <div class="col-sm-4">


                                    <div class="form-group input-group-sm">
                                        <label for="extact" class="col-form-label">M2 Nuevo:</label>
                                        <input type="text" class="form-control text-right" name="metrosn" id="metrosn" placeholder="Nueva Media">
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
<script src="fjs/cortemat.js?v=<?php echo (rand()); ?>"></script>
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