<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$idarea = (isset($_POST['idarea'])) ? $_POST['idarea'] : '';
$idconcepto = (isset($_POST['idconcepto'])) ? $_POST['idconcepto'] : '';

$saldo = 0;

$consulta = "SELECT pendiente FROM detalle_area WHERE id_area ='$idarea' and id_concepto='$idconcepto'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
    foreach ($data as $reg) {
        $saldo = $reg['pendiente'];
    }
}
print json_encode($saldo, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
