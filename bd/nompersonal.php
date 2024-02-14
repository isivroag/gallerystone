<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$id_per = (isset($_POST['id_per'])) ? $_POST['id_per'] : '';
$diasp = (isset($_POST['diasp'])) ? $_POST['diasp'] : '';
$diast = (isset($_POST['diast'])) ? $_POST['diast'] : '';
$salariodf = (isset($_POST['salariodf'])) ? $_POST['salariodf'] : '';
$salariobf = (isset($_POST['salariobf'])) ? $_POST['salariobf'] : '';
$descuentof = (isset($_POST['descuentof'])) ? $_POST['descuentof'] : '';
$bonof = (isset($_POST['bonof'])) ? $_POST['bonof'] : '';
$salariofijo = (isset($_POST['salariofijo'])) ? $_POST['salariofijo'] : '';
$porcentaje = (isset($_POST['porcentaje'])) ? $_POST['porcentaje'] : '';
$participacion = (isset($_POST['participacion'])) ? $_POST['participacion'] : '';
$salariodd = (isset($_POST['salariodd'])) ? $_POST['salariodd'] : '';
$sanciones = (isset($_POST['sanciones'])) ? $_POST['sanciones'] : '';
$retardo = (isset($_POST['retardo'])) ? $_POST['retardo'] : '';
$reparto = (isset($_POST['reparto'])) ? $_POST['reparto'] : '';
$salariobd = (isset($_POST['salariobd'])) ? $_POST['salariobd'] : '';
$descuentod = (isset($_POST['descuentod'])) ? $_POST['descuentod'] : '';
$bonod = (isset($_POST['bonod'])) ? $_POST['bonod'] : '';
$salariodestajo = (isset($_POST['salariodestajo'])) ? $_POST['salariodestajo'] : '';
$salariototal = (isset($_POST['salariototal'])) ? $_POST['salariototal'] : '';




$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;

switch ($opcion) {
    case 1: //alta
        $consulta = "SELECT * from nom_emp where id_per='$id_per' and folio_nom='$folio' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            
            if ($resultado->rowCount()==0){
                $consulta = "INSERT INTO nom_emp(folio_nom,id_per,diasp,diast,salariodf,salariobf,descuentof,bonof,salariofijo,porcentaje,
                participacion,salariodd,sanciones,retardo,reparto,salariobd,descuentod,bonod,salariodestajo,salariototal) 
                VALUES ('$folio','$id_per','$diasp','$diast','$salariodf','$salariobf','$descuentof','$bonof','$salariofijo','$porcentaje',
                '$participacion','$salariodd','$sanciones','$retardo','$reparto','$salariobd','$descuentod','$bonod','$salariodestajo','$salariototal') ";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $consulta = "SELECT * FROM vnom_emp where folio_nom='$folio' and id_per='$id_per' ";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                    $res = $resultado->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        }


       
        break;
    case 2: //modificación
        $consulta = "UPDATE nom_emp SET diasp ='$diasp', diast='$diast',salariodf = '$salariodf', descuentof = '$descuentof', bonof = '$bonof', salariofijo = '$salariofijo',
        porcentaje = '$porcentaje' , participacion = '$participacion', salariodd = '$salariodd' , sanciones = '$sanciones',retardo='$retardo',reparto='$reparto' , salariobd = '$salariobd' , descuentod = '$descuentod', bonod = '$bonod',
        salariodestajo = '$salariodestajo', salariototal = '$salariototal' 
        WHERE id_per = '$id_per' and folio_nom ='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $consulta = "SELECT * FROM vnom_emp where folio_nom='$folio' and id_per='$id_per' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $res = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }



        break;
    case 3: //baja
        $consulta = "DELETE FROM nom_emp  WHERE id_reg='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }

        break;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
