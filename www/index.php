<?php

/*
    Fichero PHP encargado de renderizar la página principal

    Prácticas de SIBW
    Curso 2022/2023
    Autor: Luis Miguel Guirado Bautista
    Universidad de Granada

    https://github.com/lu1smgb/SIBW
*/

require_once "__twigLoad.php";
require_once "conexion.php";

session_start();

$connection = new Conexion();
$data = $connection->getIndexInfo();

echo $twig->render('index.twig', [ "data" => $data ]);

?>
