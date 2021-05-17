<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   



$nom_her = (isset($_POST['nom_her'])) ? $_POST['nom_her'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$ubicacion = (isset($_POST['ubicacion'])) ? $_POST['ubicacion'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';



$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO herramienta (nom_her,cant_her,ubi_her,obs_her) VALUES('$nom_her','$cantidad','$ubicacion','$obs')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM herramienta ORDER BY id_her DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE herramienta SET nom_her='$nom_her',ubi_her='$ubicacion',obs_her='$obs' WHERE id_her='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM herramienta WHERE id_her='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE herramienta SET estado_her=0 WHERE id_her='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
