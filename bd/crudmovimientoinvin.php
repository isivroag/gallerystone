
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

$conversion = 0;
$saldofinn = 0;
$saldofina = 0;
$saldofint = 0;
$saldoinn = 0;
$saldoina = 0;
$saldoint = 0;
$contenidoc = 0;
$contenidoa = 0;
$contenidot = 0;

$res = 0;
$consulta = "SELECT * from consumible where id_cons='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {

        $presentacion = $rowdata['presentacion'];

   

        $saldoinn = $rowdata['contenidon'];
        $saldoina = $rowdata['contenidoa'];
        $saldoint = $rowdata['contenidot'];

        $saldo = $rowdata['cant_cons'];;
    }
    $conversion = $presentacion * $montomov;


    switch ($tipomov) {

        case "Entrada":
            $saldofinn = $saldoinn + $conversion;
            $saldofint = $saldoint + $conversion;
            $saldofin = $saldo + $montomov;
            break;

        case "Salida":
            $saldofinn = $saldoinn - $conversion;
            $saldofint = $saldoint - $conversion;
            $saldofin = $saldo - $montomov;
            break;
        case "Inventario Inicial":
            $saldofinn = $conversion;
            $saldofint =  $saldoina + $conversion;

            $saldofin = $montomov;
            break;
    }
    //guardar el movimiento
    $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
    values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario','$saldoinn','$conversion','$saldofinn','$saldoina','0','$saldoina','$saldoint','$conversion','$saldofint')";
    $resultado = $conexion->prepare($consulta);

    if ($resultado->execute()) {

        $consulta = "UPDATE consumible SET cant_cons='$saldofin',contenidon='$saldofinn',contenidot='$saldofint' WHERE id_cons='$id'";
        $resultado = $conexion->prepare($consulta);
        
        if ($resultado->execute()) {
            $res = 1;
        }

    }
}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
