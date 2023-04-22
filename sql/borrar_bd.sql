-- SQL para borrar todas las tablas

-- Prácticas de SIBW
-- Curso 2022/2023
-- Autor: Luis Miguel Guirado Bautista
-- Universidad de Granada

-- https://github.com/lu1smgb/SIBW

-- Base de datos en la que se ejecutará la consulta
USE SIBW;

-- Borramos los datos de las tablas
DELETE FROM Comentario;
DELETE FROM Usuario;
DELETE FROM ImagenBiografia;
DELETE FROM Social;
DELETE FROM Cientifico;
DELETE FROM Imagen;
DELETE FROM PalabraProhibida;

-- Eliminamos las tablas
DROP TABLE Comentario;
DROP TABLE Usuario;
DROP TABLE ImagenBiografia;
DROP TABLE Social;
DROP TABLE Cientifico;
DROP TABLE Imagen;
DROP TABLE PalabraProhibida;