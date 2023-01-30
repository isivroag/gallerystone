
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

$saldom2 = (isset($_POST['saldom2'])) ? $_POST['saldom2'] : '';
$m2mov = (isset($_POST['m2mov'])) ? $_POST['m2mov'] : '';
$saldofinm2 = (isset($_POST['saldofinm2'])) ? $_POST['saldofinm2'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$fechavp = date('Y-m-d');


$res = 0;
$consulta = "SELECT * from materialpieza where id_mat='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
        $saldo = $rowdata['cant_mat'];
        $saldom2 =$rowdata['m2_mat'];
    }
    $res += 1;
}
switch ($tipomov) {

    case "Entrada":
        $saldofin = $saldo + $montomov;
        $saldofinm2 = $saldom2 + $m2mov;
        break;
    case "Salida":
        $saldofin = $saldo - $montomov;
        $saldofinm2 = $saldom2 - $m2mov;
        break;
    case "Inventario Inicial":
        $saldofin = $montomov;
        $saldofinm2 = $m2mov;
        break;
}
//guardar el movimiento
$consulta = "INSERT INTO mov_matpieza(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario,m2_ini,m2_cantidad,m2_final) 
values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario','$saldom2','$m2mov','$saldofinm2')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;
}

$consulta = "UPDATE materialpieza SET cant_mat='$saldofin',m2_mat='$saldofinm2' WHERE id_mat='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;
}


print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

?>