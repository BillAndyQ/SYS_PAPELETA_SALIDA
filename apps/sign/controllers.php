<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "./apps/sign/models.php";
require './libs/PHPMailer/src/Exception.php';
require './libs/PHPMailer/src/PHPMailer.php';
require './libs/PHPMailer/src/SMTP.php';


class login extends Controller{
    function verifLogin(){}
    function get(){
        popUpCorrect("Solicitud GET");
        require_once "./apps/sign/views/login.php";
    }
    function post(){
        $user = new User();
        $user->authentication();
        require_once "./apps/sign/views/login.php";
    }
}
class forgetPass extends Controller{
    function verifLogin(){}
    function get(){
        popUpCorrect("Solicitud GET");
        require_once "./apps/sign/views/forget_pass.php";
    }
    function post(){
        $mail = new PHPMailer(true);
        require_once "./apps/sign/views/forget_pass.php";

        // generar Token
        $user = new User();
        $email = $_POST['email'];
        $token = $user->generateToken($email);

        if($token!=null){
        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Cambia 'smtp.example.com' por tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'billandyqm@gmail.com'; // Tu dirección de correo electrónico de Gmail
            $mail->Password = 'opyu zyuy zgob vzbo'; // Tu contraseña de Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            $mail->setFrom('billandyqm@gmail.com', 'Bill Andy');
            $mail->addAddress($email, '');

            $mail->Subject = 'RECUPERACION DE CONTRASEÑA UGEL';
            $mail->isHTML(true);
            $ruta = getRuta("new_pass"). "/?token=" . $token;
            $msj = 'Recuperación de contraseña<br><a href="'. $ruta .'">Click para Crear nueva contraseña</a>';
            $mail->Body = $msj;

            $mail->send();
            
            popUpCorrect("Correo de verificación enviado!");

        } catch (Exception $e) {
            popUpAlert("El correo no es existe");
        }
        }
    }
}

class newPass extends Controller{
    function verifLogin(){}
    function get()
    {
        if(isset($_GET['token'])){
            require_once "./apps/sign/views/new_pass.php";
        }else{
            redirect("login");
        }
    }
    function post()
    {
        if(isset($_GET['token'])){
            $token = $_GET['token'];
            $user = new User();
            $user->newPass($token);
            redirect("login");
        }else{
            redirect("login");
        }
    }
}