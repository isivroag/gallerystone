<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$id_llamada = (isset($_POST['id_llamada'])) ? $_POST['id_llamada'] : '';
$desc_llamada = (isset($_POST['desc_llamada'])) ? $_POST['desc_llamada'] : '';
$fecha_llamada = (isset($_POST['fecha_llamada'])) ? $_POST['fecha_llamada'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$nota_ant = (isset($_POST['nota_ant'])) ? $_POST['nota_ant'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $data=0;
        $consulta = "INSERT INTO llamadapres(folio_pres,id_llamada,desc_llamada,fecha_llamada,nota_ant) VALUES('$folio','$id_llamada','$desc_llamada','$fecha_llamada','$nota_ant') ";			
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;
        };
        

        $consulta = "UPDATE presupuesto set estado_pres='4' where folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data+=1;
        };
        $nota="SEGUIMIENTO DE PRESUPUESTO:".$desc_llamada." PROGRAMADA PARA ".$fecha_llamada;
        $consulta = "INSERT INTO notaspres (folio_pres,fecha,estado,nota,usuario) VALUES('$folio','$fecha','4','$nota','$usuario') ";
        $resultado = $conexion->prepare($consulta);
        if(        $resultado->execute()){
            $data+=1;
        }


        
        break;
    case 2: //modificación
        
        break;        
    case 3://baja

    }
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
