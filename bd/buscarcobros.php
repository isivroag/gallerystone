<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$metodo = (isset($_POST['metodo'])) ? $_POST['metodo'] : '';
$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$fin = (isset($_POST['fin'])) ? $_POST['fin'] : '';





$consulta = "SELECT * FROM vpagocxc WHERE estado_pagocxc='1' and fecha between '$inicio' and '$fin' AND metodo='$metodo' ORDER BY fecha,folio_pagocxc";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
