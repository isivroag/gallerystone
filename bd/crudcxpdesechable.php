<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fecha_limite = (isset($_POST['fechal'])) ? $_POST['fechal'] : '';
$fecha_actual = date('Y-m-d');
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$id_partida = (isset($_POST['id_partida'])) ? $_POST['id_partida'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$facturado = (isset($_POST['facturado'])) ? $_POST['facturado'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';

$fechavp = date('Y-m-d');

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE cxp set fecha='$fecha',fecha_limite='$fecha_limite',id_prov='$id_prov',id_partida='$id_partida',concepto='$concepto',facturado='$facturado',
        referencia='$referencia',subtotal='$subtotal',iva='$iva',total='$total',saldo='$total',estado='1' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        // CONSULTA DEL DETALLE
        $consulta = "SELECT * FROM detallecxp_desechable WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {

            // EMPIEZA EL INCREMENTO EN INVENTARIO
            $id = $row['id_des'];
            $tipomov = 'Entrada';
            $saldo = 0;
            $montomov = $row['cant_des'];
            $saldofin = 0;
            $descripcion = "COMPRA DE INSUMOS CXP FOLIO: " . $folio;

            $usos = 0;
            $totalusos = 0;
            $finusos = 0;
            $cantidadfin = 0;
            $cantidadini = 0;
            $difcantidad = 0;

            $usuario = $row['usuario'];


            $consultam = "SELECT * from desechable where id_des='$id'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datam as $rowdatam) {

                    $saldo = $rowdatam['cant_des'];
                    $uso = $rowdatam['usos'];
                    $totalusos = $rowdatam['totalusos'];
                }
                $res += 1;
            }

            $usosmov= $uso* $montomov;
            $saldofin = $saldo + $montomov;
            $totalusos=$totalusos+$usosmov;
           
            //guardar el movimiento
            $consultam = "INSERT INTO mov_des(id_des,fecha_movd,tipo_movd,cantidad,saldoini,saldofin,descripcion,totalusos,usuario,usos_mov) values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$totalusos','$usuario','$usosmov')";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $consultam = "UPDATE desechable SET cant_des='$saldofin',totalusos='$totalusos' WHERE id_des='$id'";
                $resultadom = $conexion->prepare($consultam);
                if ($resultadom->execute()) {
                    $res = 1;
                }
            }
            //TERMINA EL INCREMENTO EN INVENTARIO   

        }


        break;
    case 2:


        break;

    case 3:
        $consulta = "UPDATE cxp SET estado_cxp='0' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;




       // CONSULTA DEL DETALLE
       $consulta = "SELECT * FROM detallecxp_desechable WHERE folio_cxp='$folio'";
       $resultado = $conexion->prepare($consulta);
       $resultado->execute();
       $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

       foreach ($data as $row) {

           // EMPIEZA EL INCREMENTO EN INVENTARIO
           $id = $row['id_des'];
           $tipomov = 'Salida Can';
           $saldo = 0;
           $montomov = $row['cant_des'];
           $saldofin = 0;
           $descripcion = "CANCELACION DE COMPRA DE INSUMOS CXP FOLIO: " . $folio;

           $usos = 0;
           $totalusos = 0;
           $finusos = 0;
           $cantidadfin = 0;
           $cantidadini = 0;
           $difcantidad = 0;

           $usuario = $row['usuario'];


           $consultam = "SELECT * from desechable where id_des='$id'";
           $resultadom = $conexion->prepare($consultam);
           if ($resultadom->execute()) {
               $datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);
               foreach ($datam as $rowdatam) {

                   $saldo = $rowdatam['cant_des'];
                   $uso = $rowdatam['usos'];
                   $totalusos = $rowdatam['totalusos'];
               }
               $res += 1;
           }

           $usosmov= $uso* $montomov;
           $saldofin = $saldo - $montomov;
           $totalusos=$totalusos-$usosmov;
          
           //guardar el movimiento
           $consultam = "INSERT INTO mov_des(id_des,fecha_movd,tipo_movd,cantidad,saldoini,saldofin,descripcion,totalusos,usuario,usos_mov) values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$totalusos','$usuario','$usosmov')";
           $resultadom = $conexion->prepare($consultam);
           if ($resultadom->execute()) {
               $consultam = "UPDATE desechable SET cant_des='$saldofin',totalusos='$totalusos' WHERE id_des='$id'";
               $resultadom = $conexion->prepare($consultam);
               if ($resultadom->execute()) {
                   $res = 1;
               }
           }
           //TERMINA EL INCREMENTO EN INVENTARIO   

       }
        break;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
