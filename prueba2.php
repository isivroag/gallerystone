<?php



include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";
include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

// Recepción de los datos enviados mediante POST desde el JS   

$folio = 1;




$importenom = 0;
$totaldias = 0;


$consulta = "SELECT * from nomina where folio_nom='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        $importenom = $row['importe'];
        $extra = $row['extra'];
        $periodoini = $row['periodoini'];
        $periodofin = $row['periodofin'];
    }
}
$resultado->closeCursor();
$importenom = $importenom + $extra;
//EMPLEADOS FIJOS




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
//$salariodiario = $importenom / $totaldias;

$cntalimpiar = "DELETE FROM nom_auxcalculo WHERE folio_nom='$folio'";
$reslimpiar = $conexion->prepare($cntalimpiar);
$reslimpiar->execute();
$reslimpiar->closeCursor();
$cnta = "SELECT * FROM vnom_emp WHERE folio_nom='$folio' and tipo<>'DESTAJO'";
$resultado = $conexion->prepare($cnta);

$retenido = 0;

if ($resultado->execute()) {

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $row) {

        $id_per = $row['id_per'];
        $diario = $row['salariodf'];
        $descuento = $row['descuentof'];
        $bono = $row['bonof'];
        $salariofijo = $row['salariofijo'];




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
            $importediat = $diario;
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
                    /* CAMBIAR LOS NO SE CHECO POR RETARDOS
                    $falta++;
                    $importefalta = $porcentaje * $salariodiario;
                    $totalfalta += $importediat;
                    //LAS FALTAS NECESARIO GUARDARLOS EN ALGUN CON LA FECHA EN LA QUE FALTO Y EL MONTO DE DESCUENTO
                    $cntafalta = "INSERT INTO nom_auxcalculo (folio_nom,id_per,fecha,importe,tipo) VALUES ($folio,'$id_per','$fecha','$importediat','1')";
                    $resfalta = $conexion->prepare($cntafalta);
                    $resfalta->execute();
                    */
                    $retardo++;
                    $asistencia++;
                    break;
            }
            $totalretardo = $importediat * intval($retardo / 3);
            $sanciones = $totalretardo + $totalfalta;
            $diast = $asistencia;
            $salariobf = ($importediat * ($diast + $falta));

            $salariofijo = ($salariobf + $bono) - $descuento;
            $salariototal =  $salariofijo;

            //actualizar el registro de nomina
            $cntanom = "UPDATE nom_emp SET diasp='$totaldias',diast='$diast',
            salariobf='$salariobf',descuentof='$sanciones',salariofijo='$salariofijo',
            salariototal=$salariototal,reparto=0
            WHERE folio_nom='$folio' and id_per='$id_per' ";
            $resnom = $conexion->prepare($cntanom);
            $resnom->execute();
        }
        $retenido += $totalretardo;
    }
}
$resultado->closeCursor();

//consultar de nom_emp cual es fijo destajo para descontar del importenom
$consulta = "SELECT * from vnom_emp where folio_nom='$folio' and tipo='FIJO DESTAJO'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        $nominafija = $row['salariofijo'];
        $importenom -= $nominafija;
    }
}
$resultado->closeCursor();

$salariodiario = $importenom / $totaldias;
//EMPLEADOS POR DESTAJO
$cnta = "SELECT * FROM vnom_emp WHERE folio_nom='$folio' and tipo='DESTAJO'";
$resultado = $conexion->prepare($cnta);

