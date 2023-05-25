<?php

require_once "__twigLoad.php";

session_start();

$errors = array();
$data = array();

if (!isset($_SESSION['user'])) {
    array_push($errors, "Inicie sesión antes de editar su información de usuario");
}
else {

    require_once "conexion.php";

    $data['user'] = $_SESSION['user'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user_id = $data['user']['id'];

        $update_errors = $connection->updateUserInfo($user_id, $_POST);

        if (!$update_errors) {
            // Obtenemos la información actualizada del usuario
            $_SESSION['user'] = $connection->getUserById($user_id);
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