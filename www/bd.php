<?php

/*

    Fichero PHP que hace de controlador para la aplicacion
    (Contiene funciones que interactúan con la base de datos)

    Prácticas de SIBW
    Curso 2022/2023
    Autor: Luis Miguel Guirado Bautista
    Universidad de Granada

    https://github.com/lu1smgb/SIBW
    
*/

    // Cambia el formato de la fecha de YYYY-MM-DD a DD/MM/YYYY
    function formatearFechaBiografia(string $fecha) {

        $fecha = str_replace('-','/',$fecha);
        $fecha = date('d/m/Y', strtotime($fecha));
        return $fecha;

    }

    // Formatea un timestamp de SQL al formato DD/MM/YYYY HH:MM
    function formatearFechaComentario(string $fecha) {

        return date('d/m/Y H:i', strtotime($fecha));

    }

    // Realiza una conexión con la base de datos y la devuelve para su uso posterior
    function conectar(string $usuario, string $contrasena) {

        $mysqli = new mysqli('lamp-mysql8', $usuario, $contrasena, 'SIBW');
        if ($mysqli->connect_errno) {
            echo ("Fallo al conectar: " . $mysqli->connect_error);
        }
        return $mysqli;

    }

    // Obtiene el nombre y la portada de todos los científicos
    function getMenu(mysqli $conexion) {

        $query = "SELECT nombre, portada FROM Cientifico";
        $res = $conexion->query($query);

        $menu = array();
        if ($res != false) {
            if ($res->num_rows > 0) {
                while (($row = $res->fetch_assoc()) != null) {
                    if ($row['portada'] == null) {
                        $row['portada'] = "default.png";
                    }
                    array_push($menu,$row);
                }
            }
            // else: No hay cientificos en la bd (no lanzar excepciones)
        }
        // else: Fallo en la consulta

        return $menu;

    }

    function getBotonesMenu(mysqli $conexion) {

        $query = "SELECT nombre, enlace FROM Menu";
        $res = $conexion->query($query);

        $menus = array();

        if ($res != false && $res->num_rows > 0) {
            while (($row = $res->fetch_assoc()) != null){
                array_push($menus, $row);
            }
        }

        return $menus;

    }

    // Obtiene los datos necesarios para mostrar la página de la biografía de un científico
    // (todos excepto la portada, que no es necesario)
    function getCientifico(mysqli $conexion, string $nombre) {

        $query = "SELECT nombre, fechaNacimiento, fechaDefuncion, lugarOrigen, biografia
                  FROM Cientifico WHERE nombre=" . "'" . $nombre . "'";
        $res = $conexion->query($query);

        // Datos a mostrar en caso de que el científico solicitado no exista
        $datos = null;

        if ($res != false && $res->num_rows > 0) {

            // Obtenemos los datos
            $row = $res->fetch_assoc();

            // Obtenemos la fecha de nacimiento
            $row['fechaNacimiento'] = formatearFechaBiografia($row['fechaNacimiento']);

            // Obtenemos la fecha de defuncion
            // Si no tiene, escribiremos 'Actualidad' en la vista
            $row['fechaDefuncion'] = ($row['fechaDefuncion'] == null) ?
                        'Actualidad' : formatearFechaBiografia($row['fechaDefuncion']);

            // Si no se ha especificado una biografía...
            if ($row['biografia'] == null) {
                $row['biografia'] = "(vacío)";
            }

            // Empaquetamos los datos
            $datos = array(
                'nombre' => $row['nombre'],
                'fechaNacimiento' => $row['fechaNacimiento'],
                'fechaDefuncion' => $row['fechaDefuncion'],
                'lugarOrigen' => $row['lugarOrigen'],
                'biografia' => $row['biografia']
            );
        }

        return $datos;

    }

    // Obtiene el identificador de un científico a partir de su nombre
    // Devuelve cero si el cientifico no existe o ocurrio un error en la BD
    function getIdCientifico(mysqli $conexion, string $nombre) {

        $query = "SELECT id FROM Cientifico WHERE nombre=" . "'" . $nombre . "'";
        $id = (int)$conexion->query($query)->fetch_assoc()['id'];
        return $id;

    }

    // Obtiene los sociales de cada cientifico
    function getSociales(mysqli $conexion, string $nombre) {

        $id_cientifico = getIdCientifico($conexion, $nombre);

        $query = "SELECT nombre, enlace FROM Social
                  WHERE id_cientifico=" . "'" . $id_cientifico . "'";
        $res = $conexion->query($query);

        $sociales = null;
        if ($res != false) {
            if ($res->num_rows > 0) {

                $sociales = array();

                while (($row = $res->fetch_assoc()) != null) {
                    array_push($sociales, $row);
                }

            }
        }
        else {
            $sociales = false; // Fallo la consulta
        }

        return $sociales;

    }

    // Obtiene los enlaces y la descripción de las fotos asociadas a la biografía de un científico
    // (concretamente de la tabla ImagenBiografia)
    function getFotosCientifico(mysqli $conexion, string $nombre) {

        $query = "SELECT Imagen.enlace, Imagen.descripcion FROM Imagen 
                  INNER JOIN ImagenBiografia ON Imagen.enlace=ImagenBiografia.enlace 
                  WHERE ImagenBiografia.id_cientifico=" . getIdCientifico($conexion, $nombre);
        $res = $conexion->query($query);

        $fotos = null;
        if ($res != false) {
            if ($res->num_rows > 0) {

                $fotos = array();
                while (($row = $res->fetch_assoc()) != null) {
                    array_push($fotos,$row);
                }

            }
        }
        else {
            $fotos = $res;
        }

        return $fotos;

    }

    // Obtiene los comentarios asociados a un científico
    function getComentarios(mysqli $conexion, string $cientifico) {

        $id_cientifico = getIdCientifico($conexion, $cientifico);
        $comentarios = null;

        if ($id_cientifico > 0) {

            $query = "SELECT Usuario.nombre, Comentario.fecha, Comentario.texto FROM Usuario
                      INNER JOIN Comentario ON Usuario.id=Comentario.id_usuario
                      WHERE Comentario.id_cientifico=" . "'" . $id_cientifico . "'" .
                      "ORDER BY Comentario.fecha DESC"; // Los comentarios más recientes irán primero
            $res = $conexion->query($query);

            if ($res != false) {
                if ($res->num_rows > 0) {

                    $comentarios = array();

                    while (($row = $res->fetch_assoc()) != null) {
                        $row['fecha'] = formatearFechaComentario($row['fecha']);
                        array_push($comentarios, $row);
                    }

                }
            }
            else {
                $comentarios = $res;
            }

        }

        return $comentarios;
    }

    // Obtiene las palabras prohibidas para los comentarios
    function getPalabrasProhibidas(mysqli $conexion) {

        $query = "SELECT palabra FROM PalabraProhibida";
        $res = $conexion->query($query);

        $palabras = null;
        if ($res != false) {
            if ($res->num_rows > 0) {

                $palabras = array();

                while (($row = $res->fetch_assoc()) != null) {
                    array_push($palabras, $row['palabra']);
                }

            }
        }
        else {
            $palabras = $res;
        }

        return $palabras;

    }

$conexion = conectar('usuario', 'usuario');
$menus = getBotonesMenu($conexion);

?>