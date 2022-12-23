<?php
$pagina = "insumoop";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';



$objeto = new conn();
$conexion = $objeto->connect();


if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "<script type='text/javascript'>";
    echo "window.location='cntainsumoop.php'";
    echo "</script>";
}



 $consulta = "SELECT * FROM vconsumible where id_cons='$id'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach($data as $dr){
    $clave=$dr['id_cons'];
    $descripcion=$dr['nom_cons'];
    $cantidad=$dr['cant_cons'];
    $presentacion=$dr['presentacion'];
    $umedida=$dr['nom_umedida'];
    $contenidon=$dr['contenidon'];
    $contenidoa=$dr['contenidoa'];
    $contenidot=$dr['contenidot'];
    
    

}

if (isset($_GET['fechaini']) && isset($_GET['fechafin'])){
    $fechaini=$_GET['fechaini'];
    $fechafin=$_GET['fechafin'];
    $consulta = "SELECT * FROM mov_consumible where estado_movi=1 AND id_cons='$id' and fecha_movi between '$fechaini' and '$fechafin' order by fecha_movi desc,id_movi desc";
}
else{
    $consulta = "SELECT * FROM mov_consumible where estado_movi=1 AND id_cons='$id' order by fecha_movi desc,id_movi desc";
}

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


$fecha = date('Y-m-d');
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
            <div class="card-header bg-gradient-secondary">
                <h4 class="card-title text-center">KARDEX DE INSUMO</h4>
            </div>

            <div class="card-body">
                
                <div class="card">
                    <div class="card-header bg-gradient-secondary">
                        INFORMACIÓN DE PRODUCTO
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-1">
                                <div class="form-group input-group-sm">
                                    <label for="clave" class="col-form-label">ID:</label>
                                    <input type="text" class="form-control bg-white" name="clave" id="clave" value="<?php echo $clave?>" placeholder="clave" disabled>
                                </div>
                            </div>

                           

                         
                            <div class="col-lg-4">
                                
                                <div class="form-group input-group-sm">
                                <label for="descripcion" class="col-form-label">Descripción:</label>
                                    <input type="text" rows="2" class="form-control bg-white" name="descripcion" id="descripcion" value="<?php echo $descripcion?>" placeholder="descripcion" disabled>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <div class="form-group input-group-sm">
                                    <label for="cantidad" class="col-form-label">Cant. Nuevo:</label>
                                    <input type="text" class="form-control bg-white text-center" name="cantidad" id="cantidad" value="<?php echo $cantidad?>" placeholder="cantidad" disabled>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <div class="form-group input-group-sm">
                                    <label for="presentacion" class="col-form-label">Presentación:</label>
                                    <input type="text" class="form-control bg-white text-center" name="presentacion" id="presentacion" value="<?php echo $presentacion?>" placeholder="cantidad" disabled>
                                </div>
                            </div>


                            <div class="col-lg-1">
                                <div class="form-group input-group-sm">
                                    <label for="nomedida" class="col-form-label">U. Medida:</label>
                                    <input type="text" class="form-control bg-white text-center" name="nomedida" id="nomedida" value="<?php echo $umedida?>" placeholder="cantidad" disabled>
                                </div>
                            </div>


                            <div class="col-lg-1">
                                <div class="form-group input-group-sm">
                                    <label for="contenidon" class="col-form-label">Cont. Nuevo:</label>
                                    <input type="text" class="form-control bg-white text-center" name="contenidon" id="contenidon" value="<?php echo $contenidon?>" placeholder="cantidad" disabled>
                                </div>
                            </div>


                            <div class="col-lg-1">
                                <div class="form-group input-group-sm">
                                    <label for="contenidoa" class="col-form-label">Cont. Abierto:</label>
                                    <input type="text" class="form-control bg-white text-center" name="contenidoa" id="contenidoa" value="<?php echo $contenidoa?>" placeholder="cantidad" disabled>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group input-group-sm">
                                    <label for="contenidot" class="col-form-label">Cont. Total:</label>
                                    <input type="text" class="form-control bg-white text-center" name="contenidot" id="contenidot" value="<?php echo $contenidot?>" placeholder="cantidad" disabled>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                    </div>
                </div>
                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px;">
                                    <thead class="text-center bg-gradient-secondary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Tipo Movimiento</th>
                                            <th>Descripción</th>
                                            <th>Cant. Inicial</th>
                                            <th>Mov.</th>
                                            <th>Cant. Final</th>

                                        
                                            <th>Cerrado Ini</th>
                                            <th>Mov.</th>
                                            <th>Cerrado Fin</th>

                                            <th>Abierto Ini</th>
                                            <th>Mov.</th>
                                            <th>Abierto Fin</th>

                                            <th>Total Ini</th>
                                            <th>Mov.</th>
                                            <th>Total Fin</th>
                                            <th>Usuario</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $rowdata) {
                                        ?>
                                            <tr>
                                                <td><?php echo $rowdata['id_movi'] ?></td>
                                                <td><?php echo $rowdata['fecha_movi'] ?></td>
                                                <td><?php echo $rowdata['tipo_movi'] ?></td>
                                                <td><?php echo $rowdata['descripcion'] ?></td>
                                                <td><?php echo $rowdata['saldoini'] ?></td>
                                                <td><?php echo $rowdata['cantidad'] ?></td>
                                                <td><?php echo $rowdata['saldofin'] ?></td>

                                                <td><?php echo $rowdata['saldoinn'] ?></td>
                                                <td><?php echo $rowdata['cantidadn'] ?></td>
                                                <td><?php echo $rowdata['saldofinn'] ?></td>

                                                <td><?php echo $rowdata['saldoina'] ?></td>
                                                <td><?php echo $rowdata['cantidada'] ?></td>
                                                <td><?php echo $rowdata['saldofina'] ?></td>

                                                <td><?php echo $rowdata['saldoint'] ?></td>
                                                <td><?php echo $rowdata['cantidadt'] ?></td>
                                                <td><?php echo $rowdata['saldofint'] ?></td>
                                                <td><?php echo $rowdata['usuario'] ?></td>
                                                
                                                
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

        </div>
        <!-- /.card -->

    </section>





    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntamovconsumible.js?v=<?php echo (rand()); ?>"></script>
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