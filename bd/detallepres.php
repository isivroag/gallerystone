<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$id_concepto = (isset($_POST['idconcepto'])) ? $_POST['idconcepto'] : '';
$id_item = (isset($_POST['id_item'])) ? $_POST['id_item'] : '';
$id_precio = (isset($_POST['id_precio'])) ? $_POST['id_precio'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$total= (isset($_POST['total'])) ? $_POST['total'] : '';



$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO detalle_pres (folio_pres,id_concepto,id_item,id_precio,precio,cantidad,total) values ('$folio','$id_concepto','$id_item','$id_precio','$precio','$cantidad','$total')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta="UPDATE presupuesto SET total=total+'$total' WHERE folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vdetalle_pres WHERE folio_pres='$folio' ORDER BY id_reg DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
       
        

        break;
        case 2:
           $consulta = "DELETE FROM detalle_pres WHERE id_reg='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta="UPDATE presupuesto SET total=total-'$total' WHERE folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        
          
        break;
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;


?>