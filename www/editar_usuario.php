<?php

require_once "__twigLoad.php";

session_start();

$errors = array();
$data = array();

if (!isset($_SESSION['user'])) {
    array_push($errors, "No tienes permiso para entrar en esta página");
}
else {

    require_once "conexion.php";

    $data['user'] = $_SESSION['user'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email_ref = $data['user']['email'];

        $update_errors = $connection->updateUserInfo($email_ref, $_POST);

        if (!$update_errors) {
            // Obtenemos la información actualizada del usuario
            $_SESSION['user'] = $connection->getUser($email_ref);
            header("Location: index.php");
            exit();
        }
        else {
            $errors = array_merge($errors, $update_errors);
        }

    }

}

echo $twig->render('editar_usuario.twig', ['errors' => $errors, 'data' => $data]);

?>