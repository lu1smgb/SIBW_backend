<?php

require_once "__twigLoad.php";
require_once "conexion.php";

$errors = array();

session_start();

$id_comm = 0;
if (isset($_GET['id'])) {
    $id_comm = abs((int)$_GET['id']);
}

$data = array();

// TODO: revisar

if (isset($_SESSION['user'])) {

    $id_usuario = $_SESSION['user']['id'];
    $id_comentador = $data['comentario']['id_usuario'];
    $rol = $_SESSION['user']['tipo'];
    $is_mod = $connection->checkUserRole($id_usuario, 'Moderador');
    $is_admin = $connection->checkUserRole($id_usuario, 'Administrador');

    if ($is_mod || $is_admin || $id_usuario == $id_comentador) {

        $data['comentario'] = $connection->getCommentById($id_comm);

        if (!$data['comentario']) {

            array_push($errors, "El comentario especificado no existe");

        }
        else if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $formateador = new DateFormatter();
            $data['comentario']['fecha'] = $formateador->comment($data['comentario']['fecha']);
            unset($formateador);

        }
        else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $texto = $_POST['texto'];
        
            if (!$texto) {
                array_push($errors, "El comentario está vacío");
            }
            else {
    
                $mod = $is_mod || $is_admin && $id_usuario != $id_comentador;
        
                $update_errors = $connection->updateComment($id_comm, $texto, $mod);
            
                if (!$update_errors) {
            
                    header("Location: cientifico.php?id=" . $data['comentario']['id_cientifico']);
                    exit();
            
                }
                else {
                    array_push($errors, $update_errors);
                }
            }
        
        }

    }
    else {
        array_push($errors, "No tienes permisos para acceder a esta página");
    }

}
else {
    array_push($errors, "No tienes permisos para acceder a esta página");
}

echo $twig->render('editar_comentario.twig', ['errors' => $errors, 'data' => $data]);

?>