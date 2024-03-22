<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$final = (isset($_POST['final'])) ? $_POST['final'] : '';
$tipof = (isset($_POST['tipof'])) ? $_POST['tipof'] : '';


switch ($tipof) {
    case 'inicio':
        $consulta = "SELECT * FROM vorden WHERE fecha_ord BETWEEN '$inicio' AND '$final' and estado_ord=1  and edo_ord<>'PENDIENTE' and tipo_proy=2 ORDER BY folio_ord";
        break;
    case 'limite':
        $consulta = "SELECT * FROM vorden WHERE fecha_limite BETWEEN '$inicio' AND '$final' and estado_ord=1 and edo_ord<>'PENDIENTE' and tipo_proy=2 ORDER BY folio_ord";
        break;
    case 'liberacion':
        $consulta = "SELECT * FROM vorden WHERE fecha_liberacion BETWEEN '$inicio' AND '$final' and estado_ord=1 and edo_ord<>'PENDIENTE' and tipo_proy=2 ORDER BY folio_ord";
        break;
        
}

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
