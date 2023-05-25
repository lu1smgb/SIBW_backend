<?php

require "conexion.php";

session_start();

if (isset($_SESSION['user'])) {
    $id = (int)$_GET['id'];
    $comment = $connection->getCommentById($id);
    $rol = $_SESSION['user']['tipo'];
    $id_sesion = $_SESSION['user']['id'];
    $id_comentador = $comment['id_usuario'];
    if ($connection->checkUserRole($id_sesion, 'Moderador') || $connection->checkUserRole($id_sesion, 'Administrador')) {
        if ($connection->deleteComment($id)) {
            header("Location: cientifico.php?id=" . $comment['id_cientifico']);
            exit();
        }
    }
}

?>