<?php

function main() {
    try {
        require_once "./project/__init__.php"; // Cargar projecto
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
main();

