<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$iditem = (isset($_POST['id_item'])) ? $_POST['id_item'] : '';
$umedida = (isset($_POST['umedida'])) ? $_POST['umedida'] : '';
$nom_mat = (isset($_POST['nom_mat'])) ? $_POST['nom_mat'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$largo = (isset($_POST['largo'])) ? $_POST['largo'] : '';
$alto = (isset($_POST['alto'])) ? $_POST['alto'] : '';
$ancho = (isset($_POST['ancho'])) ? $_POST['ancho'] : '';
$ubicacion = (isset($_POST['ubicacion'])) ? $_POST['ubicacion'] : '';
$metros = (isset($_POST['metros'])) ? $_POST['metros'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$cantidadm = $metros;
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


        $consulta = "INSERT INTO material (id_item,nom_mat,largo_mat,ancho_mat,alto_mat,cant_mat,id_umedida,m2_mat,ubi_mat,obs_mat) VALUES('$iditem','$nom_mat','$largo','$ancho','$alto','$cantidad','$umedida','$metros','$ubicacion','$obs')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vmaterial ORDER BY id_mat DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $row){
            $idmat=$row['id_mat'];
        }
      

        

        $consulta = "INSERT INTO detallecxp_mat (folio_cxp,id_mat,cant_mat,costo_mat,subtotal,usuario) values ('$folio','$idmat','$cantidadm','$costo','$subtotal','$usuario')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * from vdetallecxp_mat where folio_cxp='$folio' and id_mat='$idmat'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
  

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
