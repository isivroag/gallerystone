<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$idfrente = (isset($_POST['idfrente'])) ? $_POST['idfrente'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';

$supervisor = (isset($_POST['supervisor'])) ? $_POST['supervisor'] : '';
$colocador = (isset($_POST['colocador'])) ? $_POST['colocador'] : '';





$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO areas (id_frente,area,supervisor,colocador) values ('$idfrente','$area','$supervisor','$colocador')";

        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        } else {
            $data = 2;
        }






        break;
    case 2:

        $consulta = "SELECT * FROM geneador WHERE id_area='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if ($resultado->rowCount() > 0) {
            $data = 0;
        } else {
            $consulta = "SELECT * FROM detalle_area WHERE id_area='$id' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if ($resultado->rowCount() > 0) {
                $data = 0;
            } else {
                $consulta = "UPDATE areas SET estado_area=0 WHERE id_area='$id' ";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $data = 1;
                }
            }
        }




        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
