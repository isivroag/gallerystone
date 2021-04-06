
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$tipomov = (isset($_POST['tipomov'])) ? $_POST['tipomov'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';
$montomov = (isset($_POST['montomov'])) ? $_POST['montomov'] : '';
$saldofin = (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$fechavp = date('Y-m-d');


$res=0;
    //guardar el movimiento
    $consulta = "INSERT INTO mov_banco(id_banco,fecha_movb,tipo_movb,monto) values('$id','$fechavp','$tipomov','$montomov')";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $res += 1;
    }

    $consulta = "UPDATE banco SET saldo_banco='$saldofin' WHERE id_banco='$id'";
    $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res += 1;
        }


print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

?>