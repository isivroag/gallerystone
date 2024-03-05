<?php
$pagina = "cntanomina";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$usuario = $_SESSION['s_usuario'];
$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$fecha = date('Y-m-d');

if ($folio != "") {

    $opcion = 2;

    $consulta = "SELECT * FROM nomina where folio_nom='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);



    foreach ($data as $dt) {
        $folio = $dt['folio_nom'];

        $fecha = $dt['fecha'];
        $periodoini = $dt['periodoini'];
        $periodofin = $dt['periodofin'];
        $importe = $dt['importe'];
        $retenido = $dt['retenido'];
        $fijo = $dt['fijo'];
        $neto = $dt['neto'];
        $extra = $dt['extra'];
        $retencion = $dt['retencion'];
        $obs = $dt['obs'];

        $importef = $dt['importef'];
        $pordest = $dt['pordest'];
        $porret = $dt['porret'];
        $porfinal = $dt['porfinal'];
        $retencionu = $dt['retencionu'];
    }





    $message = "";


    // buscar las ordenes
    $consultadet = "";
    $resultadodet = $conexion->prepare($consultadet);
    $resultadodet->execute();
    $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);


    //buscar los empleados


} else {
    $opcion = 1;
    $consulta = "SELECT * FROM nomina WHERE aplicado=0";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    if ($resultado->rowCount() == 0) {
        $consulta = "INSERT INTO nomina(fecha,periodoini,periodofin,importe,retenido,retencion,fijo,neto,extra,usuario) VALUES('$fecha','$fecha','$fecha','0','0','0','0','0','0','$usuario')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM nomina WHERE aplicado=0 and usuario='$usuario'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
    }

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        $folio = $row['folio_nom'];
        $fecha = $row['fecha'];
        $periodoini = $row['periodoini'];
        $periodofin = $row['periodofin'];
        $importe = $row['importe'];
        $retenido = $row['retenido'];
        $fijo = $row['fijo'];
        $neto = $row['neto'];
        $extra = $row['extra'];
        $retencion = $row['retencion'];
        $obs = $row['obs'];
        $importef = $row['importef'];
        $pordest = $row['pordest'];
        $porret = $row['porret'];
        $porfinal = $row['porfinal'];
        $retencionu = $row['retencionu'];
    }
}

$consulta = "SELECT * FROM vnom_emp WHERE folio_nom='$folio' order by id_per";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataper = $resultado->fetchAll(PDO::FETCH_ASSOC);

$numpersonal = 0;
$numpersonal = $resultado->rowCount();

$inicio = $periodoini;
$fin = $periodofin;

$fechaInicio = new DateTime($periodoini);
$fechaFin = new DateTime($periodofin);

// Calcular el número de días entre las fechas
$intervalo = $fechaInicio->diff($fechaFin);
$numDias = $intervalo->days;
$numDias = $numDias;



$consulta = "SELECT * FROM vnom_ord WHERE folio_nom='$folio' order by id_reg";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataord = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta = "SELECT nom_retenciones.folio_nom, nomina.fecha,nom_retenciones.importe FROM nom_retenciones join nomina on nom_retenciones.folio_nom =nomina.folio_nom 
WHERE nom_retenciones.importe>0 order by nom_retenciones.id_reg";
$resultadoret = $conexion->prepare($consulta);
$resultadoret->execute();
$dataret = $resultadoret->fetchAll(PDO::FETCH_ASSOC);





?>



