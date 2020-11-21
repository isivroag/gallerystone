<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$subtipo = (isset($_POST['subtipo'])) ? $_POST['subtipo'] : '';
$id_tipo = (isset($_POST['id_tipo'])) ? $_POST['id_tipo'] : '';
$id_subtipo = (isset($_POST['id_subtipo'])) ? $_POST['id_subtipo'] : '';

$subtipo = $subtipo;

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO subtipo_concepto (id_t_concepto,nom_subt_concepto) VALUES('$id_tipo','$subtipo') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vsubtipo_concepto ORDER BY id_subt_concepto DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE subtipo_concepto SET nom_subt_concepto='$subtipo',id_t_concepto='$id_tipo' WHERE id_subt_concepto='$id_subtipo' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vsubtipo_concepto WHERE id_subt_concepto='$id_subtipo'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //baja
        $consulta = "DELETE FROM subtipo_concepto WHERE id_subt_concepto='$id_subtipo' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
