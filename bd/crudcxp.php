<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fecha_limite = (isset($_POST['fechal'])) ? $_POST['fechal'] : '';

$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$id_partida = (isset($_POST['id_partida'])) ? $_POST['id_partida'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$facturado = (isset($_POST['facturado'])) ? $_POST['facturado'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$concepto = $concepto;



switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO cxp (fecha,fecha_limite,id_prov,id_partida,concepto,facturado,referencia,subtotal,iva,total,saldo,tokenid) VALUES ('$fecha','$fecha_limite','$id_prov','$id_partida','$concepto','$facturado','$referencia','$subtotal','$iva','$total','$saldo','$tokenid')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;



        break;
    case 2:
        $consulta = "UPDATE cxp SET fecha='$fecha',fecha_limite='$fecha_limite',id_prov='$id_prov',id_partida='$id_partida',concepto='$concepto',facturado='$facturado',referencia='$referencia',subtotal='$subtotal',iva='$iva',total='$total',saldo='$total',tokenid='$tokenid' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;

        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
