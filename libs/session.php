<?php
    function verifLogin(){
        if(isset($_SESSION['login'])){
            if($_SESSION['login'] == true){
                popUpCorrect("inició sesion!");
            }
        }else{
            popUpAlert("Inicie sesion!");
            exit();
        }
    }