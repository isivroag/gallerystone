<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$data=0;
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$importe= (isset($_POST['importe'])) ? $_POST['importe'] : '';
$ml= (isset($_POST['ml'])) ? $_POST['ml'] : '';
$costoml= (isset($_POST['costoml'])) ? $_POST['costoml'] : '';

$consulta = "UPDATE orden SET importenom='$importe',mlfinal='$ml',costoml='$costoml' WHERE folio_ord='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
    $data=1;
}




print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>