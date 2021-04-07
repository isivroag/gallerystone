<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$foliocxp = (isset($_POST['foliocxp'])) ? $_POST['foliocxp'] : '';
$fechavp = (isset($_POST['fechavp'])) ? $_POST['fechavp'] : '';
$obsvp = (isset($_POST['obsvp'])) ? $_POST['obsvp'] : '';
$conceptovp = (isset($_POST['conceptovp'])) ? $_POST['conceptovp'] : '';
$saldovp = (isset($_POST['saldovp'])) ? $_POST['saldovp'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$saldofin = (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$metodo = (isset($_POST['metodo'])) ? $_POST['metodo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$banco = (isset($_POST['banco'])) ? $_POST['banco'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


$res = 0;
switch ($opcion) {
    case '1':
        //guardar el pago
        $consulta = "INSERT INTO pagocxp (folio_cxp,fecha,concepto,obs,saldoini,monto,saldofin,metodo,usuario) VALUES ('$foliocxp','$fechavp','$conceptovp','$obsvp','$saldovp','$monto','$saldofin','$metodo','$usuario')";
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $res += 1;
            //consultar saldo de la cuenta
            $consulta = "SELECT * from banco where id_banco='$banco'";
            $resultado = $conexion->prepare($consulta);
            $saldoinib = 0;
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $rowdata) {
                    $saldoinib = $rowdata['saldo_banco'];
                }
                $res += 1;
            }
            $saldofinb=$saldoinib-$monto;
           

            //consultar el folio del pago
            $consulta = "SELECT folio_pagocxp from pagocxp where folio_cxp='$foliocxp' order by folio_pagocxp desc limit 1";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $res += 1;
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $fpago = 0;

                foreach ($data as $regdata) {
                    $fpago = $regdata['folio_pagocxp'];
                }
            }
            
            //guardar el movimiento
            $consulta = "INSERT INTO mov_banco(id_banco,fecha_movb,tipo_movb,monto,folio_pagocxp,saldoini,saldofin,descripcion) values('$banco','$fechavp','Egreso','$monto','$fpago','$saldoinib','$saldofinb','$conceptovp')";
            $resultado = $conexion->prepare($consulta);

            if ($resultado->execute()) {
                $res += 1;
                //consultar el id del movimiento
                $consulta = "SELECT id_movb from mov_banco where folio_pagocxp='$fpago' order by id_movb desc limit 1";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $datam = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    $fmovb = 0;
                    foreach ($datam as $regdatam) {
                        $fmovb = $regdatam['id_movb'];
                    }
                }

                //actualizar el id_movb en pago

                $consulta = "UPDATE pagocxp SET id_movb='$fmovb' where folio_pagocxp='$fpago'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $res += 1;
                }



                $consulta = "UPDATE banco SET saldo_banco=saldo_banco-'$monto' WHERE id_banco='$banco'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $res += 1;
                }
            } else {
                $res = 0;
            }
        } else {
            $res = 0;
        }
        print json_encode($res, JSON_UNESCAPED_UNICODE);
        $conexion = NULL;
        break;

    case '2':

       
        break;
}
