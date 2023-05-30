<?php

require_once "conexion.php";

session_start();
$id_cientifico = null;
if (isset($_GET['id'])) {
    $id_cientifico = (int)$_GET['id'];
}

if (isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = (int)$_SESSION['user']['id'];
    $texto = $_POST['texto'];
    if ($connection->uploadComment($id_usuario, $id_cientifico, $texto)) {
        header("Location: cientifico.php?id=" . $id_cientifico);
    }
    else {
        header("Location: index.php");
    }
    exit();
}

?>