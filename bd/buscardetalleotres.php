<?php
header('Content-Type: application/json');
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$data="";

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$res=0;
$consulta = "SELECT det_ot.id_ot, det_ot.estado ,count(det_ot.estado_reg) as piezas,consulta.totalpiezas
FROM det_ot JOIN (SELECT COUNT(estado_reg) AS totalpiezas,det_ot.id_ot AS idot FROM det_ot where estado_reg=1 and id_ot='$folio' GROUP BY id_ot ) AS consulta
ON det_ot.id_ot=consulta.idot
WHERE det_ot.estado_reg=1 and det_ot.id_ot='$folio'
GROUP BY det_ot.id_ot,det_ot.estado ORDER BY det_ot.estado
";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount()>0){
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
}



echo json_encode($data); //enviar el array final en formato json a JS
$conexion = NULL;
?>