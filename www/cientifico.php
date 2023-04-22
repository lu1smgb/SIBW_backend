<?php

/*

    Fichero PHP encargado de renderizar la página de la biografía

    Prácticas de SIBW
    Curso 2022/2023
    Autor: Luis Miguel Guirado Bautista
    Universidad de Granada

    https://github.com/lu1smgb/SIBW
    
*/

require_once "/usr/local/lib/php/vendor/autoload.php";
include ("bd.php");

$loader = new \Twig\Loader\FilesystemLoader('assets/templates');
$twig = new \Twig\Environment($loader);

// TODO: Intentar usar URLS limpias
$nombre = $_GET['nombre'];

$conexion = conectar('usuario', 'usuario');

$datos = array(
    'cientifico' => null,
    'sociales' => null,
    'imagenes' => null,
    'comentarios' => null,
    'palabras' => null
);

$datos['cientifico'] = getCientifico($conexion, $nombre);

if ($datos['cientifico'] == null) {
    $datos['cientifico'] = array(
        'nombre' => 'Error',
        'biografia' => 'El científico solicitado no existe, pruebe con otro'
    );
}
else {
    $datos['sociales'] = getSociales($conexion, $nombre);
    $datos['imagenes'] = getFotosCientifico($conexion, $nombre);
    $datos['comentarios'] = getComentarios($conexion, $nombre);
    $datos['palabras'] = getPalabrasProhibidas($conexion);
}

echo $twig->render('cientifico.twig', [
    'datos' => $datos, 'menus' => $menus
]);

?>
