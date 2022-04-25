<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';



switch ($tipo) {
    case 1:
        $consulta = "SELECT * FROM vconsumible WHERE tarjeta=1 and estado_cons=1 ORDER BY id_cons";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
