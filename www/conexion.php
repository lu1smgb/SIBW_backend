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
    // MAXIMO 5 MBytes
    private const MAX_FILESIZE = 40000000;
    // Esta ruta debe partir desde las plantillas TWIG
    private const PHP_IMAGE_DIR = 'assets/images/';
    private const TWIG_IMAGE_DIR = '../images/';
    public const FRONT_IMG_FILENAME = 'default.png';
    private DateFormatter $date_form;
    private mysqli $connection;

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

        $query = "SELECT id, nombre, portada FROM Cientifico WHERE publicado = 1";
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

        $query = "SELECT id, nombre, fechaNacimiento, fechaDefuncion, lugarOrigen, biografia, publicado
                  FROM Cientifico WHERE id=?";

        $stm = $this->connection->prepare($query);
        $stm->bind_param("i", $id);
        $stm->execute();
        $res = $stm->get_result();
        $stm->close();

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
    private function getScientistSocials(int $id) : array | false
    {

        $query = "SELECT nombre, enlace FROM Social WHERE id_cientifico=?";
        $stm = $this->connection->prepare($query);
        $stm->bind_param("i", $id);
        $stm->execute();
        $res = $stm->get_result();
        $stm->close();

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
        $stm = $this->connection->prepare($query);
        $stm->bind_param("i", $id);
        $stm->execute();
        $res = $stm->get_result();
        $stm->close();

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
    private function getScientistComments(int $id) : array | false
    {

        $comentarios = array();

        // Comprobamos que el id es positivo
        if ($id > 0) {

            // Realizamos la consulta
            // Los comentarios más recientes irán primero
            $query = "SELECT Comentario.id, Usuario.nombre, Usuario.email, Comentario.fecha, Comentario.texto, Comentario.moderado 
                      FROM Usuario INNER JOIN Comentario ON Usuario.id=Comentario.id_usuario
                      WHERE Comentario.id_cientifico=? ORDER BY Comentario.fecha DESC";
            $stm = $this->connection->prepare($query);
            $stm->bind_param("i", $id);
            $stm->execute();
            $res = $stm->get_result();
            $stm->close();

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
    public function getForbiddenWords() : array | false
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

    // Es importante abrir antes una cookie en la página de origen antes de llamar a esta función
    public function getCommonPageInfo() : array
    {
        $data = array();
        $data['user'] = (isset($_SESSION['user'])) ? $_SESSION['user'] : null;
        $data['menus'] = $this->getNavbar();
        return $data;
    }

    public function getIndexInfo() : array
    {
        $info = array(
            'cientificos' => $this->getMenu()
        );

        $ret = array_merge($info, $this->getCommonPageInfo());

        return $ret;
    }

    public function getScientistInfo(int $id) : array
    {
        $info = array(
            'id' => $id,
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
            $info['sociales'] = $this->getScientistSocials($id);
            $info['imagenes'] = $this->getScientistImages($id);
            $info['comentarios'] = $this->getScientistComments($id);
            $info['palabras'] = $this->getForbiddenWords();
            $info['hashtags'] = $this->getHashtags($id);
        }

        $ret = array_merge($info, $this->getCommonPageInfo());

        return $ret;

    }

    private function isValidUsername(string $username) : bool 
    {
        return preg_match("/^[a-z0-9-_\s]{8,32}$/i", $username);
    }

    private function isValidEmail(string $email) : bool 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function isValidPassword(string $pwd) : bool
    {
        return preg_match("/^[a-zA-Z\d@#$%&\/\\\(\)\=\!~_-]{8,32}$/", $pwd);
    }

    private function generatePasswordHash(string $pwd) : string | false
    {
        return password_hash($pwd, PASSWORD_DEFAULT);
    }

    public function checkUserRole(int $id, string $role) : bool
    {
        $query = "SELECT * FROM Usuario WHERE id=? AND tipo=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("is", $id, $role);
        if (!$smt->execute()) {
            return false;
        }
        return ($smt->get_result()->num_rows > 0);
    }

    // Comprueba que el usuario con el email tiene la contraseña especificada
    public function checkLogin(string $email, string $password) : bool {

        if (!$this->isValidEmail($email) or !$this->isValidPassword($password)) {
            return false;
        }
    
        $query = "SELECT pwd FROM Usuario WHERE email=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("s", $email);
        $smt->execute();
        $res = $smt->get_result()->fetch_assoc();
        $smt->close();

        return password_verify($password, $res['pwd']);

    }

    // Obtiene los datos del usuario a partir de su email
    public function getUserById(int $id) {

        $query = "SELECT id, email, nombre, tipo FROM Usuario WHERE id=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("i", $id);
        $smt->execute();
        $res = $smt->get_result()->fetch_assoc();

        $smt->close();

        return $res;

    }

    public function getUserByEmail(string $email) {

        if (!$this->isValidEmail($email)) {
            return false;
        }

        $query = "SELECT id, email, nombre, tipo FROM Usuario WHERE email=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("s", $email);
        $smt->execute();
        $res = $smt->get_result()->fetch_assoc();

        $smt->close();

        return $res;

    }

    private function emailExists(string $email) : bool
    {
        $query = "SELECT email FROM Usuario WHERE email=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("s", $email);
        $smt->execute();
        return $smt->get_result()->num_rows > 0;
    }

    private function verifyUserRegisterInput(array $data) {

        $errors = array();
        
        if (isset($data['nombre'])) {

            // https://regex101.com
            // El nombre tendra que comenzar por una letra
            // Puede contener numeros, guiones, guiones bajos y espacios
            // Debe tener entre 8 y 32 caracteres
            if (!$this->isValidUsername($data['nombre'])) {

                array_push($errors, "El nombre de usuario no es válido");

            }

        }
        else {

            array_push($errors, "No se ha especificado un nombre de usuario");

        }
    
        if (isset($data['email'])) {

            // Verificamos si es un email válido
            if (!$this->isValidEmail($data['email'])) {

                array_push($errors, "El correo electrónico no es válido");

            }
            else {

                // Comprobamos si el email existe en la BD
                if ($this->emailExists($data['email'])) {

                    array_push($errors, "El correo electrónico ya está en uso");

                }

            }

        }
        else {

            array_push($errors, "No se ha especificado el correo electrónico");

        }
    
        if (isset($data['password'])) {

            // https://regex101.com
            // La contraseña debe tener entre 8 y 32 caracteres
            // Puede tener los siguientes caracteres especiales: @ # $ % & / \ ( ) = ! ~
            if (!$this->isValidPassword($data['password'])) {

                array_push($errors, "La contraseña no es válida");

            }

        }
        else {

            array_push($errors, "No se ha especificado la contraseña");

        }

        return $errors;

    }

    // Registra a un usuario en la base de datos
    // Los parámetros irán en un array con las siguientes claves
    // - nombre: Nombre del nuevo usuario, debe seguir las pautas de abajo
    // - email: Email del nuevo usuario, no debe estar presente en la BD y debe seguir las pautas de abajo
    // - password: Contraseña del nuevo usuario
    // Los usuarios registrados por este método serán simplemente usuarios
    public function register(array $data) : array
    {
        
        $errors = $this->verifyUserRegisterInput($data);

        // Si todo esta correcto, procedemos a registrar el usuario
        if (!$errors) {

            $register = array(
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'password' => $this->generatePasswordHash($data['password'])
            );

            if (!$register['password']) {
                array_push($errors, "Error al encriptar la contraseña, contacte con el administrador");
                return $errors;
            }

            $query = "INSERT INTO Usuario(nombre, email, pwd) VALUES (?,?,?)";
            $smt = $this->connection->prepare($query);
            $smt->bind_param("sss", $register['nombre'], $register['email'], $register['password']);

            if (!$smt->execute()) {
                array_push($errors, "No se ha podido registrar al usuario en el sistema, contacte con el administrador");
            }

            $smt->close();

        }

        return $errors;
    }

    private function verifyUserUpdateInput(array $data) : array {

        $errors = array();

        if ($data['nombre']) {

            if (!$this->isValidUsername($data['nombre'])) {

                array_push($errors, "El nombre de usuario no es válido");
                    
            }

        }
        else {
            array_push($errors, "No se ha introducido el nombre de usuario");
        }

        if ($data['email']) {

            if (!$this->isValidEmail($data['email'])) {

                array_push($errors, "El correo electrónico no es válido");

            }

        }
        else {

            array_push($errors, "No se ha introducido el email");

        }

        if ($data['password']) {

            if (!$this->isValidPassword($data['password'])) {

                array_push($errors, "La contraseña nueva introducida no es válida");

            }
            else if ($data['password'] !== $data['repeat_pwd']) {

                array_push($errors, "Las contraseñas no coinciden");

            }

        }

        if ($data['old_pwd']) {

            if (!$this->checkLogin($data['email'], $data['old_pwd'])) {

                array_push($errors, "La contraseña actual introducida no es correcta");

            }

        }
        else {

            array_push($errors, "No se ha introducido la contraseña actual");

        }

        return $errors;

    }

    public function updateUserInfo(int $id, array $values) : array
    {

        $errors = array();

        $input_errors = $this->verifyUserUpdateInput($values);
        $errors = array_merge($errors, $input_errors);

        if (!$errors) {

            $update = $values;
            $smt = null;

            if (!$update['password']) {
                $query = "UPDATE Usuario SET nombre=?, email=? WHERE id=?";
                $smt = $this->connection->prepare($query);
                $smt->bind_param("ssi", $update['nombre'], $update['email'], $id);
            }
            else {
                $update['password'] = $this->generatePasswordHash($update['password']);
                if (!$update['password']) {
                    array_push($errors, "No se ha podido encriptar la nueva contraseña, contacte al administrador");
                    return $errors;
                }
                $query = "UPDATE Usuario SET nombre=?, email=?, pwd=? WHERE id=?";
                $smt = $this->connection->prepare($query);
                $smt->bind_param("sssi", $update['nombre'], $update['email'], $update['password'], $id);
            }

            if (!$smt->execute()) {
                array_push($errors, "No se han podido actualizar los datos");
            }

            $smt->close();

        }

        return $errors;

    }

    public function getCommentById(int $id) : array | false
    {
        $ret = array();
        $query = "SELECT Comentario.id,
                         Usuario.id AS id_usuario, 
                         Cientifico.id AS id_cientifico, 
                         Usuario.nombre AS nombre_usuario,
                         Usuario.email AS email_usuario,
                         Cientifico.nombre AS nombre_cientifico, 
                         Comentario.fecha, 
                         Comentario.texto 
                         FROM Usuario 
                         INNER JOIN Comentario
                            ON Usuario.id = Comentario.id_usuario
                         INNER JOIN Cientifico
                            ON Cientifico.id = Comentario.id_cientifico
                         WHERE Comentario.id = ?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("i", $id);
        if ($smt->execute()) {
            $res = $smt->get_result();
            $ret = $res->fetch_assoc();
            if (!$ret) { $ret = false; }
        }
        else {
            $ret = false;
        }
        $smt->close();
        return $ret;
    }

    public function updateComment(int $id, string $texto, bool $mod) : array
    {
        $errors = array();
        $_mod = (int)$mod;
        if ($_mod < 0) { $_mod = 0; }
        else if ($_mod > 1) { $_mod = 1; }

        if (!$texto) {
            array_push($errors, "El comentario está vacío");
        }
        else {
            $query = "UPDATE Comentario SET texto=?, fecha=?, moderado=? WHERE Comentario.id = ?";
            $smt = $this->connection->prepare($query);
            $date = date('Y-m-d H:i:s');
            if (!$smt->bind_param("ssii", $texto, $date, $_mod, $id)) {
                array_push($errors, "Error interno, consulte al administrador");
            }
            else if (!$smt->execute()) {
                array_push($errors, "No se ha podido realizar la operación");
            }
            $smt->close();
        }

        return $errors;
    }

    public function deleteComment(int $id) : bool
    {

        $query = "DELETE FROM Comentario WHERE id=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("i", $id);
        $ret = $smt->execute();
        $smt->close();
        return $ret;

    }

    public function getAllUsers() : array
    {
        $ret = array();
        $query = "SELECT id, nombre, email, tipo FROM Usuario";
        $smt = $this->connection->prepare($query);
        if ($smt->execute()) {
            $ret = $smt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return $ret;
    }

    public function getRoles() : array
    {
        $ret = array();
        $query = "SELECT tipo FROM TipoUsuario";
        $smt = $this->connection->prepare($query);
        if ($smt->execute()) {
            $res = $smt->get_result();
            while($row = $res->fetch_assoc()) {
                array_push($ret, $row['tipo']);
            }
        }
        $smt->close();
        return $ret;
    }

    // Actualiza el rol de un usuario
    // Devuelve un array con los errores producidos
    public function setUserRole(int $id, string $role) : array
    {
        $errors = array();

        // Tenemos que comprobar que no vamos a eliminar al unico superusuario del sistema
        if ($role !== 'Administrador') {

            $query = "SELECT id, tipo FROM Usuario WHERE tipo='Administrador'";
            $smt = $this->connection->prepare($query);

            if (!$smt->execute()) {

                array_push($errors, "Se ha producido un error verificando el rol del usuario");

            }

            $res = $smt->get_result();

            if ($smt->num_rows === 1 && $res->fetch_assoc()['id'] === $id) {

                array_push($errors, "No se puede cambiar el rol del único superusuario del sistema");

            }

            $smt->close();

        }

        if (!$errors) {

            $query = "UPDATE Usuario SET tipo=? WHERE id=?";
            $smt = $this->connection->prepare($query);
            $smt->bind_param("si", $role, $id);

            if (!$smt->execute()) {

                array_push($errors, "Error al actualizar el rol del usuario");

            }

            $smt->close();

            $_SESSION['user'] = $this->getUserById($_SESSION['user']['id']);

        }

        return $errors;
    }

    public function getAllComments()
    {

        $ret = array();
        $query = "SELECT Comentario.id,
                         Usuario.nombre AS nombre_usuario,
                         Cientifico.nombre AS nombre_cientifico,
                         Comentario.fecha,
                         Comentario.texto
                         FROM Comentario
                         INNER JOIN Cientifico ON Comentario.id_cientifico = Cientifico.id
                         INNER JOIN Usuario ON Comentario.id_usuario = Usuario.id";
        $smt = $this->connection->prepare($query);
        if ($smt->execute()) {
            $ret = $smt->get_result()->fetch_all(MYSQLI_ASSOC);
            foreach ($ret as &$row) {
                $row['fecha'] = $this->date_form->comment($row['fecha']);
            }
        }
        return $ret;

    }

    public function getAllScientists($search, $solo_publicados = false) : array
    {

        $query = "SELECT DISTINCT id, nombre FROM Cientifico";

        if ($search) {

            $search = '%' . $search . '%';
            $query = $query . " WHERE nombre LIKE ?";

            if ($solo_publicados) {

                $query = $query . " AND publicado = 1";

            }

        }

        $smt = $this->connection->prepare($query);

        if ($search) {

            $smt->bind_param("s", $search);

        }

        $smt->execute();
        return $smt->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    private function getHashtags(int $id) : array
    {
        $ret = array();
        $query = "SELECT nombre FROM HashtagCientifico WHERE id_cientifico=?";
        $smt = $this->connection->prepare($query);
        $smt->bind_param("i", $id);
        if ($smt->execute()) {
            $res = $smt->get_result();
            while ($row = $res->fetch_assoc()) {
                array_push($ret, $row);
            }
        }
        else {
            array_push($ret, "No se han podido obtener los hashtags");
        }
        return $ret;
    }

    private function deleteScientistReferences(int $id) : bool
    {
        $tables = ['ImagenBiografia', 'Comentario', 'Social', 'HashtagCientifico'];
        foreach ($tables as &$table) {
            $query = "DELETE FROM " . $table . " WHERE id_cientifico=?";
            $smt = $this->connection->prepare($query);
            $smt->bind_param("i", $id);
            if (!$smt->execute()) {
                return false;
            }
        }
        return true;
    }

    public function addScientist(array $info) : array
    {
        $errors = array();

        echo var_dump($info);

        if (!$info['nombre']) {
            array_push($errors, "No se ha especificado un nombre");
        }
        
        if (!$info['fechaNacimiento']) {
            array_push($errors, "No se ha especificado una fecha de nacimiento");
        }

        if (!$info['lugarOrigen']) {
            array_push($errors, "No se ha especificado un lugar de origen");
        }

        if (!$info['biografia']) {
            array_push($errors, "La biografia está vacía");
        }

        if (!$info['visibilidad']) {
            $info['visibilidad'] = 0;
        }

        if (!$errors) {

            // Primero insertamos el cientifico
            $query = "INSERT INTO Cientifico(nombre, fechaNacimiento, fechaDefuncion, lugarOrigen, biografia, publicado)
            VALUES (?, ?, ?, ?, ?, ?)";
            $smt = $this->connection->prepare($query);
            $smt->bind_param("sssssi", $info['nombre'], $info['fechaNacimiento'], $info['fechaDefuncion'], $info['lugarOrigen'], $info['biografia'], $info['visibilidad']);

            if (!$smt->execute()) {
                array_push($errors, "No se ha podido insertar el cientifico en la base de datos");
            }
            else {

                $id = $this->connection->insert_id;

                // Redes sociales
                if ($info['sociales'] != null) {
                    $query = "INSERT INTO Social(id_cientifico, nombre, enlace) VALUES (?, ?, ?)";
                    $smt = $this->connection->prepare($query);

                    foreach ($info['sociales'] as $nombre => $enlace) {

                        $smt->bind_param("iss", $id, $nombre, $enlace);
                        if (!$smt->execute()) {
                            array_push($errors, "No se ha podido insertar la red social " . $nombre);
                        }

                    }
                }

                // Hashtags
                if ($info['hashtags'] != null) {

                    $query = "INSERT INTO HashtagCientifico VALUES (?, ?)";
                    $smt = $this->connection->prepare($query);

                    foreach ($info['hashtags'] as $nombre) {

                        $smt->bind_param("is", $id, $nombre);
                        if (!$smt->execute()) {
                            array_push($errors, "No se ha podido insertar el hashtag #" . $nombre);
                        }

                    }

                }

                // Portada
                if ($info['portada'] != null) {

                    $filename = $info['portada']['filename'];
                    $query = "INSERT INTO Imagen(enlace) VALUES (?)";
                    $smt = $this->connection->prepare($query);
                    $smt->bind_param("s", $filename);

                    $query = "UPDATE Cientifico SET portada=? WHERE id=?";
                    $smt = $this->connection->prepare($query);
                    $smt->bind_param("si", $filename, $id);
                    if (!$smt->execute()) {
                        array_push($errors, "No se ha podido establecer la portada del cientifico");
                    }

                }

                // Imagenes
                if ($info['imagenes'] != null) {

                    foreach ($info['imagenes'] as $idx => $img) {
                        
                        $query = "INSERT INTO Imagen VALUES (?)";
                        $smt = $this->connection->prepare($query);
                        $smt->bind_param("s", $img['filename']);
                        $smt->execute();

                        //? Se me olvidaron los pies de página :'(
                        $query = "INSERT INTO ImagenBiografia(id_cientifico, enlace, descripcion) VALUES (?, ?, ?)";
                        $smt = $this->connection->prepare($query);
                        echo var_dump($img);
                        $smt->bind_param("iss", $id, $img['filename'], $img['desc']);
                        if (!$smt->execute()) {
                            array_push($errors, "No se ha podido incluir la imagen número " . $idx . " en la biografía (está repetida)");
                        }

                    }

                }

                if ($errors) {

                    array_unshift($errors, "El cientifico se ha insertado, pero han ocurrido los siguientes errores:");

                }

            }

        }

        return $errors;
    }

    public function updateScientist(int $id, array $info) : array
    {
        $errors = [];
        $query = "UPDATE Cientifico SET nombre=?, fechaNacimiento=?, fechaDefuncion=?, lugarOrigen=?, biografia=?, publicado=?
                  WHERE id=?";

        $smt = $this->connection->prepare($query);
        $smt->bind_param("sssssii", $info['nombre'], $info['fechaNacimiento'], $info['fechaDefuncion'], $info['lugarOrigen'], $info['biografia'], $info['visibilidad'], $id);
        if (!$smt->execute()) {
            array_push($errors, "Error en actualizacion");
        }
        return $errors;
    }

    public function deleteScientist(int $id) : bool
    {
        // Hay que eliminar los datos que referencian al cientifico antes de
        // eliminarlo de la base de datos:
        // ImagenBiografia, Comentario, Social y HashtagCientifico
        $ret = false;
        if ($this->deleteScientistReferences($id)) {
            $query = "DELETE FROM Cientifico WHERE id=?";
            $smt = $this->connection->prepare($query);
            $smt->bind_param("i", $id);
            $ret = $smt->execute();
        }
        return $ret;
    }

    public function uploadComment(int $id_user, int $id_scientist, string $text) : bool
    {
        $query = "INSERT INTO Comentario(id_usuario, id_cientifico, fecha, texto)
                  VALUES (?, ?, ?, ?)";
        $smt = $this->connection->prepare($query);
        $date = date('Y-m-d H:i:s');
        $smt->bind_param("iiss", $id_user, $id_scientist, $date, $text);
        return $smt->execute();
    }

    public function hasValidImageExtension(string &$filename)
    {
        $valid_extensions = array("jpeg", "jpg", "png");
        $file_ext = explode('.',$filename);
        $file_ext = end($file_ext);
        $file_ext = strtolower($file_ext);
        return in_array($file_ext, $valid_extensions);
    }

    public function hasValidImageSize(int $filesize) {
        return $filesize <= Conexion::MAX_FILESIZE;
    }

    public function uploadImage(string $tmp_name, string $final_name) : string | false
    {
        $storage_dir = Conexion::PHP_IMAGE_DIR . $final_name;
        return move_uploaded_file($tmp_name, $storage_dir);
    }

    public function defaultFrontImageLocation() : string
    {
        return Conexion::TWIG_IMAGE_DIR . 'default.png';
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

$connection = new Conexion();

?>