<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$id_tipo = (isset($_POST['id_tipo'])) ? $_POST['id_tipo'] : '';
$id_subtipo = (isset($_POST['id_subtipo'])) ? $_POST['id_subtipo'] : '0';
$id_concepto = (isset($_POST['id_concepto'])) ? $_POST['id_concepto'] : '';
$id_umedida = (isset($_POST['id_umedida'])) ? $_POST['id_umedida'] : '';
$uso = (isset($_POST['uso'])) ? $_POST['uso'] : '';

$concepto = $concepto;

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO concepto (nom_concepto,id_t_concepto,id_subt_concepto,id_umedida,tipo) VALUES('$concepto','$id_tipo','$id_subtipo','$id_umedida','$uso')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vconceptos ORDER BY id_concepto DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE concepto SET nom_concepto='$concepto',id_umedida='$id_umedida',id_t_concepto='$id_tipo',id_subt_concepto='$id_subtipo',tipo='$uso' WHERE id_concepto='$id_concepto'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vconceptos WHERE id_concepto='$id_concepto'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //baja
        $consulta = "DELETE FROM concepto WHERE id_concepto='$id_concepto' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
