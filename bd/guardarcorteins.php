<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


$consulta = "UPDATE corteins set fecha='$fecha',obs='$obs',usuario='$usuario' WHERE folio_corte='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();


$res = 0;

$consulta = "SELECT * from corteins_detalle where folio_corte='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$positivo = 0;
$negativo = 0;
foreach ($data as $row) {
    $id_cons = $row['id_cons'];
    $saldoini = $row['cant_cons'];
    $saldoinn = $row['contenidon'];
    $saldoina = $row['contenidoa'];
    $saldoint = $row['contenidot'];


    $saldofin = $row['ncant'];
    $saldofinn = $row['ncontenidon'];
    $saldofina = $row['ncontenidoa'];
    $saldofint = $row['ncontenidot'];

    $dcosto = $row['dcosto'];
    if ($dcosto > 0) {
        $positivo += $dcosto;
    } else {
        $negativo += $dcosto;
    }


    $cantidad = $saldofin - $saldoini;
    $cantidadn = $saldofinn - $saldoinn;
    $cantidada = $saldofina - $saldoina;
    $cantidadt = $saldofint - $saldoint;
    $descripcion = 'CORTE FOLIO ' . $folio;
    $tipo = 'CORTE';



    $cons = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
    values('$id_cons','$fecha','$tipo','$cantidad','$saldoini','$saldofin','$descripcion','$usuario','$saldoinn','$cantidadn','$saldofinn','$saldoina','$cantidada','$saldofina','$saldoint','$cantidadt','$saldofint')";
    $res = $conexion->prepare($cons);
    $res->execute();

    $cons = "UPDATE consumible SET cant_cons='$saldofin',contenidon='$saldofinn',contenidoa='$saldofina',contenidot='$saldofint' WHERE id_cons='$id_cons' ";
    $res = $conexion->prepare($cons);
    $res->execute();
}

$consulta = "UPDATE corteins set costo_neg='$negativo',costo_pos='$positivo', estado_corte='2' WHERE folio_corte='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();






print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
