<?php




include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$fin = (isset($_POST['fin'])) ? $_POST['fin'] : '';

$res = 0;
$consulta = "UPDATE nomina SET aplicado=1 WHERE folio_nom='$folio'";

$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res++;

    $consulta = "SELECT * from vnom_emp WHERE folio_nom='$folio'";

    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $row) {
            $id_per = $row['id_per'];

            $cnta = "UPDATE asistencia SET bloqueo=1 WHERE id_per='$id_per' AND fecha between '$inicio' AND '$fin'";
            $res = $conexion->prepare($cnta);
            if ($res->execute()) {
                $res++;

            }
        }

        $cnta="SELECT * from nom_ord where folio_nom='$folio'";
        $res=$conexion->prepare($cnta);
        if($res->execute() ) {
            $data=$res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) {
                $folioord=$row['folio_ord'];
                $porcentaje=$row['porcentaje'];
                
                $importe=$row['importe'];

                $cntaord="call sp_actualizarorden('$folioord','$porcentaje','$importe')";
                $res=$conexion->prepare($cntaord);
                if ($res->execute()) {
                    $res++;
    
                }
            }
        }

        
        $cnta="SELECT * from nomina where folio_nom='$folio'";
        $res=$conexion->prepare($cnta);
        if($res->execute() ) {
            $data=$res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row){
                $retencion=$row['retencion'];
                $retencionu=$row['retencionu'];

            }
            if ($retencion>0) {
            $cnta2="INSERT INTO nom_retenciones(folio_nom,importe) values('$folio','$retencion')";
            $res2=$conexion->prepare($cnta2);
            $res2->execute();
            }

            if($retencionu!=0){
                while ($retencionu > 0) {
                    $cnta3="SELECT * FROM nom_retenciones WHERE importe>0 and folio_nomu <> '$folio' order by folio_nom desc limit 1";
                    $res3=$conexion->prepare($cnta3);
                    $res3->execute();
                    $data3 = $res3->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data3 as $row3){

                        $idreg=$row3['id_reg'];
                        $importereg=$row3['importe'];
                    }
                    if($retencionu>$importereg){
                        $retencionu=$retencionu-$importereg;
                        $importereg=0;
                    }
                    else{
                        $importereg=$importereg-$retencionu;
                        $retencionu=0;
                    }
                    $cnta3="UPDATE nom_retenciones SET importe='$importereg', folio_nomu='$folio' WHERE id_reg='$idreg'";
                    $res3=$conexion->prepare($cnta3);
                    $res3->execute();

                }

            }
        }


    }
}




print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
