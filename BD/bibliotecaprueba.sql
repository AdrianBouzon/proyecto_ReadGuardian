-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3308
-- Tiempo de generación: 13-03-2024 a las 21:17:32
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bibliotecaprueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `CodAlumno` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) DEFAULT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `curso` varchar(50) DEFAULT NULL,
  `numCarnet` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`CodAlumno`, `nombre`, `apellido1`, `apellido2`, `curso`, `numCarnet`) VALUES
(1, 'Juan', 'Perez', 'Alonso', '2ºESO', NULL),
(2, 'Sara', 'Rodriguez', 'Acosta', '4ºESO', '000245'),
(3, 'Santiago', 'Miguez', 'Acuña', '2ºESO', '000366'),
(4, 'David', 'Garcia', 'Garcia', '1ºESO', '000421'),
(5, 'Pablo', 'Lopez', 'Vazquez', '1ºBACH', '000689'),
(6, 'Laura', 'Mendez', 'Santos', '2ºBACH', '001458'),
(7, 'Carolina', 'Iglesias', 'Lago', '4ºESO', '000547'),
(8, 'Fernando', 'Diaz', 'Rueda', '1ºESO', '000065'),
(9, 'Bea', 'Diaz', 'Campos', '1ºESO', '000068'),
(10, 'prueba', 'prueba', 'prueba', 'prueba', '000000'),
(11, 'Dario', 'Perez', 'Perez', '3ºESO', '000741'),
(12, 'Sergio', 'Novoa', 'Silva', '1ºBACH', '000300'),
(13, 'Aitor', 'Navarro', 'Campos', '3ºESO', '000192');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `autor` varchar(80) NOT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `paginas` int(11) DEFAULT NULL,
  `portada` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `nombre`, `autor`, `genero`, `paginas`, `portada`) VALUES
