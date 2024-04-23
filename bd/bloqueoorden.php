<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

if ($estado==1){
    $estado=0;
}else{
    $estado=1;
}




        $consulta = "UPDATE orden SET bloqueouso='$estado' where folio_ord='$folio' ";			
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $res=1;
        }

        

    

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
