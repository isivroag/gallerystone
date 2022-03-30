<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$forden = (isset($_POST['forden'])) ? $_POST['forden'] : '';


$idesp = 0;
$consulta = "UPDATE det_ot SET estado='COLOCADO' WHERE id_reg='$id' ";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $resp = 1;

   

    $consulta = "SELECT * FROM det_ot WHERE id_ot='$forden' and estado='PENDIENTE' ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if ($resultado->rowCount() == 0) {
        $consulta =  "UPDATE orden SET edo_ord='COLOCADO' WHERE folio_ord='$forden'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $resp=2;
        }
        
    }
}



print json_encode($resp, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
