<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$largo = (isset($_POST['largo'])) ? $_POST['largo'] : '';
$alto = (isset($_POST['alto'])) ? $_POST['alto'] : '';
$m2 = (isset($_POST['m2'])) ? $_POST['m2'] : '';
$tipored = (isset($_POST['tipored'])) ? $_POST['tipored'] : '';

$pedaceria=(isset($_POST['pedaceria'])) ? $_POST['pedaceria'] : '';
$usuario=(isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fechavp = date('Y-m-d');


$movimiento=0;
$saldofin=$m2;
$consulta = "SELECT * from material where id_mat='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
        $saldo = $rowdata['m2_mat'];
    }
 
}


if ($pedaceria==0){
    $res=0;
    $consulta = "UPDATE material SET largo_mat='$largo',alto_mat='$alto',m2_mat='$m2' WHERE id_mat='$id'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()){
        $res=1;
    }
    
}else{
    $res=0;
    $consulta = "UPDATE material SET largo_mat='0',alto_mat='0',m2_mat='0' WHERE id_mat='$id'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()){
        


        $montomov=$saldo;
        $saldofin=0;
        $tipomov='Pedacería';
        $descripcion="Material Sobrante Enviado a Pedacería";


        $consulta = "INSERT INTO mov_prod(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario) values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario')";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }


    }
}


/*

if($tipored==1){
    $montomov=$m2-$saldo;
    $tipomov='Cambio';
    $descripcion="Cambio de Medidas Aumento";
}else{
    $montomov=$saldo-$m2;
    $tipomov='Cambio';
    $descripcion="Cambio de Medidas Disminución";
}

$consulta = "INSERT INTO mov_prod(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario) values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res = 1;
}
*/
print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>