<?php

class Router{
    private $rutas = [];
    public function path($ruta, $controller, $alias = null){
        $dirProject = "/SYS_PAPELETA_SALIDA";
        $this->rutas[] = [ $dirProject .$ruta, $controller, $alias];
    }

    public function load(){
        $verifLoadPage = false;
        foreach ($this->rutas as $ruta) {
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
    public function includePath($ruta){
        
    }
}
$router = new Router();

function redirect(){
    echo "redirect";
}