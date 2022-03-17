<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';
$idot = (isset($_POST['idot'])) ? $_POST['idot'] : '';
$foliofis = (isset($_POST['foliofis'])) ? $_POST['foliofis'] : '';
$material = (isset($_POST['material'])) ? $_POST['material'] : '';
$moldura = (isset($_POST['moldura'])) ? $_POST['moldura'] : '';
$zoclo = (isset($_POST['zoclo'])) ? $_POST['zoclo'] : '';
$superficie = (isset($_POST['superficie'])) ? $_POST['superficie'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res=0;
switch($opcion){
    case 1: //alta
        $consulta = "UPDATE ordentrabajo SET material_ot='$material',moldura_ot='$moldura',zoclo_ot='$zoclo',superficie_ot='$superficie',tipos_ot='$tipo',obs_ot='$obs',estado_ot='1' where id_ot='$idot' ";			
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $res=1;
        }

        

        
        break;
    case 2: //modificación
        $consulta = "UPDATE partida SET nom_partida='$nombre',id_cuentaegr='$cuenta' WHERE id_partida='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM vpartida WHERE id_partida='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE partida SET estado_partida=0 WHERE id_partida='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
