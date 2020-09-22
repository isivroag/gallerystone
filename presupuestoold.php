<?php
$pagina="presupuesto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vpresupuesto order by id_pros";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$message = "";



$consultac = "SELECT * FROM prospecto order by id_pros";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

$consultacon = "SELECT * FROM concepto order by id_concepto";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);


$consultamat = "SELECT * FROM material order by id_mat";
$resultadomat = $conexion->prepare($consultamat);
$resultadomat->execute();
$datamat = $resultadomat->fetchAll(PDO::FETCH_ASSOC);

?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h1 class="card-title mx-auto">Presupuestos</h1>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">
            <button id="btnNuevo" type="button" class="btn bg-gradient-orange btn-ms" data-toggle="modal"><i class="fas fa-user-plus"></i> Nuevo</button>
            
            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
          </div>
        </div>

        <!-- Formulario Datos de Cliente -->
        <form id="formDatos" action="" method="POST">
          <div class="row justify-content-md-center">

            <div class="col-lg-6">
              <div class="form-group">

                <input type="hidden" class="form-control" name="id_pros" id="id_pros">
                <label for="nombre" class="col-form-label">Prospecto:</label>

                <div class="input-group">

                  <input type="text" class="form-control" name="nombre" id="nombre">
                  <span class="input-group-append">
                    <button id="bcliente" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                  </span>
                </div>
              </div>
            </div>

            <div class="col-lg-2">
              <div class="form-group">
                <label for="fecha" class="col-form-label">Fecha:</label>
                <input type="date" class="form-control" name="fecha" id="fecha">
              </div>
            </div>

            <div class="col-lg-1">
              <div class="form-group">
                <label for="folio" class="col-form-label">Folio:</label>
                <input type="text" class="form-control" name="folio" id="folio">
              </div>
            </div>



          </div>
          <!-- Formulario Agrear Item -->
          <div class="row justify-content-md-center">

           

            <div class="col-lg-2">
              <div class="form-group">

              <input type="hidden" class="form-control" name="claveconcepto" id="claveconcepto">

                <label for="concepto" class="col-form-label">Concepto:</label>
                <div class="input-group">
                <input type="text" class="form-control" name="concepto" id="concepto">
                  <span class="input-group-append">
                    <button id="bconcepto" type="button" class="btn btn-sm btn-primary "><i class="fas fa-search"></i></button>
                  </span>
                </div>
               
              </div>
            </div>



            <div class="col-lg-3">
              <div class="form-group">

              <input type="hidden" class="form-control" name="clavemat" id="clavemat">
                <label for="material" class="col-form-label">Material:</label>

                <div class="input-group">
                <input type="text" class="form-control" name="material" id="material">
                  <span class="input-group-append">
                    <button id="bmaterial" type="button" class="btn btn-sm btn-primary "><i class="fas fa-search"></i></button>
                  </span>
                </div>
                
              </div>
            </div>

            <div class="col-lg-1">
              <div class="form-group">
                <label for="cantidad" class="col-form-label">Cantidad:</label>
                <input type="text" class="form-control" name="cantidad" id="cantidad">
              </div>
            </div>

            <div class="col-lg-1">
              <div class="form-group">
                <label for="precio" class="col-form-label">Precio U:</label>
                <input type="text" class="form-control " name="precio" id="precio">
              </div>
            </div>

            <div class="col-lg-1 ">
              <label for="" class="col-form-label">Acción:</label>
              <div class="form-group ">

                <button type="button" id="btnagregar" name="btnagregar" class="btn bg-gradient-orange" value="btnGuardar"><i class="fas fa-plus-square"></i></button>
                <button type="button" id="btlimpiar" name="btlimpiar" class="btn bg-gradient-purple" value="btnlimpiar"><i class="fas fa-brush"></i></button>
              </div>
            </div>

          </div>

          <!-- Tabla -->
          <div class="row">
            <div class="col-lg-10 mx-auto">
              <div class="table-responsive">
                <table name="tablaV" id="tablaV" class="table table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-orange">
                    <tr>
                      <th>Id</th>
                      <th>Clave</th>
                      <th>Concepto</th>
                      <th>Material</th>
                      <th>Cantidad</th>
                      <th>P.U.</th>
                      <th>Monto</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Formulario totales -->
          <div class="row ">
            <div class="col-lg-2 offset-lg-9 in line">
              <div class="form-group">
                <label for="subtotal" class="col-form-label">Subtotal:</label>
                <input type="text" class="form-control" name="subtotal" id="subtotal">

                <label for="iva" class="col-form-label">IVA:</label>
                <input type="text" class="form-control" name="iva" id="iva">

                <label for="total" class="col-form-label">Total:</label>
                <input type="text" class="form-control" name="total" id="total">
              </div>
            </div>

          </div>




        </form>

        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>

      <div class="card-footer">
        Footer
      </div>
      <!-- /.card -->

  </section>
  <section>
    <div class="container">

      <!-- Default box -->
      <div class="modal fade" id="modalProspecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR PROSPECTO</h5>

            </div>
            <br>
            <div class="table table-hover responsive w-auto " style="padding:10px">
              <table name="tablaC" id="tablaC" class="table table-striped table-bordered table-condensed " style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Calle</th>
                    <th>Num</th>
                    <th>Colonia</th>
                    <th>C.P.</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Telefono</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($datac as $datc) {
                  ?>
                    <tr>
                      <td><?php echo $datc['id_pros'] ?></td>
                      <td><?php echo $datc['nombre'] ?></td>
                      <td><?php echo $datc['calle'] ?></td>
                      <td><?php echo $datc['num'] ?></td>
                      <td><?php echo $datc['col'] ?></td>
                      <td><?php echo $datc['cp'] ?></td>
                      <td><?php echo $datc['cd'] ?></td>
                      <td><?php echo $datc['edo'] ?></td>
                      <td><?php echo $datc['tel'] ?></td>
                      <td><?php echo $datc['cel'] ?></td>

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
        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </div>
  </section>



  <section>
    <div class="container">

      <!-- Default box -->
      <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTO</h5>

            </div>
            <br>
            <div class="table table-hover responsive w-auto " style="padding:10px">
              <table name="tablaCon" id="tablaCon" class="table table-striped table-bordered table-condensed " style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Concepto</th>
                    
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($datacon as $datc) {
                  ?>
                    <tr>
                      <td><?php echo $datc['id_concepto'] ?></td>
                      <td><?php echo $datc['nom_concepto'] ?></td>
                      

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
        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </div>
  </section>

  <section>
    <div class="container">

      <!-- Default box -->
      <div class="modal fade" id="modalMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR MATERIAL</h5>

            </div>
            <br>
            <div class="table table-hover responsive w-auto " style="padding:10px">
              <table name="tablaMat" id="tablaMat" class="table table-striped table-bordered table-condensed " style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Material</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  
                  foreach ($datamat as $datmat) {
                  ?>
                    <tr>
                      <td><?php echo $datmat['id_mat'] ?></td>
                      <td><?php echo $datmat['nom_mat'] ?></td>
                      <td><?php echo $datmat['precio_mat']?></td>

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
        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </div>
  </section>
  <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/presupuesto.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>