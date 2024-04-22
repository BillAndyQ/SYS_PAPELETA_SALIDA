<?php

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
    public function generationUser(){
        $connect = new Connect();
        $connectdb = $connect->connectBD();

        $pass_salt = bin2hex(random_bytes(16));
        $pass_hash = crypt($_POST['password'] , $pass_salt);

        // Consulta SQL para insertar un nuevo usuario
        $sql = "INSERT INTO users (username, pass_hash, pass_salt, nombres, apellidos, dni, email, area, oficina) 
                VALUES (:username, :pass_hash, :pass_salt, :nombres, :apellidos, :dni, :email, :area, :oficina)";

        try {
            // Preparar la consulta
            $consulta = $connectdb->prepare($sql);
            $username = $_POST['username'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $dni = $_POST['dni'];
            $email = $_POST['email'];
            $area = $_POST['area'];
            $oficina = $_POST['oficina'];
            
            // Asignar valores a los parámetros
            $consulta->bindParam(':username', $username);
            $consulta->bindParam(':pass_hash', $pass_hash);
            $consulta->bindParam(':pass_salt', $pass_salt);
            $consulta->bindParam(':nombres', $nombres);
            $consulta->bindParam(':apellidos', $apellidos);
            $consulta->bindParam(':dni', $dni);
            $consulta->bindParam(':email', $email);
            $consulta->bindParam(':area', $area);
            $consulta->bindParam(':oficina', $oficina);

            // Ejecutar la consulta
            $connectdb->beginTransaction();
            $consulta->execute();
            $connectdb->commit();
            popUpCorrect("Usuario creado exitosamente!");

        } catch (PDOException $e) {
            $connectdb->rollBack();
            popUpError('Error al crear el nuevo usuario: ' . $e->getMessage());
        }
    }
}

