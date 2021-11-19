<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idcons = (isset($_POST['idcons'])) ? $_POST['idcons'] : '';
$cantidad = (isset($_POST['cantidadi'])) ? $_POST['cantidadi'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO detallecxp_insumo (folio_cxp,id_cons,cant_cons,costo_cons,subtotal,usuario) values ('$folio','$idcons','$cantidad','$costo','$subtotal','$usuario')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * from vdetallecxp_insumo where folio_cxp='$folio' and id_cons='$idcons'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:
            $consulta = "DELETE FROM detallecxp_insumo where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
           
            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>