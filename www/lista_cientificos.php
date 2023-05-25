<?php

require_once "__twigLoad.php";
require_once "conexion.php";

session_start();

$data = array();
$errors = array();

if (isset($_SESSION['user']) && ($_SESSION['user']['tipo'] === 'Gestor' || $_SESSION['user']['tipo'] === 'Administrador')) {

    $data['user'] = $_SESSION['user'];
    $data['search'] = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST['search'] : null;
    $data['cientificos'] = $connection->getAllScientists($data['search']);

}
else {
    array_push($errors, "No tiene permiso para acceder a esta página");
}

echo $twig->render('lista_cientificos.twig', ['data' => $data, 'errors' => $errors]);

?>