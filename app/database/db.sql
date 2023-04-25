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
(9, 'Raymond Webster', 'Clayton', '51', 'jajer@mailinator.com', '$2y$10$VD9y77KRH8Mxvy0Yj1bZDOtFvZt/xbwoJ/m4O66Rgs2.b8ik2DFyy', 'parent', 'view_observer,view_cite_parents'),
(11, 'Anthony Robbins', 'Boyd', '77', 'kynybabumo@mailinator.com', '$2y$10$s5a5qBF.NwQvJ.1ubHfsV.gNUyhx1x/FFgDwFomQgdX/5fCtvB4KW', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(12, 'Eve Bowers', 'Hopkins', '26', 'xyqafizo@mailinator.com', '$2y$10$EVSd3ZxrwTwgDDvIHeFxquQPNp3xGBJD4Iqg5jTMzq9oeAPf2Lx1e', 'parent', 'view_observer,view_cite_parents'),
(13, 'Mallory Franks', 'Gomez', '85', 'hohytatyt@mailinator.com', '$2y$10$Y7xpjfzj46w4HZy6wVQfoeWSLIW.Z0o4Ca7WI3971pNY7NjtoRigm', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(26, 'Ocean Oliver', 'Carter', '18', 'bywizixaj@mailinator.com', '$2y$10$g2sdldMRc2pOse2RqvoHYuq5sWN5Dy9BBJEVm4A3H8IkxebHW5g5i', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(37, 'Jeremy Levy', 'Fox', '87', 'dorymebe@mailinator.com', '$2y$10$WQMKK6YXRHNwtndsoOfkIeNl.0iIlz9Y0u0PM8qitljXRTCJi4TO6', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(45, 'Isaac Perez', 'Peterson', '42', 'biqyke@mailinator.com', '$2y$10$ms2ygqZp0sTyS0g9QYW2f.lngPNpfVOEZHPHSWYTKhGzUA1fF02ZS', 'parent', 'view_observer,view_cite_parents'),
(48, 'Benedict Hall', 'Vaughn', '76', 'dakeweti@mailinator.com', '$2y$10$WgN4OcOvhd3UvrbIBpb1LedNtvgxfqud41OZiuzxNY32uhxk5/SUm', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(49, 'Zenaida Norton', 'Fitzpatrick', '48', 'lehekah@mailinator.com', '$2y$10$ve4Lv5F9g.HYLL8CI011Wenn.3ce1y0H6gQQC1lrXWryabpOQD.sG', 'parent', 'view_observer,view_cite_parents'),
(53, 'Daria Frank', 'Douglas', '45', 'goqiwetah@mailinator.com', '$2y$10$2YttpHYYKBVO8Uf3TwIVteIRX7GzaqEMplE5oud7CtQWAJydK6dSu', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(59, 'Shannon Jefferson', 'Rowe', '33', 'jehewilep@mailinator.com', '$2y$10$ijZVGj1sDQeggheIS3ioeOIrvgeJgY46FOibz3zGZZ8oPIXjbB51.', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(68, 'Kathleen Hoover', 'Dunlap', '46', 'xojeripazo@mailinator.com', '$2y$10$ck9frOdn4AC8Ul..we1EAOyWGJAoDX95g5HuZX9ts4XyosshitSwO', 'parent', 'view_observer,view_cite_parents'),
(70, 'Ruth Vaughan', 'Green', '42', 'tacuzog@mailinator.com', '$2y$10$hr67ripHCw6tNbFed1//Ze3XeiA2JVY2J9s.Ktsyfzat8HD4oUTFS', 'parent', 'view_observer,view_cite_parents'),
(72, 'Judith Roberson', 'Calderon', '26', 'delymu@mailinator.com', '$2y$10$KkUgUfmNL2xlQiSEH9.mAesjjvpX7GfxlNwSkary3qyUzbSAtvJXW', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(84, 'Fallon Norton', 'Miles', '22', 'kivijuwen@mailinator.com', '$2y$10$Devr0P4qTU9oURfQAZwsnu.sfYHUZgcbNo60awD3wuCmPaSDxFL4u', 'parent', 'view_observer,view_cite_parents'),
(87, 'Maggie Keller', 'Carrillo', '17', 'lypasinuki@mailinator.com', '$2y$10$XTFxUiw63zGCPl9aSpAlu.WVRFhynG15k7i9cEjLRAWaVHTKxR9Qy', 'parent', 'view_observer,view_cite_parents'),
(65701167, 'daadasda', 'Rojas', '3173926578', 'rojasricor@gmail.com', '$2y$10$Sd4KW1Q/6yp4CB9elyzPDuvXpR5/07xXokRWzVNzl0l.3BNIaBD5W', 'teacher', 'make_notation,cite_parents,view_observer,view_cite_parents'),
(393738947, 'Xanthus Clarke', 'Stark', '6265555554', 'rsystfip@gmail.com', '$2y$10$/Cqu0ug4dMsX5eHLExp4pOSbwEIqjK.L2HfVUwyz5hvA9.G8HfieC', 'parent', 'view_observer,view_cite_parents'),
(1111122448, 'Ricardo Andres', 'Rojas Rico', '3173926578', 'rrojas48@itfip.edu.co', '$2y$10$uI/ZxDeeBPal/4AGUgFiv.97EFRTvxcMuGrMD5D9C4Ae98Rt3QhwO', 'parent', 'view_observer,view_cite_parents');


ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `ID CARD` (`_id`);
COMMIT;
