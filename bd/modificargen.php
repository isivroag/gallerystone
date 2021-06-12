<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$foliogen = (isset($_POST['generador'])) ? $_POST['generador'] : '';





$consulta = "SELECT * FROM tmp_gen WHERE folio_gen='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($dt as $row) {
    $tokenid = $row['tokenid'];
    $id_frente = $row['id_frente'];
    $fecha = $row['fecha'];
    $area = $row['area'];
    $descripcion = $row['descripcion'];
    $inicio = $row['inicio'];
    $fin = $row['fin'];
    
}
$consulta = "UPDATE tmp_gen SET estado_pres=2 WHERE folio_gen='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "UPDATE generador SET id_frente='$id_frente',fecha='$fecha',descripcion='$descripcion',area='$area',inicio='$inicio',fin='$fin' WHERE folio_gen='$foliogen'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "DELETE FROM detalle_gen WHERE folio_gen='$foliogen'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();



$consulta = "SELECT * FROM detalle_tmpgen WHERE folio_gen='$folio' and estado_detalle='1'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);


foreach ($dt as $row) {

    $id_concepto = $row['id_concepto'];
    $nom_concepto = $row['nom_concepto'];
    $cantidad = $row['cantidad'];
    

    $consultain = "INSERT INTO detalle_gen (folio_gen,id_concepto,nom_concepto,cantidad) VALUES ('$foliogen','$id_concepto','$nom_concepto','$cantidad')";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
}





print json_encode($foliogen, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
