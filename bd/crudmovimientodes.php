
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$tipomov = (isset($_POST['tipomov'])) ? $_POST['tipomov'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';
$montomov = (isset($_POST['montomov'])) ? $_POST['montomov'] : '';
$saldofin = (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fechavp = date('Y-m-d');


$res = 0;
$consulta = "SELECT * from desechable where id_des='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
        $saldo = $rowdata['cant_des'];
        $uso = $rowdata['usos'];
        $totalusos = $rowdata['totalusos'];
    }
}

$usosmov= $uso* $montomov;
switch ($tipomov) {

    case "Entrada":

        $saldofin = $saldo + $montomov;
        $totalusos=$totalusos+$usosmov;

        break;

    case "Salida":

        $saldofin = $saldo - $montomov;
        $totalusos=$totalusos-$usosmov;
        break;
    case "Inventario Inicial":
        $saldofin = $montomov;
        $totalusos=$usosmov;
        break;
}

$totalusos = $saldofin * $uso;
//guardar el movimiento
$consulta = "INSERT INTO mov_des(id_des,fecha_movd,tipo_movd,cantidad,saldoini,saldofin,descripcion,totalusos,usuario,usos_mov) values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$totalusos','$usuario','$usosmov')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $consulta = "UPDATE desechable SET cant_des='$saldofin',totalusos='$totalusos' WHERE id_des='$id'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $res = 1;
    }
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

?>