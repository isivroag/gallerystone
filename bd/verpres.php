<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   



$id_pros = (isset($_POST['id_pros'])) ? $_POST['id_pros'] : '';


$consulta = "SELECT * FROM vpres WHERE id_pros='$id_pros' ORDER BY folio_pres";



$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
