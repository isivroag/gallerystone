<?php
header('Content-Type: application/json');
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$data="";

$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';
$res=1;
$consulta = "SELECT ordentrabajo.folio_orden, det_ot.id_ot,det_ot.id_reg,det_ot.concepto,det_ot.medida,det_ot.estado_reg,det_ot.estado
FROM ordentrabajo JOIN det_ot ON ordentrabajo.folio_orden=det_ot.id_ot
WHERE det_ot.estado_reg=1 and ordentrabajo.folio_orden='$orden' AND estado<>'COLOCADO' ORDER BY id_reg";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount()>0){
    $res =0;
}



echo json_encode($res); //enviar el array final en formato json a JS
$conexion = NULL;
?>