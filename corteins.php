<?php
$pagina = "corteins";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');
$obs = "";
$estado = 1;
$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';


if ($folio != "") {
    $consulta = "SELECT * FROM corteins where folio_corte='$folio'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $row) {
        $folio = $row['folio_corte'];
        $fecha = $row['fecha'];
        $obs = $row['obs'];
        $estado = $row['estado_corte'];
    }
} else {
    $consulta = "SELECT * FROM corteins where estado_corte=1";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $folio = 0;
    foreach ($data as $row) {
        $folio = $row['folio_corte'];
    }

    if ($folio == 0) {
        $consulta = "INSERT INTO corteins(fecha,estado_corte) VALUES('$fecha','1') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM corteins where estado_corte=1 ORDER BY folio_corte DESC limit 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $row) {
            $folio = $row['folio_corte'];
        }


        //crear consulta de insumos con compras para obtener costo
        $consulta = "SELECT * FROM vconsumible WHERE estado_cons=1 and contenidot > 0  ORDER BY id_cons";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $datamat = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datamat as $row) {
            $id_cons = $row['id_cons'];
            $clave_cons = $row['clave_cons'];
            $nom_cons = $row['nom_cons'];

            $cant_cons = $row['cant_cons'];
            $presentacion = $row['presentacion'];
            $contenidon = $row['contenidon'];
            $contenidoa = $row['contenidoa'];
            $contenidot = $row['contenidot'];
            $id_umedida = $row['id_umedida'];
            $nom_umedida = $row['nom_umedida'];
            $costo = $row['costo_cons'];
            $ncant = 0;
            $ncontenidon = 0;
            $ncontenidoa = 0;
            $ncontenidot = 0;
            $dcosto = 0;

            $consulta = "INSERT INTO corteins_detalle (folio_corte,id_cons,clave_cons,nom_cons,cant_cons,presentacion,contenidon,contenidoa,contenidot,id_umedida,nom_umedida,
            costo,ncant,ncontenidon,ncontenidoa,ncontenidot,dcosto) 
            VALUES ('$folio','$id_cons','$clave_cons','$nom_cons','$cant_cons','$presentacion','$contenidon','$contenidoa','$contenidot','$id_umedida','$nom_umedida',
            '$costo','$ncant','$ncontenidon','$ncontenidoa','$ncontenidot','$dcosto')";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }
    }
}




