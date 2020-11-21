<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$insumo = (isset($_POST['insumo'])) ? $_POST['insumo'] : '';
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$color = (isset($_POST['color'])) ? $_POST['color'] : '';
$acabado = (isset($_POST['acabado'])) ? $_POST['acabado'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$nombre = $nombre;

$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO item (nom_item,clave_item, id_insumo,id_color,id_acabado,tipo_item) VALUES('$nombre','$clave', '$insumo', '$color','$acabado','$tipo') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vitem ORDER BY id_item DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE item SET nom_item='$nombre',clave_item='$clave', id_insumo='$insumo', id_color='$color', id_acabado='$acabado',tipo_item='$tipo' WHERE id_item='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM vitem WHERE id_item='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "DELETE FROM item WHERE id_item='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
