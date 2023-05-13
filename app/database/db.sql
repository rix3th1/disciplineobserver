SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `role` enum('teacher','parent') NOT NULL,
  `permissions` set('make_notation','cite_parents','view_observer','view_cite_parents') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

INSERT INTO `users` (`_id`, `name`, `lastname`, `telephone`, `email`, `password`, `role`, `permissions`) VALUES
(1111122448, 'Ricardo Andres', 'Rojas Rico', '3173926578', 'rojasricor@gmail.com', '$2y$10$4pZH99QTzEXUW1X8XYbHzuCEYli45kJyTgTEbVqw7D3S/WJAXgEaC', 'parent', 'view_observer,view_cite_parents');


ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `ID CARD` (`_id`);
COMMIT;
