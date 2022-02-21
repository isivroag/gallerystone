<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folioorden = (isset($_POST['folioorden'])) ? $_POST['folioorden'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';




switch ($opcion) {
        case 1: //alta

                $consulta = "INSERT INTO citamed (folio_ord,fecha) VALUES('$folioorden', '$fecha') ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $consulta = "UPDATE orden SET fecha_plantilla='$fecha' WHERE folio_ord='$folioorden' ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $res=1;
                print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
                break;
        case 2:
                $consulta = "UPDATE citamed SET fecha='$fecha' WHERE folio_cita='$id' ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
                break;


        case 3:
                $consulta = "SELECT * FROM citamed WHERE folio_cita='$folioorden'";
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
                $consulta = "SELECT * FROM vcitamed WHERE id='$id'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
        break;
}


$conexion = NULL;
