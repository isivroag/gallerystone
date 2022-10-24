<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$id_her = (isset($_POST['id_her'])) ? $_POST['id_her'] : '';
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$opc = (isset($_POST['opc'])) ? $_POST['opc'] : '';
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$caja = (isset($_POST['caja'])) ? $_POST['caja'] : '';

switch ($opc) {
    case 1:
        $consulta = "SELECT * FROM cajah_detalle WHERE id_cajah='$id' and estado_reg='1' ORDER BY id_her";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "INSERT INTO cajah_detalle(id_cajah,id_her,clave_her,nom_her) VALUES('$id','$id_her','$clave','$nombre') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM cajah_detalle WHERE id_cajah='$id' ORDER BY id_reg DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        break;
    case 3:
        $consulta = "DELETE FROM cajah_detalle where id_reg='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
    case 4:
        
        $consulta = "SELECT * FROM cajah_detalle WHERE id_cajah='$caja' ORDER BY id_reg";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            $id_her = $row['id_her'];
            $clave_her = $row['clave_her'];
            $nom_her = $row['nom_her'];
            $cantidad = 1;

            $consulta = "INSERT INTO vale_detalle (folio_vale,id_her,cantidad_her,estado,obs) 
            values ('$folio','$id_her','$cantidad','PENDIENTE','')";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }
        $consulta = "SELECT * FROM cajah_detalleins WHERE id_cajah='$caja' ORDER BY id_reg";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            $id_her = $row['id_des'];
            $clave_her = $row['clave_des'];
            $nom_her = $row['nom_des'];
            $cantidad = $row['cantidad_des'];

            $consulta = "INSERT INTO vale_detalleins (folio_vale,id_des,cantidad_des,estado,obs) 
            values ('$folio','$id_her','$cantidad','PENDIENTE','')";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }

        $consulta = "UPDATE cajah SET vale='$folio',bloqueado='1' WHERE id_cajah='$caja'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        break;
}



print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
