<?php

/*
    Fichero PHP encargado de renderizar la página principal

    Prácticas de SIBW
    Curso 2022/2023
    Autor: Luis Miguel Guirado Bautista
    Universidad de Granada

    https://github.com/lu1smgb/SIBW
*/

require_once "/usr/local/lib/php/vendor/autoload.php";
include("bd.php");

$loader = new \Twig\Loader\FilesystemLoader('assets/templates');
$twig = new \Twig\Environment($loader);

$usuario = 'usuario';
$contrasena = 'usuario';
$conexion = conectar($usuario, $contrasena);
$datos = getMenu($conexion);

echo $twig->render('index.twig', [ "datos" => $datos, "menus" => $menus ]);

?>
