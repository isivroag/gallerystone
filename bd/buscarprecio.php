<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$id_umedida = (isset($_POST['id_umedida'])) ? $_POST['id_umedida'] : '';

$consulta = "SELECT * FROM vprecio where id_item='$id' and id_umedida='$id_umedida' order by id_precio";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>