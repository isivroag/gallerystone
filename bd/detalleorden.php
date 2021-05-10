<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idmat = (isset($_POST['idmat'])) ? $_POST['idmat'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO detalle_ord (folio_ord,id_mat,cant_mat) values ('$folio','$idmat','$cantidad')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT * FROM vdetalle_ord WHERE folio_ord='$folio' ORDER BY id_reg DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
       
        

        break;
        case 2:
            $consulta = "UPDATE detalle_ord SET estado_deto=0 where id_reg='$id'";
        
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