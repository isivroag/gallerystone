<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idmat = (isset($_POST['idmat'])) ? $_POST['idmat'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO detallecxp_mat (folio_cxp,id_mat,cant_mat,costo_mat,subtotal,usuario) values ('$folio','$idmat','$cantidad','$costo','$subtotal','$usuario')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * from vdetallecxp_mat where folio_cxp='$folio' and id_mat='$idmat'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:

        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>