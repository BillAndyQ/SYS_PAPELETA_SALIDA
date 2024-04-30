<?php
use config\Connect;
class User{
    private $login;
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
    public function generateToken($email){
        $randomBytes = random_bytes(40);
        $token = rtrim(strtr(base64_encode($randomBytes), '+/', '-_'), '=');
        
        $connect = new Connect();
        $connectdb = $connect->connectBD();

        $consulta = $connectdb->prepare("UPDATE users SET token = :token WHERE email = :email ");
        
        $consulta->bindParam(':token', $token, PDO::PARAM_LOB);
        $consulta->bindParam(':email', $email);
        $consulta->execute();

        $numFilasAfectadas = $consulta->rowCount();

        if ($numFilasAfectadas > 0) {
            return $token;

        } else {
            popUpError("El correo no es válido!");
            return null;
        }
    }
    public function verifToken($token){

    }
    public function newPass($token){
        $connect = new Connect();
        $connectdb = $connect->connectBD();

        $pass_salt = bin2hex(random_bytes(16));
        $pass_hash = crypt($_POST['password'] , $pass_salt);

        $sql = $connectdb->prepare("UPDATE users SET pass_salt = :pass_salt, pass_hash = :pass_hash WHERE token = :token");

        $sql->bindParam(":pass_salt", $pass_salt);
        $sql->bindParam(":pass_hash", $pass_hash);
        $sql->bindParam(":token", $token);

        $connectdb->beginTransaction();
        $sql->execute();
        $connectdb->commit();

        $numFilasAfectadas = $sql->rowCount();
        
        if ($numFilasAfectadas > 0) {
            $sql = $connectdb->prepare("UPDATE users SET token = null WHERE token = :token");
            $sql->bindParam(":token", $token);
            $connectdb->beginTransaction();
            $sql->execute();
            $connectdb->commit();
            
            popUpCorrect("Nueva contraseña registrada!");
        } else {
            popUpError("No se registro!");
        }
    }

}

