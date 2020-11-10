<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio_vta = (isset($_POST['folio_vta'])) ? $_POST['folio_vta'] : '';
$fechavp = (isset($_POST['fechavp'])) ? $_POST['fechavp'] : '';
$obsvp = (isset($_POST['obsvp'])) ? $_POST['obsvp'] : '';
$conceptovp = (isset($_POST['conceptovp'])) ? $_POST['conceptovp'] : '';
$saldovp = (isset($_POST['saldovp'])) ? $_POST['saldovp'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$saldofin= (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$metodo = (isset($_POST['metodo'])) ? $_POST['metodo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$consulta = "INSERT INTO pagocxc (folio_vta,fecha,concepto,obs,saldoini,monto,saldofin,metodo,usuario) VALUES ('$folio_vta','$fechavp','$conceptovp','$obsvp','$saldovp','$monto','$saldofin','$metodo','$usuario')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
    $res=1;
}
else{
    $res=0;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>