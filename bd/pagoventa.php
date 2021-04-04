<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio_vta = (isset($_POST['folio_vta'])) ? $_POST['folio_vta'] : '';
$fechavp = (isset($_POST['fechavp'])) ? $_POST['fechavp'] : '';
$obsvp = (isset($_POST['obsvp'])) ? $_POST['obsvp'] : '';
$conceptovp = (isset($_POST['conceptovp'])) ? $_POST['conceptovp'] : '';
$saldovp = (isset($_POST['saldovp'])) ? $_POST['saldovp'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$saldofin= (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$metodo = (isset($_POST['metodo'])) ? $_POST['metodo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$bloqueo = (isset($_POST['bloqueo'])) ? $_POST['bloqueo'] : '';

$fcliente = (isset($_POST['fcliente'])) ? $_POST['fcliente'] : '';
$facturado = (isset($_POST['facturado'])) ? $_POST['facturado'] : '';
$factura = (isset($_POST['factura'])) ? $_POST['factura'] : '';
$fechafact = (isset($_POST['fechafact'])) ? $_POST['fechafact'] : '';
$banco = (isset($_POST['banco'])) ? $_POST['banco'] : '';

$porcom = (isset($_POST['porcom'])) ? $_POST['porcom'] : '';
$comision = (isset($_POST['comision'])) ? $_POST['comision'] : '';
$pagocom = (isset($_POST['pagocom'])) ? $_POST['pagocom'] : '';

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
switch($opcion){
case '1':
    $consulta = "INSERT INTO pagocxc (folio_vta,fecha,concepto,obs,saldoini,monto,saldofin,metodo,usuario,fcliente,facturado,factura,fecha_fact,porcom,comision,pagocom) VALUES ('$folio_vta','$fechavp','$conceptovp','$obsvp','$saldovp','$monto','$saldofin','$metodo','$usuario','$fcliente','$facturado','$factura','$fechafact','$porcom','$comision','$pagocom')";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()){

        $consulta="INSERT INTO mov_banco(id_banco,fecha_movb,tipo_movb,monto) values('$banco','$fechavp','Ingreso','$monto')";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $res=2;
            $consulta="UPDATE banco SET saldo_banco=saldo_banco+'$monto' WHERE id_banco='$banco'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            
            
        }
        else{
            $res=1;
        }
        
    }
    else{
        $res=0;
    }
    break;
case '2':

    $consulta = "UPDATE pagocxc SET fecha='$fechavp',concepto='$conceptovp',obs='$obsvp',metodo='$metodo',fcliente='$fcliente',facturado='$facturado',factura='$factura',fecha_fact='$fechafact',seguro_fact='$bloqueo' WHERE folio_pagocxc='$folio'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()){
        $res=1;
    }
    else{
        $res=0;
    }
    break;

}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
