<?php

/*

    Fichero PHP que hace de controlador para la aplicacion
    (Contiene funciones que interactúan con la base de datos)
    Version actualizada (posterior a defensa)

    Prácticas de SIBW
    Curso 2022/2023
    Autor: Luis Miguel Guirado Bautista
    Universidad de Granada

    https://github.com/lu1smgb/SIBW
    
*/

require "date_formatter.php";

class Conexion
{
    private DateFormatter $date_form;
    private mysqli $connection;

    // todo: prepare --- methods bind_param execute get_result close 

    public function __construct()
    {
        $this->date_form = new DateFormatter();
        $username = 'usuario';
        $password = $username;
        $this->connection = new mysqli('lamp-mysql8', $username, $password, 'SIBW');
        if ($this->connection->connect_errno) {
            echo ("Fallo al conectar: " . $this->connection->connect_error);
        }
    }

    // Obtiene el nombre y la portada de todos los científicos
    private function getMenu() : array | false
    {

        $query = "SELECT id, nombre, portada FROM Cientifico";
        $res = $this->connection->query($query);

        $ret = array();
        if ($res != false) {
            if ($res->num_rows > 0) {
                while (($row = $res->fetch_assoc()) != null) {
                    if ($row['portada'] == null) {
                        $row['portada'] = "default.png";
                    }
                    array_push($ret,$row);
                }
            }
        }
        else {
            $ret = false;
        }

        return $ret;

    }

    private function getNavbar() : array | false
    {

        $query = "SELECT nombre, enlace FROM Menu";
        $res = $this->connection->query($query);

        $ret = array();
        if ($res != false) {
            if ($res->num_rows > 0) {
                while (($row = $res->fetch_assoc()) != null){
                    array_push($ret, $row);
                }
            }
        }
        else {
            $ret = false;
        }

        return $ret;

    }

    // Obtiene los datos necesarios para mostrar la página de la biografía de un científico
    // (todos excepto la portada, que no es necesario)
    private function getScientist(int $id) : array | false
    {

        $query = "SELECT nombre, fechaNacimiento, fechaDefuncion, lugarOrigen, biografia
                  FROM Cientifico WHERE id=?";

        $stm = $this->connection->prepare($query);
        $stm->bind_param("i", $id);
        $stm->execute();
        $res = $stm->get_result();

        // Datos a mostrar en caso de que el científico solicitado no exista
        $ret = array();

        if ($res != false) {

            if ($res->num_rows > 0) {
                // Obtenemos los datos
                $row = $res->fetch_assoc();

                // Obtenemos la fecha de nacimiento
                $row['fechaNacimiento'] = $this->date_form->common($row['fechaNacimiento']);

                // Obtenemos la fecha de defuncion
                // Si no tiene, escribiremos 'Actualidad' en la vista
                if ($row['fechaDefuncion'] == null) {
                    $row['fechaDefuncion'] = "Actualidad";
                }
                else {
                    $row['fechaDefuncion'] = $this->date_form->common($row['fechaDefuncion']);
                }

                // Si no se ha especificado una biografía...
                if ($row['biografia'] == null) {
                    $row['biografia'] = "Esta biografía está vacía";
                }

                // Empaquetamos los datos
                $ret = $row;
            }

        }
        else {
            $ret = false;
        }

        return $ret;

    }

    // Obtiene los sociales de cada cientifico
    private function getSocials(int $id) : array | false
    {

        $query = "SELECT nombre, enlace FROM Social WHERE id_cientifico=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("i", $id);
        $smt->execute();
        $res = $smt->get_result();

        $ret = array();
        if ($res != false) {
            if ($res->num_rows > 0) {
                while (($row = $res->fetch_assoc()) != null) {
                    array_push($ret, $row);
                }
            }
        }
        else {
            $ret = false;
        }

        return $ret;

    }

    // Obtiene los enlaces y la descripción de las fotos asociadas a la biografía de un científico
    // (concretamente de la tabla ImagenBiografia)
    private function getScientistImages(int $id) : array | false
    {

        $query = "SELECT Imagen.enlace, ImagenBiografia.descripcion FROM Imagen 
                  INNER JOIN ImagenBiografia ON Imagen.enlace=ImagenBiografia.enlace 
                  WHERE ImagenBiografia.id_cientifico=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("i", $id);
        $smt->execute();
        $res = $smt->get_result();

        $ret = array();
        if ($res != false) {
            if ($res->num_rows > 0) {

                while (($row = $res->fetch_assoc()) != null) {
                    array_push($ret,$row);
                }

            }
        }
        else {
            $ret = $res;
        }

        return $ret;

    }

    // Obtiene los comentarios asociados a un científico
    private function getComments(int $id) : array | false
    {

        $comentarios = array();

        // Comprobamos que el id es positivo
        if ($id > 0) {

            // Realizamos la consulta
            // Los comentarios más recientes irán primero
            $query = "SELECT Usuario.nombre, Comentario.fecha, Comentario.texto FROM Usuario
                        INNER JOIN Comentario ON Usuario.id=Comentario.id_usuario
                        WHERE Comentario.id_cientifico=? ORDER BY Comentario.fecha DESC";
            $smt = $this->connection->prepare($query);
            $smt->bind_param("i", $id);
            $smt->execute();
            $res = $smt->get_result();

            if ($res != false) {
                if ($res->num_rows > 0) {

                    while (($row = $res->fetch_assoc()) != null) {
                        $row['fecha'] = $this->date_form->comment($row['fecha']);
                        array_push($comentarios, $row);
                    }

                }
            }
            else {
                $comentarios = false;
            }

        }
        else {
            $comentarios = false;
        }

        return $comentarios;
    }

    // Obtiene las palabras prohibidas para los comentarios
    private function getForbiddenWords() : array | false
    {

        $query = "SELECT palabra FROM PalabraProhibida";
        $res = $this->connection->query($query);

        $ret = array();
        if ($res != false) {
            if ($res->num_rows > 0) {

                while (($row = $res->fetch_assoc()) != null) {
                    array_push($ret, $row['palabra']);
                }

            }
        }
        else {
            $ret = false;
        }

        return $ret;

    }

    // TODO: Incluir metodos para conseguir directamente la informacion de cada una de las paginas?

    private function getCommonPageInfo()
    {
        return array(
            'menus' => $this->getNavbar()
        );
    }

    public function getIndexInfo()
    {
        $info = array(
            'cientificos' => $this->getMenu()
        );

        $ret = array_merge($info, $this->getCommonPageInfo());

        return $ret;
    }

    public function getScientistInfo(int $id)
    {
        $info = array(
            'cientifico' => $this->getScientist($id)
        );
        
        if ($info['cientifico'] === false) {
            $info['cientifico'] = array(
                'nombre' => "Error",
                "biografia" => "Fallo al conectar al servidor"
            );
        }
        else if (sizeof($info['cientifico']) <= 0) {
            $info['cientifico'] = array(
                'nombre' => "Error",
                "biografia" => "El cientifico solicitado no existe"
            );
        }
        else {
            $info['sociales'] = $this->getSocials($id);
            $info['imagenes'] = $this->getScientistImages($id);
            $info['comentarios'] = $this->getComments($id);
            $info['palabras'] = $this->getForbiddenWords();
        }

        $ret = array_merge($info, $this->getCommonPageInfo());

        return $ret;

    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

?>