$consulta = "SELECT * FROM corteins_detalle WHERE folio_corte='$folio' order by id_reg";
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
                <h1 class="card-title mx-auto">Corte de Insumos</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <?php if ($estado != 2) { ?>
                            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        <?php } ?>

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
                                        <input type="text" class="form-control" name="foliocorte" id="foliocorte" autocomplete="off" value="<?php echo $folio ?>">
                                        <input type="hidden" class="form-control" name="estadocorte" id="estadocorte" autocomplete="off" value="<?php echo $estado ?>">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="fechan" class="col-form-label">Fecha:</label>
                                        <input type="date" class="form-control" name="fechan" id="fechan" autocomplete="off" value="<?php echo $fecha; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group input-group-sm">
                                        <label for="obs" class="col-form-label">Observaciones:</label>
                                        <input type="text" class="form-control" name="obs" id="obs" autocomplete="off" value="<?php echo $obs; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-light">
                                    <h1 class="card-title mx-auto">Insumos</h1>
                                </div>
                                <div class="card-body m-0">
                                    <div class="table-responsive ">
                                        <br>
                                        <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%; font-size:15px">
                                            <thead class="text-center bg-gradient-secondary">
                                                <tr>
                                                    <th>Id Reg</th>
                                                    <th>Id Cons</th>
                                                    <th>Clave </th>
                                                    <th>Insumo</th>
                                                    <th>Id U.Medida</th>

                                                    <th>Costo</th>
                                                    <th>Pres</th>
                                                    <th>U.Medida</th>
                                                    <th>Cant. Pres</th>
                                                    <th>Cant. Cerrada</th>
                                                    <th>Cant. Abierta</th>
                                                    <th>Cant. Total</th>
                                                    <th>N Cant. Pres</th>
                                                    <th>N Cant. Cerrada</th>
                                                    <th>N Cant. Abierta</th>
                                                    <th>N Cant. Total</th>
                                                    <th>Dif Cto</th>
                                                    <th>Apli</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $dat) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $dat['id_reg'] ?></td>
                                                        <td><?php echo $dat['id_cons'] ?></td>
                                                        <td><?php echo $dat['clave_cons'] ?></td>
                                                        <td><?php echo $dat['nom_cons'] ?></td>
                                                        <td><?php echo $dat['id_umedida'] ?></td>

                                                        <td><?php echo $dat['costo'] ?></td>
                                                        <td><?php echo $dat['presentacion'] ?></td>
                                                        <td><?php echo $dat['nom_umedida'] ?></td>
                                                        <td><?php echo $dat['cant_cons'] ?></td>
                                                        <td><?php echo $dat['contenidon'] ?></td>
                                                        <td><?php echo $dat['contenidoa'] ?></td>
                                                        <td><?php echo $dat['contenidot'] ?></td>
                                                        <td><?php echo $dat['ncant'] ?></td>
                                                        <td><?php echo $dat['ncontenidon'] ?></td>
                                                        <td><?php echo $dat['ncontenidoa'] ?></td>
                                                        <td><?php echo $dat['ncontenidot'] ?></td>
                                                        <td><?php echo $dat['dcosto'] ?></td>
                                                        <td><?php echo $dat['aplicado'] ?></td>
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
                                        <input type="text" class="form-control text-right" name="costo" id="costo" autocomplete="off" placeholder="Clave" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="ninsumo" class="col-form-label">Insumo:</label>
                                        <input type="text" class="form-control" name="ninsumo" id="ninsumo" autocomplete="off" placeholder="Insumo" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="presentacion" class="col-form-label">Presentacion:</label>
                                        <input type="text" class="form-control text-right" name="presentacion" id="presentacion" autocomplete="off" placeholder="Presentacion" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="umedida" class="col-form-label">Unidad:</label>
                                        <input type="text" class="form-control" name="umedida" id="umedida" autocomplete="off" placeholder="Unidad" disabled>
                                        <input type="hidden" class="form-control" name="idunidad" id="idunidad" autocomplete="off" placeholder="Unidad" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="cant_act" class="col-form-label">Cantidad:</label>
                                        <input type="text" class="form-control text-right" name="cant_act" id="cant_act" autocomplete="off" placeholder="Cantidad" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="contenidonact" class="col-form-label">Cont Cerrado:</label>
                                        <input type="text" class="form-control text-right" name="contenidonact" id="contenidonact" autocomplete="off" placeholder="Contenido Cerrado" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="contenidoaact" class="col-form-label">Cont Abierto:</label>
                                        <input type="text" class="form-control text-right" name="contenidoaact" id="contenidoaact" autocomplete="off" placeholder="Contenido Abierto" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="contenidotact" class="col-form-label">Cont Total:</label>
                                        <input type="text" class="form-control text-right" name="contenidotact" id="contenidotact" autocomplete="off" placeholder="Contenido Total" disabled>
                                    </div>
                                </div>




                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="cantidadn" class="col-form-label">Nueva Cant. Cerrado:</label>
                                        <input type="number" class="form-control text-right" name="cantidadn" id="cantidadn" autocomplete="off" placeholder="Nueva Cantidad">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="contenidonn" class="col-form-label">Nuevo Cont Cerrado:</label>
                                        <input type="number" class="form-control text-right" name="contenidonn" id="contenidonn" autocomplete="off" placeholder="Nuevo Cont Cerrado" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="contenidoan" class="col-form-label">Nuevo Cont Abierto:</label>
                                        <input type="number" class="form-control text-right" name="contenidoan" id="contenidoan" autocomplete="off" placeholder="Nuevo Cont Abierto">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="contenidotn" class="col-form-label">Nuevo Cont Total:</label>
                                        <input type="number" class="form-control text-right" name="contenidotn" id="contenidotn" autocomplete="off" placeholder="Nuevo Cont Abierto">
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
<script src="fjs/corteins.js?v=<?php echo (rand()); ?>"></script>
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