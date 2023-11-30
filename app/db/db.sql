SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `citations` (
  `_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `citation_date` datetime NOT NULL,
  `msg_parent` text NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `citations` (`_id`, `student_id`, `citation_date`, `msg_parent`, `resolved`, `created_at`) VALUES
(1, 1111122448, '2023-11-26 16:38:00', 'Su hijo ha llegado tarde dos veces. Que pasa?', 0, '2023-11-26 16:39:01'),
(2, 1111122448, '2023-11-29 06:00:00', 'test', 0, '2023-11-29 18:18:35');

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
  `student_id` int(11) NOT NULL,
  `notation` text NOT NULL,
  `grade` varchar(10) NOT NULL,
  `testimony` text NOT NULL,
  `severity_level` enum('Grave','Mediano','Leve') NOT NULL,
  `teacher_name` varchar(50) NOT NULL,
  `subject_id` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `notations` (`_id`, `student_id`, `notation`, `grade`, `testimony`, `severity_level`, `teacher_name`, `subject_id`, `created_at`) VALUES
(1, 1111122448, 'Llegada tarde a clases.', 'K', 'Injustificado', 'Leve', 'Carlos Enrique Lara Meneses', '1111122448-6563b91d96d72', '2023-11-26 16:31:09'),
(2, 1111122448, 'Llegada tarde al colegio por segunda vez.', 'K', 'Nuevamente injustificado.', 'Mediano', 'Carlos Enique Lara Meneses', '1111122448-6563baf59ea63', '2023-11-26 16:39:01'),
(7, 1111122448, 'aaaa', 'K', 'aaa', 'Grave', 'Rafael Hernández', '1111122448-6567c688e98b2', '2023-11-29 18:17:29'),
(8, 1111122448, 'test2', 'K', 'test', 'Grave', 'Rafael Hernández', '1111122448-6567c6cb1d625', '2023-11-29 18:18:35');

CREATE TABLE `parents_students` (
  `_id` int(11) NOT NULL,
  `job` varchar(60) NOT NULL,
  `days_available` set('Lunes','Martes','Miércoles','Jueves','Viernes') NOT NULL,
  `availability_start_time` time NOT NULL,
  `availability_end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `parents_students` (`_id`, `job`, `days_available`, `availability_start_time`, `availability_end_time`) VALUES
(92674897, 'Lorem ipsum', 'Lunes,Miércoles,Jueves,Viernes', '09:00:00', '12:00:00'),
(93618323, 'Prueba', '', '00:00:00', '00:00:00');

CREATE TABLE `roles` (
  `_id` enum('teacher','parent','rector','secretary') NOT NULL,
  `role` varchar(30) NOT NULL,
  `permissions` set('make_notation','cite_parents','view_observer','view_cite_parents','admin_students','admin_teachers') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `roles` (`_id`, `role`, `permissions`) VALUES
('teacher', 'Docente', 'make_notation,cite_parents,view_observer,view_cite_parents'),
('parent', 'Padre de Familia', 'view_observer,view_cite_parents'),
('rector', 'Rector', 'make_notation,cite_parents,view_observer,view_cite_parents,admin_students,admin_teachers'),
('secretary', 'Secretaria', 'make_notation,cite_parents,view_observer,view_cite_parents,admin_students,admin_teachers');

CREATE TABLE `students` (
  `_id` int(11) NOT NULL,
  `student` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `students` (`_id`, `student`, `grade`, `parent_id`, `is_enabled`) VALUES
(1111122448, 'Richard Stallman', 'K', 93618323, 1);

CREATE TABLE `subjects` (
  `_id` varchar(30) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_schedule` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `subjects` (`_id`, `subject_name`, `subject_schedule`) VALUES
('1111122448-6563b91d96d72', 'Matemáticas', '07:00:00'),
('1111122448-6563baf59ea63', 'Matemáticas', '07:00:00'),
('1111122448-6567c49bb3c12', 'Quia consectetur aut', '00:31:00'),
('1111122448-6567c4c2f3922', 'test', '18:09:00'),
('1111122448-6567c50c0af72', 'test', '07:00:00'),
('1111122448-6567c58167e8f', 'aaa', '18:19:00'),
('1111122448-6567c5d5927e4', 'aaa', '18:19:00'),
('1111122448-6567c6793efad', 'aaa', '18:19:00'),
('1111122448-6567c67b616ea', 'aaa', '18:19:00'),
('1111122448-6567c688e98b2', 'aaa', '18:19:00'),
('1111122448-6567c6cb1d625', 'test', '18:18:00');

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
(1, 'Rafael', 'Hernández', '3012834716', 'rafaelhernandez@gmail.com', '$2y$10$odAqXs1rTW9JrO6C820r6.IVmcOpJPitzfDeTYo0D28Dx.ocjDKVC', 'rector'),
(65701167, 'Luas', 'asssss', '3178342234', 'jrcs@gmail.com', '$2y$10$cDLIYtKqGaZ5wOdxe7SvC.uVdnc5/ymvnm3GpF2AVgo5X5UsRR3kG', 'parent'),
(92674897, 'Luas', 'Porter', '3287492744', 'spa@gmail.com', '$2y$10$K5BVRXejXdvfTI9STX2Yn.nNS9/VQl9rb7ZTZzqHj08vxjbGbiqmC', 'parent'),
(93173722, 'Carlos Enrique', 'Lara Meneses', '3129487283', 'Clara@itfip.edu.co', '$2y$10$Ptj7IJKgGys0/A29r6b0...wI20FAROrkcf4PC6IoMtb7Np5rRq7q', 'teacher'),
(93618323, 'Acudiente', 'Prueba', '3124826422', 'acudienteprueba@gmail.com', '$2y$10$6CWqwU.lo2/394PtlIOmnOJu5GK3bhUn0CzIowgqYW6CaEhj0kmpu', 'parent'),
(657011672, 'Luas', 'asssss', '3178342234', 'jrcss@gmail.com', '$2y$10$GbczjSpz2lKyRrrcoWyJNOjfcUNmtLs60OWNg8d6eIpm3aUrXBCyG', 'parent');


ALTER TABLE `citations`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `student_id` (`student_id`);

ALTER TABLE `grades`
  ADD PRIMARY KEY (`_id`);

ALTER TABLE `notations`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `grade` (`grade`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `id_subject` (`subject_id`);

ALTER TABLE `parents_students`
  ADD PRIMARY KEY (`_id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`_id`);

ALTER TABLE `students`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `grade` (`grade`),
  ADD KEY `parent_id` (`parent_id`);

ALTER TABLE `subjects`
  ADD PRIMARY KEY (`_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `role` (`role`);


ALTER TABLE `citations`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `notations`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `parents_students`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93618324;

ALTER TABLE `students`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111122449;

ALTER TABLE `users`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=657011673;


ALTER TABLE `citations`
  ADD CONSTRAINT `citations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`_id`);

ALTER TABLE `notations`
  ADD CONSTRAINT `notations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`_id`),
  ADD CONSTRAINT `notations_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`_id`);

ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`grade`) REFERENCES `grades` (`_id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `parents_students` (`_id`);

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`_id`);
