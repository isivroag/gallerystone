
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

    

   
        $cantidad=$rowdata['cant_cons'];
        $saldoinn = $rowdata['contenidon'];
        $saldoina = $rowdata['contenidoa'];
        $saldoint = $rowdata['contenidot'];
        $saldo = $rowdata['cant_cons'];;

    }
    


    switch ($tipomov) {

        case "Entrada":
            $saldofinn = $saldoinn;
            $saldofinab=$saldoina+$montomov;
            $saldofint = $saldoint + $montomov;
            $saldofin=$saldo;
            break;

        case "Salida":
            $saldofinn = $saldoinn;
            $saldofinab=$saldoina - $montomov;
            $saldofint = $saldoint - $montomov;
            $saldofin=$saldo;
            break;
        case "Inventario Inicial":
            $saldofinn = $saldoinn;
            $saldofinab=$montomov;
            $saldofint = $saldofinn + $montomov;
            $saldofin=$saldo;
            break;
    }
    $descripcion.= "  (Contenido Abierto)";
    //guardar el movimiento
    $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
    values('$id','$fechavp','$tipomov','0','$saldo','$saldofin','$descripcion','$usuario','$saldoinn','0','$saldofinn','$saldoina','$montomov','$saldofinab','$saldoint','$montomov','$saldofint')";
    $resultado = $conexion->prepare($consulta);

    if ($resultado->execute()) {

        $consulta = "UPDATE consumible SET contenidoa='$saldofinab',contenidot='$saldofint' WHERE id_cons='$id'";
        $resultado = $conexion->prepare($consulta);
        
        if ($resultado->execute()) {
            $res = 1;
        }

    }
}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
