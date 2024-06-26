<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idmat = (isset($_POST['idmat'])) ? $_POST['idmat'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$largo = (isset($_POST['largo'])) ? $_POST['largo'] : '';
$alto = (isset($_POST['alto'])) ? $_POST['alto'] : '';
$ancho = (isset($_POST['ancho'])) ? $_POST['ancho'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$tipoorg = (isset($_POST['tipoorg'])) ? $_POST['tipoorg'] : '';

switch ($opcion) {
    case 1: //alta
        //$consulta = "INSERT INTO detalle_ord (folio_ord,id_mat,cant_mat) values ('$folio','$idmat','$cantidad')";
        $consulta = "INSERT INTO detalle_ord (folio_ord,id_mat,cant_mat,largo,alto,ancho) values ('$folio','$idmat','$cantidad','$largo','$alto','$ancho')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();



        //BUSCAR MATERIAL Y TRAER INVENTARIO ACTUAL


        $tipomov = "Salida";
        if ($tipoorg == 1) {
            $descripcion = "Usado en Proyecto Folio:" . $folio;
        } else {
            $descripcion = "Usado en Obra Folio:" . $folio;
        }

        $fechavp = date('Y-m-d');


        $saldoini = 0;
        $saldofin = 0;


        $consulta = "SELECT * from material where id_mat='$idmat'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $rowdata) {


                $saldoini = $rowdata['m2_mat'];
            }


            $saldofin = $saldoini - $cantidad;

            //INSERTAR EL MOVIMIENTO

            $consulta = "INSERT INTO mov_prod(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario) 
            values('$idmat','$fechavp','$tipomov','$cantidad','$saldoini','$saldofin','$descripcion','$usuario')";
            $resultado = $conexion->prepare($consulta);

            if ($resultado->execute()) {
                // DESCONTAR DE INVENTARIO

                $consulta = "UPDATE material SET m2_mat='$saldofin' WHERE id_mat='$idmat'";
                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {
                    //DEVUELVE LA FILA
                    $consulta = "SELECT * FROM vdetalle_ord2 WHERE folio_ord='$folio' ORDER BY id_reg DESC LIMIT 1";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        }






        break;
    case 2:
        $consulta = "UPDATE detalle_ord SET estado_deto=0 where id_reg='$id'";

        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {


            //BUSCAR MATERIAL Y CANTIDAD
            $consulta = "SELECT * FROM detalle_ord WHERE id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $rowd) {
                $idmat = $rowd['id_mat'];
                $montomov = $rowd['cant_mat'];
                $folio = $rowd['folio_ord'];
            }


            $tipomov = "Entrada Can";
            if ($tipoorg == 1) {
                $descripcion = "Cancelación en Proyecto Reg:" . $folio;
            } else {
                $descripcion = "Cancelación en Obra Reg:" . $folio;
            }


            $fechavp = date('Y-m-d');

            $saldoini = 0;
            $saldofin = 0;


            $consulta = "SELECT * from material where id_mat='$idmat'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $rowdata) {

                    $saldoini = $rowdata['m2_mat'];
                }



                $saldofin = $saldoini + $montomov;





                $consulta = "INSERT INTO mov_prod(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario) 
                    values('$idmat','$fechavp','$tipomov','$montomov','$saldoini','$saldofin','$descripcion','$usuario')";
                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {

                    $consulta = "UPDATE material SET m2_mat='$saldofin' WHERE id_mat='$idmat'";
                    $resultado = $conexion->prepare($consulta);

                    $resultado->execute();
                    $data = 1;
                }
            }



            //REGRESAR A INVENTARIO

        } else {
            $data = 0;
        }


        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
