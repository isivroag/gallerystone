<?php
date_default_timezone_set('America/Mexico_City');
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$id_llamada = (isset($_POST['id_llamada'])) ? $_POST['id_llamada'] : '';

$desc_llamada = (isset($_POST['desc_llamada'])) ? $_POST['desc_llamada'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$nota_ant = (isset($_POST['nota_ant'])) ? $_POST['nota_ant'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha=date('Y-m-d H:i:s');
$data = 0;
$consulta = "UPDATE llamadapres SET fecha_rea='$fecha',nota_rea='$nota_ant',usuario='$usuario',estado_llamada=0 WHERE folio_pres='$folio' AND id_llamada='$id_llamada'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = 1;
};



$nota = "CIERRE DE:" . $desc_llamada ;
$consulta = "INSERT INTO notaspres (folio_pres,fecha,estado,nota,usuario) VALUES('$folio','$fecha','4','$nota','$usuario') ";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data += 1;
}


print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
