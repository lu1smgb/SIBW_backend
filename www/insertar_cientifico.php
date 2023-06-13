<?php

require_once "__twigLoad.php";
require_once "conexion.php";

session_start();

$errors = array();
$data = $connection->getCommonPageInfo();

if (isset($_SESSION['user'])) {

    $data['user'] = $_SESSION['user'];
    $id_usuario = $data['user']['id'];
    $rol = $data['user']['tipo'];

    if ($connection->checkUserRole($id_usuario, 'Gestor') || $connection->checkUserRole($id_usuario, 'Administrador')) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data['formulario'] = array();

            // NOMBRE
            if ($_POST['nombre']) {
                $data['formulario']['nombre'] = $_POST['nombre'];
            }
            else {
                $data['formulario']['nombre'] = null;
            }

            // FECHA DE NACIMIENTO
            if ($_POST['fechaNacimiento']) {
                $data['formulario']['fechaNacimiento'] = $_POST['fechaNacimiento'];
            }
            else {
                $data['formulario']['fechaNacimiento'] = null;
            }

            // FECHA DE DEFUNCION
            // Comprueba si la casilla está marcada
            $fallecido = isset($_POST['haFallecido']);
            $data['formulario']['fechaDefuncion'] = $fallecido ? $_POST['fechaDefuncion'] : null;

            if ($_POST['lugarOrigen']) {
                $data['formulario']['lugarOrigen'] = $_POST['lugarOrigen'];
            }
            else {
                $data['formulario']['lugarOrigen'] = null;
            }

            // BIOGRAFIA
            if ($_POST['biografia']) {
                $data['formulario']['biografia'] = $_POST['biografia'];
            }
            else {
                $data['formulario']['biografia'] = null;
            }

            // NOMBRE DE LAS REDES SOCIALES + ENLACES
            if (array_key_exists('nombre-social', $_POST)) {
                $data['formulario']['sociales'] = array_combine($_POST['nombre-social'], $_POST['enlace-social']);
            }
            else {
                $data['formulario']['sociales'] = null;
            }
            
            // HASHTAGS / ETIQUETAS
            $data['formulario']['hashtags'] = !empty($_POST['nombre-hashtag']) ? $_POST['nombre-hashtag'] : null;

            $data['formulario']['visibilidad'] = $_POST['visibilidad'] == 'visible' ? 1 : 0;

            // PORTADA DEL CIENTIFICO
            $data['formulario']['portada'] = null;

            $data['formulario']['imagenes'] = null;

            // Utilizaremos este array para introducir los nombres de los ficheros en la base de datos
            $img_filenames = array();

            if (isset($_FILES['portada-cientifico']) && !$_FILES['portada-cientifico']['error']) {

                $portada_errors = array();
                $portada_name = $_FILES['portada-cientifico']['name'];
                $portada_size = $_FILES['portada-cientifico']['size'];
                $portada_tmp = $_FILES['portada-cientifico']['tmp_name'];
                $portada_type = $_FILES['portada-cientifico']['type'];

                if (!$connection->hasValidImageExtension($portada_name)) {

                    array_push($portada_errors, "La extensión de la portada no es válida");

                }

                if (!$connection->hasValidImageSize($portada_size)) {

                    array_push($portada_errors, "Tamaño de la portada demasiado grande");

                }

                if (empty($portada_errors)) {

                    $data['formulario']['portada'] = array(
                        'filename' => $portada_name,
                        'tmp' => $portada_tmp
                    );

                }

                $errors = array_merge($errors, $portada_errors);

            }

            // IMAGENES DEL CIENTIFICO
            if (isset($_FILES['imagen-cientifico']) && !$_FILES['imagen-cientifico']['error'][0]) {

                $data['formulario']['imagenes'] = array();
                echo var_dump($_FILES['imagen-cientifico']);

                for ($i = 0; $i < sizeof($_FILES['imagen-cientifico']['name']); $i++) {

                    echo var_dump($i);
                    $img_errors = array();
                    $img_name = $_FILES['imagen-cientifico']['name'][$i];
                    $img_size = $_FILES['imagen-cientifico']['size'][$i];
                    $img_tmp = $_FILES['imagen-cientifico']['tmp_name'][$i];
                    $img_type = $_FILES['imagen-cientifico']['type'][$i];
                    $img_desc = $_POST['pie'][$i];

                    if (!$connection->hasValidImageExtension($img_name)) {

                        array_push($img_errors, "La extensión de la imagen número " . $i . " no es válida");
    
                    }
    
                    if (!$connection->hasValidImageSize($img_size)) {
    
                        array_push($img_errors, "Tamaño de la imagen número " . $i . " demasiado grande");
    
                    }

                    if (empty($img_errors)) {

                        array_push($data['formulario']['imagenes'], [
                            'filename' => $img_name,
                            'tmp' => $img_tmp,
                            'desc' => $img_desc
                        ]);
    
                    }

                    $errors = array_merge($errors, $img_errors);

                }

            }

            // Si no existe ningún error con los datos proporcionados, los subimos a la base de datos
            if (!$errors) {

                $db_errors = $connection->addScientist($data['formulario']);
                if (!$db_errors) {

                    header("Location: index.php");
                    exit();

                }
                else {

                    $errors = array_merge($db_errors, $errors);

                }
            
            }

        }        

    }
    else {

        array_push($errors, "No tiene permiso para entrar a esta página");

    }

}
else {

    array_push($errors, "No tiene permiso para entrar a esta página");

}

echo $twig->render('insertar_cientifico.twig', ['data' => $data, 'errors' => $errors])

?>