<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$areacol = (isset($_POST['areacol'])) ? $_POST['areacol'] : '';
$supervisor = (isset($_POST['supervisor'])) ? $_POST['supervisor'] : '';
$colocador = (isset($_POST['colocador'])) ? $_POST['colocador'] : '';




$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO frente (id_ord,nom_frente,area_frente,supervisor_frente,colocador_frente,areacol_frente) values ('$orden','$nombre','$area','$supervisor','$colocador','$areacol')";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM frente WHERE id_ord='$orden' ORDER BY id_frente DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);



        break;
    case 2:
        $consulta = "UPDATE frente SET estado_frente=0 WHERE id_frente='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }





        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
