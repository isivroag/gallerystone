<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$final = (isset($_POST['final'])) ? $_POST['final'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$tipo_proy = (isset($_POST['tipo_proy'])) ? $_POST['tipo_proy'] : '';
$idclie = (isset($_POST['idclie'])) ? $_POST['idclie'] : '';

switch ($opcion) {
    case 0:
        $consulta = "SELECT * FROM vventa WHERE fecha_vta BETWEEN '$inicio' AND '$final' and estado_vta=1 and tipo_proy='$tipo_proy' ORDER BY folio_vta";
        break;
    case 1:
        $consulta = "SELECT * FROM vventa WHERE fecha_vta BETWEEN '$inicio' AND '$final' and saldo>0 and estado_vta=1 and tipo_proy='$tipo_proy' ORDER BY folio_vta";
        break;
    case 2:
        $consulta = "SELECT * FROM vventa WHERE fecha_vta BETWEEN '$inicio' AND '$final' and estado_vta=1 and id_clie='$idclie' ORDER BY folio_vta";
        break;
    case 3:
        $consulta = "SELECT * FROM vventa WHERE fecha_vta BETWEEN '$inicio' AND '$final' and saldo>0 and estado_vta=1 and id_clie='$idclie' ORDER BY folio_vta";
        break;
}

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
