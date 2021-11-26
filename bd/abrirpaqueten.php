
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$montomov = (isset($_POST['montomov'])) ? $_POST['montomov'] : '';
$fechavp = date('Y-m-d');
$tipomov = (isset($_POST['tipomov'])) ? $_POST['tipomov'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


$res = 0;

$cerrado = 0;
$abierto = 0;
$presentacion = 0;
$saldo = 0;
$saldofin = 0;
$conversion = 0;
$unidad="";

$saldofinn = 0;
$saldofina = 0;
$saldofint = 0;
$saldoinn=0;
$saldoina=0;
$saldoint=0;

$consulta = "SELECT * from vconsumible where id_cons='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res += 1;




    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
     
        
        $presentacion = $rowdata['presentacion'];
        
        
        $contenidoa = $rowdata['contenidoa'];
        $contenidot = $rowdata['contenidot'];

        $saldoinn = $rowdata['contenidon'];
        $saldoina = $rowdata['contenidoa'];
        $saldoint = $rowdata['contenidot'];

        $saldo = $rowdata['cant_cons'];
        $unidad= $rowdata['nom_umedida'];
    }

    //OPERACIONES DE CONVERSION
    $conversion = $presentacion * $montomov;

// SALDO FINAL
    $saldofinn=$saldoinn-$conversion;
    $contenidon = $conversion*$montomov;

    $saldofina=$saldoina+($conversion);
    $contenidoa = $conversion;

    $saldofint=$saldoint;
    $contenidot = 0;
    

    $cerrado = $cerrado - $conversion;
    $abierto += $conversion;

    $saldofin = $saldo - $montomov;

    $descripcion.=" ".$montomov. " ITEM(S) DE ". $presentacion ." ". $unidad;
 
    $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
                VALUES('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario','$saldoinn','$conversion','$saldofinn','$saldoina','$contenidoa','$saldofina','$saldoint','$contenidot','$saldofint')";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $res += 1;

        $consulta = "UPDATE consumible set contenidoa='$saldofina', cant_cons='$saldofin',contenidon='$saldofinn' WHERE id_cons='$id' ";
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