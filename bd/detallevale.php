<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';

$iddes = (isset($_POST['iddes'])) ? $_POST['iddes'] : '';
$cantidad = (isset($_POST['cantidadi'])) ? $_POST['cantidadi'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


$item = (isset($_POST['item'])) ? $_POST['item'] : '';
$motivo = (isset($_POST['motivo'])) ? $_POST['motivo'] : '';
$vale = (isset($_POST['vale'])) ? $_POST['vale'] : '';
$cantidadu = (isset($_POST['cantidadu'])) ? $_POST['cantidadu'] : '';
$cantidadr = (isset($_POST['cantidadr'])) ? $_POST['cantidadr'] : '';

$fecha = date("Y-m-d");

switch ($opcion) {
    case 1: //alta
        if ($tipo == "HERRAMIENTA") {
            $consulta = "INSERT INTO vale_detalle (folio_vale,id_her,cantidad_her,estado,obs) 
        values ('$folio','$iddes','$cantidad','PENDIENTE','')";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $consulta = "SELECT * from vvale_detalle where folio_vale='$folio' and id_her='$iddes' and estado_reg='1' and tipo='HERRAMIENTA'";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
        } else {
            $consulta = "INSERT INTO vale_detalleins (folio_vale,id_des,cantidad_des,estado,obs) 
            values ('$folio','$iddes','$cantidad','PENDIENTE','')";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $consulta = "SELECT * from vvale_detalle where folio_vale='$folio' and id_her='$iddes' and estado_reg='1' and tipo='INSUMO'";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
        }


        break;
    case 2:
        if ($tipo == "HERRAMIENTA") {
            $consulta = "DELETE FROM vale_detalle where id_reg='$id'";
        } else {
            $consulta = "DELETE FROM vale_detalleins where id_reg='$id'";
        }
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $resultado->closeCursor();


        $data = 1;
        break;
    case 3:
        $consulta = "SELECT * FROM vvale_detalle where folio_vale='$folio' and estado_reg=1 order by id_reg";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $resultado->closeCursor();
        break;
    case 4:
        $res = 0;
        if ($tipo == "HERRAMIENTA") {
            $consulta = "UPDATE vale_detalle SET estado=1 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id' and tipo='HERRAMIENTA'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
            $resultado->closeCursor();

            $consulta2 = "SELECT * from vale_detalle where folio_vale='$foliovale' and estado='0' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='ENTREGADO' where folio_vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
                $data = 2;
            } else {
                $data = 1;
            }
            $res2->closeCursor();
        } else {
            $consulta = "UPDATE vale_detalleins SET estado=1 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id' and tipo='INSUMO'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
            $resultado->closeCursor();
            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='0' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='ENTREGADO' where folio_vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
                $data = 2;
            } else {
                $data = 1;
            }
            $res2->closeCursor();
        }



        break;

    case 5:
        $res = 0;
        if ($tipo == "HERRAMIENTA") {
            $consulta = "UPDATE vale_detalle SET estado=2 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id' and tipo='HERRAMIENTA'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
            $resultado->closeCursor();
            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res3 = $conexion->prepare($consulta2);
                $res3->execute();
                $data = 2;
                $res3->closeCursor();

                $consulta2 = "UPDATE cajah SET bloqueado=0 where vale='$foliovale'";
                $res3 = $conexion->prepare($consulta2);
                $res3->execute();
                $res3->closeCursor();
            } else {
                $data = 1;
            }
            $res2->closeCursor();
        } else {
            $consulta = "UPDATE vale_detalleins SET estado=2, cantidad_reg=cantidad_des where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id' and tipo='INSUMO'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
            $resultado->closeCursor();

            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res3 = $conexion->prepare($consulta2);
                $res3->execute();
                $res3->closeCursor();
                $data = 2;

                $consulta2 = "UPDATE cajah SET bloqueado=0 where vale='$foliovale'";
                $res3 = $conexion->prepare($consulta2);
                $res3->execute();
                $res3->closeCursor();
            } else {
                $data = 1;
            }
        }

        break;
    case 6:
        $res = 0;
        if ($tipo == "HERRAMIENTA") {
            $consulta = "UPDATE vale_detalle SET estado=2 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id' and tipo='HERRAMIENTA'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
            $resultado->closeCursor();

            //buscar la cajah
            $consultacaja = "SELECT * FROM  cajah where vale='$foliovale'";
            $rescaja = $conexion->prepare($consultacaja);
            $rescaja->execute();
            $datacaja = $rescaja->fetchAll(PDO::FETCH_ASSOC);
            foreach ($datacaja as $row) {
                $idcaja = $row['id_cajah'];
            }
            $rescaja->closeCursor();
            //buscar el item de la cajah y cambiar la cantidad de elementos
            $cntarest = "UPDATE cajah_detalle SET estado_reg=0 where id_cajah='$idcaja' and id_her='$item'";
            $res3 = $conexion->prepare($cntarest);
            $res3->execute();
            $res3->closeCursor();
            //disminuir de inventario la herramienta


            $tipomov = 'Salida';
            $saldo = 0;
            $montomov = $cantidadu;
            $saldofin = 0;
            $descripcion = "SALIDA POR VALE: " . $foliovale . " " . $motivo;




            $consultam = "SELECT * from herramienta where id_her='$item'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datam as $rowdatam) {
                    $saldo = $rowdatam['cant_her'];
                }
            }
            $resultadom->closeCursor();

            $saldofin = $saldo - $montomov;

            //guardar el movimiento
            $consultam = "INSERT INTO mov_herramienta(id_her,fecha_movh,tipo_movh,cantidad,saldoini,saldofin,descripcion,usuario) values('$item','$fecha','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario')";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
            }
            $resultadom->closeCursor();
            $consultam = "UPDATE herramienta SET cant_her='$saldofin' WHERE id_her='$item'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
            }
            $resultadom->closeCursor();

            // termina disminuir inventario de la herramienta



            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res3 = $conexion->prepare($consulta2);
                $res3->execute();
                $res3->closeCursor();
                $data = 2;

                $consulta2 = "UPDATE cajah SET bloqueado=0 where vale='$foliovale'";
                $res3 = $conexion->prepare($consulta2);
                $res3->execute();
                $res3->closeCursor();
            } else {
                $data = 1;
            }
            $res2->closeCursor();
        } else {
            $idcaja = 0;
            $consulta = "UPDATE vale_detalleins SET estado=2,cantidad_reg='$cantidadr' where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id' and tipo='INSUMO'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
            $resultado->closeCursor();

            //buscar la cajah
            $consultacaja = "SELECT * FROM  cajah where vale='$foliovale'";
            $rescaja = $conexion->prepare($consultacaja);
            $rescaja->execute();
            $datacaja = $rescaja->fetchAll(PDO::FETCH_ASSOC);
            foreach ($datacaja as $row) {
                $idcaja = $row['id_cajah'];
            }
            $rescaja->closeCursor();
            //buscar el item de la cajah y cambiar la cantidad de elementos
            if ($cantidadr == 0) {
                $cntarest = "UPDATE cajah_detalleins SET estado_reg=0, cantidad_des=0 where id_cajah='$idcaja' and id_des='$item'";
            } else {
                $cntarest = "UPDATE cajah_detalleins SET cantidad_des='$cantidadr' where id_cajah='$idcaja' and id_des='$item'";
            }

            $res3 = $conexion->prepare($cntarest);
            $res3->execute();
            $res3->closeCursor();
            //disminuir de inventario la herramienta


            $tipomov = 'Salida';
            $saldo = 0;
            $montomov = $cantidadu;
            $saldofin = 0;
            $descripcion = "SALIDA POR VALE: " . $vale . " " . $motivo;

            $conversion = 0;
            $saldofinn = 0;
            $saldofina = 0;
            $saldofint = 0;
            $saldoinn = 0;
            $saldoina = 0;
            $saldoint = 0;
            $contenidoc = 0;
            $contenidoa = 0;
            $contenidot = 0;
            $presentacion = 0;
            $cantidad = 0;
            $saldo = 0;
            $saldoini = 0;
            $saldofin = 0;

            $consulta = "SELECT * FROM consumible where id_cons='$item'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $rowdata) {

                    $presentacion = $rowdata['presentacion'];
                    $cantidad = $rowdata['cant_cons'];
                    $saldoinn = $rowdata['contenidon'];
                    $saldoina = $rowdata['contenidoa'];
                    $saldoint = $rowdata['contenidot'];
                    $saldo = $rowdata['contenidoa'];
                }

                $conversion =  $montomov;
                $saldoini = $cantidad * $presentacion;

                $saldofinn = $saldoinn;
                $saldofina = $saldoina - $conversion;
                $saldofint = $saldoint - $conversion;
                $saldofin = $saldo - $montomov;

                //guardar el movimiento
                $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,
                usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint,usuario) 
                values('$item','$fecha','$tipomov','0','$cantidad','$cantidad','$descripcion',
                '$usuario','$saldoinn','0','$saldofinn','$saldoina','$montomov','$saldofina','$saldoint','$conversion','$saldofint','$usuario')";
                $resultado = $conexion->prepare($consulta);




