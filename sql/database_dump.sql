-- Volcado de la base de datos (con las tablas creadas y los valores insertados)
-- Fichero generado de forma automática en phpMyAdmin

-- Prácticas de SIBW
-- Curso 2022/2023
-- Autor: Luis Miguel Guirado Bautista
-- Universidad de Granada

-- https://github.com/lu1smgb/SIBW

-- --------------------------------------------------------

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: database:3306
-- Tiempo de generación: 25-04-2023 a las 11:52:54
-- Versión del servidor: 8.0.32
-- Versión de PHP: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `SIBW`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cientifico`
--

CREATE TABLE `Cientifico` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `fechaDefuncion` date DEFAULT NULL,
  `lugarOrigen` varchar(100) NOT NULL,
  `biografia` text,
  `portada` varchar(150) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `Cientifico`
--

INSERT INTO `Cientifico` (`id`, `nombre`, `fechaNacimiento`, `fechaDefuncion`, `lugarOrigen`, `biografia`, `portada`) VALUES
(1, 'Albert Einstein', '1879-03-14', '1955-04-18', 'Alemania', 'Albert Einstein fue un físico teórico alemán que nació en 1879 y murió en 1955. \r\n    Es ampliamente considerado como uno de los científicos más influyentes del siglo XX y es conocido por su teoría de la relatividad y \r\n    su famosa ecuación E=mc2.\r\n    Einstein creció en una familia judía en Alemania y mostró una pasión temprana por la ciencia y las matemáticas. \r\n    Estudió en la Escuela Politécnica de Zurich en Suiza y trabajó como examinador de patentes antes de ser contratado \r\n    como profesor de física en la Universidad de Berna.\r\n    En 1905, Einstein publicó una serie de artículos que cambiarían la física para siempre, incluyendo su teoría \r\n    de la relatividad especial. En 1915, publicó su teoría de la relatividad general, que redefinió nuestra comprensión del espacio y el tiempo.\r\n    Einstein también hizo importantes contribuciones a la física cuántica, la estadística y la cosmología. \r\n    En 1921, fue galardonado con el Premio Nobel de Física por su explicación del efecto fotoeléctrico.\r\n    En 1933, Einstein emigró a Estados Unidos para escapar del régimen nazi en Alemania. Allí, trabajó en el Instituto de \r\n    Estudios Avanzados de Princeton hasta su muerte en 1955.\r\n    Además de su trabajo científico, Einstein también fue un activista político y pacifista, abogando por la paz mundial y los derechos \r\n    civiles. Su imagen icónica y su legado científico lo convierten en uno de los personajes más reconocidos de la historia moderna.', 'albert_einstein.jpg'),
(2, 'Marie Curie', '1867-11-07', '1934-07-04', 'Varsovia, Polonia', 'Marie Curie nació el 7 de noviembre de 1867 en Varsovia, Polonia (entonces parte del Imperio Ruso). \r\n    Fue una científica pionera en el campo de la radioactividad y la primera mujer en ganar un Premio Nobel, \r\n    así como la primera persona en ganar dos Premios Nobel en diferentes disciplinas. \r\n    En 1895 se trasladó a París para estudiar física y en 1903, junto con su esposo Pierre Curie, recibió \r\n    el Premio Nobel de Física por su trabajo sobre la radiación. Tras la muerte de Pierre en 1906, \r\n    Marie se convirtió en la primera mujer en enseñar en la Sorbona y continuó sus investigaciones en el campo \r\n    de la radiactividad. En 1911 recibió su segundo Premio Nobel, esta vez en química, por su descubrimiento del radio y el polonio. \r\n    Marie Curie falleció el 4 de julio de 1934 en Francia debido a una anemia aplásica causada por su exposición prolongada a la radiación.', 'marie_curie.jpg'),
(3, 'Nikola Tesla', '1856-07-10', '1943-01-07', 'Smiljan, Croacia', 'Nikola Tesla nació el 10 de julio de 1856 en Smiljan, Croacia, en ese momento parte del Imperio Austrohúngaro. \r\n    Fue un inventor, ingeniero eléctrico y físico conocido por su trabajo en el desarrollo del sistema eléctrico de corriente alterna. \r\n    Tesla emigró a los Estados Unidos en 1884, donde trabajó con Thomas Edison antes de fundar su propia compañía en 1887. \r\n    A lo largo de su vida, Tesla registró más de 300 patentes por sus invenciones en campos que van desde la energía eléctrica hasta la \r\n    robótica y la teledirigencia. Falleció el 7 de enero de 1943 en Nueva York.', 'nikola_tesla.jpeg'),
(4, 'Stephen Hawking', '1942-01-08', '2018-03-14', 'Oxford, Inglaterra', 'Stephen Hawking nació el 8 de enero de 1942 en Oxford, Inglaterra. Fue un físico teórico y cosmólogo que \r\n    realizó importantes contribuciones a la comprensión del universo y la naturaleza de los agujeros negros. \r\n    Hawking fue diagnosticado con esclerosis lateral amiotrófica (ELA) a los 21 años, lo que eventualmente \r\n    lo dejó paralizado y lo obligó a comunicarse a través de un sintetizador de voz. \r\n    A pesar de sus limitaciones físicas, continuó trabajando y enseñando en la Universidad de Cambridge y \r\n    publicó varios libros populares sobre su trabajo, incluyendo \"Una breve historia del tiempo\". \r\n    Hawking falleció el 14 de marzo de 2018 a los 76 años.', 'stephen_hawking.jpg'),
(5, 'Alan Turing', '1912-06-23', '1954-06-07', 'Londres, Inglaterra', 'Alan Turing nació en Maida Vale, Londres, Reino Unido, el 23 de junio de 1912. \r\n    Fue un matemático y científico de la computación británico, considerado uno de los padres de \r\n    la computación moderna y pionero en la teoría de la inteligencia artificial. \r\n    Durante la Segunda Guerra Mundial, trabajó para descifrar los códigos alemanes, contribuyendo \r\n    significativamente a la victoria de los Aliados. Después de la guerra, fue procesado por homosexualidad, \r\n    que entonces era ilegal en el Reino Unido, y se le prohibió trabajar en su profesión. En 1952, \r\n    Turing falleció a los 41 años, aparentemente por suicidio. En 2009, el entonces primer ministro británico, \r\n    Gordon Brown, emitió una disculpa oficial en nombre del gobierno británico por \r\n    la forma en que Turing fue tratado después de la guerra.', 'alan_turing.jpg'),
(6, 'Louis Pasteur', '1822-12-27', '1895-09-28', 'Dole, Francia', 'Louis Pasteur nació el 27 de diciembre de 1822 en Dole, Francia. Fue un químico y microbiólogo \r\n    cuyas contribuciones revolucionaron la medicina y la biología. En 1857, demostró que la fermentación \r\n    se debe a la acción de microorganismos y desarrolló la técnica de pasteurización para evitar la \r\n    descomposición de alimentos y bebidas. También creó la primera vacuna contra la rabia en 1885, basada \r\n    en sus estudios de la enfermedad. Pasteur fue un pionero en la teoría de los gérmenes y la higiene, \r\n    y sus investigaciones sentaron las bases de la microbiología moderna. Murió en Saint-Cloud, Francia, el 28 de septiembre de 1895.', 'louis_pasteur.jpg'),
(7, 'Isaac Newton', '1643-01-04', '1727-03-31', 'Woolstrope, Inglaterra', 'Isaac Newton nació en Woolsthorpe, Inglaterra, el 4 de enero de 1643. Fue un físico, matemático, astrónomo \r\n    y filósofo inglés considerado como una de las figuras científicas más importantes de la historia. En 1687 publicó \r\n    su obra más importante, \"Philosophiæ Naturalis Principia Mathematica\", donde presentó sus leyes del movimiento y la \r\n    ley de la gravitación universal. También fue presidente de la Royal Society y realizó importantes contribuciones en \r\n    óptica y cálculo diferencial. Newton murió en Londres el 31 de marzo de 1727.', 'isaac_newton.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Comentario`
--

