<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$porcentaje = (isset($_POST['porcentaje'])) ? $_POST['porcentaje'] : '';
$venta = (isset($_POST['venta'])) ? $_POST['venta'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fechaini = (isset($_POST['fechaini'])) ? $_POST['fechaini'] : '';
$fechalib = (isset($_POST['fechalib'])) ? $_POST['fechalib'] : '';

$hoy=date("Y-m-d");
$res = 0;
if ($estado == 'ACTIVO') {



    $consulta = "UPDATE orden SET edo_ord='$estado',avance='$porcentaje',fecha_limite='$fecha',fecha_ord='$fechaini' WHERE folio_ord='$folio'";
} else if ($estado == 'LIBERADO') {
    $consulta = "UPDATE orden SET edo_ord='$estado',avance='$porcentaje',fecha_liberacion='$fechalib' WHERE folio_ord='$folio'";
} else {
    $consulta = "UPDATE orden SET edo_ord='$estado',avance='$porcentaje' WHERE folio_ord='$folio'";
}

$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {

    $consulta="UPDATE ordenestado set activo='0', fecha_fin='$hoy' where id_orden='$folio' and activo='1'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    $consulta="INSERT INTO ordenestado (id_orden,estado,fecha_ini,fecha_fin,activo) VALUES ('$folio','$estado','$hoy','$hoy','1')";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    if ($venta != '') {
        $consulta = "UPDATE citav 
                    SET fecha = concat('$fecha',' ',time(fecha)) 
                    WHERE folio_vta='$venta'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        if ($estado == 'ACTIVO') {
            $edo_orden = 'PRODUCCION';
        } else if ($estado == 'LIBERADO') {
            $edo_orden = 'LIBERADO';
        }
        $consulta = "UPDATE venta SET edo_orden='$edo_orden' WHERE folio_vta='$venta'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
    } else {
        $res = 1;
    }
}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
