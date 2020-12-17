<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$subtotal= (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva= (isset($_POST['iva'])) ? $_POST['iva'] : '';
$total= (isset($_POST['total'])) ? $_POST['total'] : '';
$descuento= (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$gtotal= (isset($_POST['gtotal'])) ? $_POST['gtotal'] : '';

$consulta = "UPDATE tmp_pres SET subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal' WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "SELECT * FROM tmp_pres WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>