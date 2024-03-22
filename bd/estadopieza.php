<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$forden = (isset($_POST['forden'])) ? $_POST['forden'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$hoy = date("Y-m-d");
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';

$idesp = 0;


switch ($opcion) {
    case 1:

        $consulta = "UPDATE det_ot SET estado='COLOCADO' WHERE id_reg='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {

            $consulta = "INSERT INTO ordenestado(id_orden,estado,fecha_ini,fecha_fin,activo,usuario,descripcion) VALUES ('$forden','COLOCACION','$hoy','$hoy','1','$usuario','$descripcion')";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $resp = 1;



            //$consulta = "SELECT * FROM det_ot WHERE id_ot='$forden' and estado='PENDIENTE' ";
            $consulta = "SELECT * FROM det_ot WHERE id_ot='$forden' and estado='PULIDO' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if ($resultado->rowCount() == 0) {
                $consulta =  "UPDATE orden SET edo_ord='COLOCADO' WHERE folio_ord='$forden'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $resp = 2;
                }
            }
        }
        break;
    case 2:
        $consulta = "UPDATE det_ot SET estado='CORTADO' WHERE id_reg='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {

            $consulta = "INSERT INTO ordenestado(id_orden,estado,fecha_ini,fecha_fin,activo,usuario,descripcion) VALUES ('$forden','CORTE','$hoy','$hoy','1','$usuario','$descripcion')";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $resp = 1;



            $consulta = "SELECT * FROM det_ot WHERE id_ot='$forden' and estado='PENDIENTE' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if ($resultado->rowCount() == 0) {
                $consulta =  "UPDATE orden SET edo_ord='ENSAMBLE',avance='45' WHERE folio_ord='$forden'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $resp = 2;
                }

                $consulta = "UPDATE ordenestado set activo='0',fecha_fin='$hoy' where id_orden='$forden' and activo='1'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $consulta = "INSERT INTO ordenestado (id_orden,estado,fecha_ini,fecha_fin,activo,usuario,descripcion) VALUES ('$forden','ENSAMBLE','$hoy','$hoy','1','$usuario','CAMBIO DE ESTADO')";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
            }
        }
        break;
    case 3:
        $consulta = "UPDATE det_ot SET estado='ENSAMBLADO' WHERE id_reg='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {

            $consulta = "INSERT INTO ordenestado(id_orden,estado,fecha_ini,fecha_fin,activo,usuario,descripcion) VALUES ('$forden','ENSAMBLE','$hoy','$hoy','1','$usuario','$descripcion')";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $resp = 1;



            $consulta = "SELECT * FROM det_ot WHERE id_ot='$forden' and estado='CORTADO' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if ($resultado->rowCount() == 0) {
                $consulta =  "UPDATE orden SET edo_ord='PULIDO',avance='75' WHERE folio_ord='$forden'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $resp = 2;
                }

                $consulta = "UPDATE ordenestado set activo='0',fecha_fin='$hoy' where id_orden='$forden' and activo='1'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $consulta = "INSERT INTO ordenestado (id_orden,estado,fecha_ini,fecha_fin,activo,usuario,descripcion) VALUES ('$forden','PULIDO','$hoy','$hoy','1','$usuario','CAMBIO DE ESTADO')";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
            }
        }
        break;

    case 4:
        //DEBE CAMBIAR PARA QUE REVISAR PRIMERO SI ES LA ULTIMA PIEZA A CAMBIAR DE ESTADO, SI ES ASI ENTONCES DEBE REVISAR SI EN EL DETALLE DE ORDEN 
        //YA TIENE 1 MATERIAL Y 3 INSUMOS E INSUMOS DE DESGASTE

        $consulta = "SELECT * FROM det_ot WHERE id_ot='$forden' and estado='ENSAMBLADO' AND id_reg<>'$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if ($resultado->rowCount() == 0) {
            $resultado->closeCursor();

            //REVISAR SI CUMPLE LOS REQUISITOS
            $flag = 0;

            $consulta = "SELECT * FROM vdetalle_ord2 where folio_ord='$forden' and estado_deto=1 order by id_reg";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            if ($resultado->rowCount() >= 1) {
                $flag += 1;
            }
            $resultado->closeCursor();

            $consulta =  "SELECT * FROM vconsumibleord where folio_ord='$forden' and estado_detalle=1 order by id_reg";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            if ($resultado->rowCount() >= 3) {
                $flag += 1;
            }
            $resultado->closeCursor();

            $consulta = "SELECT * FROM vdesechableord where folio_ord='$forden' and estado_detalle=1 order by id_reg";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            if ($resultado->rowCount() >= 3) {
                $flag += 1;
            }
            $resultado->closeCursor();


            if ($flag == 3) {
                $consulta = "UPDATE det_ot SET estado='PULIDO' WHERE id_reg='$id' ";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $resultado->closeCursor();
                $consulta = "INSERT INTO ordenestado(id_orden,estado,fecha_ini,fecha_fin,activo,usuario,descripcion) VALUES ('$forden','PULIDO','$hoy','$hoy','1','$usuario','$descripcion')";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $resultado->closeCursor();

                $consulta =  "UPDATE orden SET edo_ord='COLOCACION',avance='90' WHERE folio_ord='$forden'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $resp = 2;
                }
                $resultado->closeCursor();

                $consulta = "UPDATE ordenestado set activo='0',fecha_fin='$hoy' where id_orden='$forden'and activo='1'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $resultado->closeCursor();

                $consulta = "INSERT INTO ordenestado (id_orden,estado,fecha_ini,fecha_fin,activo,usuario,descripcion) VALUES ('$forden','COLOCACION','$hoy','$hoy','1','$usuario','CAMBIO DE ESTADO'))";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $resultado->closeCursor();
            } else {
                $resp = 3;
            }
        } else {
            $consulta = "UPDATE det_ot SET estado='PULIDO' WHERE id_reg='$id' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();


            $consulta = "INSERT INTO ordenestado(id_orden,estado,fecha_ini,fecha_fin,activo,usuario,descripcion) VALUES ('$forden','PULIDO','$hoy','$hoy','1','$usuario','$descripcion')";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $resultado->closeCursor();

            $resp = 1;
        }

        break;
}




print json_encode($resp, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
