<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$estado= (isset($_POST['estado'])) ? $_POST['estado'] : '';
$porcentaje= (isset($_POST['porcentaje'])) ? $_POST['porcentaje'] : '';
$venta= (isset($_POST['venta'])) ? $_POST['venta'] : '';
$fecha= (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fechaini= (isset($_POST['fechaini'])) ? $_POST['fechaini'] : '';
$fechalib= (isset($_POST['fechalib'])) ? $_POST['fechalib'] : '';


$res=0;
if ($estado=='ACTIVO'){
    $consulta = "UPDATE orden SET edo_ord='$estado',avance='$porcentaje',fecha_limite='$fecha',fecha_ord='$fechaini' WHERE folio_ord='$folio'";
}
else if($estado=='LIBERADO'){
    $consulta = "UPDATE orden SET edo_ord='$estado',avance='$porcentaje',fecha_liberacion='$fechalib' WHERE folio_ord='$folio'";
}
else{
    $consulta = "UPDATE orden SET edo_ord='$estado',avance='$porcentaje' WHERE folio_ord='$folio'";

}

$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
   
    if ($venta!=''){
        if ($estado=='ACTIVO'){
            $edo_orden='PRODUCCION';

        }
        else if($estado=='LIBERADO'){
            $edo_orden='LIBERADO'   ;     
        }
        $consulta = "UPDATE venta SET edo_orden='$edo_orden' WHERE folio_vta='$venta'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $res=1;
        }

    }
    else{
        $res=1;
    }
}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
