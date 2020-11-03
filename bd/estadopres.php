<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$nota = (isset($_POST['nota'])) ? $_POST['nota'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';



$consulta = "UPDATE presupuesto SET estado_pres='$estado' WHERE folio_pres='$folio' ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "INSERT INTO notaspres (folio_pres,fecha,estado,nota,usuario) VALUES('$folio','$fecha','$estado','$nota','$usuario') ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();



print json_encode(1, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;


?>