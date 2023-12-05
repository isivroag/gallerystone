<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$idper = (isset($_POST['idper'])) ? $_POST['idper'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$tipon = (isset($_POST['tipon'])) ? $_POST['tipon'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res=0;

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO asistencia (id_per,fecha,tipo,tipon) VALUES('$idper','$fecha','$tipo','$tipon') ";			
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res=1;
        }

        
        break;
    case 2: //modificación
        $consulta = "UPDATE asistencia SET tipo='$tipo', tipon='$tipon' WHERE id_reg='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        if ($resultado->execute()) {
            $res=1;
        }
       
        break;        
    case 3://baja
                         
        break;        
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
