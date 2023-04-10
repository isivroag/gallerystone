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

$presentacion = (isset($_POST['presentacion'])) ? $_POST['presentacion'] : '';
$contenidon = (isset($_POST['contenidon'])) ? $_POST['contenidon'] : '';
$contenidoa = (isset($_POST['contenidoa'])) ? $_POST['contenidoa'] : '';
$contenidot = (isset($_POST['contenidot'])) ? $_POST['contenidot'] : '';

$tarjeta = (isset($_POST['tarjeta'])) ? $_POST['tarjeta'] : '';
$valortarjeta = (isset($_POST['valortarjeta'])) ? $_POST['valortarjeta'] : '';

$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cmin = (isset($_POST['cmin'])) ? $_POST['cmin'] : '';
$cmax = (isset($_POST['cmax'])) ? $_POST['cmax'] : '';


switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO consumible (nom_cons,cant_cons,id_umedida,ubi_cons,obs_cons,presentacion,contenidon,contenidoa,contenidot,clave_cons,tarjeta,valortarjeta,costo_cons,minimo,maximo) 
        VALUES('$nom_cons','$cantidad','$umedida','$ubicacion','$obs','$presentacion','$contenidon','$contenidoa','$contenidot','$clave','$tarjeta','$valortarjeta','$costo','$cmin','$cmax')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vconsumible ORDER BY id_cons DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE consumible SET nom_cons='$nom_cons',id_umedida='$umedida',ubi_cons='$ubicacion',obs_cons='$obs',clave_cons='$clave',
        tarjeta='$tarjeta',valortarjeta='$valortarjeta',costo_cons='$costo', minimo='$cmin', maximo='$cmax' WHERE id_cons='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM vconsumible WHERE id_cons='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE consumible SET estado_cons=0 WHERE id_cons='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
