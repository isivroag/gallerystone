<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$foliogen = (isset($_POST['generador'])) ? $_POST['generador'] : '';
$idorden = (isset($_POST['idorden'])) ? $_POST['idorden'] : '';





$consulta = "SELECT * FROM tmp_gen WHERE folio_gen='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($dt as $row) {
    $tokenid = $row['tokenid'];
    
    $id_area = $row['id_area'];
    $fecha = $row['fecha'];
    $area = $row['area'];
    $descripcion = $row['descripcion'];
    $inicio = $row['inicio'];
    $fin = $row['fin'];
    
}
$consulta = "UPDATE tmp_gen SET estado_pres=2 WHERE folio_gen='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "UPDATE generador SET id_area='$id_area',fecha='$fecha',descripcion='$descripcion',area='$area',inicio='$inicio',fin='$fin' WHERE folio_gen='$foliogen'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();




$consulta = "SELECT * FROM detalle_gen WHERE folio_gen='$foliogen'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);


foreach ($dt as $row) {

    $id_concepto = $row['id_concepto'];
    $nom_concepto = $row['nom_concepto'];
    $cantidad = $row['cantidad'];
    

    $consultain = "SELECT * from detalle_area where id_concepto='$id_concepto' and id_area='$id_area'";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
    $dat = $resultadoin->fetchAll(PDO::FETCH_ASSOC);

    
    $generado = 0;
    $pendiente = 0;

    foreach ($dat as $rowd) {
        $totalcant = $rowd['cantidad'];
        $generado = $rowd['generado'];
        $pendiente = $rowd['pendiente'];
    }
    $generado -= $cantidad;
    $pendiente += $cantidad;

    $consultain = "UPDATE detalle_area set generado='$generado',pendiente='$pendiente' WHERE id_area='$id_area' and id_concepto='$id_concepto'";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
}


$consulta = "DELETE FROM detalle_gen WHERE folio_gen='$foliogen'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();



$consulta = "SELECT * FROM detalle_tmpgen WHERE folio_gen='$folio' and estado_detalle='1'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);
$precio=0;
$costo=0;
$totalcosto=0;
$totalpublico=0;

foreach ($dt as $row) {

    $id_concepto = $row['id_concepto'];
    $nom_concepto = $row['nom_concepto'];
    $cantidad = $row['cantidad'];

    //buscar costo y precio
    $consultapc = "SELECT * FROM detalle_conceptosobra where id_concepto='$id_concepto' and estado_detalle='1' and id_orden='$idorden'";
    $resultadopc = $conexion->prepare($consultapc);
    $resultadopc->execute();
    $dtpc = $resultadopc->fetchAll(PDO::FETCH_ASSOC);
    foreach($dtpc as $rowpc){
        $precio=$rowpc['precio_concepto'];
        $costo=$rowpc['costo_concepto'];
    }
    $totalcosto+=$cantidad*$costo;
    $totalpublico+=$cantidad*$precio;


    

    $consultain = "INSERT INTO detalle_gen (folio_gen,id_concepto,nom_concepto,cantidad) VALUES ('$foliogen','$id_concepto','$nom_concepto','$cantidad')";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();

    $consultain = "SELECT * from detalle_area where id_concepto='$id_concepto' and id_area='$id_area'";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
    $dat = $resultadoin->fetchAll(PDO::FETCH_ASSOC);

    $totalcant = 0;
    $generado = 0;
    $pendiente = 0;

    foreach ($dat as $rowd) {
        $totalcant = $rowd['cantidad'];
        $generado = $rowd['generado'];
        $pendiente = $rowd['pendiente'];
    }
    $generado += $cantidad;
    $pendiente -= $cantidad;

    $consultain = "UPDATE detalle_area set generado='$generado',pendiente='$pendiente' WHERE id_area='$id_area' and id_concepto='$id_concepto'";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();

    $consultain = "UPDATE generador set costo_gen='$totalcosto',pp_gen='$totalpublico' WHERE folio_gen ='$foliogen'";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
}





print json_encode($foliogen, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
