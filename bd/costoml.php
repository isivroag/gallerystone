<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';


$fecha = date('Y-m-d');
$res = 0;

$consulta = "UPDATE mlcosto SET estado=0";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "INSERT INTO mlcosto (costo,fecha) VALUES('$costo','$fecha')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res = 1;
}



print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
