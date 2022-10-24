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


            }else{
                $data = 1;
            }
        }

        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
