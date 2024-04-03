<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';
$flag = 0;




$data = 0;

$consulta = "SELECT * FROM pres_cto_detalle where folio_ord='$orden'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() == 0) {
    $flag += 1;
}
$resultado->closeCursor();
$consulta = "SELECT * FROM pres_cto_detalle where folio_ord='$orden'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() == 0) {
    $flag += 1;
}
$resultado->closeCursor();

$consulta = "SELECT * FROM pres_cto_detalle where folio_ord='$orden'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() == 0) {
    $flag += 1;
}
$resultado->closeCursor();




print json_encode($flag, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