//NUEVO CODIGO PARA INSERTAR EN ORDEN EL MOVIMIENTO
                if ($resultado->execute()) {
                    //BUSCAR A QUE ORDEN PERTENECE EL MOVIMIENTO
                    $cntav = "SELECT * FROM vale where folio_vale='$foliovale'";
                    $resv = $conexion->prepare($cntav);
                    if ($resv->execute()) {
                        $datav = $resv->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($datav as $row) {
                            $folioorden = $row['folio_orden'];
                        }
                        $resv->closeCursor();

                        //INSERTAR EL MOVIMIENTO EN EL DETALLE DE LA ORDEN

                        $consulta = "INSERT INTO consumible_ord (folio_ord,id_cons,cantidad) values ('$folioorden','$item','$montomov')";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();
                        $resultado->closeCursor();
                    }
                    $resv->closeCursor();
                    $consulta = "UPDATE consumible SET cant_cons='$cantidad',contenidon='$saldoini',contenidoa='$saldofina',contenidot='$saldofint' WHERE id_cons='$item'";
                    $resultado = $conexion->prepare($consulta);

                    if ($resultado->execute()) {
                        $res = 1;
                    }
                    $resultado->closeCursor();
                }
                $resultado->closeCursor();
            }
            $resultado->closeCursor();


            // termina disminuir inventario de la herramienta

            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $data = 2;
                $consulta2 = "UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();


                $consulta2 = "UPDATE cajah SET bloqueado=0 where vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
            } else {
                $data = 1;
            }
        }
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
