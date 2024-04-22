<?php

$router->path("", "sign.login", "login"); // ruta & app.controlador & name
$router->path("/login", "sign.login");
$router->path("/register", "sign.register");
$router->path("/boletasalida", "boleta_salida.boletaSalida");


