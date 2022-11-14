<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = "";
$id_pros = "";
$fecha = "";
$concepto = "";
$ubicacion = "";




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
    $notas= $row['notas'];
    $vendedor= $row['vendedor'];
    $tipo_proy= $row['tipo_proy'];
    $usuario= $row['usuario'];
}

$consulta = "UPDATE tmp_pres SET estado_pres=2 WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "INSERT INTO presupuesto 
(id_pros,fecha_pres,concepto_pres,ubicacion,subtotal,tokenid,estado_pres,descuento,iva,total,gtotal,folio_tmp,notas,vendedor,tipo_proy,usuario) 
VALUES('$id_pros','$fecha','$concepto','$ubicacion','$subtotal','$tokenid','1','$descuento','$iva','$total','$gtotal','$folio','$notas','$vendedor','$tipo_proy','$usuario')";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "SELECT * FROM presupuesto ORDER BY folio_pres DESC LIMIT 1";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $rw) {
    $foliopres = $rw['folio_pres'];
}



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
