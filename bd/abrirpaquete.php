
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$montomov = (isset($_POST['montomov'])) ? $_POST['montomov'] : '';
$fechavp = date('Y-m-d');
$tipomov = (isset($_POST['tipomov'])) ? $_POST['tipomov'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';


$res = 0;

$cerrado = 0;
$abierto = 0;
$presentacion = 0;
$saldo = 0;
$saldofin = 0;
$conversion = 0;
$unidad="";
$consulta = "SELECT * from vconsumible where id_cons='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;




    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
     
        $cerrado = $rowdata['contenidon'];
        $presentacion = $rowdata['presentacion'];
        $abierto = $rowdata['contenidoa'];
        $saldo = $rowdata['cant_cons'];
        $unidad= $rowdata['nom_umedida'];
    }

    //OPERACIONES DE CONVERSION
    $conversion = $presentacion * $montomov;
    $cerrado = $cerrado - $conversion;
    $abierto += $conversion;

    $saldofin = $saldo - $montomov;

    $descripcion.=" ".$montomov. " ITEM(S) DE ". $presentacion ." ". $unidad;
 
    $consulta = "INSERT INTO mov_insumo(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion) values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion')";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $res += 1;

        $consulta = "UPDATE consumible set contenidoa='$abierto', cant_cons='$saldofin',contenidon='$cerrado' WHERE id_cons='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res += 1;
        }
    }
} else {
    $res = 0;
}
//guardar el movimiento


print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

?>