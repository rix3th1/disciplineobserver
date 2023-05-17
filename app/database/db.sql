SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `citations` (
  `_id` int(11) NOT NULL,
  `msg_parent` text NOT NULL,
  `email_parent` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `citations` (`_id`, `msg_parent`, `email_parent`, `created_at`) VALUES
(17, 'Id asperiores qui vo', 'Consequatur aperiam ', '2023-05-13 11:27:04'),
(26, 'Ut qui quas commodo ', 'Sequi facilis dolore', '2023-05-13 11:28:15'),
(26, 'Expedita quo dolore ', 'Sunt sit corporis ', '2023-05-13 12:23:35'),
(1111122448, 'acuda rapido sr.', 'rojasricor@gmail.com', '2023-05-13 12:31:45'),
(1111122448, 'Acuda rapido por favor sr. padre de familia', 'rojasricor@gmail.com', '2023-05-13 12:41:37'),
(1111122448, 'Acuda rapido por favor sr. padre de familia', 'rojasricor@gmail.com', '2023-05-13 12:42:38'),
(1111122448, 'Deserunt lorem id v', 'Et amet vel odit cu', '2023-05-13 12:45:43'),
(1111122448, 'Qui qui dolor velit ', 'Quisquam aperiam rep', '2023-05-13 12:46:34'),
(1111122448, 'Qui qui dolor velit ', 'Quisquam aperiam rep', '2023-05-13 13:29:07'),
(1111122448, 'Nam nihil nisi earum', 'Earum suscipit fugia', '2023-05-13 13:29:28'),
(1111122448, 'Aliquam dolores dolo', 'rojasricor@gmail.com', '2023-05-13 13:31:15'),
(1111122448, 'Aliquam dolores dolo', 'rojasricor@gmail.com', '2023-05-13 13:33:21'),
(1111122448, 'Aliquam dolores dolo', 'rojasricor@gmail.com', '2023-05-13 13:34:16'),
(1111122448, 'Aliquam dolores dolo', 'rojasricor@gmail.com', '2023-05-13 13:35:41'),
(1111122448, 'Officiis ducimus be', 'Rem autem quis paria', '2023-05-13 14:42:20'),
(1111122448, 'Officiis ducimus be', 'Rem autem quis paria', '2023-05-13 14:43:03'),
(1111122448, 'Officiis ducimus be', 'Rem autem quis paria', '2023-05-13 14:43:07'),
(1111122448, 'Officiis ducimus be', 'Rem autem quis paria', '2023-05-13 14:43:09'),
(1111122448, 'Officiis ducimus be', 'Rem autem quis paria', '2023-05-13 14:43:09'),
(1111122448, 'Officiis ducimus be', 'Rem autem quis paria', '2023-05-13 14:43:10'),
(1111122448, 'Id iusto sit nihil ', 'Eligendi dignissimos', '2023-05-13 14:44:14'),
(1111122448, 'Id iusto sit nihil ', 'Eligendi dignissimos', '2023-05-13 14:44:20'),
(1111122448, 'Id iusto sit nihil ', 'Eligendi dignissimos', '2023-05-13 14:44:30'),
(1111122448, 'Id iusto sit nihil ', 'Eligendi dignissimos', '2023-05-13 14:44:50'),
(1111122448, 'Id iusto sit nihil ', 'Eligendi dignissimos', '2023-05-13 14:45:05'),
(1111122448, 'Id iusto sit nihil ', 'Eligendi dignissimos', '2023-05-13 14:45:14'),
(1111122448, 'Eveniet qui vero si', 'Ut quod dolor proide', '2023-05-13 14:45:28'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:45:43'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:45:55'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:46:08'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:56:30'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:57:13'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:57:25'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:57:32'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:58:00'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:58:23'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:58:27'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:58:43'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 14:58:49'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 15:04:21'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 15:05:42'),
(1111122448, 'Irure maiores praese', 'rojasricor@gmail.com', '2023-05-13 15:06:13'),
(1111122448, 'Labore unde tempora ', 'Aut aut consequuntur', '2023-05-13 19:53:10'),
(1111122448, 'Ipsa quia sed accus', 'rojasricor@gmail.com', '2023-05-13 19:53:40'),
(1111122448, 'Hic cum quis volupta', 'rojasricor@gmail.com', '2023-05-13 19:55:20'),
(1111122448, 'Hic cum quis volupta', 'rojasricor@gmail.com', '2023-05-13 20:04:19'),
(1111122448, 'Architecto inventore', 'Nisi dolores Nam nis', '2023-05-15 13:37:10'),
(1111122448, 'Consequuntur volupta', 'rrojas48@itfip.edu.co', '2023-05-15 13:37:34'),
(1111122448, 'Consequuntur volupta', 'rrojas48@itfip.edu.co', '2023-05-15 13:37:55'),
(1111122448, 'Exercitationem totam', 'rojasricor@gmail.com', '2023-05-15 13:38:23'),
(1111122448, 'Exercitationem totam', 'rojasricor@gmail.com', '2023-05-15 13:55:29');

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
(7, 'Nostrud repellendus', '10th', 'Natus esse et exped', '2023-05-12 18:56:15'),
(17, 'Beatae ratione aut N', 'K', 'Neque eius elit eu ', '2023-05-13 11:26:15'),
(17, 'Beatae ratione aut N', 'K', 'Neque eius elit eu ', '2023-05-13 11:27:04'),
(26, 'Tenetur ad assumenda', '11th', 'Sed reprehenderit do', '2023-05-13 11:28:15'),
(26, 'Numquam minim archit', '11th', 'Dolore est excepturi', '2023-05-13 12:23:35'),
(1111122448, 'Cago en los banos', '8th', 'jajajaj', '2023-05-13 12:31:45'),
(1111122448, 'jajaja', 'PK', 'XD', '2023-05-13 12:41:37'),
(1111122448, 'jajaja', 'PK', 'XD', '2023-05-13 12:42:38'),
(1111122448, 'A maxime sint non d', '1st', 'Dolores temporibus s', '2023-05-13 12:45:43'),
(1111122448, 'Dolore eos autem no', '3rd', 'Cumque error quia sa', '2023-05-13 12:46:34'),
(1111122448, 'Dolore eos autem no', '3rd', 'Cumque error quia sa', '2023-05-13 13:29:07'),
(1111122448, 'Explicabo Commodo t', '3rd', 'Iure quisquam conseq', '2023-05-13 13:29:28'),
(1111122448, 'Expedita nulla conse', 'PK', 'Consequatur delectus', '2023-05-13 13:31:15'),
(1111122448, 'Expedita nulla conse', 'PK', 'Consequatur delectus', '2023-05-13 13:33:21'),
(1111122448, 'Expedita nulla conse', 'PK', 'Consequatur delectus', '2023-05-13 13:34:16'),
(1111122448, 'Expedita nulla conse', 'PK', 'Consequatur delectus', '2023-05-13 13:35:41'),
(1111122448, 'Quia eum id repellen', '3rd', 'Ut aute eos officia', '2023-05-13 14:42:20'),
(1111122448, 'Quia eum id repellen', '3rd', 'Ut aute eos officia', '2023-05-13 14:43:03'),
(1111122448, 'Quia eum id repellen', '3rd', 'Ut aute eos officia', '2023-05-13 14:43:07'),
(1111122448, 'Quia eum id repellen', '3rd', 'Ut aute eos officia', '2023-05-13 14:43:09'),
(1111122448, 'Quia eum id repellen', '3rd', 'Ut aute eos officia', '2023-05-13 14:43:09'),
(1111122448, 'Quia eum id repellen', '3rd', 'Ut aute eos officia', '2023-05-13 14:43:10'),
(1111122448, 'Consectetur proident', 'K', 'Culpa delectus sint', '2023-05-13 14:44:14'),
(1111122448, 'Consectetur proident', 'K', 'Culpa delectus sint', '2023-05-13 14:44:20'),
(1111122448, 'Consectetur proident', 'K', 'Culpa delectus sint', '2023-05-13 14:44:30'),
(1111122448, 'Consectetur proident', 'K', 'Culpa delectus sint', '2023-05-13 14:44:50'),
(1111122448, 'Consectetur proident', 'K', 'Culpa delectus sint', '2023-05-13 14:45:04'),
(1111122448, 'Consectetur proident', 'K', 'Culpa delectus sint', '2023-05-13 14:45:14'),
(1111122448, 'Pariatur Et sit lo', 'K', 'Voluptate id optio', '2023-05-13 14:45:28'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:45:42'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:45:55'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:46:08'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:56:30'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:57:13'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:57:25'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:57:32'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:58:00'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:58:23'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:58:27'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:58:43'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 14:58:49'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 15:04:21'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 15:05:42'),
(1111122448, 'Dolor sit culpa ex', 'K', 'Autem asperiores ali', '2023-05-13 15:06:13'),
(1111122448, 'Molestiae ad natus a', '7th', 'Incididunt non ea cu', '2023-05-13 19:53:10'),
(1111122448, 'Non suscipit Nam con', '7th', 'Id sit non quis min', '2023-05-13 19:53:40'),
(1111122448, 'Necessitatibus omnis', '4th', 'Ut debitis autem quo', '2023-05-13 19:55:20'),
(1111122448, 'Necessitatibus omnis', '4th', 'Ut debitis autem quo', '2023-05-13 20:04:19'),
(1111122448, 'Modi minima accusant', '9th', 'Veniam molestiae do', '2023-05-15 13:37:10'),
(1111122448, 'Nihil in suscipit pe', '9th', 'Quis explicabo Reru', '2023-05-15 13:37:34'),
(1111122448, 'Nihil in suscipit pe', '9th', 'Quis explicabo Reru', '2023-05-15 13:37:55'),
(1111122448, 'Laborum sint blandi', '9th', 'Excepturi odit eius ', '2023-05-15 13:38:23'),
(1111122448, 'Laborum sint blandi', '9th', 'Excepturi odit eius ', '2023-05-15 13:55:29');

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
(17, 'Quasi irure iste ape'),
(26, 'Dolore proident rer'),
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
