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
        $data=1;



        break;
}



print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;