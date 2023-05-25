<?php

require_once "conexion.php";

session_start();

if (isset($_SESSION['user'])) {
    $id = (int)$_GET['id'];
    $id_user = (int)$_SESSION['user']['id'];
    $role = $_SESSION['user']['tipo'];
    if ($connection->checkUserRole($id_user, 'Gestor') || $connection->checkUserRole($id_user, 'Administrador')) {
        $connection->deleteScientist($id);
    }
}
header("Location: index.php");
exit();

?>