<?php

/*

    Fichero PHP encargado de renderizar la página de la biografía

    Prácticas de SIBW
    Curso 2022/2023
    Autor: Luis Miguel Guirado Bautista
    Universidad de Granada

    https://github.com/lu1smgb/SIBW
    
*/

require "twig_load.php";
require "conexion.php";

$id = 0;
if (array_key_exists('id', $_GET)) {
    $id = abs((int)$_GET['id']);
}

$imprimir = false;
if (array_key_exists('imprimir', $_GET)) {
    $imprimir = $_GET['imprimir'];
    if ($imprimir == "true") {
        $imprimir = true;
    }
    else {
        $imprimir = false;
    }
}

$connection = new Conexion();

$data = $connection->getScientistInfo($id);
echo $twig->render('cientifico.twig', ["id" => $id, "imprimir" => $imprimir, "data" => $data]);

?>
