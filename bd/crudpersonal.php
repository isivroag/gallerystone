<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$cel = (isset($_POST['cel'])) ? $_POST['cel'] : '';
$ingreso = (isset($_POST['ingreso'])) ? $_POST['ingreso'] : '';
$salariod = (isset($_POST['salariod'])) ? $_POST['salariod'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO personal (nom_per,cel_per,fechaing,salariod,tipo) VALUES('$nombre','$cel','$ingreso,'$salariod','$tipo') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM personal ORDER BY id_per DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE personal SET nom_per='$nombre',cel_per='$cel',fechaing='$ingreso',salariod='$salariod',tipo='$tipo' WHERE id_per='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM personal WHERE id_per='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE personal SET estado_per=0 WHERE id_per='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
