-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-04-2019 a las 08:55:29
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(48) DEFAULT NULL,
  `correo` varchar(32) NOT NULL,
  `especialidad` varchar(32) DEFAULT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id`, `nombre`, `correo`, `especialidad`, `password`) VALUES
(1, 'Maria Gonzalez', 'mago@gmail.com', 'Pediatría', '$2y$10$PgbTG8BPafGVu9QO35DvEelTf/w68o1/3Gy8KTSAC6JmElNgF7.JG'),
(2, 'Jesús López', 'jelopez@gmail.com', 'Traumatología', '$2y$10$8znp8N1miKBoSWMo4/e8F.GT1TRS3yxmgfmu9eZtelaQCiifnQOLi'),
(3, 'Julían Beltrán', 'jubel@gmail.com', 'Dermatología', '$2y$10$sZtVsCBZlXdq6BqipFhnneZkX2Lgykw32/1IWOL3jv.2Jcs8.etFu'),
(4, 'Alberto Beirán', 'albe@gmail.com', 'Traumatología', '$2y$10$4oY3VPgNg4VRmQEg8ibVu.CJ6sHTsqV6ecvUGPScNYqspAxiOx10a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(16) DEFAULT NULL,
  `apellidos` varchar(32) DEFAULT NULL,
  `correo` varchar(32) NOT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `company` varchar(32) DEFAULT NULL,
  `tlf` varchar(15) DEFAULT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellidos`, `correo`, `dni`, `company`, `tlf`, `password`) VALUES
(1, 'Mario', 'Pérez', 'mape@gmail.com', '33332222V', 'Adeslas', '654773524', '$2y$10$xjO9cXeguAA9fcszpGSjVOVnxhR0xzKDY2TBNVcqwKP3rGVTyKTeO'),
(2, 'Carlos', 'Gil Solanas', 'cagil04@ucm.es', '25203663X', 'DKV', '654076762', '$2y$10$mZDvRcvY.34fut0qLPt4Lu.9mmks9Ri7TM5FyVITz4Pq5hw4VfsIy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_actual`
--

CREATE TABLE `periodo_actual` (
  `fecha` date NOT NULL,
  `hora` time DEFAULT NULL,
  `id_medico` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `periodo_actual`
--

INSERT INTO `periodo_actual` (`fecha`, `hora`, `id_medico`, `id_paciente`) VALUES
('2019-04-15', '10:30:00', 2, 1),
('2019-04-15', '13:30:00', 2, 2),
('2019-04-15', '12:00:00', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `periodo_actual`
--
ALTER TABLE `periodo_actual`
  ADD PRIMARY KEY (`fecha`,`id_medico`,`id_paciente`),
  ADD KEY `periodo_ibfk_1` (`id_medico`),
  ADD KEY `periodo_ibfk_2` (`id_paciente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `periodo_actual`
--
ALTER TABLE `periodo_actual`
  ADD CONSTRAINT `periodo_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id`),
  ADD CONSTRAINT `periodo_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
