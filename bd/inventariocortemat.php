
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

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$alto = (isset($_POST['alto'])) ? $_POST['alto'] : '';
$largo = (isset($_POST['largo'])) ? $_POST['largo'] : '';
$ancho = (isset($_POST['ancho'])) ? $_POST['ancho'] : '';

$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$fechavp = date('Y-m-d');


$res = 0;
$consulta = "SELECT * from material where id_mat='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
        $clavean= $rowdata['clave_mat'];
        $descan= $rowdata['nom_mat'];

        $altoan= $rowdata['alto_mat'];
        $largoan= $rowdata['largo_mat'];
        $anchoan= $rowdata['ancho_mat'];
        $m2an = $rowdata['m2_mat'];
    }
    $res += 1;
}

      
//guardar el movimiento
$consulta = "INSERT INTO mov_prod(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario) 
values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;
}

$consulta = "UPDATE material SET m2_mat='$saldofin',largo_mat='$largo',alto_mat='$alto',ancho_mat='$ancho',cant_mat='$saldofin' WHERE id_mat='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;
}


$consulta = "INSERT INTO bkmaterial (id_mat,nom_mat,largo_mat,alto_mat,ancho_mat,m2_mat,clave_mat) 
values ('$id','$descan','$largoan','$altoan','$anchoan','$saldo','$clavean')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;
}
print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

?>