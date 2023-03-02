<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$res = 0;


$consulta = "SELECT * from corteins_detalle where folio_corte='$folio' and aplicado='0'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount() > 0) {
    $res = 1;
}






print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
