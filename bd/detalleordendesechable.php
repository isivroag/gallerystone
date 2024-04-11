<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idcons = (isset($_POST['idcons'])) ? $_POST['idcons'] : '';
$cantidadi = (isset($_POST['cantidadi'])) ? $_POST['cantidadi'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$tipoorg = (isset($_POST['tipoorg'])) ? $_POST['tipoorg'] : '';


switch ($opcion) {

        //AGREAR
    case 1:
/*
        $consultapre = "SELECT * from desechable_ord where folio_ord='$folio' and id_des='$idcons' and estado_detalle=1";
        $resultado = $conexion->prepare($consultapre);
        $resultado->execute();
        if ($resultado->rowCount() > 0) {
            $data = 0;
        } else {*/
            $consulta = "INSERT INTO desechable_ord (folio_ord,id_des,cantidad) values ('$folio','$idcons','$cantidadi')";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $id = $idcons;
            $tipomov = "Salida";
            if ($tipoorg==1){
                $descripcion = "Usado en Proyecto Folio:" . $folio;
            }else{
                $descripcion = "Usado en Obra Folio:" . $folio;
            }
            $montomov = $cantidadi;

            $fechavp = date('Y-m-d');


            $cantidad = 0;
            $usos = 0;
            $totalusos = 0;
            $finusos = 0;
            $cantidadfin = 0;
            $cantidadini = 0;
            $difcantidad = 0;

            $consulta = "SELECT * from desechable where id_des='$id'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $rowdata) {

                    $cantidadini = $rowdata['cant_des'];
                    $usos = $rowdata['usos'];
                    $totalusos = $rowdata['totalusos'];
                }

                $finusos = $totalusos - $cantidadi;

                if (($finusos % $usos) == 0) {
                    $cantidadfin = $finusos / $usos;
                } else {
                    $cantidadfin = intdiv($finusos, $usos) + 1;
                }
                $difcantidad = $cantidadini - $cantidadfin;





                $consulta = "INSERT INTO mov_des(id_des,fecha_movd,tipo_movd,cantidad,saldoini,usos_mov,saldofin,descripcion,totalusos,usuario) 
                                    values('$id','$fechavp','$tipomov','$difcantidad','$cantidadini','$cantidadi','$cantidadfin','$descripcion','$finusos','$usuario')";
                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {

                    $consulta = "UPDATE desechable SET cant_des='$cantidadfin',totalusos='$finusos' WHERE id_des='$id'";
                    $resultado = $conexion->prepare($consulta);

                    $resultado->execute();
                }
            }



            $consulta = "SELECT * FROM vdesechableord WHERE folio_ord='$folio' ORDER BY id_reg DESC LIMIT 1";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
       /* }*/
        break;
        //CANCELAR
    case 2:
        $consulta = "UPDATE desechable_ord SET estado_detalle=0 WHERE id_reg='$id'";

        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {


            $consulta = "SELECT * FROM desechable_ord WHERE id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $rowd) {
                $idcons = $rowd['id_des'];
                $montomov = $rowd['cantidad'];
                $folio = $rowd['folio_ord'];
            }


            $tipomov = "Entrada Can";
            if ($tipoorg==1){
                $descripcion = "Cancelación en Proyecto Reg:" . $folio;
            }else{
                $descripcion = "Cancelación en Obra Reg:" . $folio;
            }

            $fechavp = date('Y-m-d');


            $cantidad = 0;
            $usos = 0;
            $totalusos = 0;
            $finusos = 0;
            $cantidadfin = 0;
            $cantidadini = 0;
            $difcantidad = 0;

            $consulta = "SELECT * from desechable where id_des='$idcons'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $rowdata) {

                    $cantidadini = $rowdata['cant_des'];
                    $usos = $rowdata['usos'];
                    $totalusos = $rowdata['totalusos'];
                }



                $finusos = $totalusos + $montomov;

                if (($finusos % $usos) == 0) {
                    $cantidadfin = $finusos / $usos;
                } else {
                    $cantidadfin = intdiv($finusos, $usos) + 1;
                }
                $difcantidad = $cantidadfin - $cantidadini;



                $consulta = "INSERT INTO mov_des(id_des,fecha_movd,tipo_movd,cantidad,saldoini,usos_mov,saldofin,descripcion,totalusos,usuario) 
                values('$idcons','$fechavp','$tipomov','$difcantidad','$cantidadini','$cantidadi','$cantidadfin','$descripcion','$finusos','$usuario')";
                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {

                    $consulta = "UPDATE desechable SET cant_des='$cantidadfin',totalusos='$finusos' WHERE id_des='$idcons'";
                    $resultado = $conexion->prepare($consulta);

                    $resultado->execute();
                    $data = 1;
                }
            }
        } else {
            $data = 0;
        }

        break;
}







print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
