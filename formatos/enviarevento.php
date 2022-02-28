
<?php

include_once '../bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$correo="";
$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$consulta = "SELECT * from vcitamed where id='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
        
        $cliente=$rowdata['title'];
        $descripcion=$rowdata['descripcion'];
        $hora=$rowdata['start'];
        $ubicacion=$rowdata['obs'];
        $responsable=$rowdata['responsable'];
    }
}



$message  = "<html><body>";
   
$message .= "<h1>Cita de Toma de Plantilla</h1><br>";
   
$message .= "<h2>Cliente: <strong>".$cliente."</strong></h2>";
   
$message .= "<h2>Fecha y Hora: <strong>".$hora."</strong></h2>";
$message .= "<h2>Descripción: <strong>".$descripcion."</strong></h2>";
$message .= "<h2>Ubicacion: <strong>".$ubicacion."</strong></h2>";
$message .= "<h2>Responsable: <strong>".$responsable."</strong></h2>";

    

$message .= "</body></html>";




require '../plugins/phpmailer/class.phpmailer.php';
require '../plugins/phpmailer/class.smtp.php';
$mail = new PHPMailer();
$mail->isSMTP();

 
//Configuracion servidor mail
$mail->From = "calendario.gallerystone@gmail.com"; //remitente
$mail->SMTPAuth = true;

$mail->SMTPSecure = 'ssl'; //seguridad
$mail->Host = "smtp.gmail.com"; // servidor smtp
$mail->Port = 465; //puerto
$mail->Username ='calendario.gallerystone@gmail.com'; //nombre usuario
$mail->Password = 'Gs2022.1'; //contraseña
$mail->addAddress('calendario.gallerystone@gmail.com');

$mail->isHTML(true);

$mail->Subject = 'Cita de Toma de Plantilla';
$mail->Body = $message;

if ($mail->send()) {
    $mensaje = 1;
} else {
    $mensaje = 0;
}

if ($mensaje == 1) {
    $mensaje  = "<html><body>";
    $mensaje .= "<img src='../img/mailbien.png'>";
    $mensaje .= "</body></html>";
    
} else {
    $mensaje  = "<html><body>";
    $mensaje .= "<img src='../img/mailmal.png'>";
    $mensaje .= "</body></html>";
}
echo $mensaje;
$mail->clearAddresses();
$mail->clearAttachments();
$mail->SmtpClose();
unset($mail);


exit;

?>

<script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>