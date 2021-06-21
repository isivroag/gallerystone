<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id_orden = (isset($_POST['idorden'])) ? $_POST['idorden'] : '';

$idconcepto = (isset($_POST['idconcepto'])) ? $_POST['idconcepto'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$costo=(isset($_POST['costo'])) ? $_POST['costo'] : '0';





$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "SELECT * from detalle_conceptosobra where id_concepto='$idconcepto' and id_orden='$id_orden' and estado_detalle=1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if ($resultado->rowCount() != 0) {
            $data = 0;
        } else {
            $consulta = "INSERT INTO detalle_conceptosobra (id_orden,id_concepto,nom_concepto,precio_concepto,costo_concepto) values ('$id_orden','$idconcepto','$concepto','$precio','$costo')";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * FROM detalle_conceptosobra WHERE id_orden='$id_orden' ORDER BY id_reg DESC LIMIT 1";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }





        break;
    case 2:
        $consulta = "UPDATE detalle_conceptosobra SET estado_detalle=0 WHERE id_reg='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }





        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
