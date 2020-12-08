<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$id_pros = (isset($_POST['IdCliente'])) ? $_POST['IdCliente'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$concepto = (isset($_POST['proyecto'])) ? $_POST['proyecto'] : '';
$ubicacion = (isset($_POST['ubicacion'])) ? $_POST['ubicacion'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '0';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '0';
$total = (isset($_POST['total'])) ? $_POST['total'] : '0';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '0';
$gtotal = (isset($_POST['gtotal'])) ? $_POST['gtotal'] : '0';

$concepto = $concepto;
$ubicacion = $ubicacion;

switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE tmp_pres SET id_pros='$id_pros' WHERE folio_pres='$folio' AND tokenid='$tokenid'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vtmppres WHERE folio_pres='$folio' AND tokenid='$tokenid'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $row){
            $id_cliente=$row['id_pros'];
        }
        if ($id_cliente==$id_pros){
            $data=1;
        }
        else{
            $data=0;
        }
        

        break;
        case 2:
            $consulta = "UPDATE tmp_pres SET id_pros='$id_pros',fecha_pres='$fecha',concepto_pres='$concepto',ubicacion='$ubicacion',subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal' WHERE folio_pres='$folio'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
            $consulta = "SELECT * FROM vtmppres WHERE folio_pres='$folio'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row){
                $id_cliente=$row['id_pros'];
            }
            if ($id_cliente==$id_pros){
                $data=1;
            }
            else{
                $data=0;
            }
        break;
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;


?>