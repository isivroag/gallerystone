<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


$consulta = "UPDATE cortemat set fecha='$fecha',obs='$obs',usuario='$usuario' WHERE folio_corte='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();


$res = 0;

$consulta = "SELECT * from cortemat_detalle where folio_corte='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
$positivo=0;
$negativo=0;
foreach ($data as $row) {
    $id_mat = $row['id_mat'];
    $saldoini = $row['m2_mat'];
    $saldofin = $row['nm2'];
    $dcosto = $row['dcosto'];
    if ($dcosto>0){
        $positivo+=$dcosto;
    }else{
        $negativo+=$dcosto;
    }
    $largo= $row['nlargo'];
    $alto= $row['nalto'];
    $ancho= $row['nancho'];

    $cantidad = $saldofin - $saldoini;
    $descripcion = 'CORTE FOLIO ' . $folio;
    $tipo = 'CORTE';



    $cons = "INSERT INTO mov_prod(id_mat,fecha_movp,descripcion,tipo_movp,saldoini,cantidad,saldofin,usuario) 
    VALUES('$id_mat','$fecha','$descripcion','$tipo','$saldoini','$cantidad','$saldofin','$usuario')";
    $res = $conexion->prepare($cons);
    $res->execute();

    $cons = "UPDATE material SET largo_mat='$largo',alto_mat='$alto',ancho_mat='$ancho',m2_mat='$saldofin' WHERE id_mat='$id_mat' ";
    $res = $conexion->prepare($cons);
    $res->execute();
}

$consulta = "UPDATE cortemat set costo_neg='$negativo',costo_pos='$positivo', estado_corte='2' WHERE folio_corte='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();






print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
