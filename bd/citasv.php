<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio_vta = (isset($_POST['folio_vta'])) ? $_POST['folio_vta'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$concepto = ucfirst(strtolower($concepto));
$obs = ucfirst(strtolower($obs));


switch ($opcion) {
        case 1: //alta

                $consulta = "INSERT INTO citav (folio_vta,fecha,concepto,obs) VALUES('$folio_vta', '$fecha', '$concepto','$obs') ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $res=1;
                print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
                break;
        case 2:
                $consulta = "UPDATE citav SET fecha='$fecha' WHERE folio_citav='$id' ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
                break;


        case 3:
                $consulta = "SELECT * FROM citav WHERE folio_vta='$folio_vta'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                if ($resultado->rowCount() >= 1){
                        $res=1;
                }
                else{
                        $res=0;
                }
                print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
                
                break;
        case 4:
                $consulta = "SELECT * FROM vcitav WHERE id='$id'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
        break;
}


$conexion = NULL;