(1, 'El nombre del viento', 'Patrick Rothfuss\r\n', 'Fantasía', 662, 'nombre_del_viento.jpg'),
(2, '1984', 'George Orwell', 'Ciencia ficción', 289, '1984.jpg'),
(3, 'Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 496, '100_años_de_soledad.jpg'),
(4, 'Ola de Calor', 'Richard Castle', 'Ciencia Ficción', 360, 'ola_de_calor.jpg'),
(5, 'La fragilidad de un corazón bajo la lluvia', 'María Martínez', 'Romance Contemporáneo', 449, 'la_fragilidad_de_un_corazón_bajo_la_lluvia.jpg'),
(6, 'Plenilunio', 'Antonio Muñoz Molina', 'Misterio', 353, 'plenilunio.jpg'),
(7, 'La música del silencio', 'Patrick Rothfuss', 'Literatura fantástica', 152, 'la_musica_del_silencio.jpg'),
(8, 'Calor Helado', 'Richard Castle', 'Ciencia Ficción', 480, 'calor_helado.jpg'),
(9, 'Calor Desnudo', 'Richard Castle', 'Ciencia Ficción', 528, 'calor_desnudo.jpg'),
(10, 'El estrecho sendero entre deseos', 'Patrick Rothfuss', 'Narrativa Fantástica', 240, 'el_estrecho_sendero_entre_deseos.jpg'),
(11, 'El temor de un hombre sabio', 'Patrick Rothfuss', 'Narrativa Fantástica', 962, 'el_temor_de_un_hombre_sabio.jpg'),
(12, 'Calor Asfixiante', 'Richard Castle', 'Ficción', 312, 'no_disponible.jpg'),
(13, 'Más Calor', 'Richard Castle', 'Ficción', 416, 'mas_calor.jpg'),
(14, 'El monje que vendió su Ferrari', 'Robin Sharma', 'Autoayuda', 216, 'el_monje_que_vendio_su_ferrari.jpg'),
(15, 'El mundo de Sofía', 'Jostein Gaarder', 'Filosofía', 656, 'el_mundo_de_sofia.jpg'),
(16, 'Una corte de rosas y espinas', 'Sarah J.Maas', 'Novela Fantástica y magia', 456, 'una_corte_de_rosas_y_espinas.jpg'),
(20, 'A ojos de nadie', 'Paola Boutellier', 'Novela Negra', 416, 'a_ojos_de_nadie.jpg'),
(21, 'Asesinato de un culpable', 'Paola Boutellier', 'Novela Negra', 502, 'asesinato_de_un_culpable.jpg'),
(22, 'Aun no es tarde', 'Paola Boutellier', 'Novela Negra', 405, 'aun_no_es_tarde.jpg'),
(23, 'Querido John', 'Nicholas Sparks ', 'Romántica', 320, 'querido_john.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `CodPrestamo` int(11) NOT NULL,
  `id_libro` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_alumno` int(11) DEFAULT NULL,
  `fecha_prestamo` date DEFAULT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `fechaDevolucionReal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`CodPrestamo`, `id_libro`, `id_usuario`, `id_alumno`, `fecha_prestamo`, `fecha_devolucion`, `fechaDevolucionReal`) VALUES
(4, 1, 2, 7, '2024-02-28', '2024-03-08', NULL),
(5, 20, 2, 5, '2024-02-29', '2024-03-18', NULL),
(6, 3, 1, 2, '2024-02-26', '2024-03-01', NULL),
(7, 2, 2, 7, '2024-02-21', '2024-03-14', '2024-03-10'),
(8, 2, 2, 5, '2024-03-29', '2024-03-09', NULL),
(9, NULL, 3, 4, '2024-03-21', '2024-04-04', NULL),
(10, NULL, 3, 2, '2024-03-25', '2024-04-08', NULL),
(11, 4, 3, 4, '2024-03-09', '2024-03-16', NULL),
(12, 21, 3, 6, '2024-03-28', '2024-04-11', NULL),
(13, 22, 2, 11, '2024-02-20', '2024-03-04', NULL),
(15, 2, 2, 4, '2024-03-06', '2024-03-20', NULL),
(16, 12, 3, 9, '2024-03-08', '2024-03-22', '2024-03-10'),
(17, 2, 3, 10, '2024-03-14', '2024-03-28', NULL),
(18, 2, 3, 11, '2024-03-14', '2024-03-28', NULL),
(19, 10, 3, 10, '2024-03-13', '2024-03-27', NULL),
(20, 8, 3, 10, '2024-03-08', '2024-03-22', NULL),
(21, 13, 3, 10, '2024-02-29', '2024-03-14', NULL),
(22, 15, 3, 10, '2024-03-04', '2024-03-18', NULL),
(23, 16, 3, 10, '2024-02-26', '2024-03-11', NULL),
(24, 8, 3, 3, '2024-03-04', '2024-03-18', NULL),
(25, 4, 3, 8, '2024-03-04', '2024-03-18', '2024-03-13'),
(26, 5, 3, 3, '2024-03-11', '2024-03-25', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stocklibros`
--

CREATE TABLE `stocklibros` (
  `CodStock` int(11) NOT NULL,
  `id_libro` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `stocklibros`
--

INSERT INTO `stocklibros` (`CodStock`, `id_libro`, `cantidad`) VALUES
(1, 1, 4),
(2, 2, 3),
(3, 3, 6),
(4, 4, 2),
(5, 5, 1),
(6, 6, 4),
(7, 7, 1),
(8, 8, 0),
(9, 9, 3),
(10, 10, 4),
(11, 11, 6),
(12, 12, 2),
(13, 13, 3),
(14, 14, 3),
(15, 15, 0),
(16, 16, 0),
(17, 20, 2),
(18, 21, 2),
(19, 22, 1),
(20, 23, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(3) NOT NULL,
  `usuario` varchar(30) CHARACTER SET utf32 NOT NULL,
  `password` varchar(30) CHARACTER SET utf32 NOT NULL,
  `email` varchar(80) CHARACTER SET utf32 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `email`) VALUES
(1, 'prueba', '1234', 'usuarioPrueba@gmail.com'),
(2, 'Maria', 'abc123.', 'maria@gmail.com'),
(3, 'Adrian', 'Ci3wrib)', 'adrian@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`CodAlumno`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`CodPrestamo`),
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `stocklibros`
--
ALTER TABLE `stocklibros`
  ADD PRIMARY KEY (`CodStock`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `CodAlumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `CodPrestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `stocklibros`
--
ALTER TABLE `stocklibros`
  MODIFY `CodStock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `prestamos_ibfk_3` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`CodAlumno`);

--
-- Filtros para la tabla `stocklibros`
--
ALTER TABLE `stocklibros`
  ADD CONSTRAINT `stocklibros_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