$retenido = 0;


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
                    /* CAMBIAR LOS NO SE CHECO POR RETARDOS
                    $falta++;
                    $importefalta = $porcentaje * $salariodiario;
                    $totalfalta += $importediat;
                    //LAS FALTAS NECESARIO GUARDARLOS EN ALGUN CON LA FECHA EN LA QUE FALTO Y EL MONTO DE DESCUENTO
                    $cntafalta = "INSERT INTO nom_auxcalculo (folio_nom,id_per,fecha,importe,tipo) VALUES ($folio,'$id_per','$fecha','$importediat','1')";
                    $resfalta = $conexion->prepare($cntafalta);
                    $resfalta->execute();
                    */
                    $retardo++;
                    $asistencia++;
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
            salariodd='$salariotrabajador',sanciones='$totalfalta',retardo='$totalretardo',salariobd='$salariobd',salariodestajo='$salariodestajo',
            salariototal=$salariototal,reparto=0
            WHERE folio_nom='$folio' and id_per='$id_per' ";
            $resnom = $conexion->prepare($cntanom);
            $resnom->execute();
            
        }
        $retenido += $totalretardo;
        $resultadop->closeCursor();
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

        if ($empleados > 0) {
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
    $resaux->closeCursor();

    $cnta4 = "SELECT vnom_emp.id_per,COUNT(vnom_emp.id_per) AS retardos,reparto,vnom_emp.salariobd,vnom_emp.salariodestajo,vnom_emp.salariototal FROM asistencia  
    JOIN vnom_emp ON vnom_emp.id_per=asistencia.id_per
    WHERE vnom_emp.folio_nom='$folio' and vnom_emp.tipo='DESTAJO' AND asistencia.fecha BETWEEN '$periodoini' AND '$periodofin' AND (asistencia.tipo=5 OR asistencia.tipo=3)  GROUP BY vnom_emp.id_per HAVING COUNT(vnom_emp.id_per) < 3";
    $res4 = $conexion->prepare($cnta4);
    $res4->execute();
    $numero = $res4->rowCount();
   
        //$numero = 0;
        
        if ($numero == 0) {
            $cnta5 = "UPDATE nomina SET retenido='$retenido' WHERE folio_nom = '$folio'";
            
            $res5 = $conexion->prepare($cnta5);
            if($res5->execute()){
                $msg="retenido ".$retenido;
            }else{
                $msg="NO SE EJECUTO" . $res5->errorInfo()[2];
            }
            
        } else {
            $retenido = $retenido / $numero;
            $dataret = $res4->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dataret as $rowret) {
                $personal = $rowret['id_per'];
                $salariobd = $rowret['salariobd'];
                $reparto = $rowret['reparto'];
                $salariodestajo = $rowret['salariodestajo'];
                $salariototal = $rowret['salariototal'];
    
                $reparto += $retenido;
                $salariobd += $retenido;
                $salariodestajo += $retenido;
                $salariototal += $retenido;
                $cntanom = "UPDATE nom_emp SET reparto='$reparto',salariobd='$salariobd',salariodestajo='$salariodestajo',salariototal='$salariototal'
                    WHERE folio_nom='$folio' and id_per='$personal' ";
                $resnom = $conexion->prepare($cntanom);
                $resnom->execute();
    
    
                $cnta5 = "UPDATE nomina SET retenido='0' WHERE folio_nom = '$folio'";
                $res5 = $conexion->prepare($cnta5);
                $res5->execute();
                $msg="retenido 0".$numero;
            }
        }
    
    

  
}
$resultado->closeCursor();
//EL MONTO RETENIDO DEBE SER REPARTIDO ENTRE TODOS LOS TRABAJADORES QUE NO TIENE FALTAS POR RETARDO Y SINO ENTONCES SE ACTUALIZA NOMINA COMO RETENIDO
//CONSULTAR EL DETALLE DE ASISTENCIA PARA VER AQUELLOS TRABAJADORES QUE NO TIENEN MAS DE 3 RETARDOS O NO CHECADAS








$cntamain = "SELECT * FROM vnom_emp WHERE folio_nom = '$folio' and tipo='FIJO' order by id_per";
$resmain = $conexion->prepare($cntamain);
$resmain->execute();
$datamain = $resmain->fetchAll(PDO::FETCH_ASSOC);
$fijo = 0;
foreach ($datamain as $rowret) {
    $fijo += $rowret['salariototal'];
}
$resmain->closeCursor();

$cntamain = "call sp_actualizarnom('$folio','$fijo')";
$resmain = $conexion->prepare($cntamain);
$resmain->execute();
$resmain->closeCursor();

$cntamain = "SELECT * FROM vnom_emp WHERE folio_nom = '$folio' order by id_per";
$resmain = $conexion->prepare($cntamain);
$resmain->execute();
$datamain = $resmain->fetchAll(PDO::FETCH_ASSOC);
$resmain->closeCursor();


$conexion = NULL;




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

                                <?php echo $msg?>
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