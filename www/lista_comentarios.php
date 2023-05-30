<?php

require_once "__twigLoad.php";
require_once "conexion.php";

$data = $connection->getCommonPageInfo();
$errors = array();

session_start();

if (isset($_SESSION['user']) && ($_SESSION['user']['tipo'] === 'Moderador' || $_SESSION['user']['tipo'] === 'Administrador')) {

    // todo Sugerencia: tabla que registre los comentarios modificados por los moderadores
    $data['user'] = $_SESSION['user'];
    $data['comentarios'] = $connection->getAllComments();
    // todo opcional busqueda de comentarios

}
else {
    array_push($errors, "No tiene permiso para entrar a esta página");
}

echo $twig->render('lista_comentarios.twig', ['data' => $data, 'errors' => $errors]);

?>