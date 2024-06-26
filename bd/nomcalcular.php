<?php




include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$extra = (isset($_POST['extra'])) ? $_POST['extra'] : '';
$retencion = (isset($_POST['retencion'])) ? $_POST['retencion'] : '';
$retencionu = (isset($_POST['retencionu'])) ? $_POST['retencionu'] : '';

$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';

$consulta = "UPDATE nomina set extra='$extra', retencion='$retencion', obs='$obs',retencionu='$retencionu' where folio_nom='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$resultado->closeCursor();
$importenom = 0;
$totaldias = 0;


$consulta = "SELECT * from nomina where folio_nom='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        $importenom = $row['importe'];
        $extra = $row['extra'];
        $retencion = $row['retencion'];
        $retencionu = $row['retencionu'];
        $periodoini = $row['periodoini'];
        $periodofin = $row['periodofin'];
    }
}
$resultado->closeCursor();
$importenom = ($importenom-$retencion) + $extra+$retencionu;
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
        $resultadop->closeCursor();
        
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
                    $resfalta->closeCursor();
                    
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
            $resnom->closeCursor();
            
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
    $resaux->closeCursor();

    foreach ($dataaux as $rowaux) {
        $fechad = $rowaux['fecha'];
        $importeaux = $rowaux['totalimporte'];

        $cntaaux2 = "call sp_repartir('$folio','$fechad')";
        $resaux2 = $conexion->prepare($cntaaux2);
        $resaux2->execute();
        
        $empleados=0;
        $empleados = $resaux2->rowCount();
        $dataaux2 = $resaux2->fetchAll(PDO::FETCH_ASSOC);
        $resaux2->closeCursor();
       
        

        if ($empleados > 0) {
            $importerepartir = $importeaux / $empleados;
            foreach ($dataaux2 as $rowaux2) {
                $id_per = $rowaux2['id_per'];

                $cntarepartir = "UPDATE nom_emp SET reparto= reparto+'$importerepartir', salariobd=salariobd + '$importerepartir',
            salariodestajo = salariodestajo + '$importerepartir', salariototal = salariototal + '$importerepartir'
            WHERE folio_nom = '$folio' AND id_per = '$id_per'";

                $resaux2 = $conexion->prepare($cntarepartir);
                $resaux2->execute();
                $resaux2->closeCursor();

                $cntarepartir = "INSERT INTO nom_auxcalculo(folio_nom,id_per,fecha,importe,tipo) VALUES('$folio','$id_per','$fechad','$importerepartir',2)";
                $resaux2 = $conexion->prepare($cntarepartir);
                $resaux2->execute();
                $resaux2->closeCursor();

               
            }
        }else{
            //CODIGO PARA AGREGAR LA RETENCION POR FALTAS
            $cntaact = "UPDATE nomina SET retenido = retenido + '$importeaux' WHERE folio_nom = '$folio'";
            $resact = $conexion->prepare($cntaact);
            $resact->execute();
            $resact->closeCursor();
        }
    }
    $resaux->closeCursor();

    $cntaret = "SELECT vnom_emp.id_per,COUNT(vnom_emp.id_per) AS retardos,reparto,vnom_emp.salariobd,vnom_emp.salariodestajo,vnom_emp.salariototal FROM asistencia  
    JOIN vnom_emp ON vnom_emp.id_per=asistencia.id_per
    WHERE vnom_emp.folio_nom='$folio' and vnom_emp.tipo='DESTAJO' AND asistencia.fecha BETWEEN '$periodoini' AND '$periodofin' AND (asistencia.tipo=5 OR asistencia.tipo=3)  GROUP BY vnom_emp.id_per HAVING COUNT(vnom_emp.id_per) < 3";
    $restret = $conexion->prepare($cntaret);
    $restret->execute();
    $numero = 0;
    $numero = $restret->rowCount();
    if ($numero == 0) {
        $cntaact = "UPDATE nomina SET retenido=retenido+'$retenido' WHERE folio_nom = '$folio'";
        $resact = $conexion->prepare($cntaact);
        $resact->execute();
    } else {
        $retenido = $retenido / $numero;
        $dataret = $restret->fetchAll(PDO::FETCH_ASSOC);
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


           /* $cntaact = "UPDATE nomina SET retenido=retenido+'0' WHERE folio_nom = '$folio'";
            $resact = $conexion->prepare($cntaact);
            $resact->execute();*/
        }
    }
}
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

$cntamain = "call sp_actualizarnom('$folio','$fijo')";
$resmain = $conexion->prepare($cntamain);
$resmain->execute();

$cntamain = "SELECT * FROM vnom_emp WHERE folio_nom = '$folio' order by id_per";
$resmain = $conexion->prepare($cntamain);
$resmain->execute();
$datamain = $resmain->fetchAll(PDO::FETCH_ASSOC);

print json_encode($datamain, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
