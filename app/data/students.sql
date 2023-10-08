-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-05-2023 a las 13:25:24
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

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
-- Estructura de tabla para la tabla `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `identificacion` int NOT NULL,
  `curso` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2147483647 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `student`, `identificacion`, `curso`) VALUES
(1, 'casandra montereal', 1352467890, 0),
(2, 'mario monstes', 1345623456, 0),
(3, 'armando Ramirez', 113234578, 0),
(4, 'nicolas urueña', 1112450266, 0),
(5, 'Andrés  sanches', 100267889, 0),
(6, 'gisel Rodigez', 1322345678, 0),
(7, 'alondra  montenegro', 1005667892, 0),
(8, 'valentina valencia', 1073926578, 0),
(9, 'anderson hernandez', 1112740266, 0),
(10, 'natalia  archuri', 1003048789, 0),
(11, 'demian archure', 1198456732, 0),
(12, 'geraldin mariales', 1003456778, 0),
(13, 'katherine montiel', 1113926578, 0),
(14, 'jaqueline casablanca', 1002740266, 0),
(15, 'Andrea Soto', 100789865, 0),
(1111122448, 'ricardo rojas rico', 0, 0),
(2147483647, 'cristian mauricio', 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
