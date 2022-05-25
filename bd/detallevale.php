<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$iddes = (isset($_POST['iddes'])) ? $_POST['iddes'] : '';
$cantidad = (isset($_POST['cantidadi'])) ? $_POST['cantidadi'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$id= (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO vale_detalle (folio_vale,id_her,cantidad_her,estado,obs) 
        values ('$folio','$iddes','$cantidad','PENDIENTE','')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * from vvale_detalle where folio_vale='$folio' and id_her='$iddes' and estado_reg='1'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:
            $consulta = "DELETE FROM vale_detalle where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
           
            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>