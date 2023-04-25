-- SQL para insertar valores en la BD

-- Prácticas de SIBW
-- Curso 2022/2023
-- Autor: Luis Miguel Guirado Bautista
-- Universidad de Granada

-- https://github.com/lu1smgb/SIBW

USE SIBW;

-- Imagen
INSERT INTO Imagen VALUES ('default.png'),
                          ('albert_einstein.jpg'),
                          ('albert_einstein2.jpg'),
                          ('marie_curie.jpg'),
                          ('marie_curie2.jpg'),
                          ('nikola_tesla.jpeg'),
                          ('nikola_tesla2.jpg'),
                          ('stephen_hawking.jpg'),
                          ('stephen_hawking2.png'),
                          ('alan_turing.jpg'),
                          ('alan_turing2.jpg'),
                          ('louis_pasteur.jpg'),
                          ('louis_pasteur2.jpg'),
                          ('isaac_newton.jpg'),
                          ('isaac_newton2.jpg');
-- INSERT INTO Imagen(enlace, descripcion) VALUES ('...', '...');

-- Cientifico
INSERT INTO Cientifico(nombre, fechaNacimiento, fechaDefuncion, lugarOrigen, biografia, portada) VALUES (
    'Albert Einstein',
    STR_TO_DATE('14/03/1879', '%d/%m/%Y'),
    STR_TO_DATE('18/04/1955', '%d/%m/%Y'),
    'Alemania',
    'Albert Einstein fue un físico teórico alemán que nació en 1879 y murió en 1955. 
    Es ampliamente considerado como uno de los científicos más influyentes del siglo XX y es conocido por su teoría de la relatividad y 
    su famosa ecuación E=mc2.
    Einstein creció en una familia judía en Alemania y mostró una pasión temprana por la ciencia y las matemáticas. 
    Estudió en la Escuela Politécnica de Zurich en Suiza y trabajó como examinador de patentes antes de ser contratado 
    como profesor de física en la Universidad de Berna.
    En 1905, Einstein publicó una serie de artículos que cambiarían la física para siempre, incluyendo su teoría 
    de la relatividad especial. En 1915, publicó su teoría de la relatividad general, que redefinió nuestra comprensión del espacio y el tiempo.
    Einstein también hizo importantes contribuciones a la física cuántica, la estadística y la cosmología. 
    En 1921, fue galardonado con el Premio Nobel de Física por su explicación del efecto fotoeléctrico.
    En 1933, Einstein emigró a Estados Unidos para escapar del régimen nazi en Alemania. Allí, trabajó en el Instituto de 
    Estudios Avanzados de Princeton hasta su muerte en 1955.
    Además de su trabajo científico, Einstein también fue un activista político y pacifista, abogando por la paz mundial y los derechos 
    civiles. Su imagen icónica y su legado científico lo convierten en uno de los personajes más reconocidos de la historia moderna.',
    'albert_einstein.jpg'
),
(
    'Marie Curie',
    STR_TO_DATE('07/11/1867', '%d/%m/%Y'),
    STR_TO_DATE('04/07/1934', '%d/%m/%Y'),
    'Varsovia, Polonia',
    'Marie Curie nació el 7 de noviembre de 1867 en Varsovia, Polonia (entonces parte del Imperio Ruso). 
    Fue una científica pionera en el campo de la radioactividad y la primera mujer en ganar un Premio Nobel, 
    así como la primera persona en ganar dos Premios Nobel en diferentes disciplinas. 
    En 1895 se trasladó a París para estudiar física y en 1903, junto con su esposo Pierre Curie, recibió 
    el Premio Nobel de Física por su trabajo sobre la radiación. Tras la muerte de Pierre en 1906, 
    Marie se convirtió en la primera mujer en enseñar en la Sorbona y continuó sus investigaciones en el campo 
    de la radiactividad. En 1911 recibió su segundo Premio Nobel, esta vez en química, por su descubrimiento del radio y el polonio. 
    Marie Curie falleció el 4 de julio de 1934 en Francia debido a una anemia aplásica causada por su exposición prolongada a la radiación.',
    'marie_curie.jpg'
),
(
    'Nikola Tesla',
    STR_TO_DATE('10/07/1856', '%d/%m/%Y'),
    STR_TO_DATE('07/01/1943', '%d/%m/%Y'),
    'Smiljan, Croacia',
    'Nikola Tesla nació el 10 de julio de 1856 en Smiljan, Croacia, en ese momento parte del Imperio Austrohúngaro. 
    Fue un inventor, ingeniero eléctrico y físico conocido por su trabajo en el desarrollo del sistema eléctrico de corriente alterna. 
    Tesla emigró a los Estados Unidos en 1884, donde trabajó con Thomas Edison antes de fundar su propia compañía en 1887. 
    A lo largo de su vida, Tesla registró más de 300 patentes por sus invenciones en campos que van desde la energía eléctrica hasta la 
    robótica y la teledirigencia. Falleció el 7 de enero de 1943 en Nueva York.',
    'nikola_tesla.jpeg'
),
(
    'Stephen Hawking',
    STR_TO_DATE('08/01/1942', '%d/%m/%Y'),
    STR_TO_DATE('14/03/2018', '%d/%m/%Y'),
    'Oxford, Inglaterra',
    'Stephen Hawking nació el 8 de enero de 1942 en Oxford, Inglaterra. Fue un físico teórico y cosmólogo que 
    realizó importantes contribuciones a la comprensión del universo y la naturaleza de los agujeros negros. 
    Hawking fue diagnosticado con esclerosis lateral amiotrófica (ELA) a los 21 años, lo que eventualmente 
    lo dejó paralizado y lo obligó a comunicarse a través de un sintetizador de voz. 
    A pesar de sus limitaciones físicas, continuó trabajando y enseñando en la Universidad de Cambridge y 
    publicó varios libros populares sobre su trabajo, incluyendo "Una breve historia del tiempo". 
    Hawking falleció el 14 de marzo de 2018 a los 76 años.',
    'stephen_hawking.jpg'
),
(
    'Alan Turing',
    STR_TO_DATE('23/06/1912', '%d/%m/%Y'),
    STR_TO_DATE('07/06/1954', '%d/%m/%Y'),
    'Londres, Inglaterra',
    'Alan Turing nació en Maida Vale, Londres, Reino Unido, el 23 de junio de 1912. 
    Fue un matemático y científico de la computación británico, considerado uno de los padres de 
    la computación moderna y pionero en la teoría de la inteligencia artificial. 
    Durante la Segunda Guerra Mundial, trabajó para descifrar los códigos alemanes, contribuyendo 
    significativamente a la victoria de los Aliados. Después de la guerra, fue procesado por homosexualidad, 
    que entonces era ilegal en el Reino Unido, y se le prohibió trabajar en su profesión. En 1952, 
    Turing falleció a los 41 años, aparentemente por suicidio. En 2009, el entonces primer ministro británico, 
    Gordon Brown, emitió una disculpa oficial en nombre del gobierno británico por 
    la forma en que Turing fue tratado después de la guerra.',
    'alan_turing.jpg'
),
(
    'Louis Pasteur',
    STR_TO_DATE('27/12/1822', '%d/%m/%Y'),
    STR_TO_DATE('28/09/1895', '%d/%m/%Y'),
    'Dole, Francia',
    'Louis Pasteur nació el 27 de diciembre de 1822 en Dole, Francia. Fue un químico y microbiólogo 
    cuyas contribuciones revolucionaron la medicina y la biología. En 1857, demostró que la fermentación 
    se debe a la acción de microorganismos y desarrolló la técnica de pasteurización para evitar la 
    descomposición de alimentos y bebidas. También creó la primera vacuna contra la rabia en 1885, basada 
    en sus estudios de la enfermedad. Pasteur fue un pionero en la teoría de los gérmenes y la higiene, 
    y sus investigaciones sentaron las bases de la microbiología moderna. Murió en Saint-Cloud, Francia, el 28 de septiembre de 1895.',
    'louis_pasteur.jpg'
),
(
    'Isaac Newton',
    STR_TO_DATE('04/01/1643', '%d/%m/%Y'),
    STR_TO_DATE('31/03/1727', '%d/%m/%Y'),
    'Woolstrope, Inglaterra',
    'Isaac Newton nació en Woolsthorpe, Inglaterra, el 4 de enero de 1643. Fue un físico, matemático, astrónomo 
    y filósofo inglés considerado como una de las figuras científicas más importantes de la historia. En 1687 publicó 
    su obra más importante, "Philosophiæ Naturalis Principia Mathematica", donde presentó sus leyes del movimiento y la 
    ley de la gravitación universal. También fue presidente de la Royal Society y realizó importantes contribuciones en 
    óptica y cálculo diferencial. Newton murió en Londres el 31 de marzo de 1727.',
    'isaac_newton.jpg'
);


