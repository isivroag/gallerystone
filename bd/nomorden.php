<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$folioord = (isset($_POST['folioord'])) ? $_POST['folioord'] : '';
$porcentaje = (isset($_POST['porcentaje'])) ? $_POST['porcentaje'] : '';
$importeorden = (isset($_POST['importeorden'])) ? $_POST['importeorden'] : '';
$mlnom = (isset($_POST['mlnom'])) ? $_POST['mlnom'] : '';




$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;

switch ($opcion) {
    case 1: //alta

        $consulta = "INSERT INTO nom_ord(folio_nom,folio_ord,porcentaje,importe,ml) 
        VALUES ('$folio','$folioord','$porcentaje','$importeorden','$mlnom')";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $consulta = "SELECT * FROM vnom_ord where folio_nom='$folio' and folio_ord='$folioord' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $res = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }


        $consulta = "UPDATE nomina SET importe=importe +'$importeorden' WHERE folio_nom='$folio' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        break;
    case 2: //buscar
        $consulta = "SELECT * from nom_ord where folio_nom='$folio' and folio_ord='$folioord'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {
            $res = 1;
        } 
        


        break;
    case 3: //baja

        $consulta = "SELECT * FROM nom_ord WHERE id_reg = :id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $row) {
            $importeorden = $row['importe'];
        }

        $consulta = "SELECT * FROM nomina WHERE folio_nom = :id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $folio, PDO::PARAM_INT);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $row) {
            $importenom = $row['importe'];
        }

        $importenom = $importenom - $importeorden;



        $consulta = "DELETE FROM nom_ord WHERE id_reg = :id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        if ($resultado->execute()) {



            $consulta = "UPDATE nomina SET importe = :importenom WHERE folio_nom = :folio";
            $resultado = $conexion->prepare($consulta);
            $resultado->bindParam(':importenom', $importenom, PDO::PARAM_STR);
            $resultado->bindParam(':folio', $folio, PDO::PARAM_STR);

            if ($resultado->execute()) {
                $res = 1;
            }
        }

        break;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
