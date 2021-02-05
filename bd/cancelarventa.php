<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio_venta = (isset($_POST['folio_venta'])) ? $_POST['folio_venta'] : '';
$motivo = (isset($_POST['motivo'])) ? $_POST['motivo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$consulta = "UPDATE venta SET estado_vta='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_vta='$folio_venta'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {

    $res = 1;
} else {
    $res = 0;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
