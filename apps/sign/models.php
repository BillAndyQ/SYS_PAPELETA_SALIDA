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
        
        echo $email;
        $connect = new Connect();
        $connectdb = $connect->connectBD();

        $consulta = $connectdb->prepare("UPDATE users SET token = :token WHERE email = bill@gmail.com ");
        
        $consulta->bindParam(':token', $token, PDO::PARAM_LOB);
        // $consulta->bindParam(':email', $email);

        $numFilasAfectadas = $consulta->rowCount();

        if ($numFilasAfectadas > 0) {
            echo "La actualización se realizó correctamente. Filas afectadas: " . $numFilasAfectadas;
        } else {
            echo "No se realizó ninguna actualización. No se encontraron filas para actualizar.";
        }

        $connectdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return "Token seguro: " . $token;
    }

}

