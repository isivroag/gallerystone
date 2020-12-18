<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$condicion = (isset($_POST['condicion'])) ? $_POST['condicion'] : '';
$registro = (isset($_POST['registro'])) ? $_POST['registro'] : '';
$opc = (isset($_POST['opc'])) ? $_POST['opc'] : '';

switch($opc){
    case 1: //alta

    $consulta = "INSERT INTO contmp (folio_pres,nom_cond) VALUES('$folio','$condicion')";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $consulta = "SELECT * FROM contmp WHERE folio_pres='$folio' ORDER BY  id_reg DESC LIMIT 1";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
case 2://baja
    $consulta = "DELETE FROM contmp WHERE id_reg='$registro' AND folio_pres='$folio' ";		
    $resultado = $conexion->prepare($consulta);
    $resultado->execute(); 
    $data=$registro;                          
    break;     
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
