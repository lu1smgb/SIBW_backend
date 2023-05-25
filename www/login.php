<?php

require_once "__twigLoad.php";

$errors = array();

session_start();

// Accion a realizar cuando el usuario haya completado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "conexion.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($connection->checkLogin($email, $password)) {
        
        $_SESSION['user'] = $connection->getUserByEmail($email);

        //! inseguro, preguntar al profesor
        header("Location: index.php");
        exit();

    }
    else {
        array_push($errors, "No se ha podido iniciar sesión, inténtelo de nuevo");
    }

}

echo $twig->render('login.twig', ['errors' => $errors]);

?>