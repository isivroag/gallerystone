<?php
header('Content-Type: application/json');
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$data="";

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$res=0;
$consulta = "SELECT ordentrabajo.folio_orden, det_ot.id_ot,det_ot.id_reg,det_ot.concepto,det_ot.medida,det_ot.estado_reg,det_ot.estado
FROM ordentrabajo JOIN det_ot ON ordentrabajo.folio_orden=det_ot.id_ot
WHERE det_ot.estado_reg=1 and ordentrabajo.folio_orden='$folio' ORDER BY id_reg";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount()>0){
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
}



echo json_encode($data); //enviar el array final en formato json a JS
$conexion = NULL;
?>