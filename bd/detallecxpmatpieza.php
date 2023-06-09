<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idmat = (isset($_POST['idmat'])) ? $_POST['idmat'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$m2 = (isset($_POST['m2'])) ? $_POST['m2'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO detallecxp_matpieza (folio_cxp,id_mat,cant_mat,m2_mat,costo_mat,subtotal,usuario) 
        values ('$folio','$idmat','$cantidad','$m2','$costo','$subtotal','$usuario')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * from vdetallecxp_matpieza where folio_cxp='$folio' and id_mat='$idmat'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:
            $consulta = "DELETE FROM detallecxp_matpieza where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
           
            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>