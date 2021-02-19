<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$final = (isset($_POST['final'])) ? $_POST['final'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 0:
        $consulta = "SELECT * FROM vventa WHERE fecha_vta BETWEEN '$inicio' AND '$final' ORDER BY folio_vta";
        break;
    case 1:
        $consulta = "SELECT * FROM vventa WHERE fecha_vta BETWEEN '$inicio' AND '$final' and saldo>0 ORDER BY folio_vta";
        break;
}

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
