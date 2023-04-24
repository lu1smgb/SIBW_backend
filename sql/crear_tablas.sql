-- Modelo de la base de datos de la web

-- Prácticas de SIBW
-- Curso 2022/2023
-- Autor: Luis Miguel Guirado Bautista
-- Universidad de Granada

-- https://github.com/lu1smgb/SIBW

-- Base de datos en la que crearemos las tablas
USE SIBW;

-- ENTIDAD Imagen
CREATE TABLE Imagen (

    enlace VARCHAR(150) NOT NULL UNIQUE,

    PRIMARY KEY (enlace) -- No habra enlaces repetidos
    
    -- Se registraran los enlaces teniendo en cuenta que el directorio
    -- de lectura por defecto es: www/assets/images

);

-- ENTIDAD Cientifico
CREATE TABLE Cientifico (

    id INT NOT NULL UNIQUE AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    fechaNacimiento DATE NOT NULL,
    fechaDefuncion DATE DEFAULT NULL,
    lugarOrigen VARCHAR(100) NOT NULL,
    biografia TEXT, -- 65,535 caracteres
    portada VARCHAR(150),

    PRIMARY KEY (id), -- No puede haber dos cientificos con el mismo id

    FOREIGN KEY (portada) REFERENCES Imagen(enlace), -- Portada -> Imagen.enlace

    -- La fecha de nacimiento siempre sera inferior a la fecha de defuncion
    CONSTRAINT VALORES_FECHAS CHECK(fechaNacimiento < fechaDefuncion)

);

CREATE TABLE Menu (

    nombre VARCHAR(100) NOT NULL UNIQUE, -- Nombre del boton
    enlace VARCHAR(150) NOT NULL, -- Enlace a donde lleva

    PRIMARY KEY (nombre)

);

-- ENTIDAD Sociales (cada entrada representara un botón social)
CREATE TABLE Social (

    id_cientifico INT,
    nombre VARCHAR(100) NOT NULL, -- Texto del botón
    enlace VARCHAR(255) NOT NULL UNIQUE, --  A donde lleva el botón

    PRIMARY KEY (enlace), -- No habra enlaces repetidos

    FOREIGN KEY (id_cientifico) REFERENCES Cientifico(id), -- id_cientifico -> Cientifico.id

    -- Los enlaces no podran ser cadenas vacias
    CONSTRAINT enlace_no_vacio CHECK(CHAR_LENGTH(enlace) > 0)
);

-- RELACION Cientifico-Imagen 1:M para las fotos de la biografía (sin incluir las de la portada)
CREATE TABLE ImagenBiografia (

    id_cientifico INT NOT NULL,
    enlace VARCHAR(150) NOT NULL,
    descripcion VARCHAR(100), -- Pie de imagen

    FOREIGN KEY (id_cientifico) REFERENCES Cientifico(id), -- id_cientifico -> Cientifico.id
    FOREIGN KEY (enlace) REFERENCES Imagen(enlace) -- enlace -> Imagen.enlace

);

-- ENTIDAD: Usuario (usuario registrado capaz de realizar comentarios)
CREATE TABLE Usuario (

    id INT NOT NULL UNIQUE AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,

    PRIMARY KEY (id,email), -- No puede haber dos usuarios con el mismo id o con el mismo email

    -- !!! El nombre de usuario tiene entre 8 y 32 caracteres !!!
    CONSTRAINT nombre_min_caracteres CHECK (CHAR_LENGTH(nombre) BETWEEN 8 AND 32),
    -- El email tendrá que cumplir una expresión regular
    CONSTRAINT email_valido CHECK (email REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$')

);

-- RELACION Usuario-Cientifico N:M para los comentarios
CREATE TABLE Comentario (

    id_usuario INT NOT NULL,
    id_cientifico INT NOT NULL,
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    texto TEXT NOT NULL, -- 65,535 caracteres

    FOREIGN KEY (id_usuario) REFERENCES Usuario(id), -- id_usuario -> Usuario.id
    FOREIGN KEY (id_cientifico) REFERENCES Cientifico(id), -- id_cientifico -> Cientifico.id

    -- El texto del comentario no puede ser una cadena vacía
    CONSTRAINT comentario_no_vacio CHECK(CHAR_LENGTH(texto) > 0)

);

-- ENTIDAD Palabras prohibidas en los comentarios
CREATE TABLE PalabraProhibida (

    palabra VARCHAR(100) NOT NULL UNIQUE,

    PRIMARY KEY (palabra)

);