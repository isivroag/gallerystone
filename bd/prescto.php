<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$partida = (isset($_POST['partida'])) ? $_POST['partida'] : '';
$mes = (isset($_POST['mes'])) ? $_POST['mes'] : '';
$ejercicio = (isset($_POST['ejercicio'])) ? $_POST['ejercicio'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';




$data=0;

$consulta = "SELECT * FROM pres_cto_detalle where id_partida='$partida' and mes='$mes' and ejercicio='$ejercicio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if($resultado->rowCount() == 0) {
    
    $consulta = "INSERT INTO pres_cto_detalle (id_partida,monto,mes,ejercicio) VALUES ('$partida','$monto','$mes','$ejercicio')";
}else{
    $consulta = "UPDATE pres_cto_detalle SET id_partida='$partida',monto='$monto',mes='$mes',ejercicio='$ejercicio' WHERE id_partida='$partida' and mes='$mes' and ejercicio='$ejercicio'";
}
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
    $data=1;
}




print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
