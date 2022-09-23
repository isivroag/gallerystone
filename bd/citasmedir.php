<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folioorden = (isset($_POST['folioorden'])) ? $_POST['folioorden'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$responsable = (isset($_POST['responsable'])) ? $_POST['responsable'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';


$res=0;

switch ($opcion) {
        case 1: //alta

                $consulta = "INSERT INTO citamed (folio_ord,fecha,responsable) VALUES('$folioorden', '$fecha','$responsable') ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $consulta = "UPDATE orden SET fecha_plantilla='$fecha' WHERE folio_ord='$folioorden' ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();


                $consulta="SELECT folio_cita FROM citamed ORDER BY folio_cita DESC LIMIT 1";
                $resultado=$conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

                foreach($data as $datarow){
                        $res=$datarow['folio_cita'];
                }




           
                print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
                break;
        case 2:
                $consulta = "UPDATE citamed SET fecha='$fecha', responsable='$responsable' WHERE folio_cita='$id' ";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()){
                        $res=$id;
                }
                

                $consulta = "SELECT folio_ord FROM citamed WHERE folio_cita='$id' ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

                foreach ($data as $row)
                {
                        $folioorden= $row['folio_ord'];
                }


                $consulta = "UPDATE orden SET fecha_plantilla='$fecha' WHERE folio_ord='$folioorden' ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
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
        case 5:
                
                $consulta = "UPDATE citamed SET estado_cita='2' WHERE folio_cita='$id' ";
                $resultado = $conexion->prepare($consulta);
                if($resultado->execute()){
                        $res=1;
                }

                print json_encode($res, JSON_UNESCAPED_UNICODE);
                break;
        case 6:
                $consulta = "UPDATE citamed SET estado_cita='0' WHERE folio_cita='$id' ";
                $resultado = $conexion->prepare($consulta);
                if($resultado->execute()){
                        $res=1;
                }

                print json_encode($res, JSON_UNESCAPED_UNICODE);
                break;
}


$conexion = NULL;
