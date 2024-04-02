<?php
$pagina = "cortemataviso";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";







?>

<style>
    td.editable {

        cursor: pointer;


    }

    .tablapiezas {

        height: 100px;
        width: 100%;
        overflow-y: auto;



    }

   
</style>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-danger">
                <h4 class="card-title text-center">CORTES</h4>
            </div>

            <div class="card-body">
                <div class="card card-danger border-danger">
                    <div class="card-header">
                        <h4>AVISO IMPORTANTE</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <h1><strong>ADVERTENCIA</strong></h1>
                                <br>
                                <h2>

                                    Antes de ingresar al módulo de corte de insumos, ten en cuenta lo siguiente:<br><br>

                                    Este módulo realizará automáticamente un proceso para guardar las medidas y cantidades actuales de todos los insumos en inventario.
                                    Esto asegura la precisión durante el corte.<br><br>

                                    Es vital terminar este procedimiento antes de usar insumos en otros procesos.
                                    <br><br><strong> De lo contrario, los movimientos de otros módulos podrían sobrescribirse, comprometiendo la integridad de tus registros.</strong>
                                </h2>
                            </div>

                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-lg-4">
                            <button id="btnAceptar" type="button" class="btn bg-gradient-warning btn-block" >
                               <h2> <i class="fas fa-circle-check text-light"></i><span class="text-light"> CONTINUAR</span></h2></button>
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
<!-- Resumen de Pagos -->



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/corteinsaviso.js?v=<?php echo (rand()); ?>"></script>
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