<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$venta = (isset($_POST['venta'])) ? $_POST['venta'] : '';
$presupuesto = (isset($_POST['presupuesto'])) ? $_POST['presupuesto'] : '';

$consulta = "SELECT saldo,gtotal FROM venta WHERE folio_vta='$venta'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($dt as $row) {
    $totalvta = $row['gtotal'];
    $saldovta = $row['saldo'];
    
}




$consulta = "SELECT * FROM presupuesto WHERE folio_pres='$presupuesto'";
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
    $notas= $row['notas'];
    $vendedor= $row['vendedor'];
    $tipo_proy= $row['tipo_proy'];
}

$diferencia=$gtotal-$totalvta;
$nsaldo=$saldovta+$diferencia;

$consulta = "UPDATE venta SET concepto_vta='$concepto',ubicacion='$ubicacion',subtotal='$subtotal',tokenid='$tokenid',descuento='$descuento',iva='$iva',total='$total',gtotal='$gtotal',notas='$notas',vendedor='$vendedor',tipo_proy='$tipo_proy',saldo='$nsaldo' WHERE folio_vta='$venta'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "DELETE FROM detalle_vta WHERE folio_vta='$venta'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();



$consulta = "SELECT * FROM detalle_pres WHERE folio_pres='$presupuesto'";
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

    $consultain = "INSERT INTO detalle_vta (folio_vta,id_concepto,id_item,id_precio,precio,cantidad,total) VALUES ('$venta','$id_concepto','$id_item','$id_precio','$precio','$cantidad','$total')";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
}




print json_encode($venta, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
