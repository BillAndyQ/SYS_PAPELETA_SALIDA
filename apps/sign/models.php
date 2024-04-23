<?php
use config\Connect;
class User{
    private $user;
    private $type_user;
    private $nombres;
    private $apellidos;
    private $dni;
    private $email;
    private $area;
    private $oficina;

    public function authentication(){
        $connect = new Connect();
        $connectdb = $connect->connectBD();
        $consulta = $connectdb->prepare("SELECT pass_hash, pass_salt, username FROM users WHERE username COLLATE utf8mb4_bin = :user ;");
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $consulta->bindParam(':user', $username);
        $consulta->execute();
    
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultados) > 0) {
            // Obtener la contraseña hash y la sal
            $pass_hash = $resultados[0]['pass_hash'];
            $pass_salt = $resultados[0]['pass_salt'];

            $hash = crypt($password , $pass_salt);
            
            if ($hash === $pass_hash) {
                popUpCorrect("Acceso correcto!");
                $_SESSION['login'] = true;
            } else {
                popUpError("Datos incorrectos!");
            }
        } else {
            popUpError("Datos incorrectos!");
        }
    }

}

