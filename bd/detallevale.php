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

            $consulta = "SELECT * from vvale_detalle where folio_vale='$folio' and id_her='$iddes' and estado_reg='1' and tipo='HERRAMIENTA'";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $consulta = "INSERT INTO vale_detalleins (folio_vale,id_des,cantidad_des,estado,obs) 
            values ('$folio','$iddes','$cantidad','PENDIENTE','')";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * from vvale_detalle where folio_vale='$folio' and id_her='$iddes' and estado_reg='1' and tipo='INSUMO'";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
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


        $data = 1;
        break;
    case 3:
        $consulta = "SELECT * FROM vvale_detalle where folio_vale='$folio' and estado_reg=1 order by id_reg";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 4:
        $res = 0;
        if ($tipo == "HERRAMIENTA") {
            $consulta = "UPDATE vale_detalle SET estado=1 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
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
        } else {
            $consulta = "UPDATE vale_detalleins SET estado=1 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
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
        }



        break;

    case 5:
        $res = 0;
        if ($tipo == "HERRAMIENTA") {
            $consulta = "UPDATE vale_detalle SET estado=2 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
                $data = 2;

                $consulta2 = "UPDATE cajah SET bloqueado=0 where vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
            } else {
                $data = 1;
            }
        } else {
            $consulta = "UPDATE vale_detalleins SET estado=2 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }
            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
                $data = 2;

                $consulta2 = "UPDATE cajah SET bloqueado=0 where vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
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

            $consulta = "SELECT * from vvale_detalle where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }

            //buscar la cajah
            $consultacaja = "SELECT * FROM  cajah where vale='$vale'";
            $rescaja = $conexion->prepare($consultacaja);
            $rescaja->execute();
            $datacaja = $rescaja->fetchAll(PDO::FETCH_ASSOC);
            foreach ($datacaja as $row) {
                $idcaja = $row['id_cajah'];
            }
            //buscar el item de la cajah y cambiar la cantidad de elementos
            $cntarest = "UPDATE cajah_detalle SET estado_reg=0 where id_cajah='$idcaja' and id_her='$item'";
            $res3 = $conexion->prepare($cntarest);
            $res3->execute();
            //disminuir de inventario la herramienta


            $tipomov = 'Salida';
            $saldo = 0;
            $montomov = $cantidadu;
            $saldofin = 0;
            $descripcion = "SALIDA POR VALE: " . $vale . " " . $motivo;




            $consultam = "SELECT * from herramienta where id_her='$item'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datam as $rowdatam) {
                    $saldo = $rowdatam['cant_her'];
                }
            }

            $saldofin = $saldo - $montomov;

            //guardar el movimiento
            $consultam = "INSERT INTO mov_herramienta(id_her,fecha_movh,tipo_movh,cantidad,saldoini,saldofin,descripcion,usuario) values('$item','$fecha','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario')";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
            }

            $consultam = "UPDATE herramienta SET cant_her='$saldofin' WHERE id_her='$item'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
            }

            // termina disminuir inventario de la herramienta



            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
                $data = 2;

                $consulta2 = "UPDATE cajah SET bloqueado=0 where vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
            } else {
                $data = 1;
            }
        } else {
            $consulta = "UPDATE vale_detalleins SET estado=2 where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consulta = "SELECT * from vvale_detalle where id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) {
                $foliovale = $row['folio_vale'];
            }

            //buscar la cajah
            $consultacaja = "SELECT * FROM  cajah where vale='$vale'";
            $rescaja = $conexion->prepare($consultacaja);
            $rescaja->execute();
            $datacaja = $rescaja->fetchAll(PDO::FETCH_ASSOC);
            foreach ($datacaja as $row) {
                $idcaja = $row['id_cajah'];
            }
            //buscar el item de la cajah y cambiar la cantidad de elementos
            if ($cantidadr==0){
                $cntarest = "UPDATE cajah_detalleins SET estado_reg=0, cantidad_des=0 where id_cajah='$idcaja' and id_des='$item'";
            }else{
                $cntarest = "UPDATE cajah_detalleins SET cantidad_des='$cantidadr' where id_cajah='$idcaja' and id_des='$item'";
            }
            
            $res3 = $conexion->prepare($cntarest);
            $res3->execute();
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

            $consulta = "SELECT * from consumible where id_cons='$item'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $rowdata) {
            
                    $presentacion = $rowdata['presentacion'];
            
               
            
                    $saldoinn = $rowdata['contenidon'];
                    $saldoina = $rowdata['contenidoa'];
                    $saldoint = $rowdata['contenidot'];
            
                    $saldo = $rowdata['cant_cons'];;
                }
                $conversion = $presentacion * $montomov;
               
                        $saldofinn = $saldoinn - $conversion;
                        $saldofint = $saldoint - $conversion;
                        $saldofin = $saldo - $montomov;
          
                //guardar el movimiento
                $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
                values('$item','$fecha','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario','$saldoinn','$conversion','$saldofinn','$saldoina','0','$saldoina','$saldoint','$conversion','$saldofint')";
                $resultado = $conexion->prepare($consulta);
            
                if ($resultado->execute()) {
            
                    $consulta = "UPDATE consumible SET cant_cons='$saldofin',contenidon='$saldofinn',contenidot='$saldofint' WHERE id_cons='$item'";
                    $resultado = $conexion->prepare($consulta);
                    
                    if ($resultado->execute()) {
                        $res = 1;
                    }
            
                }
            }


         
            // termina disminuir inventario de la herramienta

            $consulta2 = "SELECT * from vvale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2 = $conexion->prepare($consulta2);
            $res2->execute();
            if ($res2->rowCount() == 0) {
                $consulta2 = "UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res2 = $conexion->prepare($consulta2);
                $res2->execute();
                $data = 2;

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
