<?php

require "__twigLoad.php";

$errors = array();

// Si se ha enviado el formulario de registro, verificamos todos los campos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "conexion.php";

    $registro = array(
        'nombre' => $_POST['nombre'],
        'email' => $_POST['email'],
        'password' => $_POST['password']
    );

    // Comprobamos el formulario
    if (!$registro['nombre']) {
        array_push($errors, "No se ha especificado el nombre de usuario");
    }

    if (!$registro['email']) {
        array_push($errors, "No se ha especificado el correo electrónico");
    }

    if (!$registro['password']) {
        array_push($errors, "No se ha especificado la contraseña");
    }
    else if (empty($_POST['repeat_pwd'])) {
        array_push($errors, "Por favor, repita la contraseña");
    }
    else if ($_POST['repeat_pwd'] !== $registro['password']) {
        array_push($errors, "Las contraseñas no coinciden");
    }    

    // Si no hay errores externos, realizamos el registro
    if (!$errors) {
        $reg_errors = $connection->register($registro);
        if ($reg_errors) {
            $errors = array_merge($errors, $reg_errors);
        }
        else {
            session_start();
            $_SESSION['user'] = $connection->getUser($registro['email']);
            header("Location: index.php");
            exit();
        }
    }

}

echo $twig->render('register.twig', ['errors' => $errors]);

?>