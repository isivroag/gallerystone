<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   



$data=0;
$consulta = "SELECT * FROM vale WHERE estado<>'RECIBIDO' and estado_vale=1";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if($resultado->rowCount()==0){
    $data=1;
}
$resultado->closeCursor();



print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>