<?php
$pagina = "cobranza";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$consulta = "SELECT * FROM vpagocxc where estado_pagocxc=1 order by fecha,folio_vta,folio_pagocxc";
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
            <div class="card-header bg-green">
                <h4 class="card-title text-center">COBRANZA</h4>
            </div>

            <div class="card-body">

                <div class="card">
                    <div class="card-header bg-gradient-green">
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
                                    <thead class="text-center bg-gradient-success">
                                        <tr>
                                            <th>Folio Vta</th>
                                            <th>Cliente</th>
                                            <th>Proyecto/Concepto</th>
                                            <th>Folio Pago</th>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th>Monto</th>
                                            <th>Metodo</th>
                                            <th>Sol. Fact</th>
                                            <th>Facturar</th>
                                            <th># Fact</th>
                                            <th>Fecha Fact</th>
                                            <th>Bloqueo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_vta'] ?></td>
                                                <td><?php echo $dat['cliente'] ?></td>
                                                <td><?php echo $dat['concepto_vta'] ?></td>
                                                <td><?php echo $dat['folio_pagocxc'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['concepto'] ?></td>
                                                <td class="text-right"><?php echo "$ " . number_format($dat['monto'], 2) ?></td>
                                                <td><?php echo $dat['metodo'] ?></td>
                                                <td><?php echo $dat['fcliente'] ?></td>
                                                <td><?php echo $dat['facturado'] ?></td>
                                                <td><?php echo $dat['factura'] ?></td>
                                                <td><?php echo $dat['fecha_fact'] ?></td>
                                                <td><?php echo $dat['seguro_fact'] ?></td>
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

        </div>
        <!-- /.card -->

    </section>

    <section>
        <div class="modal fade" id="modalcan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-warning">
                        <h5 class="modal-title" id="exampleModalLabel">CANCELAR PAGO</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formcan" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="motivo" class="col-form-label">Motivo de Cancelacioón:</label>
                                        <textarea rows="3" class="form-control" name="motivo" id="motivo" placeholder="Motivo de Cancelación"></textarea>
                                        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha ?>">


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
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle de Pago</h5>

                    </div>
                    <form id="formPago" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content-sm-between my-auto">

                                <div class="col-sm-3 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="foliovp" class="col-form-label">Folio Venta:</label>
                                        <input type="text" class="form-control" name="foliopago" id="foliopago" value="" disabled>
                                        <input type="hidden" class="form-control" name="foliovp" id="foliovp" value="" disabled>
                                    </div>
                                </div>



                                <div class="col-sm-3 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="fechavp" class="col-form-label ">Fecha de Pago:</label>
                                        <input type="date" id="fechavp" name="fechavp" class="form-control text-right" autocomplete="off" value="" placeholder="Fecha">
                                    </div>
                                </div>

                                <div class="col-sm-6 bg-gray-light rounded-lg">
                                    <div class="row d-block">
                                        <div class="d-flex d-flex justify-content-around">
                                            <div class=" d-block custom-control custom-checkbox ">
                                                <input class="custom-control-input" type="checkbox" id="ccliefact" name="ccliefact" value="">
                                                <label for="ccliefact" class="custom-control-label">Cliente Solicito Fact.</label>
                                            </div>

                                            <div class="d-block custom-control custom-checkbox ">
                                                <input class="custom-control-input" type="checkbox" id="facturado" name="facturado" value="">
                                                <label for="facturado" class="custom-control-label">Facturar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" name="divfactura" id="divfactura" disabled>
                                        <div class="col-sm-6">
                                            <div class="form-group input-group-sm">
                                                <label for="factura" class="col-form-label">No. Factura:</label>
                                                <input type="text" class="form-control" name="factura" id="factura" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group input-group-sm">
                                                <label for="fechafact" class="col-form-label ">Fecha de Factura:</label>
                                                <input type="date" id="fechafact" name="fechafact" class="form-control text-right" autocomplete="off" value="" placeholder="Fecha Factura" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="conceptovp" class="col-form-label">Concepto Pago</label>
                                        <input type="text" class="form-control" name="conceptovp" id="conceptovp" autocomplete="off" placeholder="Concepto de Pago">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-center">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="obsvp" class="col-form-label">Observaciones:</label>
                                        <textarea class="form-control" name="obsvp" id="obsvp" rows="3" autocomplete="off" placeholder="Observaciones"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-sm-end">

                                <div class="col-lg-4 my-auto">
                                    <div class=" custom-control custom-checkbox ">
                                        <input class="custom-control-input" type="checkbox" id="bloqueo" name="bloqueo" value="">
                                        <label for="bloqueo" class="custom-control-label">Bloquear Registro</label>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label for="montopago" class="col-form-label">Pago:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="montopago" name="montopago" class="form-control text-right" autocomplete="off" placeholder="Monto del Pago" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="input-group-sm">
                                        <label for="metodo" class="col-form-label">Metodo de Pago:</label>

                                        <select class="form-control" name="metodo" id="metodo">
                                            <option id="Efectivo" value="Efectivo">Efectivo</option>
                                            <option id="Transferencia" value="Transferencia">Transferencia</option>
                                            <option id="Deposito" value="Deposito">Deposito</option>
                                            <option id="Cheque" value="Cheque">Cheque</option>
                                            <option id="Tarjeta de Crédito" value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                                            <option id="Tarjeta de Debito" value="Tarjeta de Debito">Tarjeta de Debito</option>

                                        </select>
                                    </div>
                                </div>

                            </div>


                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnGuardarvp" name="btnGuardarvp" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntapagocxc.js"></script>
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