-- SQL para insertar valores en la BD

-- Prácticas de SIBW
-- Curso 2022/2023
-- Autor: Luis Miguel Guirado Bautista
-- Universidad de Granada

-- https://github.com/lu1smgb/SIBW

-- Imagen
INSERT INTO Imagen(enlace) VALUES ('default.png');
INSERT INTO Imagen(enlace, descripcion) VALUES ('albert_einstein.jpg', 'Tercera edad (1947)');
INSERT INTO Imagen(enlace, descripcion) VALUES ('albert_einstein2.jpg', 'Foto en color');
-- INSERT INTO Imagen(enlace, descripcion) VALUES ('...', '...');

-- Cientifico
INSERT INTO Cientifico(nombre, fechaNacimiento, fechaDefuncion, lugarOrigen, biografia, portada) VALUES (
    'Albert Einstein',
    STR_TO_DATE('14/03/1879', '%d/%m/%Y'),
    STR_TO_DATE('18/04/1955', '%d/%m/%Y'),
    'Alemania',
    'Albert Einstein fue un físico teórico alemán que nació en 1879 y murió en 1955. Es ampliamente considerado como uno de los científicos más influyentes del siglo XX y es conocido por su teoría de la relatividad y su famosa ecuación E=mc2.
    Einstein creció en una familia judía en Alemania y mostró una pasión temprana por la ciencia y las matemáticas. Estudió en la Escuela Politécnica de Zurich en Suiza y trabajó como examinador de patentes antes de ser contratado como profesor de física en la Universidad de Berna.
    En 1905, Einstein publicó una serie de artículos que cambiarían la física para siempre, incluyendo su teoría de la relatividad especial. En 1915, publicó su teoría de la relatividad general, que redefinió nuestra comprensión del espacio y el tiempo.
    Einstein también hizo importantes contribuciones a la física cuántica, la estadística y la cosmología. En 1921, fue galardonado con el Premio Nobel de Física por su explicación del efecto fotoeléctrico.
    En 1933, Einstein emigró a Estados Unidos para escapar del régimen nazi en Alemania. Allí, trabajó en el Instituto de Estudios Avanzados de Princeton hasta su muerte en 1955.
    Además de su trabajo científico, Einstein también fue un activista político y pacifista, abogando por la paz mundial y los derechos civiles. Su imagen icónica y su legado científico lo convierten en uno de los personajes más reconocidos de la historia moderna.',
    'albert_einstein.jpg'
);
INSERT INTO Cientifico(nombre, fechaNacimiento, lugarOrigen) VALUES (
    'Cientifico Vacio',
    STR_TO_DATE('01/01/2000', '%d/%m/%Y'),
    'La nada'
);

-- ImagenBiografia
INSERT INTO ImagenBiografia(id_cientifico, enlace) VALUES (1, 'albert_einstein.jpg');
INSERT INTO ImagenBiografia(id_cientifico, enlace) VALUES (1, 'albert_einstein2.jpg');
-- INSERT INTO ImagenBiografia(id_cientifico, enlace) VALUES (..., '...');

-- Social
INSERT INTO Social(id_cientifico, nombre, enlace) VALUES (1, "Wikipedia", "https://es.wikipedia.org/wiki/Albert_Einstein");
-- INSERT INTO Social(id_cientifico, nombre, enlace) VALUES (..., "...", "...");

-- Usuario
INSERT INTO Usuario(nombre, email) VALUES ('Usuario1', 'usuario1@example.com');
INSERT INTO Usuario(nombre, email) VALUES ('Usuario2', 'usuario2@example.com');
INSERT INTO Usuario(nombre, email) VALUES ('Usuario3', 'usuario3@example.com');
-- INSERT INTO Usuario(nombre, email) VALUES ('...', '...');

-- Comentario
INSERT INTO Comentario(id_usuario, id_cientifico, texto) VALUES (1,1,"Definitivamente es un cientifico");
INSERT INTO Comentario(id_usuario, id_cientifico, texto) VALUES (2,1,"5mentarios");
INSERT INTO Comentario(id_usuario, id_cientifico, texto) VALUES (3,1,"Pero ese no es el nombre de una plaza?");
INSERT INTO Comentario(id_usuario, id_cientifico, texto) VALUES (2,1,"Hola mundo!");
-- INSERT INTO Comentario(id_usuario, id_cientifico, texto) VALUES (...,...,"...");

-- PalabraProhibida
INSERT INTO PalabraProhibida VALUES ('tonto');
INSERT INTO PalabraProhibida VALUES ('tonta');
INSERT INTO PalabraProhibida VALUES ('repampanos');
INSERT INTO PalabraProhibida VALUES ('cielos');
INSERT INTO PalabraProhibida VALUES ('fifa');
INSERT INTO PalabraProhibida VALUES ('recorcholis');
INSERT INTO PalabraProhibida VALUES ('caracoles');
INSERT INTO PalabraProhibida VALUES ('flautas');
INSERT INTO PalabraProhibida VALUES ('cipote');
INSERT INTO PalabraProhibida VALUES ('cipota');
-- INSERT INTO PalabraProhibida VALUES ('...');