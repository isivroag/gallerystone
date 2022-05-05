<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';





$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO frente (id_ord,nom_frente) values ('$orden','$nombre')";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM frente WHERE id_ord='$orden' ORDER BY id_frente DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);



        break;
    case 2:

        $consulta = "SELECT * FROM areas  WHERE id_frente='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if ($resultado->rowCount() > 0){
            $data=0;
        }else{
            $consulta = "UPDATE frente SET estado_frente=0 WHERE id_frente='$id' ";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = 1;
            }
    
        }

       


       




        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
