<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio_venta = (isset($_POST['folio_venta'])) ? $_POST['folio_venta'] : '';
$folio_pago = (isset($_POST['folio_pago'])) ? $_POST['folio_pago'] : '';
$motivo = (isset($_POST['motivo'])) ? $_POST['motivo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$consulta = "UPDATE pagocxc SET estado_pagocxc='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagocxc='$folio_pago'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {


    $consulta = "SELECT monto,id_movb FROM pagocxc WHERE folio_pagocxc='$folio_pago'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $idmovb=0;
        foreach ($data as $dat) {

            $monto = $dat['monto'];
            $idmovb=$dat['id_movb'];
        }

        if ($idmovb){
            //consultar el movimiento de banco
            $consulta = "SELECT * FROM mov_banco WHERE id_movb='$idmovb'";

            $resultado = $conexion->prepare($consulta);
            $idbanco=0;
            $montomov=0;

            $leyenda='Cancelación de Pago: '.$folio_pago;
            if ($resultado->execute()) {
                $data= $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as $rowdata){
                    $idbanco=$rowdata['id_banco'];
                    $montomov=$rowdata['monto'];

                    //consultar el banco para traer saldo
                    $consulta = "SELECT saldo_banco FROM banco WHERE id_banco='$idbanco'";
                    $resultado = $conexion->prepare($consulta);
                    $saldobancoini=0;
                    
                    if ($resultado->execute()) {
                        $data2= $resultado->fetchAll(PDO::FETCH_ASSOC);
                        foreach($data2 as $rowdata2){
                            $saldobancoini=$rowdata2['saldo_banco'];
                        }
                    }

                    $saldobancofin=$saldobancoini-$montomov;


                    //crear movimiento de banco
                    $consulta = "INSERT INTO mov_banco(id_banco,fecha_movb,tipo_movb,descripcion,saldoini,monto,saldofin) VALUES ('$idbanco','$fecha','Egreso','$leyenda','$saldobancoini','$montomov','$saldobancofin')";
                    $resultado = $conexion->prepare($consulta);

                    if ($resultado->execute()) {
                        $consulta = "UPDATE banco SET saldo_banco='$saldobancofin' WHERE id_banco='$idbanco'";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();
                    
                    }

                    //actualizar saldo del banco

                }
            }
        }

        $consulta = "UPDATE venta SET saldo=saldo+'$monto' WHERE folio_vta='$folio_venta'";

        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $res = 1;
        } else {
            $res = 0;
        }
    } else {
        $res = 0;
    }
} else {
    $res = 0;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
