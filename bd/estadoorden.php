<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$estado= (isset($_POST['estado'])) ? $_POST['estado'] : '';
$porcentaje= (isset($_POST['porcentaje'])) ? $_POST['porcentaje'] : '';
$res=0;
$consulta = "UPDATE orden SET edo_ord='$estado',avance='$porcentaje' WHERE folio_ord='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
    $res=1;
}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>