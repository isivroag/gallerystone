<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$iditem = (isset($_POST['iditem'])) ? $_POST['iditem'] : '';



$numplaca = 0;
$consulta = "SELECT max(numero) as placa from material where id_item='$iditem'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount()){
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach($data as $row){
        $numplaca=$row['placa'];
    }
}
$numplaca+=1;


print json_encode($numplaca, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
