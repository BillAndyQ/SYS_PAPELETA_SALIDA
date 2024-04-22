<?php
    session_start();
    require_once "./libs/popUps.php"; //mensajes emergentes
    require_once "./project/config.php"; // configuracion DATABASE
    require_once "./libs/controller.php"; // Controladores
    require_once "./libs/model.php"; // Modelos
    require_once "./libs/session.php"; //Verificar login
    require_once "libs/router.php"; // Router
    require_once "project/urls.php"; // Rutas

    $router->load(); // Cargar rutas
    loadPopUp(); // cargar mensajes emergente

    // popUpCorrect("Solicitud POST"); //ejemplo popUp