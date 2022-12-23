<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$iditem = (isset($_POST['id_item'])) ? $_POST['id_item'] : '';
$umedida = (isset($_POST['umedida'])) ? $_POST['umedida'] : '';
$nom_mat = (isset($_POST['nom_mat'])) ? $_POST['nom_mat'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';

$ubicacion = (isset($_POST['ubicacion'])) ? $_POST['ubicacion'] : '';

$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$clave_mat = (isset($_POST['clave_mat'])) ? $_POST['clave_mat'] : '';




$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO materialpieza (id_item,nom_mat,cant_mat,id_umedida,ubi_mat,obs_mat,clave_mat) 
        VALUES('$iditem','$nom_mat','$cantidad','$umedida','$ubicacion','$obs','$clave_mat')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vmaterialpieza ORDER BY id_mat DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE materialpieza SET nom_mat='$nom_mat',id_umedida='$umedida'
        ,ubi_mat='$ubicacion',obs_mat='$obs',clave_mat='$clave_mat' WHERE id_mat='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM vmaterialpieza WHERE id_mat='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE materialpieza SET estado_mat=0 WHERE id_mat='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
