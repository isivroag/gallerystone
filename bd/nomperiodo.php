<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$fin = (isset($_POST['fin'])) ? $_POST['fin'] : '';

$res = 0;




$consulta = "UPDATE nomina SET periodoini='$inicio', periodofin='$fin' WHERE folio_nom='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res = 1;
}




print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
