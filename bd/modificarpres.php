<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$foliopres = (isset($_POST['presupuesto'])) ? $_POST['presupuesto'] : '';





$consulta = "SELECT * FROM tmp_pres WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($dt as $row) {
    $tokenid = $row['tokenid'];
    $id_pros = $row['id_pros'];
    $fecha = $row['fecha_pres'];
    $concepto = $row['concepto_pres'];
    $ubicacion = $row['ubicacion'];
    $subtotal = $row['subtotal'];
    $descuento= $row['descuento'];
    $iva= $row['iva'];
    $total= $row['total'];
    $gtotal= $row['gtotal'];
}

$consulta = "UPDATE tmp_pres SET estado_pres=2 WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "UPDATE presupuesto SET id_pros='$id_pros',fecha_pres='$fecha',concepto_pres='$concepto',ubicacion='$ubicacion',subtotal='$subtotal',tokenid='$tokenid',descuento='$descuento',iva='$iva',total='$total',gtotal='$gtotal' WHERE folio_pres='$foliopres'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "DELETE FROM detalle_pres WHERE folio_pres='$foliopres'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();



$consulta = "SELECT * FROM detalle_tmp WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);


foreach ($dt as $row) {

    $id_concepto = $row['id_concepto'];
    $id_item = $row['id_item'];
    $id_precio = $row['id_precio'];
    $precio = $row['precio'];
    $cantidad = $row['cantidad'];
    $total = $row['total'];

    $consultain = "INSERT INTO detalle_pres (folio_pres,id_concepto,id_item,id_precio,precio,cantidad,total) VALUES ('$foliopres','$id_concepto','$id_item','$id_precio','$precio','$cantidad','$total')";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
}




print json_encode($foliopres, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
