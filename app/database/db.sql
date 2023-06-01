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

CREATE TABLE `roles` (
  `_id` varchar(15) NOT NULL,
  `role` varchar(30) NOT NULL,
  `permissions` set('make_notation','cite_parents','view_observer','view_cite_parents','admin_students','admin_teachers') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `roles` (`_id`, `role`, `permissions`) VALUES
('parent', 'Padre de Familia', 'view_observer,view_cite_parents'),
('rector', 'Rector', 'make_notation,cite_parents,view_observer,view_cite_parents,admin_students,admin_teachers'),
('secretary', 'Secretaria', 'make_notation,cite_parents,view_observer,view_cite_parents,admin_students,admin_teachers'),
('teacher', 'Docente', 'make_notation,cite_parents,view_observer,view_cite_parents');

CREATE TABLE `students` (
  `_id` int(11) NOT NULL,
  `student` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `name_parent` varchar(50) NOT NULL,
  `email_parent` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `students` (`_id`, `student`, `grade`, `name_parent`, `email_parent`) VALUES
(1111122448, 'Ricardo Andrés Rojas Rico', '11th', 'Persona xyz', 'rojasricor@gmail.com');

CREATE TABLE `users` (
  `_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `role` enum('teacher','parent','rector','secretary') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `users` (`_id`, `name`, `lastname`, `telephone`, `email`, `password`, `role`) VALUES
(1111122448, 'Ricardo Andrés', 'Rojas Rico', '3173926578', 'rojasricor@gmail.com', '$2y$10$TPTBpf8ExiOTlJPRY.IfwO1EDUBulCoGhC9yBCqAjLrcOoqX.Ud/i', 'teacher');


ALTER TABLE `citations`
  ADD KEY `_id` (`_id`);

ALTER TABLE `grades`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id` (`_id`);

ALTER TABLE `notations`
  ADD KEY `_id` (`_id`) USING BTREE,
  ADD KEY `grade` (`grade`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `_id` (`_id`);

ALTER TABLE `students`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `_id` (`_id`),
  ADD KEY `grade` (`grade`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `_id` (`_id`);


ALTER TABLE `notations`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `students`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111122449;

ALTER TABLE `users`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111122451;


ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`grade`) REFERENCES `grades` (`_id`);
COMMIT;
