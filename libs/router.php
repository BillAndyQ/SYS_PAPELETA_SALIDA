<?php
$rutas = [];
    
    function path($ruta, $controller, $alias = null){
        $dirProject = "/SYS_PAPELETA_SALIDA";
        global $rutas;
        $rutas[] = [ $dirProject .$ruta, $controller, $alias];
    }
    function redirect($nameRuta){
        global $rutas;
        foreach ($rutas as $ruta) {
            if($ruta[2]==$nameRuta){
                header("Location: http://".$_SERVER['HTTP_HOST']. $ruta[0]);
                exit();
            }
        }
    }
    function getRuta($nameRuta){
        global $rutas;
        foreach ($rutas as $ruta) {
            if($ruta[2]==$nameRuta){
                $url = "http://".$_SERVER['HTTP_HOST']. $ruta[0];
                echo $url;
            }
        }
    }
    function load(){
        
        $verifLoadPage = false;
        global $rutas;
        foreach ($rutas as $ruta) {
            $path = $ruta[0];
            $controller = $ruta[1];
            $urlActual= rtrim($_SERVER['REQUEST_URI'], "/");

            if($path == $urlActual){
                //Obtener app.controller
                if($posicion = strpos($controller, ".")){
                    $ref = explode(".", $controller);
                    require_once "./apps/". $ref[0] . "/controllers.php";
                    $controller = new $ref[1]();
                }else{
                    echo $controller;
                }
                $verifLoadPage = True;
                break;
            }else{
                $verifLoadPage = false;
            }
        }
        if(!$verifLoadPage){
            echo "Error 404";
            exit();
        }
    }



