SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `abstract_citations` (
  `_id` int(11) NOT NULL,
  `citation_id` int(11) NOT NULL,
  `resolved` tinyint(1) NOT NULL,
  `observation_txt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

CREATE TABLE `citations` (
  `_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `citation_date` datetime NOT NULL,
  `msg_parent` text NOT NULL,
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
  `student_id` int(11) NOT NULL,
  `notation` text NOT NULL,
  `grade` varchar(10) NOT NULL,
  `testimony` text NOT NULL,
  `teacher_name` varchar(50) NOT NULL,
  `subject_id` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

CREATE TABLE `parents_students` (
  `_id` int(11) NOT NULL,
  `job` varchar(60) NOT NULL,
  `availability` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `parents_students` (`_id`, `job`, `availability`) VALUES
(2147483647, 'Data Science', '2023-11-21 17:03:00');

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
(374287362, 'James Doe', '2nd', 2147483647, 1);

CREATE TABLE `subjects` (
  `_id` varchar(30) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_schedule` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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
(1, 'John', 'Doe', '3012834716', 'rojasricor@gmail.com', '$2y$10$odAqXs1rTW9JrO6C820r6.IVmcOpJPitzfDeTYo0D28Dx.ocjDKVC', 'rector'),
(46738328, 'Ryan', 'Ray', '3173927402', 'ryanray@gmail.com', '$2y$10$Pdv8fUdXNF3Fjik43lzuCu.pWCFYBZauRb5gf33uXh.Oh4FTzp5HK', 'teacher'),
(2147483647, 'Jose Repelin', 'Cucharas', '3173628492', 'jrc@gmail.com', '$2y$10$MoLuQsjpF/hu506BIoJK2usYzArKpJ1qdEQTGbzHlQlMwp7llGhK6', 'parent');


ALTER TABLE `abstract_citations`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `citation_id` (`citation_id`);

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


ALTER TABLE `abstract_citations`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `citations`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `notations`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `parents_students`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

ALTER TABLE `students`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=374287363;

ALTER TABLE `users`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;


ALTER TABLE `abstract_citations`
  ADD CONSTRAINT `abstract_citations_ibfk_1` FOREIGN KEY (`citation_id`) REFERENCES `citations` (`_id`);

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
