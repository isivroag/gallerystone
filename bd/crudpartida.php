<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$nombre = $nombre;

$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO partida (nom_partida,id_cuentaegr) VALUES('$nombre','$cuenta') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vpartida ORDER BY id_partida DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE partida SET nom_partida='$nombre',id_cuentaegr='$cuenta' WHERE id_partida='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM vpartida WHERE id_partida='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE partida SET estado_partida=0 WHERE id_partida='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
