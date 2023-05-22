<?php

require_once "__twigLoad.php";
require_once "conexion.php";

$errors = array();
$data = array();

session_start();

$id = 0;
if (isset($_GET['id'])) {
    $id = abs((int)$_GET['id']);
}

$data = array();
$comentario = array();

// TODO: revisar

if (isset($_SESSION['user'])) {

    $data['user'] = $_SESSION['user'];
    $comentario = $connection->getCommentById($id);

    if ($data['user']['tipo'] == 'Moderador' || $data['user']['tipo'] == 'Administrador' || $data['user']['id'] == $comentario['id_usuario']) {
        $data['comentario'] = $comentario;
        if (!$data['comentario']) {
            array_push($errors, "El comentario especificado no existe");
        }
        else {
            $formateador = new DateFormatter();
            $data['comentario']['fecha'] = $formateador->comment($data['comentario']['fecha']);
            unset($formateador);
        }
    }
    else {
        array_push($errors, "No tienes permisos para acceder a esta página");
    }

}
else {
    array_push($errors, "No tienes permisos para acceder a esta página");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $texto = $_POST['texto'];

    if (!$texto) {
        array_push($errors, "El comentario está vacío");
    }
    else {

        if ($data['user']['tipo'] == 'Moderador' || $data['user']['tipo'] == 'Administrador' && $usuario['id'] != $comentario['id_usuario']) {
            $texto = "<i>Mensaje editado por un moderador</i>" . $texto;
        }

        $update_errors = $connection->updateComment($id, $texto);
    
        if (!$update_errors) {
    
            header("Location: cientifico.php?id=" . $comentario['id_cientifico']);
            exit();
    
        }
        else {
            array_push($errors, $update_errors);
        }
    }

}

echo $twig->render('editar_comentario.twig', ['errors' => $errors, 'data' => $data]);

?>