<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$sugerido = (isset($_POST['sugerido'])) ? $_POST['sugerido'] : '';
$tipo= (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$resp=0;
if ($importe>=$sugerido){
    $valor=1;
}else{
    $valor=0;
}

switch ($tipo){
    case 'UTILIDAD':
        $consulta = "UPDATE pagocxc SET futilidad='$valor',utilidad='$importe' WHERE folio_pagocxc='$folio' ";
        
    break;
    case 'MANTENIMIENTO':
        $consulta = "UPDATE pagocxc SET fmant='$valor',mant='$importe' WHERE folio_pagocxc='$folio' ";
    break;
    case 'IMPUESTOS':
        $consulta = "UPDATE pagocxc SET fimp='$valor',imp='$importe' WHERE folio_pagocxc='$folio' ";
    break;

}

$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "SELECT * from vpagocxc where folio_pagocxc='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
$resp=1;
}

print json_encode($resp, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;


?>