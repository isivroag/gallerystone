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
$ubicacion = (isset($_POST['ubicacion'])) ? $_POST['ubicacion'] : '';
$metros = (isset($_POST['metros'])) ? $_POST['metros'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$clave_mat = (isset($_POST['clave_mat'])) ? $_POST['clave_mat'] : '';
$numero = (isset($_POST['numero'])) ? $_POST['numero'] : '';



$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO material (id_item,nom_mat,largo_mat,ancho_mat,alto_mat,cant_mat,id_umedida,m2_mat,ubi_mat,obs_mat,clave_mat,numero) 
        VALUES('$iditem','$nom_mat','$largo','$ancho','$alto','$cantidad','$umedida','$metros','$ubicacion','$obs','$clave_mat','$numero')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vmaterial ORDER BY id_mat DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE material SET nom_mat='$nom_mat',largo_mat='$largo',ancho_mat='$ancho',alto_mat='$alto',id_umedida='$umedida',numero='$numero'
        ,m2_mat='$metros',ubi_mat='$ubicacion',obs_mat='$obs',clave_mat='$clave_mat' WHERE id_mat='$id' ";		
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
