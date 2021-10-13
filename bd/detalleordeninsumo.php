<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idcons = (isset($_POST['idcons'])) ? $_POST['idcons'] : '';
$cantidadi = (isset($_POST['cantidadi'])) ? $_POST['cantidadi'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO consumible_ord (folio_ord,id_cons,cantidad) values ('$folio','$idcons','$cantidadi')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT * FROM vconsumibleord WHERE folio_ord='$folio' ORDER BY id_reg DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
       
        

        break;
        case 2:
            $consulta = "UPDATE consumible_ord SET estado_detalle=0 where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()){
                $data=1;
            }
            else{
                $data=0;
            }
          
        break;
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>