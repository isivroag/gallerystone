<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';

$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$umedida = (isset($_POST['umedida'])) ? $_POST['umedida'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';




$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO complemento_ord (id_ord,concepto_com,nom_umedida,cant_com) values ('$orden','$concepto','$umedida','$cantidad')";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM complemento_ord WHERE id_ord='$orden' ORDER BY id_reg DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);



        break;
    case 2:
        $consulta = "DELETE FROM complemento_ord WHERE id_reg='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }





        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
