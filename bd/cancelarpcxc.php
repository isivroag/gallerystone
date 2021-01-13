<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio_venta = (isset($_POST['folio_venta'])) ? $_POST['folio_venta'] : '';
$folio_pago = (isset($_POST['folio_pago'])) ? $_POST['folio_pago'] : '';
$motivo = (isset($_POST['motivo'])) ? $_POST['motivo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$consulta = "UPDATE pagocxc SET estado_pagocxc='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagocxc='$folio_pago'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {


    $consulta = "SELECT monto FROM pagocxc WHERE folio_pagocxc='$folio_pago'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $dat) {

            $monto = $dat['monto'];
        }

        $consulta = "UPDATE venta SET saldo=saldo+'$monto' WHERE folio_vta='$folio_venta'";

        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $res = 1;
        } else {
            $res = 0;
        }
    } else {
        $res = 0;
    }
} else {
    $res = 0;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
