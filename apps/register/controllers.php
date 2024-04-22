<?php
require_once "./apps/register/models.php";


class register extends Controller{
    function get(){
        popUpCorrect("Solicitud GET");
        require_once "./apps/register/views/register.php";
    }
    function post(){
        $user = new newUser();
        $user->generationUser();
        require_once "./apps/register/views/register.php";
    }
}