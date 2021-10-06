<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$foliofis= (isset($_POST['foliofis'])) ? $_POST['foliofis'] : '';



$res=0;
$consulta = "UPDATE orden SET folio_fisico='$foliofis' WHERE folio_ord='$folio'";


$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
 $res=1;
}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
