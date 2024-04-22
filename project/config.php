<?php

class Connect{
    private $db = "sys_papeleta_salida";
    private $host = "127.0.0.1";
    private $port = "3306";
    private $user = "root";
    private $pass = "deikyt2002";

    public function connectBD(){
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db}";
            $connectdb = new PDO($dsn, $this->user, $this->pass);

            $connectdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connectdb;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}

