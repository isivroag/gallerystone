<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$idarea = (isset($_POST['idarea'])) ? $_POST['idarea'] : '';

$idconcepto = (isset($_POST['idconcepto'])) ? $_POST['idconcepto'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$generado=(isset($_POST['generado'])) ? $_POST['cantidad'] : '0';
$pendiente=(isset($_POST['pendiente'])) ? $_POST['cantidad'] : '0';




$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "SELECT * from detalle_area where id_concepto='$idconcepto' and id_area='$idarea' and estado_detalle=1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if ($resultado->rowCount() != 0) {
            $data = 0;
        } else {
            $consulta = "INSERT INTO detalle_area (id_area,id_concepto,nom_concepto,cantidad,precio,total,generado,pendiente) values ('$idarea','$idconcepto','$concepto','$cantidad',0,0,'$generado','$pendiente')";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * FROM detalle_area WHERE id_area='$idarea' ORDER BY id_reg DESC LIMIT 1";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }





        break;
    case 2:
        $consulta = "UPDATE detalle_area SET estado_detalle=0 WHERE id_reg='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }





        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
