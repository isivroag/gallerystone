<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$monto= (isset($_POST['monto'])) ? $_POST['monto'] : '';

$consulta = "UPDATE venta SET saldo=saldo-'$monto' WHERE folio_vta='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "SELECT saldo FROM venta WHERE folio_vta='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>