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
        $consulta = "SELECT * FROM vpres WHERE fecha_pres BETWEEN '$inicio' AND '$final' and tipo_proy='$tipo_proy' ORDER BY folio_pres";
        break;
    case 1:
        $consulta = "SELECT * FROM vpres WHERE fecha_pres BETWEEN '$inicio' AND '$final' and estado_pres<>'RECHAZADO' and tipo_proy='$tipo_proy' ORDER BY folio_pres";
        break;
        case 2:
            $consulta = "SELECT * FROM vpres WHERE fecha_pres BETWEEN '$inicio' AND '$final' and id_pros='$idclie' ORDER BY folio_pres";
            break;
        case 3:
            $consulta = "SELECT * FROM vpres WHERE fecha_pres BETWEEN '$inicio' AND '$final' and id_pros='$idclie' and estado_pres<>'RECHAZADO'  ORDER BY folio_pres";
            break;
}

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
