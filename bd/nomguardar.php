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

    }
}




print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
