SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `citations` (
  `_id` int(11) NOT NULL,
  `citation_date` datetime NOT NULL,
  `msg_parent` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `citations` (`_id`, `citation_date`, `msg_parent`, `created_at`) VALUES
(738846377, '2023-10-08 07:00:00', 'Lorem ipsum', '2023-10-08 22:09:40');

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
(738846377, 'Lorem ipsum dolor sit amet', '11th', 'Lorem ipsum dolor sit amet', '2023-10-08 22:00:18'),
(738846377, 'Lorem ipsum dolor sit amet', '10th', 'Lorem ipsum dolor sit amet', '2023-10-08 22:06:06'),
(738846377, 'Lorem ipsum dolor sit amet', '10th', 'Lorem ipsum dolor sit amet', '2023-10-08 22:06:25'),
(738846377, 'Lorem ipsum', '11th', 'Lorem ipsum', '2023-10-08 22:07:12'),
(738846377, 'Lorem ipsum', '11th', 'Lorem ipsum', '2023-10-08 22:08:02'),
(738846377, 'Lorem ipsum', '11th', 'Lorem ipsum', '2023-10-08 22:08:18'),
(738846377, 'Lorem ipsum', '11th', 'Lorem ipsum', '2023-10-08 22:09:00'),
(738846377, 'Lorem ipsum', '11th', 'Lorem ipsum', '2023-10-08 22:09:40');

CREATE TABLE `parents_students` (
  `_id` int(11) NOT NULL,
  `job` varchar(60) NOT NULL,
  `availability` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `parents_students` (`_id`, `job`, `availability`) VALUES
(64573864, 'joneydoe@gmail.com', '2023-10-27 10:00:00'),
(65786497, 'Singer', '2023-10-27 05:00:00'),
(93118311, 'Data Enginner', '1998-08-18 07:42:00'),
(336427626, 'Scientific', '2023-10-31 11:00:00'),
(479583637, 'Programmer', '2023-10-12 06:00:00'),
(777846432, 'Computer Engineering', '2023-10-21 20:00:00');

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
(738846377, 'James Doe', '11th', 479583637, 0);

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
(64573864, 'Joney', 'Doe', '3228472744', 'joneydoe@gmail.com', '$2y$10$odAqXs1rTW9JrO6C820r6.IVmcOpJPitzfDeTYo0D28Dx.ocjDKVC', 'parent'),
(65786497, 'Jake', 'Smith', '1335748583', 'jakesmith@gmail.com', '$2y$10$kej6UsGBxAY5HVooVfVAeO5Eq/s6mwf2WthTxPiA.eHzhMB7Sj1..', 'parent'),
(83970346, 'Ryan', 'Ray', '3182647374', 'ryanray@gmail.com', '$2y$10$eoWj.0obrCY6TIDQerhiT.b823ZahMyAIcrqgvBWFOMS0Te/TVz/S', 'teacher'),
(93118311, 'John', 'Doe', '3183047239', 'johndoe@gmail.com', '$2y$10$5Kai.bO.ApkTXwaEig8lIuySewLZaSvc0qDWZ.UOyGTSIFqgo6tvW', 'rector'),
(336427626, 'Jessie', 'Doe', '3887327384', 'jessiedoe@gmail.com', '$2y$10$qvWGRfnuIqV6xo1nItZZmuJFQq4T5AtVfWQ19eu3UpcCn4G5jYFyK', 'parent'),
(479583637, 'Jane', 'Doe', '3193472684', 'janedoe@gmail.com', '$2y$10$1QwJueX7nS.VnySBQ1O.y.iawKE4ZAuJLaJ6aHuXCwcP1DtpA6K3q', 'parent'),
(777846432, 'Jean', 'Doe', '6373263842', 'jeandoe@gmail.com', '$2y$10$RnafqyVXV.kpjOHBazg3He8kLDuC5XPkyijSRuGwxZVcwHCTO5JVO', 'parent');


ALTER TABLE `citations`
  ADD KEY `_id` (`_id`);

ALTER TABLE `grades`
  ADD PRIMARY KEY (`_id`);

ALTER TABLE `notations`
  ADD KEY `_id` (`_id`) USING BTREE,
  ADD KEY `grade` (`grade`);

ALTER TABLE `parents_students`
  ADD PRIMARY KEY (`_id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`_id`);

ALTER TABLE `students`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `grade` (`grade`),
  ADD KEY `parent_id` (`parent_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `role` (`role`);


ALTER TABLE `notations`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=738846378;

ALTER TABLE `parents_students`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=777846433;

ALTER TABLE `students`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=738846378;

ALTER TABLE `users`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=777846433;


ALTER TABLE `citations`
  ADD CONSTRAINT `citations_ibfk_1` FOREIGN KEY (`_id`) REFERENCES `students` (`_id`);

ALTER TABLE `notations`
  ADD CONSTRAINT `notations_ibfk_1` FOREIGN KEY (`_id`) REFERENCES `students` (`_id`);

ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`grade`) REFERENCES `grades` (`_id`);

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`_id`);
