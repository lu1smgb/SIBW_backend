<?php

    // Con este código cargamos una página HTML

    # Libreria TWIG
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    // TODO: Hacer el menu con respecto a la base de datos

    $usuario = 'usuario';
    $contrasena = 'usuario';
    $conexion = conectar($usuario, $contrasena);
    $datos = getMenu($conexion);

    echo $twig->render('index.html', [ "datos" => $datos ]);

?>
