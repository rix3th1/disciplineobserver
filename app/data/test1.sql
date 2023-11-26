-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-11-2023 a las 20:26:05
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `disciplineobserver`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citations`
--

DROP TABLE IF EXISTS `citations`;
CREATE TABLE IF NOT EXISTS `citations` (
  `_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `citation_date` datetime NOT NULL,
  `msg_parent` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `citations`
--

INSERT INTO `citations` (`_id`, `student_id`, `citation_date`, `msg_parent`, `resolved`, `created_at`) VALUES
(1, 1111122448, '2023-11-26 00:21:00', 'lorem', 1, '2023-11-26 00:21:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `_id` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `grade` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `grades`
--

INSERT INTO `grades` (`_id`, `grade`) VALUES
('10th', 'Décimo'),
('11th', 'Once'),
('1st', 'Primero'),
('2nd', 'Segundo'),
('3rd', 'Tercero'),
('4th', 'Cuarto'),
('5th', 'Quinto'),
('6th', 'Sexto'),
('7th', 'Séptimo'),
('8th', 'Octavo'),
('9th', 'Noveno'),
('K', 'Jardín'),
('PK', 'Prejardín');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notations`
--

DROP TABLE IF EXISTS `notations`;
CREATE TABLE IF NOT EXISTS `notations` (
  `_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `notation` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `grade` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `testimony` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `teacher_name` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `subject_id` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`_id`),
  KEY `grade` (`grade`),
  KEY `student_id` (`student_id`),
  KEY `id_subject` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `notations`
--

INSERT INTO `notations` (`_id`, `student_id`, `notation`, `grade`, `testimony`, `teacher_name`, `subject_id`, `created_at`) VALUES
(1, 1111122448, 'lorem', '11th', 'lorem', 'lorem', '1111122448-6562d5a5e205f', '2023-11-26 00:20:37'),
(2, 1111122448, 'lorem', '11th', 'lorem', 'lorem', '1111122448-6562d5e1c559c', '2023-11-26 00:21:37'),
(3, 1234567891, 'qASADFD', '2nd', 'DFSDGF', 'DFSD', '1234567891-6563a29fc63ee', '2023-11-26 14:55:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parents_students`
--

DROP TABLE IF EXISTS `parents_students`;
CREATE TABLE IF NOT EXISTS `parents_students` (
  `_id` int NOT NULL AUTO_INCREMENT,
  `job` varchar(60) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `availability` datetime NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2147483648 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `parents_students`
--

INSERT INTO `parents_students` (`_id`, `job`, `availability`) VALUES
(1111122456, 'rector', '2023-11-28 14:48:00'),
(2147483647, 'Data Science', '2023-11-21 17:03:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `_id` enum('teacher','parent','rector','secretary') COLLATE utf8mb4_spanish2_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `permissions` set('make_notation','cite_parents','view_observer','view_cite_parents','admin_students','admin_teachers') COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`_id`, `role`, `permissions`) VALUES
('teacher', 'Docente', 'make_notation,cite_parents,view_observer,view_cite_parents'),
('parent', 'Padre de Familia', 'view_observer,view_cite_parents'),
('rector', 'Rector', 'make_notation,cite_parents,view_observer,view_cite_parents,admin_students,admin_teachers'),
('secretary', 'Secretaria', 'make_notation,cite_parents,view_observer,view_cite_parents,admin_students,admin_teachers');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `_id` int NOT NULL AUTO_INCREMENT,
  `student` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `grade` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `parent_id` int NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`_id`),
  KEY `grade` (`grade`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1234567892 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`_id`, `student`, `grade`, `parent_id`, `is_enabled`) VALUES
(1111122448, 'Ricardo Rojas', '11th', 2147483647, 1),
(1234567891, 'kail', '2nd', 1111122456, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `_id` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `subject_name` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `subject_schedule` time NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `subjects`
--

INSERT INTO `subjects` (`_id`, `subject_name`, `subject_schedule`) VALUES
('1111122448-6562d5a5e205f', 'lorem', '02:21:00'),
('1111122448-6562d5e1c559c', 'lorem', '00:22:00'),
('1234567891-6563a29fc63ee', 'EFSRD', '14:55:00'),
('374287362-6562c3de705d4', 'Sociales', '23:04:00'),
('374287362-6562c4167382e', 'Matematicas', '23:05:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `lastname` varchar(25) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `telephone` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `role` enum('teacher','parent','rector','secretary') COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=2147483648 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`_id`, `name`, `lastname`, `telephone`, `email`, `password`, `role`) VALUES
(1, 'John', 'Doe', '3012834716', 'rojasricor@gmail.com', '$2y$10$odAqXs1rTW9JrO6C820r6.IVmcOpJPitzfDeTYo0D28Dx.ocjDKVC', 'rector'),
(46738328, 'Ryan', 'Ray', '3173927402', 'ryanray@gmail.com', '$2y$10$Pdv8fUdXNF3Fjik43lzuCu.pWCFYBZauRb5gf33uXh.Oh4FTzp5HK', 'teacher'),
(63864836, 'Lysandra Booker', 'Miller', '3924826463', 'privateaccount@gmail.com', '$2y$10$ZBZ.jDZe/ZLIcXzYs0aKYeaiNHNu4fSyDQI7c5yl3Qzl2zQLr.5ly', 'teacher'),
(73884826, 'Juan', 'Sánchez', '3173874244', 'juan@gmail.com', '$2y$10$d9q0fTHFHKJLY2YIt2A3AeEFH7ZRHlzYAm7FgHIKJSprIFzEMiY6a', 'teacher'),
(1111122456, 'Andrés ', 'Mayorquins', '3223456789', 'asoto0798@gmail.com', '$2y$10$Ctyy19NxFLIAx.WsIZYGk.B9yN.rovqo0xHAbOPDJ7i0cG6FJT8uK', 'parent');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citations`
--
ALTER TABLE `citations`
  ADD CONSTRAINT `citations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`_id`);

--
-- Filtros para la tabla `notations`
--
ALTER TABLE `notations`
  ADD CONSTRAINT `notations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`_id`),
  ADD CONSTRAINT `notations_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`_id`);

--
-- Filtros para la tabla `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`grade`) REFERENCES `grades` (`_id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `parents_students` (`_id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
