<?php



include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";
include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

$importenom = 0;
$totaldias = 0;


$consulta = "SELECT * from nomina where folio_nom='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        $importenom = $row['importe'];
        $periodoini = $row['periodoini'];
        $periodofin = $row['periodofin'];
    }
}


$inicio = $periodoini;
$fin = $periodofin;

$fechaInicio = new DateTime($periodoini);
$fechaFin = new DateTime($periodofin);
$intervalo = $fechaInicio->diff($fechaFin);
$numDias = $intervalo->days;
$numDias = $numDias + 1;

$domingo = 0;

// Iterar sobre cada día en el rango
while ($fechaInicio <= $fechaFin) {
    // Verificar si el día actual es domingo (día de la semana = 0)
    if ($fechaInicio->format('w') == 0) {
        $domingo++;
    }

    // Avanzar al siguiente día
    $fechaInicio->add(new DateInterval('P1D'));
}





$totaldias = $numDias - $domingo;
$salariodiario = $importenom / $totaldias;

$cntalimpiar = "DELETE FROM nom_auxcalculo WHERE folio_nom='$folio'";
$reslimpiar = $conexion->prepare($cntalimpiar);
$reslimpiar->execute();

$cnta = "SELECT * FROM nom_emp WHERE folio_nom='$folio'";
$resultado = $conexion->prepare($cnta);



if ($resultado->execute()) {

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $row) {

        $id_per = $row['id_per'];
        $porcentaje = $row['porcentaje'];
        $descuento = $row['descuentod'];
        $bono = $row['bonod'];
        $salariofijo = $row['salariofijo'];

        $porcentaje = $porcentaje / 100;
        $participacion = $porcentaje * $importenom;
        $salariotrabajador = $salariodiario * $porcentaje;

        $cnta2 = "call sp_verfechas('$periodoini','$periodofin','$id_per')";
        $resultadop = $conexion->prepare($cnta2);
        $resultadop->execute();

        $datap = $resultadop->fetchAll(PDO::FETCH_ASSOC);

        $nr = 0;
        $asistencia = 0;
        $falta = 0;
        $retardo = 0;

        $totalfalta = 0;
        $totalasistencia = 0;
        $totalretardo = 0;
        $sanciones = 0;





        foreach ($datap as $rowp) {
            $estado = $rowp['tipo'];
            $fecha = $rowp['nfecha'];
            $importediat = $porcentaje * $salariodiario;
            //CONTAR ASISTENCIAS, FALTAS, RETARDOS Y NO CHECADOS
            switch ($estado) {
                case '0':
                    $nr++;
                    break;
                case '1':
                    $asistencia++;
                    $totalasistencia += $importediat;

                    break;
                case '2':
                    $falta++;
                    $totalfalta += $importediat;
                    //LAS FALTAS NECESARIO GUARDARLOS EN ALGUN CON LA FECHA EN LA QUE FALTO Y EL MONTO DE DESCUENTO
                    $cntafalta = "INSERT INTO nom_auxcalculo (folio_nom,id_per,fecha,importe,tipo) VALUES ($folio,'$id_per','$fecha','$importediat','1')";
                    $resfalta = $conexion->prepare($cntafalta);
                    $resfalta->execute();
                    break;
                case '3':
                    $retardo++;
                    $asistencia++;
                    break;
                case '4':
                    $asistencia++;
                    $totalasistencia += $importediat;
                    break;
                case '5':
                    $falta++;
                    $importefalta = $porcentaje * $salariodiario;
                    $totalfalta += $importediat;
                    //LAS FALTAS NECESARIO GUARDARLOS EN ALGUN CON LA FECHA EN LA QUE FALTO Y EL MONTO DE DESCUENTO
                    $cntafalta = "INSERT INTO nom_auxcalculo (folio_nom,id_per,fecha,importe,tipo) VALUES ($folio,'$id_per','$fecha','$importediat','1')";
                    $resfalta = $conexion->prepare($cntafalta);
                    $resfalta->execute();
                    break;
            }
            $totalretardo = $importediat * intval($retardo / 3);
            $sanciones = $totalretardo + $totalfalta;
            $diast = $asistencia;
            $salariobd = $participacion - $sanciones;

            $salariodestajo = ($salariobd + $bono) - $descuento;
            $salariototal = $salariodestajo + $salariofijo;

            //actualizar el registro de nomina
            $cntanom = "UPDATE nom_emp SET diasp='$totaldias',diast='$diast',participacion='$participacion',
            salariodd='$salariotrabajador',sanciones='$sanciones',salariobd='$salariobd',salariodestajo='$salariodestajo',
            salariototal=$salariototal,reparto=0
            WHERE folio_nom='$folio' and id_per='$id_per' ";
            $resnom = $conexion->prepare($cntanom);
            $resnom->execute();
        }
    }
    //BUSCAR LOS FECHAS CON FALTA Y REPARTIRLO ENTRE LOS TRABAJADORES QUE SI FUERON
    //1 SUMAR EL IMPORTE TOTAL DE DESCUENTO POR FECHA 
    $cntaaux = "SELECT fecha,sum(importe) as totalimporte FROM nom_auxcalculo WHERE folio_nom='$folio' and tipo='1' GROUP BY folio_nom,fecha";
    $resaux = $conexion->prepare($cntaaux);
    $resaux->execute();
    $dataaux = $resaux->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dataaux as $rowaux) {
        $fechad = $rowaux['fecha'];
        $importeaux = $rowaux['totalimporte'];

        $cntaaux2 = "call sp_repartir('$folio','$fechad')";
        $resaux2 = $conexion->prepare($cntaaux2);
        $resaux2->execute();
        $dataaux2 = $resaux2->fetchAll(PDO::FETCH_ASSOC);
        $empleados = $resaux2->rowCount();

        $importerepartir = $importeaux / $empleados;
        foreach ($dataaux2 as $rowaux2) {
            $id_per = $rowaux2['id_per'];

            $cntarepartir = "UPDATE nom_emp SET reparto= reparto+'$importerepartir', salariobd=salariobd + '$importerepartir',
            salariodestajo = salariodestajo + '$importerepartir', salariototal = salariototal + '$importerepartir'
            WHERE folio_nom = '$folio' AND id_per = '$id_per'";

            $resaux2 = $conexion->prepare($cntarepartir);
            $resaux2->execute();

            $cntarepartir = "INSERT INTO nom_auxcalculo(folio_nom,id_per,fecha,importe,tipo) VALUES('$folio','$id_per','$fechad','$importerepartir',2)";
            $resaux2 = $conexion->prepare($cntarepartir);
            $resaux2->execute();
        }
    }
}




