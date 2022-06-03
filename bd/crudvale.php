<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$creador = (isset($_POST['creador'])) ? $_POST['creador'] : '';
$receptor = (isset($_POST['receptor'])) ? $_POST['receptor'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res=0;

switch($opcion){
    case 1: //alta
        $consulta = "UPDATE vale set estado_vale='1',fecha_vale='$fecha',usuario_entrega='$creador',usuario_recibe='$receptor',obs='$obs'
        WHERE folio_vale='$folio' ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id_vend,nom_vend FROM vendedor ORDER BY id_vend DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $res=1;
        }
        
        break;
    case 2: //modificación
      
        break;        
    case 3://baja
        $consulta = "UPDATE vale SET estado_vale=0 WHERE folio_vale=='$folio' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $res=1;                          
        break;        
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
