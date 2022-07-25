<?php
$pagina = "prescto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);


$mesactual = (isset($_GET['mes'])) ? $_GET['mes'] : date("m");
$yearactual = (isset($_GET['ejercicio'])) ? $_GET['ejercicio'] : date("Y");

$consulta = "call sp_egresos('$mesactual','$yearactual')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
}









?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
    .fill {
        border: none;
        border-bottom: 3px dotted #000;
        display: inline-block;
    }

    .borde-purple {
        border-left: 3px solid #6f42c1 !important;
        border-right: 3px solid #6f42c1 !important;
    }

    .borde-verde {
        border-left: 3px solid #28a745 !important;
        border-right: 3px solid #28a745 !important;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-purple  ">
                <h1 class="card-title text-light ">PRESUPUESTO DE EGRESOS</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <div class="card-header bg-gray">
                            Selector de Período
                        </div>
                        <div class="card-body p-0">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="mes" class="col-form-label">MES:</label>
                                        <select class="form-control" name="mes" id="mes" value="<?php echo $mesactual ?>">
                                            <option id="01" value="01" <?php echo ($mesactual == '01') ? "selected" : "" ?>>ENERO</option>
                                            <option id="02" value="02" <?php echo ($mesactual == '02') ? "selected" : "" ?>>FEBRERO</option>
                                            <option id="03" value="03" <?php echo ($mesactual == '03') ? "selected" : "" ?>>MARZO</option>
                                            <option id="04" value="04" <?php echo ($mesactual == '04') ? "selected" : "" ?>>ABRIL</option>
                                            <option id="05" value="05" <?php echo ($mesactual == '05') ? "selected" : "" ?>>MAYO</option>
                                            <option id="06" value="06" <?php echo ($mesactual == '06') ? "selected" : "" ?>>JUNIO</option>
                                            <option id="07" value="07" <?php echo ($mesactual == '07') ? "selected" : "" ?>>JULIO</option>
                                            <option id="08" value="08" <?php echo ($mesactual == '08') ? "selected" : "" ?>>AGOSTO</option>
                                            <option id="09" value="09" <?php echo ($mesactual == '09') ? "selected" : "" ?>>SEPTIEMBRE</option>
                                            <option id="10" value="10" <?php echo ($mesactual == '10') ? "selected" : "" ?>>OCTUBRE</option>
                                            <option id="11" value="11" <?php echo ($mesactual == '11') ? "selected" : "" ?>>NOVIEMBRE</option>
                                            <option id="12" value="12" <?php echo ($mesactual == '12') ? "selected" : "" ?>>DICIEMBRE</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="ejercicio" class="col-form-label">EJERCICIO:</label>
                                        <input type="text" class="form-control" name="ejercicio" id="ejercicio" value="<?php echo $yearactual ?>">
                                    </div>
                                </div>

                                <div class="col-lg-2 align-self-end text-center">
                                    <div class="form-group input-group-sm">
                                        <button id="btnconsulta" name="btnconsulta" type="button" class="btn bg-gradient-success btn-ms form-control"><i class="fas fa-search"></i> Consultar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget " style="margin-bottom:0px;">

                            <div class="card-header bg-purple " style="margin:0px;padding:8px">
                                <span>
                                    <h3>DETALLE DE PREUSPUESTO</h3>
                                </span>
                            </div>

                            <div class="card-body mb-0 pb-0 " style="margin:0px;padding:1px;">
                                <div class="container-fluid">


                                    <div class="row ">
                                        <div class="col-lg-12 ">
                                            <div class="table-responsive ">
                                                <br>
                                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                                    <thead class="text-center bg-gradient-secondary">
                                                        <tr>
                                                            <th>Id Partida </th>
                                                            <th>Partida </th>
                                                            <th>Monto Presupuesto</th>
                                                            <th>Monto Ejercido</th>
                                                            <th>Diferencia</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($data as $dat) {

                                                        ?>
                                                            <tr>
                                                               <td><?php echo $dat['id_partida'];?></td>
                                                               <td><?php echo $dat['nom_partida'];?></td>
                                                               <td class="text-right"><?php echo number_format($dat['mpresupuesto'],2);?></td>
                                                               <td class="text-right"><?php echo number_format($dat['mejecutado'],2);?></td>
                                                               <td class="text-right <?php echo (($dat['mpresupuesto']-$dat['mejecutado'])>=0)?"text-green":" text-danger" ?>"><?php echo number_format(($dat['mpresupuesto']-$dat['mejecutado']),2);?></td>
                                                               <td></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <th></th>
                                                        <th>TOTALES</th>
                                                        <th class="text-right"></th>
                                                        <th class="text-right" ></th>
                                                        <th class="text-right"></th>
                                                        <th></th>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>
                    <!-- Formulario Agrear Item -->


            </div>


            </form>

        </div>
    </section>


    <section>
    <div class="modal fade" id="modalPres" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-gray">
            <h5 class="modal-title" id="exampleModalLabel">Monto Presupuestado</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formPres" action="" method="POST">
              <div class="modal-body row justify-content-center">


                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <input type="hidden" class="form-control" name="idpartida" id="idpartida" autocomplete="off" placeholder="Nombre">
                    <input type="hidden" class="form-control" name="nmes" id="nmes" autocomplete="off" placeholder="Nombre" value="<?php echo $mesactual ?>">
                    <input type="hidden" class="form-control" name="nejercicio" id="nejercicio" autocomplete="off" placeholder="Nombre" value="<?php echo $yearactual ?>">
                    <label for="partida" class="col-form-label">Partida:</label>
                    <input type="text" class="form-control" name="partida" id="partida" autocomplete="off" placeholder="Nombre" disabled>
                  </div>
                </div>
            
                <div class="col-sm-8">
                <div class="form-group input-group-sm">
                    
                    
                    <label for="monto" class="col-form-label">Monto Presupuestado:</label>

                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>

                        <input type="text" class="form-control text-right" name="monto" id="monto" autocomplete="off" placeholder="Monto" >
                      </div>
                 
                  </div>
                </div>
               

              </div>
          </div>


        
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
            <button type="button" id="bguardarpres" name="bguardarpres" class="btn btn-success" value="btngliberar"><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>
 
</div>

<!-- /.card -->








<!-- /.content -->




<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaprescto.js?v=<?php echo(rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>
