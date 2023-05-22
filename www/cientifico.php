<?php

/*

    Fichero PHP encargado de renderizar la página de la biografía

    Prácticas de SIBW
    Curso 2022/2023
    Autor: Luis Miguel Guirado Bautista
    Universidad de Granada

    https://github.com/lu1smgb/SIBW
    
*/

require "__twigLoad.php";
require "conexion.php";

$id = 0;
if (isset($_GET['id'])) {
    $id = abs((int)$_GET['id']);
}

$imprimir = false;
if (isset($_GET['imprimir'])) {
    $imprimir = $_GET['imprimir'];
    if ($imprimir == "true") {
        $imprimir = true;
    }
    else {
        $imprimir = false;
    }
}

session_start();
$data = $connection->getScientistInfo($id);

echo $twig->render('cientifico.twig', ["imprimir" => $imprimir, "data" => $data]);

?>
