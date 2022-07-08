<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha= (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$venta=0;


$res=0;
$consulta = "UPDATE orden SET fecha_limite='$fecha' WHERE folio_ord='$folio'";


$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
 $res=1;


 $consulta = "SELECT * from orden WHERE folio_ord='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach($data as $row){
    $venta=$row['folio_vta'];
}
 $consulta = "UPDATE citav 
 SET fecha = concat('$fecha',' ',time(fecha)) 
 WHERE folio_vta='$venta'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
