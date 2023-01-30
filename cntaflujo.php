<?php
$pagina = "flujo";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fechahome =strtotime(date("Y-m-d"));
$meshome = date("m", $fechahome);
$yearhome = date("Y", $fechahome);

$consulta = "SELECT * FROM vpagocxc where year(fecha)='$yearhome' and month(fecha)='$meshome' and estado_pagocxc=1 order by fecha,folio_pagocxc";
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
                <h4 class="card-title text-center">DISTRIBUCION DE INGRESO</h4>
            </div>

            <div class="card-body">

                <div class="card">
                    <div class="card-header bg-lightblue">
                        Filtro por rango de Fecha
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-2">
                                <div class="form-group input-group-sm">
                                    <label for="fecha" class="col-form-label">Desde:</label>
                                    <input type="date" class="form-control" name="inicio" id="inicio">
                                    <input type="hidden" class="form-control" name="tipo_proy" id="tipo_proy" value=1>

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
                                    <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-lightblue btn-ms"><i class="fas fa-search"></i> Buscar</button>
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
                                            <th>Folio Vta</th>
                                            <th>Cliente</th>
                                            <th>Proyecto/Concepto</th>
                                            <th>Folio Pago</th>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th>Monto</th>
                                            <th>Utilidad</th>
                                            <th>Utilidad Sug </th>
                                            <th>Utilidad Dist</th>
                                            <th>Mnto</th>
                                            <th>Mnto Sug</th>
                                            <th>Mnto Dist</th>
                                            <th>Imp</th>
                                            <th>Imp Sug</th>
                                            <th>Imp Dist</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_vta'] ?></td>
                                                <td><?php echo $dat['cliente'] ?></td>
                                                <td ><?php echo $dat['concepto_vta'] ?></td>
                                                <td><?php echo $dat['folio_pagocxc'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['concepto'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['monto'], 2) ?></td>
                                                <td class="text-center"><?php echo $dat['futilidad'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['util'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['utilidad'], 2) ?></td>
                                                <td class="text-center"><?php echo $dat['fmant'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['mante'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['mant'], 2) ?></td>
                                                <td class="text-center"><?php echo $dat['fimp'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['impu'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['imp'], 2) ?></td>
                                               
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
                                            <th class="currency text-right" style="text-align:right">Total:</th>
                                            <th class="text-right "></th>
                                            <th></th>
                                            <th class="text-right "></th>
                                            <th class="text-right "></th>
                                            <th></th>
                                            <th class="text-right "></th>
                                            <th class="text-right "></th>
                                            <th></th>
                                            <th class="text-right "></th>
                                            <th class="text-right "></th>
                                           
                                            
                                        </tr>
                                    </tfoot>
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

 

    <section>
        <div class="modal fade" id="modalFlujo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-lightblue">
                        <h5 class="modal-title" id="exampleModalLabel">DISTRIBUCION DE INGRESO</h5>

                    </div>
                    <form id="formPago" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content-sm-between my-auto">

                                <div class="col-sm-2 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="foliopago" class="col-form-label">Pago:</label>
                                        <input type="text" class="form-control" name="foliopago" id="foliopago" value="" disabled>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="tipo" class="col-form-label">Tipo:</label>
                                    <div class="input-group input-group-sm">
                                      
                                        <input type="text" id="tipo" name="tipo" class="form-control " autocomplete="off" placeholder="Monto Sugerido" disabled>
                                    </div>
                                </div>

                            <div class="col-lg-3">
                                    <label for="montos" class="col-form-label">Monto Sugerido:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="montos" name="montos" class="form-control text-right" autocomplete="off" placeholder="Monto Sugerido" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="importeflujo" class="col-form-label">Importe:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="importeflujo" name="importeflujo" class="form-control text-right" autocomplete="off" placeholder="Monto del Pago" >
                                    </div>
                                </div>

                          

                            </div>


                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaflujo.js"></script>
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