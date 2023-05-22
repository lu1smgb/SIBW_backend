<?php

require "conexion.php";

session_start();

if (isset($_SESSION['user'])) {
    $id = (int)$_GET['id'];
    $comment = $connection->getCommentById($id);
    if ($_SESSION['user']['tipo'] == 'Administrador' || $_SESSION['user']['tipo'] == 'Moderador' || $_SESSION['user']['id'] == $comment['id_usuario']) {
        if ($connection->deleteComment($id)) {
            header("Location: cientifico.php?id=" . $comment['id']);
            exit();
        }
    }
}

?>