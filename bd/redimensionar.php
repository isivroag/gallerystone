<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$largo = (isset($_POST['largo'])) ? $_POST['largo'] : '';
$alto = (isset($_POST['alto'])) ? $_POST['alto'] : '';
$m2 = (isset($_POST['m2'])) ? $_POST['m2'] : '';

$data=0;
$consulta = "UPDATE material SET largo_mat='$largo',alto_mat='$alto',m2_mat='$m2' WHERE id_mat='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
    $data=1;
}



print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>