<?php

require_once "conexion.php";

header('Content-Type: application/json');

if (array_key_exists('cadena', $_GET)) {

    session_start();

    $solo_publicados = true;

    if (array_key_exists('user', $_SESSION)){
        $tipo = $_SESSION['user']['tipo'];
        if ($tipo == 'Gestor' || $tipo == 'Administrador') {
            $solo_publicados = false;
        }
    }

    $result = $connection->getAllScientists($_GET['cadena'], $solo_publicados);

    echo(json_encode($result));

}

?>