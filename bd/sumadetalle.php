<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$total = 0;


switch ($tipo) {
    case 1: //material
        $consulta = "SELECT sum(subtotal) as subtotal from detallecxp_mat where folio_cxp='$folio' GROUP BY folio_cxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            $total=$row['subtotal'];
        }


        break;
    case 2://INSUMO
        $consulta = "SELECT sum(subtotal) as subtotal from detallecxp_insumo where folio_cxp='$folio' GROUP BY folio_cxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            $total=$row['subtotal'];
        }

        break;

    case 3:// DESGASTE
        $consulta = "SELECT sum(subtotal) as subtotal from detallecxp_desechable where folio_cxp='$folio' GROUP BY folio_cxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            $total=$row['subtotal'];
        }
        break;

    case 4://HERRAMIENTA
        $consulta = "SELECT sum(subtotal) as subtotal from detallecxp_herramienta where folio_cxp='$folio' GROUP BY folio_cxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            $total=$row['subtotal'];
        }
        break;
    case 5://PIEZAS
        $consulta = "SELECT sum(subtotal) as subtotal from detallecxp_matpieza where folio_cxp='$folio' GROUP BY folio_cxp";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            $total=$row['subtotal'];
        }
        break;
}

print json_encode($total, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
