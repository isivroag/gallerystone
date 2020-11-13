<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';


        $consulta="SELECT descuento FROM pdescuento WHERE '$monto' between m_inicial and m_final";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        if ($resultado->rowCount() >= 1) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            }
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
?>