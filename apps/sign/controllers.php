<?php
require_once "./apps/sign/models.php";

class login extends Controller{
    function verifLogin(){}
    function get(){
        popUpCorrect("Solicitud GET");
        require_once "./apps/sign/views/login.php";
    }
    function post(){
        $auth = new User();
        $auth->authentication();
        require_once "./apps/sign/views/login.php";
    }
}
class register extends Controller{
    
    function get(){
        popUpCorrect("Solicitud GET");
        require_once "./apps/sign/views/register.php";
    }
    function post(){
        $auth = new User();
        $auth->generationUser();
        require_once "./apps/sign/views/register.php";
    }
}