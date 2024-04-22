<?php

class newUser{
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

            if("" == $_POST['username'] ||
            "" == $_POST['nombres'] ||
            "" == $_POST['apellidos'] ||
            "" == $_POST['dni'] ||
            "" == $_POST['email'] ||
            "" == $_POST['area'] ||
            "" == $_POST['oficina']){
                popUpAlert("Complete todos los campos!");
            }else{
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
            }
            


        } catch (PDOException $e) {
            $connectdb->rollBack();
            popUpError('Error al crear el nuevo usuario: ' . $e->getMessage());
        }
    }
}