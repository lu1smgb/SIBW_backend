<?php

    // Libreria TWIG
    require_once "/usr/local/lib/php/vendor/autoload.php";

    // Controlador
    include ("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    // TODO: Intentar usar URLS limpias
    $var = $_GET['nombre'];
    if (isset($var) && gettype($var) == 'string') {
        $nombre = $var;
    }
    else {
        $nombre = null;
    }

    $usuario = 'usuario';
    $contrasena = 'usuario';
    $conexion = conectar($usuario, $contrasena);
    $datos = getCientifico($conexion, $nombre);
    $imagenes = getFotosCientifico($conexion, $nombre);

    echo $twig->render('cientifico.html', [ 'datos' => $datos, "imagenes" => $imagenes ]);

?>
