<?php
header('Content-Type: application/json');
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$data="";

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$res=0;
$consulta = "SELECT * FROM citamed where estado_cita='1' and folio_ord='$id' ORDER BY folio_cita";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount()>0){
    $res=1;
}



echo json_encode($res); //enviar el array final en formato json a JS
$conexion = NULL;
?>