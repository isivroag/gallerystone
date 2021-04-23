<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$iditem = (isset($_POST['id_item'])) ? $_POST['id_item'] : '';
$umedida = (isset($_POST['umedida'])) ? $_POST['umedida'] : '';
$nom_mat = (isset($_POST['nom_mat'])) ? $_POST['nom_mat'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$largo = (isset($_POST['largo'])) ? $_POST['largo'] : '';
$alto = (isset($_POST['alto'])) ? $_POST['alto'] : '';
$ancho = (isset($_POST['ancho'])) ? $_POST['ancho'] : '';



$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO material (id_item,nom_mat,largo_mat,ancho_mat,alto_mat,cant_mat,id_umedida) VALUES('$iditem','$nom_mat','$largo','$ancho','$alto','$cantidad','$umedida')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vmaterial ORDER BY id_mat DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE material SET nom_mat='$nom_mat',largo_mat='$largo',ancho_mat='$ancho',alto_mat='$alto',id_umedida='$umedida' WHERE id_mat='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM vmaterial WHERE id_mat='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE material SET estado_mat=0 WHERE id_mat='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
