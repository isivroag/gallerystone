<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   



$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';
$data=0;
$consulta = "SELECT * FROM vale WHERE folio_orden='$orden' and estado<>'RECIBIDO' and estado_vale=1";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if($resultado->rowCount()==0){
    $data=1;
}else{
    $data=0;
}
$resultado->closeCursor();



print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>