<?php

// Cambia el formato de la fecha de Y-m-d a d/m/Y
function formatearFecha(string $fecha) {

    $fecha = str_replace('-','/',$fecha);
    $fecha = date('d/m/Y', strtotime($fecha));
    return $fecha;

}

function conectar(string $usuario, string $contrasena) {

    $mysqli = new mysqli('lamp-mysql8', $usuario, $contrasena, 'SIBW');
    if ($mysqli->connect_errno) {
        echo ("Fallo al conectar: " . $mysqli->connect_error);
    }
    return $mysqli;

}

function getCientifico(mysqli $conexion, string $nombre) {

    $query = "SELECT * FROM Cientifico WHERE nombre=" . "'" . $nombre . "'";
    $res = $conexion->query($query);

    $datos = array(
        'nombre' => 'Desconocido',
        'fechaNacimiento' => '??/??/????',
        'fechaDefuncion' => '??/??/????',
        'lugarOrigen' => 'Desconocido',
        'biografia' => 
            'El científico solicitado no existe, pruebe con otro'
    );

    if (gettype($res) != "boolean") {
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $datos = array(
                'nombre' => $row['nombre'],
                'fechaNacimiento' => formatearFecha($row['fechaNacimiento']),
                'fechaDefuncion' => formatearFecha($row['fechaDefuncion']),
                'lugarOrigen' => $row['lugarOrigen'],
                'biografia' => $row['biografia']
            );
        }
    }

    return $datos;

}

function getFotosCientifico(mysqli $conexion, string $nombre) {

    $query = "SELECT Imagen.enlace, Imagen.descripcion FROM Imagen 
              INNER JOIN ImagenBiografia ON Imagen.enlace=ImagenBiografia.enlace 
              WHERE ImagenBiografia.cientifico=" . "'" . $nombre . "'";
    $res = $conexion->query($query);

    $datos = array();
    if (gettype($res) != "boolean") {
        if ($res->num_rows > 0) {
            while (($row = $res->fetch_assoc()) != null) {
                array_push($datos,$row);
            }
        }
    }

    return $datos;

}

function getMenu(mysqli $conexion) {

    $query = "SELECT nombre, portada FROM Cientifico";
    $res = $conexion->query($query);

    $datos = array();
    if (gettype($res) != "boolean") {
        if ($res->num_rows > 0) {
            while (($row = $res->fetch_assoc()) != null) {
                array_push($datos,$row);
            }
        }
    }

    return $datos;

}

?>