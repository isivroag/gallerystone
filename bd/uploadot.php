<?php

$orden=$_POST['orden'];
$fecha=date("YmdHis");
$nombre=$_FILES['file']['name'];
$extencion =explode(".", $nombre);
$extencion=end($extencion);


if (is_array($_FILES) && count($_FILES) > 0) {
    if (($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/gif")) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../archivos/ot".$orden.$fecha.".".$extencion)) {
            //more code here...
            $archivo= "archivos/ot".$orden.$fecha.".".$extencion;

            include_once 'conexion.php';
            $objeto = new conn();
            $conexion = $objeto->connect();
            $consulta="SELECT * from imgot where folio_orden='$orden' and mapaurl='img/nd.png'";
            $resultado = $conexion->prepare($consulta); 
            $resultado->execute();
            if ($resultado->rowCount()>0){
                $consulta = "UPDATE imgot set mapaurl='$archivo' WHERE folio_orden='$orden' and mapaurl='img/nd.png'";
                //$consulta = "INSERT INTO imgot (folio_orden,mapaurl) VALUES ('$orden','$archivo')";
                $resultado = $conexion->prepare($consulta); 
                if ($resultado->execute()) {
                    echo 1;
                } else {
                    echo 0;
                }
            }else{
                $consulta = "INSERT INTO imgot (folio_orden,mapaurl) VALUES ('$orden','$archivo')";
                $resultado = $conexion->prepare($consulta); 
                if ($resultado->execute()) {
                    echo 1;
                } else {
                    echo 0;
                }
            }
           


        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}


