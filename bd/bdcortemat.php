<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$idreg = (isset($_POST['idreg'])) ? $_POST['idreg'] : '';
$nlargo = (isset($_POST['nlargo'])) ? $_POST['nlargo'] : '';
$nalto = (isset($_POST['nalto'])) ? $_POST['nalto'] : '';


$nancho = (isset($_POST['nancho'])) ? $_POST['nancho'] : '';
$nm2 = (isset($_POST['nm2'])) ? $_POST['nm2'] : '';
$dcosto = (isset($_POST['dcosto'])) ? $_POST['dcosto'] : '';
$res=0;




        $consulta = "UPDATE cortemat_detalle SET nlargo='$nlargo', nalto='$nalto', nancho='$nancho',nm2='$nm2',dcosto='$dcosto',aplicado='1' where id_reg='$idreg' ";			
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $res=1;
        }

        

    

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
