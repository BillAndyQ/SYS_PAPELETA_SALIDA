<?php

abstract class Controller {
    protected function get(){
        echo "solicitud GET no autorizada";
        exit();
    }
    protected function post(){
        echo "solicitud POST no autorizada";
        exit();
    }
    function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->get();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->post();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            echo "Estás realizando una solicitud PUT";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            echo "Estás realizando una solicitud DELETE";
        }
        $this->verifLogin();
    }
    protected function verifLogin(){
        if(isset($_SESSION['login'])){
            if($_SESSION['login'] == true){
                popUpCorrect("inició sesion!");
            }
            else{
                header("Location: https://".$_SERVER['HTTP_HOST']."/SYS_PAPELETA_SALIDA/login");
                exit();
            }
        }else{
            header("Location: https://".$_SERVER['HTTP_HOST']."/SYS_PAPELETA_SALIDA/login");
                exit();
        }
    }
}
