INSERT INTO Pais VALUES ('Alemania');
INSERT INTO Pais VALUES ('España');
INSERT INTO Pais VALUES ('Portugal');
INSERT INTO Pais VALUES ('Inglaterra');
INSERT INTO Pais VALUES ('Francia');
INSERT INTO Pais VALUES ('Estados Unidos');
INSERT INTO Pais VALUES ('Bélgica');
INSERT INTO Pais VALUES ('Suecia');

INSERT INTO Imagen(enlace) VALUES ('default.png');
INSERT INTO Imagen(enlace, descripcion) VALUES ('albert_einstein.jpg', 'Tercera edad (1947)');
INSERT INTO Imagen(enlace, descripcion) VALUES ('albert_einstein2.jpg', 'Foto en color');

INSERT INTO Cientifico(nombre, fechaNacimiento, fechaDefuncion, lugarOrigen, biografia) VALUES (
    'Albert Einstein',
    STR_TO_DATE('14/03/1879', '%d/%m/%Y'),
    STR_TO_DATE('18/04/1955', '%d/%m/%Y'),
    'Alemania',
    'Albert Einstein fue un físico teórico alemán que nació en 1879 y murió en 1955. Es ampliamente considerado como uno de los científicos más influyentes del siglo XX y es conocido por su teoría de la relatividad y su famosa ecuación E=mc2.
    Einstein creció en una familia judía en Alemania y mostró una pasión temprana por la ciencia y las matemáticas. Estudió en la Escuela Politécnica de Zurich en Suiza y trabajó como examinador de patentes antes de ser contratado como profesor de física en la Universidad de Berna.
    En 1905, Einstein publicó una serie de artículos que cambiarían la física para siempre, incluyendo su teoría de la relatividad especial. En 1915, publicó su teoría de la relatividad general, que redefinió nuestra comprensión del espacio y el tiempo.
    Einstein también hizo importantes contribuciones a la física cuántica, la estadística y la cosmología. En 1921, fue galardonado con el Premio Nobel de Física por su explicación del efecto fotoeléctrico.
    En 1933, Einstein emigró a Estados Unidos para escapar del régimen nazi en Alemania. Allí, trabajó en el Instituto de Estudios Avanzados de Princeton hasta su muerte en 1955.
    Además de su trabajo científico, Einstein también fue un activista político y pacifista, abogando por la paz mundial y los derechos civiles. Su imagen icónica y su legado científico lo convierten en uno de los personajes más reconocidos de la historia moderna.'
);
INSERT INTO Cientifico(nombre, fechaNacimiento, fechaDefuncion, lugarOrigen, biografia) VALUES (
    'Cientifico1',
    STR_TO_DATE('01/01/2000', '%d/%m/%Y'),
    STR_TO_DATE('01/01/2100', '%d/%m/%Y'),
    'España',
    'bfsdjf'
);

INSERT INTO ImagenBiografia(cientifico, enlace) VALUES ('Albert Einstein', 'albert_einstein.jpg');
INSERT INTO ImagenBiografia(cientifico, enlace) VALUES ('Albert Einstein', 'albert_einstein2.jpg');