-- Menu
INSERT INTO Menu(nombre, enlace) VALUES ('Menu 1', 'index.php');

-- ImagenBiografia
INSERT INTO ImagenBiografia(id_cientifico, enlace, descripcion) VALUES (1, 'albert_einstein.jpg', 'Tercera edad (1947)'),
                                                                       (1, 'albert_einstein2.jpg', 'Foto en color'),
                                                                       (2, 'marie_curie.jpg', ''),
                                                                       (2, 'marie_curie2.jpg', 'En su laboratorio'),
                                                                       (3, 'nikola_tesla.jpeg', ''),
                                                                       (3, 'nikola_tesla2.jpg', 'Retrato en lienzo'),
                                                                       (4, 'stephen_hawking.jpg', ''),
                                                                       (4, 'stephen_hawking2.png', 'En una conferencia'),
                                                                       (5, 'alan_turing.jpg', ''),
                                                                       (5, 'alan_turing2.jpg', 'Estatua en Bletchley, Inglaterra'),
                                                                       (6, 'louis_pasteur.jpg', ''),
                                                                       (6, 'louis_pasteur2.jpg', 'En su laboratorio'),
                                                                       (7, 'isaac_newton.jpg', ''),
                                                                       (7, 'isaac_newton2.jpg', 'Retrato en lienzo (1702)');

-- Social
INSERT INTO Social(id_cientifico, nombre, enlace) VALUES (1, "Wikipedia", "https://es.wikipedia.org/wiki/Albert_Einstein");

-- Usuario
INSERT INTO Usuario(nombre, email) VALUES ('Usuario1', 'usuario1@example.com'),
                                          ('Usuario2', 'usuario2@example.com'),
                                          ('Usuario3', 'usuario3@example.com');

-- Comentario
INSERT INTO Comentario(id_usuario, id_cientifico, texto) VALUES (1, 1, "Definitivamente es un cientifico");
INSERT INTO Comentario(id_usuario, id_cientifico, texto, fecha) VALUES (2, 1, "5mentarios", CURRENT_TIMESTAMP + 1),
                                                                       (3, 1, "Pero ese no es el nombre de una plaza?", CURRENT_TIMESTAMP + 5),
                                                                       (2, 1, "Hola mundo!", CURRENT_TIMESTAMP + 10);

-- PalabraProhibida
INSERT INTO PalabraProhibida VALUES ('tonto'),
                                    ('tonta'),
                                    ('repampanos'),
                                    ('cielos'),
                                    ('fifa'),
                                    ('recorcholis'),
                                    ('caracoles'),
                                    ('flautas'),
                                    ('cipote'),
                                    ('cipota');