CREATE TABLE `Comentario` (
  `id_usuario` int NOT NULL,
  `id_cientifico` int NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `texto` text NOT NULL
) ;

--
-- Volcado de datos para la tabla `Comentario`
--

INSERT INTO `Comentario` (`id_usuario`, `id_cientifico`, `fecha`, `texto`) VALUES
(1, 1, '2023-04-25 11:52:04', 'Definitivamente es un cientifico'),
(2, 1, '2023-04-25 11:52:05', '5mentarios'),
(3, 1, '2023-04-25 11:52:09', 'Pero ese no es el nombre de una plaza?'),
(2, 1, '2023-04-25 11:52:14', 'Hola mundo!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imagen`
--

CREATE TABLE `Imagen` (
  `enlace` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Imagen`
--

INSERT INTO `Imagen` (`enlace`) VALUES
('alan_turing.jpg'),
('alan_turing2.jpg'),
('albert_einstein.jpg'),
('albert_einstein2.jpg'),
('default.png'),
('isaac_newton.jpg'),
('isaac_newton2.jpg'),
('louis_pasteur.jpg'),
('louis_pasteur2.jpg'),
('marie_curie.jpg'),
('marie_curie2.jpg'),
('nikola_tesla.jpeg'),
('nikola_tesla2.jpg'),
('stephen_hawking.jpg'),
('stephen_hawking2.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ImagenBiografia`
--

CREATE TABLE `ImagenBiografia` (
  `id_cientifico` int NOT NULL,
  `enlace` varchar(150) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ImagenBiografia`
--

INSERT INTO `ImagenBiografia` (`id_cientifico`, `enlace`, `descripcion`) VALUES
(1, 'albert_einstein.jpg', 'Tercera edad (1947)'),
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Menu`
--

CREATE TABLE `Menu` (
  `nombre` varchar(100) NOT NULL,
  `enlace` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Menu`
--

INSERT INTO `Menu` (`nombre`, `enlace`) VALUES
('Menu 1', 'index.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PalabraProhibida`
--

CREATE TABLE `PalabraProhibida` (
  `palabra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `PalabraProhibida`
--

INSERT INTO `PalabraProhibida` (`palabra`) VALUES
('caracoles'),
('cielos'),
('cipota'),
('cipote'),
('fifa'),
('flautas'),
('recorcholis'),
('repampanos'),
('tonta'),
('tonto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Social`
--

CREATE TABLE `Social` (
  `id_cientifico` int DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `enlace` varchar(255) NOT NULL
) ;

--
-- Volcado de datos para la tabla `Social`
--

INSERT INTO `Social` (`id_cientifico`, `nombre`, `enlace`) VALUES
(1, 'Wikipedia', 'https://es.wikipedia.org/wiki/Albert_Einstein');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`id`, `nombre`, `email`) VALUES
(1, 'Usuario1', 'usuario1@example.com'),
(2, 'Usuario2', 'usuario2@example.com'),
(3, 'Usuario3', 'usuario3@example.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Cientifico`
--
ALTER TABLE `Cientifico`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `portada` (`portada`);

--
-- Indices de la tabla `Comentario`
--
ALTER TABLE `Comentario`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cientifico` (`id_cientifico`);

--
-- Indices de la tabla `Imagen`
--
ALTER TABLE `Imagen`
  ADD PRIMARY KEY (`enlace`),
  ADD UNIQUE KEY `enlace` (`enlace`);

--
-- Indices de la tabla `ImagenBiografia`
--
ALTER TABLE `ImagenBiografia`
  ADD KEY `id_cientifico` (`id_cientifico`),
  ADD KEY `enlace` (`enlace`);

--
-- Indices de la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `PalabraProhibida`
--
ALTER TABLE `PalabraProhibida`
  ADD PRIMARY KEY (`palabra`),
  ADD UNIQUE KEY `palabra` (`palabra`);

--
-- Indices de la tabla `Social`
--
ALTER TABLE `Social`
  ADD PRIMARY KEY (`enlace`),
  ADD UNIQUE KEY `enlace` (`enlace`),
  ADD KEY `id_cientifico` (`id_cientifico`);

--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`id`,`email`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Cientifico`
--
ALTER TABLE `Cientifico`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Cientifico`
--
ALTER TABLE `Cientifico`
  ADD CONSTRAINT `cientifico_ibfk_1` FOREIGN KEY (`portada`) REFERENCES `Imagen` (`enlace`);

--
-- Filtros para la tabla `Comentario`
--
ALTER TABLE `Comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id`),
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`id_cientifico`) REFERENCES `Cientifico` (`id`);

--
-- Filtros para la tabla `ImagenBiografia`
--
ALTER TABLE `ImagenBiografia`
  ADD CONSTRAINT `imagenbiografia_ibfk_1` FOREIGN KEY (`id_cientifico`) REFERENCES `Cientifico` (`id`),
  ADD CONSTRAINT `imagenbiografia_ibfk_2` FOREIGN KEY (`enlace`) REFERENCES `Imagen` (`enlace`);

--
-- Filtros para la tabla `Social`
--
ALTER TABLE `Social`
  ADD CONSTRAINT `social_ibfk_1` FOREIGN KEY (`id_cientifico`) REFERENCES `Cientifico` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
