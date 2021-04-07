<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$foliocxp = (isset($_POST['foliocxp'])) ? $_POST['foliocxp'] : '';

$saldo = 0;

$consulta = "SELECT * FROM cxp WHERE folio_cxp ='$foliocxp' ORDER BY folio_cxp";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
    foreach ($data as $reg) {
        $saldo = $reg['saldo'];
    }
}
print json_encode($saldo, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
