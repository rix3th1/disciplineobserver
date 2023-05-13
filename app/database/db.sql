SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `citations` (
  `_id` int(11) NOT NULL,
  `msg_parent` text NOT NULL,
  `email_parent` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

CREATE TABLE `grades` (
  `_id` varchar(10) NOT NULL,
  `grade` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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

CREATE TABLE `notations` (
  `_id` int(11) NOT NULL,
  `notation` text NOT NULL,
  `grade` varchar(10) NOT NULL,
  `testimony` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `notations` (`_id`, `notation`, `grade`, `testimony`, `created_at`) VALUES
(1111122448, 'El estudiante agredio a uno de sus compañeros.', '9th', 'Yo solo se que nada se.', '2023-05-11 21:36:51'),
(1111122448, 'Intento meterle candela a uno de los salones.', '5th', 'Exp.', '2023-05-11 21:40:27'),
(7, 'Nostrud repellendus', '10th', 'Natus esse et exped', '2023-05-12 18:56:15');

CREATE TABLE `roles` (
  `_id` varchar(15) NOT NULL,
  `role` varchar(30) NOT NULL,
  `permissions` set('make_notation','cite_parents','view_observer','view_cite_parents') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `roles` (`_id`, `role`, `permissions`) VALUES
('parent', 'Padre de Familia', 'view_observer,view_cite_parents'),
('rector', 'Rector', 'make_notation,cite_parents,view_observer,view_cite_parents'),
('teacher', 'Docente', 'make_notation,cite_parents,view_observer,view_cite_parents');

CREATE TABLE `students` (
  `_id` int(11) NOT NULL,
  `student` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `students` (`_id`, `student`) VALUES
(7, 'Fuga Aliqua Maxime'),
(1111122448, 'Ricardo Andres Rojas Rico de Noveno grado.');

CREATE TABLE `users` (
  `_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `role` enum('teacher','parent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `users` (`_id`, `name`, `lastname`, `telephone`, `email`, `password`, `role`) VALUES
(2, 'Maisie Robinson', 'Stark', '32', 'kexadil@mailinator.com', '$2y$10$g5mcRW02IlryTqBazv4Kg.YjaY21qN8CIw5dvYwW.X2HlsRIcV2ZC', 'parent'),
(15, 'Kasper Powell', 'Russell', '1', 'hykutu@mailinator.com', '$2y$10$oPAAM4q/PTt42lvr/2y33eHu3DHn8En0SzzpXAPVPoCofOpI78gqi', 'parent'),
(65701167, 'Oscar', 'Rojas', '3173926578', 'rrojas48@itfip.edu.co', '$2y$10$7R7EWB0s5hY.LaMrGU3CWOIp1WLWOmmgyYuwMHyiACGSpvE8mkBY2', 'teacher'),
(1005754328, 'michael', 'ramirez', '3112740266', 'michaelstevenhernandezramirez@gmail.com', '$2y$10$/pSHix5AYkhjb4N1WmWHhe7AeWI8Zy1vnEQCGBx65awiqw4etFaoy', 'parent'),
(1005772256, 'Andrés ', 'Mayorquin', '3203048789', 'andrewpark2345@gmail.com', '$2y$10$gDi5JvEBsbmTOaNubVuxH.E1bdCY0g7xIZyaO3.bS6ucd1/l8LPay', 'parent'),
(1111122448, 'Ricardo Andres', 'Rojas Rico', '3173926578', 'rojasricor@gmail.com', '$2y$10$4pZH99QTzEXUW1X8XYbHzuCEYli45kJyTgTEbVqw7D3S/WJAXgEaC', 'teacher');


ALTER TABLE `citations`
  ADD KEY `_id` (`_id`);

ALTER TABLE `grades`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id` (`_id`);

ALTER TABLE `notations`
  ADD KEY `_id` (`_id`) USING BTREE;

ALTER TABLE `roles`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `_id` (`_id`);

ALTER TABLE `students`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `_id` (`_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `_id` (`_id`);


ALTER TABLE `notations`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111122449;

ALTER TABLE `students`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111122449;

ALTER TABLE `users`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111122449;
COMMIT;
