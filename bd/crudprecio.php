<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$iditem = (isset($_POST['iditem'])) ? $_POST['iditem'] : '';
$unidad = (isset($_POST['unidad'])) ? $_POST['unidad'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$id_umedida = (isset($_POST['umedida'])) ? $_POST['umedida'] : '';
$unidad = $unidad;


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO precio (id_item,formato,monto,id_umedida) VALUES('$iditem','$unidad','$precio','$id_umedida')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vprecio ORDER BY id_precio DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE precio SET formato='$unidad', monto='$precio', id_umedida='$id_umedida' WHERE id_precio='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM vprecio WHERE id_precio='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "DELETE FROM precio WHERE id_precio='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
