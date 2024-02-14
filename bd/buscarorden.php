<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   





$consulta = "SELECT * from vorden2 where importenom<>0 and tnomina<>importenom and nomtomado<>100 and mlfinal<>0 ORDER BY avance,folio_ord";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>