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
            $query = "SELECT Comentario.id, Usuario.nombre, Usuario.email, Comentario.fecha, Comentario.texto 
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

    // Es importante abrir antes una cookie en la página de origen antes de llamar a esta función
    private function getCommonPageInfo() : array
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
            // TODO: Conseguir los hashtags de los cientificos aqui
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
        return preg_match("/^[a-zA-Z\d@#$%&\/\\\(\)\=\!~]{8,32}$/", $pwd);
    }

    private function generatePasswordHash(string $pwd) : string | false
    {
        return password_hash($pwd, PASSWORD_DEFAULT);
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
    public function getUser(string $email) {

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
                if ($this->getUser($data['email'])) {

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

    public function updateUserInfo(string $email, array $values) : array
    {

        $errors = array();

        $input_errors = $this->verifyUserUpdateInput($values);
        $errors = array_merge($errors, $input_errors);

        if (!$errors) {

            $update = $values;
            $smt = null;

            if (!$update['password']) {
                $query = "UPDATE Usuario SET nombre=?, email=? WHERE email=?";
                $smt = $this->connection->prepare($query);
                $smt->bind_param("sss", $update['nombre'], $update['email'], $email);
            }
            else {
                $update['password'] = $this->generatePasswordHash($update['password']);
                if (!$update['password']) {
                    array_push($errors, "No se ha podido encriptar la nueva contraseña, contacte al administrador");
                    return $errors;
                }
                $query = "UPDATE Usuario SET nombre=?, email=?, pwd=? WHERE email=?";
                $smt = $this->connection->prepare($query);
                $smt->bind_param("ssss", $update['nombre'], $update['email'], $update['password'], $email);
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
        $smt->execute();
        $ret = $smt->get_result()->fetch_assoc();
        $smt->close();
        return $ret;
    }

    public function updateComment(int $id, string $texto) : array
    {
        $errors = array();

        if (!$texto) {
            array_push($errors, "El comentario está vacío");
        }
        else {
            $query = "UPDATE Comentario SET texto=?, fecha=? WHERE Comentario.id = ?";
            $smt = $this->connection->prepare($query);
            $fecha_actual = date('Y-m-d H:i:s');
            if (!$smt->bind_param("ssi", $texto, $fecha_actual, $id)) {
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

    public function __destruct()
    {
        $this->connection->close();
    }
}

$connection = new Conexion();

?>