$cntamain = "SELECT * FROM vnom_emp WHERE folio_nom = '$folio'";
$resmain = $conexion->prepare($cntamain);
$resmain->execute();
$datamain = $resmain->fetchAll(PDO::FETCH_ASSOC);





?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-orange">
                <h1 class="card-title mx-auto">NOMINA</h1>
            </div>

            <div class="card-body">



        

                <!-- INICIO FORM -->
                <form id="formDatos" action="" method="">


                    <div class="content">

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-orange " style="margin:0px;padding:8px">
                                <h1 class="card-title ">Información de Nomina</h1>

                            </div>

                        
                            <!-- Formulario Agrear Item -->

                            <!-- Tabla -->
                            <div class="content" style="padding:5px 0px;">
                                <!-- ORDENES -->
                          
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
                                        <div class="row justify-content-between">
                                            <div class="col-sm-2">
                                                <button id="btnAgregarPer" type="button" class="btn bg-gradient-primary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Agregar Personal</span></button>
                                            </div>
                                            <div class="col-sm-1">
                                                <button id="btnCalcularnom" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-calculator text-light"></i><span class="text-light"> Calcular</span></button>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="col-lg-12 mx-auto">

                                            <div class="table-responsive" style="padding:2px;">

                                                <table name="tablaNomper" id="tablaNomper" class="table table-sm table-striped table-bordered table-condensed mx-auto" style="width:100%; font-size:15px">
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
                                                            <th>Sanciones SD</th>
                                                            <th>Bruto SD</th>
                                                            <th>Descuento SD</th>
                                                            <th>Bono SD</th>
                                                            <th>Salario Destajo</th>
                                                            <th>Salario Total</th>
                                                            <th>Acciones</th>



                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($datamain as $rowper) { ?>
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
                                                                <td><?php echo $rowper['salariobd'] ?></td>
                                                                <td><?php echo $rowper['descuentod'] ?></td>
                                                                <td><?php echo $rowper['bonod'] ?></td>
                                                                <td><?php echo $rowper['salariodestajo'] ?></td>
                                                                <td><?php echo $rowper['salariototal'] ?></td>
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
                          

                            </div>
                            <!-- Formulario totales -->

                        </div>

                    </div>


                </form>
                <!-- TERMINA FORM -->

            </div>

        </div>

        <!-- /.card -->

    </section>
</div>
