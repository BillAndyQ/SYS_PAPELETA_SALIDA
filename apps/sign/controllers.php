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

        // generar Token
        $user = new User();
        $user->generateToken($_POST['email']);
        // try {
        //     $mail->CharSet = 'UTF-8';
        //     $mail->isSMTP();
        //     $mail->Host = 'smtp.gmail.com';  // Cambia 'smtp.example.com' por tu servidor SMTP
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'billandyqm@gmail.com'; // Tu dirección de correo electrónico de Gmail
        //     $mail->Password = 'opyu zyuy zgob vzbo'; // Tu contraseña de Gmail
        //     $mail->SMTPSecure = 'tls';
        //     $mail->Port = 587;
            
        //     $mail->setFrom('billandyqm@gmail.com', 'Bill Andy');
        //     $mail->addAddress('deikyt2002@gmail.com', '');

        //     $mail->Subject = 'RECUPERACION DE CONTRASEÑA UGEL';
        //     $mail->isHTML(true);
            
        //     $mail->Body = 'Recuperación de contraseña<br>Ruta';

        //     $mail->send();
            
        //     popUpCorrect("Correo de verificación enviado!");

        // } catch (Exception $e) {
        //     popUpAlert("El correo no es válido");
        // }
        require_once "./apps/sign/views/forget_pass.php";
    }
}

class newPass extends Controller{
    function verifLogin(){}
    function get()
    {
        if(isset($_GET['token'])){
            echo "Genera nueva contraseña";
            require_once "./apps/sign/views/new_pass.php";
        }else{
            redirect("login");
        }
    }
    function post()
    {
        
    }
}