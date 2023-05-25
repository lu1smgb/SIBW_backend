<?php

require_once "__twigLoad.php";
require_once "conexion.php";

$errors = array();
$data = array();

session_start();

if (isset($_SESSION['user'])) {

    $data['user'] = $_SESSION['user'];

    if ($_SESSION['user']['tipo'] == 'Administrador') {

        $data['user_list'] = $connection->getAllUsers();
        $data['roles'] = $connection->getRoles();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $update_errors = $connection->setUserRole((int)$_POST['user_id'], $_POST['tipo']);

            if (!$update_errors) {

                header("Location: index.php");
                exit();

            }
            else {
                $errors = array_merge($errors, $update_errors);
            }

        }
    }

    

}
else {
    array_push($errors, "No tiene permiso para acceder a esta página");
}

echo $twig->render('gestion_roles.twig', ['data' => $data, 'errors' => $errors]);

?>