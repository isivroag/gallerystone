<?php
$pagina = "cntamovb";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$consulta = "SELECT * FROM banco where estado_banco=1 order by id_banco";
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
            <div class="card-header bg-lightblue">
                <h4 class="card-title text-center">MOVIMIENTOS BANCARIOS</h4>
            </div>

            <div class="card-body">

                <div class="card">
                    <div class="card-header bg-lightblue">
                        Seleccionar Cuenta Bancaria
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-3">
                                <div class="form-group input-group-sm">
                                    <label for="tcuenta" class="col-form-label">Cuenta:</label>

                                    <select class="form-control" name="tcuenta" id="tcuenta">
                                        <?php
                                        foreach ($data as $rowdata) {
                                        ?>
                                            <option id="<?php echo $rowdata['id_banco'] ?>" value="<?php echo $rowdata['id_banco'] ?> "> <?php echo $rowdata['nom_banco'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label for="saldocuenta" class="col-form-label">Saldo Actual:</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>

                                    </div>
                                    <input type="text" class="form-control text-right bg-white" name="saldocuenta" id="saldocuenta" value="" placeholder="Saldo" disabled>
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
                                    <thead class="text-center bg-lightblue">
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Tipo Movimiento</th>
                                            <th>Monto</th>
                                            <th>Folio Ingreso</th>
                                            <th>Folio Egreso</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
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
<script src="fjs/cntamovb.js"></script>
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