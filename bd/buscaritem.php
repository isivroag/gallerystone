<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$tipoitem = (isset($_POST['tipoitem'])) ? $_POST['tipoitem'] : '';

$consulta = "SELECT id_item,clave_item,nom_item FROM item WHERE tipo_item='$tipoitem' ORDER BY id_item";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>