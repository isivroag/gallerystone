<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$importe = 0;

$consulta = "SELECT importe,retenido,fijo,neto FROM nomina WHERE folio_nom ='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