<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">
<style>
    .borde-titulogris {
        border-left: grey;
        border-style: outset;
        ;
    }

    .fondogris {
        background-color: rgba(183, 185, 187, .8);
    }

    .borde-titulazul {
        border-left: rgb(0, 123, 255);
        border-style: outset;
        ;
    }

    .fondorosa {
        background-color: rgba(232, 62, 140, .8);
    }


    .borde-titulrosa {
        border-left: rgb(232, 62, 140);
        border-style: outset;
        ;
    }

    .fondoazul {
        background-color: rgba(0, 123, 255, .8);
    }

    .borde-titulinfo {
        border-left: rgb(23, 162, 184);
        border-style: outset;
        ;
    }

    .fondoinfo {
        background-color: rgba(23, 162, 184, .8);
    }

    .borde-titulpur {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondopur {
        background-color: rgba(117, 74, 195, .8);
    }



    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    #div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.1);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 6;
    }

    #cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-orange">
                <h1 class="card-title mx-auto">NOMINA</h1>
            </div>
            <div class="m-0 p-0">
                <br>
                <div class="row pl-2 pb-0 pt-0">
                    <?php if ($opcion == 1) { ?>
                        <div class="col-sm-2">
                            <button id="bntGuardarNom" name="bntGuardarNom" type="button" class="btn bg-success btn-sm">
                                <i class="far fa-save"></i> Guardar Nomina
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </div>



            <div class="card-body pt-0">



                <br>
                <div id="div_carga" tabindex="-1">

                    <img id="cargador" src="img/loader.gif" />
                    <span class=" " id="textoc"><strong>Cargando...</strong></span>

                </div>


                <!-- INICIO FORM -->
                <form id="formDatos" action="" method="">


                    <div class="content">

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-orange " style="margin:0px;padding:8px">
                                <h1 class="card-title ">Información de Nomina</h1>

                            </div>

                            <div class="card-body" id="cuerpo" style="margin:0px;padding:15px;">

                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folio" class="col-form-label">Folio :</label>
                                            <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo   $opcion; ?>">
                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo   $folio; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>


                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="periodoini" class="col-form-label">P. Ini:</label>
                                            <input type="date" class="form-control" name="periodoini" id="periodoini" value="<?php echo $periodoini; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="periodofin" class="col-form-label">P. Fin:</label>
                                            <input type="date" class="form-control" name="periodofin" id="periodofin" value="<?php echo $periodofin; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <?php if ($opcion == 1) { ?>
                                            <div class="form-group input-group-sm">
                                                <label for="btnestablecer" class="col-form-label">Establecer</label>
                                                <button type="button" class="btn bg-primary btn-sm form-control " id="btnestablecer">
                                                    <i class="fa-solid fa-calendar-days"></i>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                                <div class="row justify-content-sm-center">



                                    <div class="col-sm-2">
                                        <label for="importeg" class="col-form-label ">Imp. Destajo:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="importeg" id="importeg" value="<?php echo $importe; ?>">
                                        </div>


                                    </div>
                                    <div class="col-sm-1">
                                        <label for="pordest" class="col-form-label ">% Dest.</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-percent"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="pordest" id="pordest" value="<?php echo $pordest; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="extra" class="col-form-label ">Imp. Extra:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="extra" id="extra" value="<?php echo $extra; ?>">
                                        </div>

                                    </div>

                                    <div class="col-sm-2">
                                        <label for="retencionu" class="col-form-label ">Imp a usar Ret. Anteriores:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="retencionu" id="retencionu" value="<?php echo $retencionu; ?>" disabled>
                                        </div>


                                    </div>

                                    <div class="col-sm-1">
                                        <?php if ($opcion == 1) { ?>
                                            <div class="form-group input-group-sm">
                                                <label for="btnVer" class="col-form-label">Ver Ret. Ant.</label>
                                                <button type="button" class="btn bg-primary btn-sm form-control " id="btnVer">
                                                    <i class="fa-solid fa-search"></i>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>



                                    <div class="col-sm-2">
                                        <label for="retencion" class="col-form-label ">Importe No Distribuido:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="retencion" id="retencion" value="<?php echo $retenido; ?>">
                                        </div>


                                    </div>





                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-2">
                                        <label for="retencion2" class="col-form-label ">Retención:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="retencion2" id="retencion2" value="<?php echo $retencion; ?>">
                                        </div>

                                    </div>
                                    <div class="col-sm-1">
                                        <label for="porret" class="col-form-label ">% Ret.</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-percent"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="porret" id="porret" value="<?php echo $porret; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="retencionf" class="col-form-label ">Imp Destajo Final a Repartir:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="retencionf" id="retencionf" value="<?php echo $importef; ?>" disabled>
                                        </div>

                                    </div>
                                    <div class="col-sm-1">
                                        <label for="porfinal" class="col-form-label ">% Ret.</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-percent"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="porfinal" id="porfinal" value="<?php echo $porfinal; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="fijog" class="col-form-label ">Fijo:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="fijog" id="fijog" value="<?php echo $fijo; ?>">
                                        </div>


                                    </div>
                                    <div class="col-sm-2"></div>

                                </div>
                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-10">

                                        <div class="form-group">
                                            <label for="obs" class="col-form-label">observaciones:</label>
                                            <textarea rows="2" class="form-control" name="obs" id="obs"><?php echo $obs; ?></textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-8"></div>
                                    <div class="col-sm-2">
                                        <label for="netog" class="col-form-label ">Neto:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="netog" id="netog" value="<?php echo $neto; ?>">
                                        </div>


                                    </div>
                                </div>

                                <div class="content" style="padding:15px 0px;">
                                    <!-- ORDENES -->
                                    <div class="card ">
                                        <div class="card-header bg-gradient-success " style="margin:0px;padding:8px;">
                                            <h1 class="card-title ">Dellate Ordenes</h1>
                                            <div class="card-tools " style="margin:0px;padding:0px;">
                                                <button type="button" class="btn bg-success btn-sm " href="#ordenes" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-minus text-white"></i>
                                                </button>

                                            </div>

                                        </div>

                                        <div class="card-body" id="ordenes">
                                            <?php if ($opcion == 1) { ?>
                                                <div class="row">
                                                    <button id="btnAgregarOrd" type="button" class="btn bg-gradient-success btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Agregar Orden</span></button>
                                                </div>
                                            <?php } ?>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-12 mx-auto">
                                                    <div class="table-responsive" style="padding:2px;">
                                                        <table name="tablaNomord" id="tablaNomord" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%; font-size:14px">
                                                            <thead class="text-center bg-gradient-success">
                                                                <tr>
                                                                    <th>id reg</th>
                                                                    <th>Orden</th>
                                                                    <th>Cliente</th>
                                                                    <th>Concepto</th>
                                                                    <th>Tipo</th>
                                                                    <th>Estado</th>
                                                                    <th>Avance</th>
                                                                    <th>ML</th>
                                                                    <th>% Tomado</th>
                                                                    <th>Imp Tomado</th>
                                                                    <th>% Nom Actual</th>
                                                                    <th>ML Nom Actual</th>
                                                                    <th>Importe Nom Actual</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php
                                                                $totalmlord = 0;
                                                                $totalimpord = 0;
                                                                foreach ($dataord as $roword) {
                                                                    $totalmlord += $roword['ml'];
                                                                    $totalimpord += $roword['importe'];
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $roword['id_reg'] ?></td>
                                                                        <td><?php echo $roword['folio_ord'] ?></td>
                                                                        <td><?php echo $roword['nombre'] ?></td>
                                                                        <td><?php echo $roword['concepto_vta'] ?></td>
                                                                        <td><?php echo $roword['tipop'] ?></td>
                                                                        <td><?php echo $roword['edo_ord'] ?></td>
                                                                        <td><?php echo $roword['avance'] ?></td>
                                                                        <td><?php echo $roword['metros'] ?></td>
                                                                        <td><?php echo $roword['tnomina'] ?></td>
                                                                        <td><?php echo $roword['nomtomado'] ?></td>
                                                                        <td><?php echo $roword['porcentaje'] ?></td>
                                                                        <td><?php echo $roword['ml'] ?></td>
                                                                        <td><?php echo $roword['importe'] ?></td>
                                                                        <td></td>
                                                                    </tr>

                                                                <?php } ?>
                                                            </tbody>

                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-sm-6"></div>
                                                <div class="col-sm-2">
                                                    <div class="form-group input-group-sm">
                                                        <label for="totalmlorden" class="col-form-label ">Suma ML:</label>
                                                        <input type="text" class="form-control text-right" name="totalmlorden" id="totalmlorden" value="<?php echo $totalmlord ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group input-group-sm">
                                                        <label for="totalimporden" class="col-form-label ">Suma Imp:</label>
                                                        <input type="text" class="form-control text-right" name="totalimporden" id="totalimporden" value="<?php echo $totalimpord ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PERSONAL -->
                                    <div class="card ">
                                        <div class="card-header bg-gradient-primary " style="margin:0px;padding:8px;">
                                            <h1 class="card-title ">Dellate Personal</h1>
                                            <div class="card-tools " style="margin:0px;padding:0px;">
                                                <button type="button" class="btn bg-primary btn-sm " href="#personal" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-minus text-white"></i>
                                                </button>

                                            </div>

                                        </div>
                                        <div class="card-body" id="personal">
                                            <?php if ($opcion == 1) { ?>
                                                <div class="row justify-content-between">
                                                    <div class="col-sm-2">
                                                        <button id="btnAgregarPer" type="button" class="btn bg-gradient-primary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Agregar Personal</span></button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button id="btnCalcularnom" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-calculator text-light"></i><span class="text-light"> Calcular</span></button>
                                                    </div>

                                                </div>
                                            <?php } ?>

                                            <div class="col-lg-12 mx-auto">

                                                <div class="table-responsive" style="padding:2px;">

                                                    <table name="tablaNomper" id="tablaNomper" class="table table-sm table-striped table-bordered table-condensed mx-auto" style="width:100%; font-size:14px">
                                                        <thead class="text-center bg-gradient-primary">
                                                            <tr>
                                                                <th>id_reg</th>
                                                                <th>ID Personal</th>
                                                                <th>Personal</th>
                                                                <th>Dias Per</th>
                                                                <th>Dias Trab</th>
                                                                <th>Diario SF</th>
                                                                <th>Bruto SF</th>
                                                                <th>Descuento SF</th>
                                                                <th>Bono SF</th>
                                                                <th>Salario Fijo</th>
                                                                <th>Porcentaje</th>
                                                                <th>Participación</th>
                                                                <th>Diario SD</th>
                                                                <th>Faltas SD</th>
                                                                <th>Retardos SD</th>
                                                                <th>Reparto SD</th>
                                                                <th>Bruto SD</th>
                                                                <th>Descuento SD</th>
                                                                <th>Bono SD</th>
                                                                <th>Salario Destajo</th>
                                                                <th>Salario Total</th>
                                                                <th>tipo</th>
                                                                <th>Acciones</th>



                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($dataper as $rowper) { ?>
                                                                <tr>
                                                                    <td><?php echo $rowper['id_reg'] ?></td>
                                                                    <td><?php echo $rowper['id_per'] ?></td>
                                                                    <td><?php echo $rowper['nom_per'] ?></td>
                                                                    <td><?php echo $rowper['diasp'] ?></td>
                                                                    <td><?php echo $rowper['diast'] ?></td>
                                                                    <td><?php echo $rowper['salariodf'] ?></td>
                                                                    <td><?php echo $rowper['salariobf'] ?></td>
                                                                    <td><?php echo $rowper['descuentof'] ?></td>
                                                                    <td><?php echo $rowper['bonof'] ?></td>
                                                                    <td><?php echo $rowper['salariofijo'] ?></td>
                                                                    <td><?php echo $rowper['porcentaje'] ?></td>
                                                                    <td><?php echo $rowper['participacion'] ?></td>
                                                                    <td><?php echo $rowper['salariodd'] ?></td>
                                                                    <td><?php echo $rowper['sanciones'] ?></td>
                                                                    <td><?php echo $rowper['retardo'] ?></td>
                                                                    <td><?php echo $rowper['reparto'] ?></td>
                                                                    <td><?php echo $rowper['salariobd'] ?></td>
                                                                    <td><?php echo $rowper['descuentod'] ?></td>
                                                                    <td><?php echo $rowper['bonod'] ?></td>
                                                                    <td><?php echo $rowper['salariodestajo'] ?></td>
                                                                    <td><?php echo $rowper['salariototal'] ?></td>
                                                                    <td><?php echo $rowper['tipo'] ?></td>
                                                                    <td></td>
                                                                </tr>

                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- ASISTENCIA -->
                                    <div class="card ">
                                        <div class="card-header bg-gradient-orange " style="margin:0px;padding:8px;">
                                            <h1 class="card-title ">Asistencia</h1>
                                            <div class="card-tools " style="margin:0px;padding:0px;">
                                                <button type="button" class="btn bg-orange btn-sm " href="#asistencia" data-card-widget="collapse" aria-expanded="false" title="Collapsed">
                                                    <i class="fas fa-minus text-white"></i>
                                                </button>

                                            </div>

                                        </div>
                                        <div class="card-body" id="asistencia">

                                            <div class="row justify-content-center">
                                                <div class="col-sm-12 mx-auto">
                                                    <div class="table-responsive">
                                                        <table name="tablaasi" id="tablaasi" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%;font-size:14px">
                                                            <thead class="text-center bg-gradient-orange">
                                                                <tr>
                                                                    <th class="text-center">PERSONAL</th>
                                                                    <?php
                                                                    while ($fechaInicio <= $fechaFin) {
                                                                        echo '<th class="text-center">' . date('d M y', strtotime($fechaInicio->format('Y-m-d'))) . '</th>';
                                                                        $fechaInicio->add(new DateInterval('P1D'));
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($dataper as $row) {
                                                                    echo '<tr><th>' . $row['nom_per'] . '</th>';
                                                                    $idper = $row['id_per'];

                                                                    $consultap = "call sp_verfechas('$inicio','$fin','$idper')";
                                                                    $resultadop = $conexion->prepare($consultap);
                                                                    $resultadop->execute();
                                                                    $datap = $resultadop->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($datap as $rowp) {
                                                                        $tipo = $rowp['tipo'];
                                                                        $tipon = $rowp['tipon'];
                                                                        switch ($tipo) {
                                                                            case '0':
                                                                                $icono = "<i class='text-info fa-solid fa-circle-exclamation '></i>";
                                                                                break;
                                                                            case '1':
                                                                                $icono = "<i class='text-success fa-solid fa-circle-check '></i>";
                                                                                break;
                                                                            case '2':
                                                                                $icono = "<i class='text-danger fa-solid fa-circle-xmark '></i>";
                                                                                break;
                                                                            case '3':
                                                                                $icono = "<i class='text-warning fa-solid fa-clock '></i>";
                                                                                break;
                                                                            case '4':
                                                                                $icono = "<i class='text-success fa-solid fa-check-to-slot '></i>";
                                                                                break;
                                                                            case '5':
                                                                                $icono = "<i class='text-danger fa-solid fa-square-xmark '></i>";
                                                                                break;
                                                                        }
                                                                        echo '<td>' . $icono . ' <span>' . $tipon . '</span></td>';
                                                                    }



                                                                    echo '</tr>';
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
                            <!-- Formulario Agrear Item -->

                            <!-- Tabla -->

                            <!-- Formulario totales -->

                        </div>

                    </div>


                </form>
                <!-- TERMINA FORM -->

            </div>

        </div>

        <!-- /.card -->

    </section>





    <section>
        <div class="container">
            <div class="modal fade" id="modalOrd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-success">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR ORDENES</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto " style="padding:10px">
                            <table name="tablaOrd" id="tablaOrd" class="table table-sm table-striped table-bordered table-condensed " style="width:100%">
                                <thead class="text-center bg-gradient-success">
                                    <tr>
                                        <th>Folio Ord</th>
                                        <th>Folio Vta</th>

                                        <th>Cliente</th>
                                        <th>Proyecto</th>
                                        <th>Tipo</th>
                                        <th>Progreso</th>
                                        <th>Estado</th>
                                        <th>ML</th>
                                        <th>Importe Vta</th>
                                        <th>Importe Nom</th>
                                        <th>Importe Tomado</th>
                                        <th>% Tomado</th>
                                        <th>Acciones</th>
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
    </section>

    <section>
        <div class="container">
            <div class="modal fade" id="modalPer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PERSONAL</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto " style="padding:10px">
                            <table name="tablaPer" id="tablaPer" class="table table-sm table-striped text-nowrap table-bordered table-condensed " style="width:100%">
                                <thead class="text-center bg-gradient-primary">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Salario Diario</th>
                                        <th>Acciones</th>
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
    </section>

    <section>
        <div class="modal fade" id="modalCalculo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle Empleado</h5>

                    </div>
                    <form id="formCalculo" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content-sm-center my-auto">


                                <div class="col-sm-2 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="id_per" class="col-form-label">ID Personal:</label>
                                        <input type="text" class="form-control" name="id_per" id="id_per" disabled>
                                    </div>
                                </div>


                                <div class="col-sm-6 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="empleado" class="col-form-label">Nombre del Personal:</label>
                                        <input type="text" class="form-control" name="empleado" id="empleado" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="diasp" class="col-form-label">Días del Período</label>
                                        <input type="text" class="form-control" name="diasp" id="diasp" autocomplete="off" placeholder="Dias Trabajados">
                                    </div>
                                </div>


                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="diast" class="col-form-label">Días Trabajados</label>
                                        <input type="text" class="form-control" name="diast" id="diast" autocomplete="off" placeholder="Dias Trabajados">
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-center my-auto">
                                <div class=" col-sm-12">
                                    <div class="card" id="cardfijo">
                                        <div class="card-header bg-success" style="margin:0px;padding:8px;">
                                            <div class="card-tittle">
                                                <span>Integración Salario Fijo</span>
                                            </div>

                                        </div>
                                        <div class="card-body row justify-content-center">

                                            <div class="col-lg-2">
                                                <label for="salariodf" class="col-form-label">Salario Diario Fijo:</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>

                                                    </div>
                                                    <input type="text" id="salariodf" name="salariodf" class="form-control text-right" autocomplete="off" placeholder="Salario Diario Fijo">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="salariobf" class="col-form-label">Salario Bruto Fijo:</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>

                                                    </div>
                                                    <input type="text" id="salariobf" name="salariobf" class="form-control text-right" autocomplete="off" placeholder="Salario Bruto Fijo">
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="descuentof" class="col-form-label">Descuentos:</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>

                                                    </div>
                                                    <input type="text" id="descuentof" name="descuentof" class="form-control text-right" autocomplete="off" placeholder="Descuentos">
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="bonof" class="col-form-label">Bonificaciones:</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>

                                                    </div>
                                                    <input type="text" id="bonof" name="bonof" class="form-control text-right" autocomplete="off" placeholder="Bonificaciones">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="salariofijo" class="col-form-label">Importe Salario Fijo:</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </span>

                                                    </div>
                                                    <input type="text" id="salariofijo" name="salariofijo" class="form-control text-right" autocomplete="off" placeholder="Importe Salario Fijo">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>



                            </div>

                            <div class="row justify-content-sm-center my-auto">
                                <div class=" col-sm-12">
                                    <div class="card" id="carddestajo">
                                        <div class="card-header bg-success" style="margin:0px;padding:8px;">
                                            <div class="card-tittle">
                                                <span>Integración Salario Destajo</span>
                                            </div>

                                        </div>
                                        <div class="card-body  justify-content-center">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group input-group-sm">
                                                        <label for="porcentaje" class="col-form-label">% Participación.</label>
                                                        <input type="text" class="form-control" name="porcentaje" id="porcentaje" autocomplete="off" placeholder="% Part.">
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label for="participacion" class="col-form-label">Importe Participación:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="participacion" name="participacion" class="form-control text-right" autocomplete="off" placeholder="Importe Participación">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="salariodd" class="col-form-label">Salario Diario Dest:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="salariodd" name="salariodd" class="form-control text-right" autocomplete="off" placeholder="Salario Diario Dest.">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="sanciones" class="col-form-label">Faltas:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="sanciones" name="sanciones" class="form-control text-right" autocomplete="off" placeholder="Faltas">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="retardo" class="col-form-label">Retardo:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="retardo" name="retardo" class="form-control text-right" autocomplete="off" placeholder="Retardos">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="reparto" class="col-form-label">Reparto:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="reparto" name="reparto" class="form-control text-right" autocomplete="off" placeholder="Reparto">
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label for="salariobd" class="col-form-label">Salario Bruto Destajo:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="salariobd" name="salariobd" class="form-control text-right" autocomplete="off" placeholder="Salario Bruto Destajo">
                                                    </div>
                                                </div>


                                                <div class="col-sm-2">
                                                    <label for="descuentod" class="col-form-label">Descuentos:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="descuentod" name="descuentod" class="form-control text-right" autocomplete="off" placeholder="Descuentos">
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <label for="bonod" class="col-form-label">Bonificaciones:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="bonod" name="bonod" class="form-control text-right" autocomplete="off" placeholder="Bonificaciones">
                                                    </div>
                                                </div>


                                                <div class="col-sm-3">
                                                    <label for="salariodestajo" class="col-form-label">Importe Salario Destajo:</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </span>

                                                        </div>
                                                        <input type="text" id="salariodestajo" name="salariodestajo" class="form-control text-right" autocomplete="off" placeholder="Importe Salario Destajo">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>



                            </div>
                            <div class="row justify-content-sm-center border-top border-success" style="border-width:5px !important">

                                <div class="col-xl-8"></div>

                                <div class="col-xl-4">
                                    <label for="salariototal" class="col-form-label">Salario Total:</label>
                                    <div class="input-group input-group-xl">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="salariototal" name="salariototal" class="form-control text-right bg-white font-weight-bold" autocomplete="off" placeholder="Salario Total">
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnAddPer" name="btnAddPer" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="modal fade" id="modalOrdenes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle Orden</h5>

                    </div>
                    <form id="formOrdenes" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content-sm-center my-auto">


                                <div class="col-sm-1 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="folio_ord" class="col-form-label">Folio Ord:</label>
                                        <input type="text" class="form-control" name="folio_ord" id="folio_ord" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-1 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="folio_vta" class="col-form-label">Folio Vta:</label>
                                        <input type="text" class="form-control" name="folio_vta" id="folio_vta" disabled>
                                    </div>
                                </div>


                                <div class="col-sm-1 my-auto">
                                    <div class="form-group input-group-sm">
                                        <label for="metros" class="col-form-label">ML:</label>
                                        <input type="text" class="form-control" name="metros" id="metros" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label for="importevta" class="col-form-label">Importe Venta:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="importevta" name="importevta" class="form-control text-right" autocomplete="off" placeholder="Importe Venta" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label for="importenom" class="col-form-label">Importe Nomina:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="importenom" name="importenom" class="form-control text-right" autocomplete="off" placeholder="Importe Nomina" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label for="tnomina" class="col-form-label">Importe Tomado:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="tnomina" name="tnomina" class="form-control text-right" autocomplete="off" placeholder="Importe Tomado" disabled>
                                    </div>
                                </div>


                                <div class="col-sm-1">
                                    <div class="form-group input-group-sm">
                                        <label for="nomtomado" class="col-form-label">% Tomado</label>
                                        <input type="text" class="form-control" name="nomtomado" id="nomtomado" autocomplete="off" placeholder="% Tomado" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="edo_ord" class="col-form-label">Estado</label>
                                        <input type="text" class="form-control" name="edo_ord" id="edo_ord" autocomplete="off" placeholder="Estado" disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-center border-top border-success" style="border-width:5px !important">
                                <div class=" col-sm-12">


                                    <div class="card-body row justify-content-center">
                                        <div class="col-sm-3"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="porcentajesug" class="col-form-label">% Sugerido</label>
                                                <select class="form-control" name="porcentajesug" id="porcentajesug"></select>
                                                <!-- <input type="text" class="form-control" name="porcentajesug" id="porcentajesug" autocomplete="off" placeholder="% Sugerido"> -->
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="mlnomord" class="col-form-label">Ml Tomados</label>
                                                <input type="text" class="form-control text-right" name="mlnomord" id="mlnomord" autocomplete="off" placeholder="Ml Tomados">
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group input-group-sm">
                                                <label for="mlnom" class="col-form-label">Ml Nom</label>
                                                <input type="text" class="form-control text-right" name="mlnom" id="mlnom" autocomplete="off" placeholder="Ml Nom">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="importeorden" class="col-form-label">Importe Nom:</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>

                                                </div>
                                                <input type="text" id="importeorden" name="importeorden" class="form-control text-right" autocomplete="off" placeholder="Importe Orden">
                                            </div>
                                        </div>



                                    </div>


                                </div>



                            </div>




                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="btnAddOrd" name="btnAddOrd" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container">
            <div class="modal fade" id="modalRet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-success">
                            <h5 class="modal-title" id="exampleModalLabel">RETENCIONES DE NOMINA</h5>

                        </div>
                        <br>
                        <div class="modal-body">
                            <div class="row justify-content-center ">
                                <div class="col-sm-10">
                                    <div class="table-hover table-responsive w-auto " style="padding:10px">
                                        <table name="tablaRet" id="tablaRet" class="table table-sm table-striped table-bordered table-condensed " style="width:100%">
                                            <thead class="text-center bg-gradient-success">
                                                <tr>
                                                    <th>Nomina</th>
                                                    <th>Fecha</th>
                                                    <th>Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $mret = 0;
                                                foreach ($dataret as $row) {
                                                    $mret = $row['importe'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['folio_nom'] ?></td>
                                                        <td><?php echo $row['fecha'] ?></td>
                                                        <td><?php echo $row['importe'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center p-3">
                                <div class="col-sm-5">
                                    <label for="acumret" class="col-form-label">Acumulado Ret:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="acumret" name="acumret" class="form-control text-right" autocomplete="off" value="<?php echo $mret ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <label for="usarret" class="col-form-label">Importe a Usar:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>

                                        </div>
                                        <input type="text" id="usarret" name="usarret" class="form-control text-right" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="button" id="bntretencionu" name="bntretencionu" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/nomina.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>