
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
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$fechavp = date('Y-m-d');


$res = 0;
$consulta = "SELECT * from material where id_mat='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
        $saldo = $rowdata['m2_mat'];
    }
    $res += 1;
}
switch ($tipomov) {

    case "Entrada":
        $saldofin = $saldo + $montomov;
        break;
    case "Salida":
        $saldofin = $saldo - $montomov;
        break;
    case "Inventario Inicial":
        $saldofin = $montomov;
        break;
}
//guardar el movimiento
$consulta = "INSERT INTO mov_prod(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario) values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;
}

$consulta = "UPDATE material SET m2_mat='$saldofin' WHERE id_mat='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;
}


print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

?>