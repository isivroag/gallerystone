<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$umedida = (isset($_POST['umedida'])) ? $_POST['umedida'] : '';
$nom_cons = (isset($_POST['nom_cons'])) ? $_POST['nom_cons'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$ubicacion = (isset($_POST['ubicacion'])) ? $_POST['ubicacion'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';

$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';

$uso = (isset($_POST['uso'])) ? $_POST['uso'] : '';
$totalusos = (isset($_POST['totalusos'])) ? $_POST['totalusos'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$tarjeta = (isset($_POST['tarjeta'])) ? $_POST['tarjeta'] : '';
$valortarjeta = (isset($_POST['valortarjeta'])) ? $_POST['valortarjeta'] : '';
$cmin = (isset($_POST['cmin'])) ? $_POST['cmin'] : '';
$cmax = (isset($_POST['cmax'])) ? $_POST['cmax'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO desechable (nom_des,cant_des,id_umedida,ubi_des,obs_des,usos,totalusos,clave_des,tarjeta,valortarjeta,minimo,maximo) 
        VALUES('$nom_cons','$cantidad','$umedida','$ubicacion','$obs','$uso','$totalusos','$clave','$tarjeta','$valortarjeta','$cmin','$cmax')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vdesechable ORDER BY id_des DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE desechable SET nom_des='$nom_cons',id_umedida='$umedida',ubi_des='$ubicacion',obs_des='$obs',clave_des='$clave',
        tarjeta='$tarjeta',valortarjeta='$valortarjeta', minimo='$cmin', maximo='$cmax' WHERE id_des='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM vdesechable WHERE id_des='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE desechable SET estado_des='0' WHERE id_des='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
