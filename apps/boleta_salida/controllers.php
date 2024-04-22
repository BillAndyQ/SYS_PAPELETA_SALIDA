<?php
class boletaSalida extends Controller{
    function get(){
        popUpCorrect("Solicitud GET");
        require_once "./apps/boleta_salida/views/boleta_salida.php";
    }
    function post(){
        require_once "./apps/boleta_salida/views/boleta_salida.php";
    }
}