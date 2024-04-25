<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   



$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';
$data=0;
$consulta = "SELECT * FROM vale WHERE folio_orden='$orden'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if($resultado->rowCount()==0){
    $data=0;
}else{
    $data=1;
}
$resultado->closeCursor();



print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>