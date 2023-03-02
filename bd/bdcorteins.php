<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$idreg = (isset($_POST['idreg'])) ? $_POST['idreg'] : '';
$ncantidad = (isset($_POST['ncantidad'])) ? $_POST['ncantidad'] : '';
$ncontenidon = (isset($_POST['ncontenidon'])) ? $_POST['ncontenidon'] : '';

$ncontenidoa = (isset($_POST['ncontenidoa'])) ? $_POST['ncontenidoa'] : '';
$ncontenidot = (isset($_POST['ncontenidot'])) ? $_POST['ncontenidot'] : '';
$dcosto = (isset($_POST['dcosto'])) ? $_POST['dcosto'] : '';
$res=0;




        $consulta = "UPDATE corteins_detalle SET ncant='$ncantidad', ncontenidon='$ncontenidon', ncontenidoa='$ncontenidoa',ncontenidot='$ncontenidot',dcosto='$dcosto',aplicado='1' where id_reg='$idreg' ";			
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $res=1;
        }

        

    

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
