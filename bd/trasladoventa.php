<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';




$consulta = "SELECT * FROM presupuesto WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($dt as $row) {
    $tokenid = $row['tokenid'];
    $id_pros = $row['id_pros'];
    $fecha = $row['fecha_pres'];
    $concepto = $row['concepto_pres'];
    $ubicacion = $row['ubicacion'];
    $subtotal = $row['subtotal'];
    $iva = $row['iva'];
    $total = $row['total'];
    $descuento = $row['descuento'];
    $gtotal = $row['gtotal'];
    
}

$consulta = "SELECT * FROM cliente where id_pros='$id_pros'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() >= 1) {
    $dta = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dta as $dt) {
        $id_cliente = $dt['id_clie'];
    }
} else {
    $id_cliente = "";
}

if ($id_cliente == "") {

    $consulta = "SELECT * FROM prospecto WHERE id_pros='$id_pros'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $dt = $resultado->fetchAll(PDO::FETCH_ASSOC);


    foreach ($dt as $row) {
        $rfc="";
        $nomclie = $row['nombre'];
        $correoclie = $row['correo'];
        $calleclie = $row['calle'];
        $numclie = $row['num'];
        $colclie = $row['col'];
        $cpclie = $row['cp'];
        $cdclie = $row['cd'];
        $edoclie = $row['edo'];
        $telclie = $row['tel'];
        $celclie = $row['cel'];

        $consulta = "INSERT INTO cliente (rfc,nombre,correo, calle, col, num, cp,cd,edo,tel,cel,id_pros) VALUES('$rfc','$nomclie','$correoclie', '$calleclie', '$colclie','$numclie','$cpclie','$cdclie','$edoclie','$telclie','$celclie','$id_pros') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id_clie FROM cliente ORDER BY id_clie DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        if ($resultado->rowCount() >= 1) {
            $dtc = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dtc as $rowc) {
                $id_cliente = $rowc['id_clie'];
            }
        } 

    }
}






$consulta = "UPDATE presupuesto SET estado_pres=3 WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$fecha=date('Y-m-d');
$consulta = "INSERT INTO venta (id_clie,fecha_vta,concepto_vta,ubicacion,subtotal,iva,total,tokenid,estado_vta,descuento,gtotal,saldo) VALUES('$id_cliente','$fecha','$concepto','$ubicacion','$subtotal','$iva','$total','$tokenid','1','$descuento','$gtotal','$gtotal')";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "SELECT * FROM venta ORDER BY folio_vta DESC LIMIT 1";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $rw) {
    $foliovta = $rw['folio_vta'];
}



$consulta = "SELECT * FROM detalle_pres WHERE folio_pres='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);


foreach ($dt as $row) {

    $id_concepto = $row['id_concepto'];
    $id_item = $row['id_item'];
    $id_precio = $row['id_precio'];
    $precio = $row['precio'];
    $cantidad = $row['cantidad'];
    $total = $row['total'];

    $consultain = "INSERT INTO detalle_vta (folio_vta,id_concepto,id_item,id_precio,precio,cantidad,total) VALUES ('$foliovta','$id_concepto','$id_item','$id_precio','$precio','$cantidad','$total')";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
}




print json_encode($foliovta, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
