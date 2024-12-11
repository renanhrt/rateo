-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/12/2024 às 01:56
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rateo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `requests`
--

CREATE TABLE `requests` (
  `id_request` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_song` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `song`
--

CREATE TABLE `song` (
  `id_song` varchar(22) NOT NULL,
  `title` text NOT NULL,
  `year` int(11) NOT NULL,
  `artist` text NOT NULL,
  `cover` text NOT NULL,
  `is_request` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `song`
--

INSERT INTO `song` (`id_song`, `title`, `year`, `artist`, `cover`, `is_request`) VALUES
('01Txvu3dNthhldq8oR0Pae', 'Money For Nothing', 2005, 'Dire Straits', 'https://i.scdn.co/image/ab67616d0000b273178419da701ab7c7f693c9ac', 0),
('0ofHAoxe9vBkTCp2UQIavz', 'Dreams - 2004 Remaster', 1977, 'Fleetwood Mac', 'https://i.scdn.co/image/ab67616d0000b273e52a59a28efa4773dd2bfe1b', 0),
('0pQskrTITgmCMyr85tb9qq', 'Starman - 2012 Remaster', 1972, 'David Bowie', 'https://i.scdn.co/image/ab67616d0000b273c41f4e1133b0e6c5fcf58680', 0),
('1CtAzw53AIXKjAemxy4b1j', 'Beds Are Burning - Remastered', 1987, 'Midnight Oil', 'https://i.scdn.co/image/ab67616d0000b2730dd350beeb5ac73672ad6e80', 0),
('2kVm4qAAXR7qUfHdiKg0qI', 'Cowboy Fora Da Lei', 1987, 'Raul Seixas', 'https://i.scdn.co/image/ab67616d0000b2738ea0dfe90d5ce77b44a38216', 0),
('2SiXAy7TuUkycRVbbWDEpo', 'You Shook Me All Night Long', 1980, 'AC/DC', 'https://i.scdn.co/image/ab67616d0000b2730b51f8d91f3a21e8426361ae', 0),
('31AOj9sFz2gM0O3hMARRBx', 'Losing My Religion', 1991, 'R.E.M.', 'https://i.scdn.co/image/ab67616d0000b273e2dd4e821bcc3f70dc0c8ffd', 0),
('37Tmv4NnfQeb0ZgUC4fOJj', 'Sultans Of Swing', 1978, 'Dire Straits', 'https://i.scdn.co/image/ab67616d0000b273b49d49cc95564aede7998bb8', 0),
('3lPr8ghNDBLc2uZovNyLs9', 'Supermassive Black Hole', 2006, 'Muse', 'https://i.scdn.co/image/ab67616d0000b27328933b808bfb4cbbd0385400', 0),
('4aVuWgvD0X63hcOCnZtNFA', 'Hold the Line', 1978, 'TOTO', 'https://i.scdn.co/image/ab67616d0000b273f903e62767a0e22e33b7af83', 0),
('4DMKwE2E2iYDKY01C335Uw', 'Carry on Wayward Son', 1976, 'Kansas', 'https://i.scdn.co/image/ab67616d0000b2731be40e44db112e123e5e8b51', 0),
('4gMgiXfqyzZLMhsksGmbQV', 'Another Brick in the Wall, Pt. 2', 1979, 'Pink Floyd', 'https://i.scdn.co/image/ab67616d0000b2735d48e2f56d691f9a4e4b0bdf', 0),
('5e9TFTbltYBg2xThimr0rU', 'The Chain - 2004 Remaster', 1977, 'Fleetwood Mac', 'https://i.scdn.co/image/ab67616d0000b273e52a59a28efa4773dd2bfe1b', 0),
('5sICkBXVmaCQk5aISGR3x1', 'Enter Sandman', 1991, 'Metallica', 'https://i.scdn.co/image/ab67616d0000b273cf84c5b276431b473e924802', 0),
('7MnT7msJZg3XBAS0OTfGrB', 'Tempo Perdido', 1986, 'Legião Urbana', 'https://i.scdn.co/image/ab67616d0000b2731eb5e996639036a49b09f1e5', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@aluno.feliz.ifrs.edu.br', '$2y$10$/SD9TiQw2KSWBrowD2E1.O2YW4yDp3/ZYFEz1q0EVnJmD4zcjGPW6', 'admin'),
(2, 'renanhrt', 'renan.hardt@aluno.feliz.ifrs.edu.br', '$2y$10$d3scqO.Z9b4GP25csGoG5e/sNtLWybuat/.ZhpV1KSmEtKSLQOQza', 'user'),
(3, 'usuario1', 'usuario1@aluno.feliz.ifrs.edu.br', '$2y$10$xHB5DSQd1nCC.4ffsBjyY.2.1.J9Oa7SdfEsqxQaIYQRotqeJ2w4u', 'user'),
(4, 'usuario2', 'usuario2@aluno.feliz.ifrs.edu.br', '$2y$10$p.e8TY3w3bpk1cqau17Wu.0di8xScNN34vDOT4laJqTzXaMz2mw1q', 'user'),
(5, 'usuario3', 'usuario3@aluno.feliz.ifrs.edu.br', '$2y$10$05VoRA66ssXUWBwxIeSCV.EEkmrfBq.wCgcYBnxpGBGlBb/FbdRF2', 'user'),
(6, 'usuario4', 'usuario4@aluno.feliz.ifrs.edu.br', '$2y$10$Wfu5GYQByy/fdug1/BX3g.eftDQnFJiSTzS9llSJVt8wHdAbsXVdq', 'user'),
(7, 'usuario5', 'usuario5@aluno.feliz.ifrs.edu.br', '$2y$10$RJfNmqHKMj/d5b6p8KvssuCEiz5.zCXKpIJb4LGGhpkD7VPAjvD.S', 'user'),
(8, 'usuario6', 'usuario6@aluno.feliz.ifrs.edu.br', '$2y$10$Kfo.NAcFdpSPmanO9HGP.uab0fQYmu.92IOzSYE5ns6S.nI0NWTBe', 'user'),
(9, 'usuario7', 'usuario7@aluno.feliz.ifrs.edu.br', '$2y$10$DY.vrDfqdQE5M9nh9rsrG.KdtUcs/kCfT5leWOQNfAe8o.DvVv9TC', 'user');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vote`
--

CREATE TABLE `vote` (
  `id_vote` int(11) NOT NULL,
  `id_song` varchar(22) NOT NULL,
  `id_user` int(11) NOT NULL,
  `vote_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vote`
--

INSERT INTO `vote` (`id_vote`, `id_song`, `id_user`, `vote_number`) VALUES
(6, '5sICkBXVmaCQk5aISGR3x1', 1, 4),
(7, '5e9TFTbltYBg2xThimr0rU', 1, 5),
(8, '3lPr8ghNDBLc2uZovNyLs9', 1, 3),
(11, '2kVm4qAAXR7qUfHdiKg0qI', 1, 5),
(12, '4DMKwE2E2iYDKY01C335Uw', 1, 3),
(13, '0pQskrTITgmCMyr85tb9qq', 1, 4),
(14, '7MnT7msJZg3XBAS0OTfGrB', 1, 3),
(15, '1CtAzw53AIXKjAemxy4b1j', 1, 5),
(17, '37Tmv4NnfQeb0ZgUC4fOJj', 1, 5),
(19, '4aVuWgvD0X63hcOCnZtNFA', 1, 4),
(20, '31AOj9sFz2gM0O3hMARRBx', 1, 3),
(21, '01Txvu3dNthhldq8oR0Pae', 1, 4),
(22, '2SiXAy7TuUkycRVbbWDEpo', 1, 3),
(23, '4gMgiXfqyzZLMhsksGmbQV', 1, 4),
(24, '0ofHAoxe9vBkTCp2UQIavz', 1, 2),
(25, '5e9TFTbltYBg2xThimr0rU', 3, 4),
(26, '01Txvu3dNthhldq8oR0Pae', 3, 3),
(27, '1CtAzw53AIXKjAemxy4b1j', 3, 2),
(28, '0ofHAoxe9vBkTCp2UQIavz', 3, 5),
(29, '3lPr8ghNDBLc2uZovNyLs9', 3, 1),
(30, '2kVm4qAAXR7qUfHdiKg0qI', 3, 3),
(31, '0pQskrTITgmCMyr85tb9qq', 3, 2),
(32, '4gMgiXfqyzZLMhsksGmbQV', 3, 3),
(33, '37Tmv4NnfQeb0ZgUC4fOJj', 3, 4),
(34, '7MnT7msJZg3XBAS0OTfGrB', 3, 3),
(35, '4DMKwE2E2iYDKY01C335Uw', 3, 5),
(36, '31AOj9sFz2gM0O3hMARRBx', 3, 1),
(37, '4aVuWgvD0X63hcOCnZtNFA', 3, 3),
(38, '2SiXAy7TuUkycRVbbWDEpo', 3, 4),
(39, '5sICkBXVmaCQk5aISGR3x1', 3, 2),
(40, '1CtAzw53AIXKjAemxy4b1j', 4, 3),
(41, '01Txvu3dNthhldq8oR0Pae', 4, 2),
(42, '2kVm4qAAXR7qUfHdiKg0qI', 4, 4),
(43, '0pQskrTITgmCMyr85tb9qq', 4, 5),
(44, '4gMgiXfqyzZLMhsksGmbQV', 4, 3),
(45, '5sICkBXVmaCQk5aISGR3x1', 4, 4),
(46, '3lPr8ghNDBLc2uZovNyLs9', 4, 5),
(47, '2SiXAy7TuUkycRVbbWDEpo', 4, 2),
(48, '7MnT7msJZg3XBAS0OTfGrB', 4, 4),
(49, '5e9TFTbltYBg2xThimr0rU', 4, 5),
(50, '0ofHAoxe9vBkTCp2UQIavz', 4, 3),
(51, '4aVuWgvD0X63hcOCnZtNFA', 4, 5),
(52, '31AOj9sFz2gM0O3hMARRBx', 4, 2),
(53, '4DMKwE2E2iYDKY01C335Uw', 4, 3),
(54, '37Tmv4NnfQeb0ZgUC4fOJj', 4, 5),
(55, '7MnT7msJZg3XBAS0OTfGrB', 5, 4),
(56, '5sICkBXVmaCQk5aISGR3x1', 5, 3),
(57, '2SiXAy7TuUkycRVbbWDEpo', 5, 2),
(58, '4aVuWgvD0X63hcOCnZtNFA', 5, 5),
(59, '4DMKwE2E2iYDKY01C335Uw', 5, 4),
(60, '1CtAzw53AIXKjAemxy4b1j', 5, 3),
(61, '0pQskrTITgmCMyr85tb9qq', 5, 2),
(62, '2kVm4qAAXR7qUfHdiKg0qI', 5, 5),
(63, '0ofHAoxe9vBkTCp2UQIavz', 5, 4),
(64, '31AOj9sFz2gM0O3hMARRBx', 5, 5),
(65, '3lPr8ghNDBLc2uZovNyLs9', 5, 3),
(66, '5e9TFTbltYBg2xThimr0rU', 5, 2),
(67, '37Tmv4NnfQeb0ZgUC4fOJj', 5, 5),
(68, '4gMgiXfqyzZLMhsksGmbQV', 5, 3),
(69, '01Txvu3dNthhldq8oR0Pae', 5, 1),
(70, '0pQskrTITgmCMyr85tb9qq', 6, 3),
(71, '3lPr8ghNDBLc2uZovNyLs9', 6, 5),
(72, '37Tmv4NnfQeb0ZgUC4fOJj', 6, 5),
(73, '1CtAzw53AIXKjAemxy4b1j', 6, 2),
(74, '31AOj9sFz2gM0O3hMARRBx', 6, 1),
(75, '01Txvu3dNthhldq8oR0Pae', 6, 3),
(76, '0ofHAoxe9vBkTCp2UQIavz', 6, 4),
(77, '2kVm4qAAXR7qUfHdiKg0qI', 6, 2),
(78, '2SiXAy7TuUkycRVbbWDEpo', 6, 3),
(79, '4gMgiXfqyzZLMhsksGmbQV', 6, 4),
(80, '4aVuWgvD0X63hcOCnZtNFA', 6, 3),
(81, '5sICkBXVmaCQk5aISGR3x1', 6, 5),
(82, '7MnT7msJZg3XBAS0OTfGrB', 6, 2),
(83, '4DMKwE2E2iYDKY01C335Uw', 6, 1),
(84, '5e9TFTbltYBg2xThimr0rU', 6, 5),
(85, '2kVm4qAAXR7qUfHdiKg0qI', 7, 4),
(86, '4aVuWgvD0X63hcOCnZtNFA', 7, 3),
(87, '0pQskrTITgmCMyr85tb9qq', 7, 2),
(88, '3lPr8ghNDBLc2uZovNyLs9', 7, 4),
(89, '7MnT7msJZg3XBAS0OTfGrB', 7, 3),
(90, '0ofHAoxe9vBkTCp2UQIavz', 7, 5),
(91, '5e9TFTbltYBg2xThimr0rU', 7, 5),
(92, '1CtAzw53AIXKjAemxy4b1j', 7, 2),
(93, '31AOj9sFz2gM0O3hMARRBx', 7, 3),
(94, '37Tmv4NnfQeb0ZgUC4fOJj', 7, 5),
(95, '4gMgiXfqyzZLMhsksGmbQV', 7, 2),
(96, '4DMKwE2E2iYDKY01C335Uw', 7, 4),
(97, '01Txvu3dNthhldq8oR0Pae', 7, 3),
(98, '5sICkBXVmaCQk5aISGR3x1', 7, 2),
(99, '2SiXAy7TuUkycRVbbWDEpo', 7, 4),
(100, '31AOj9sFz2gM0O3hMARRBx', 8, 4),
(101, '1CtAzw53AIXKjAemxy4b1j', 8, 3),
(102, '0pQskrTITgmCMyr85tb9qq', 8, 2),
(103, '01Txvu3dNthhldq8oR0Pae', 8, 3),
(104, '5e9TFTbltYBg2xThimr0rU', 8, 2),
(105, '3lPr8ghNDBLc2uZovNyLs9', 8, 4),
(106, '4DMKwE2E2iYDKY01C335Uw', 8, 3),
(107, '7MnT7msJZg3XBAS0OTfGrB', 8, 2),
(108, '2kVm4qAAXR7qUfHdiKg0qI', 8, 3),
(109, '2SiXAy7TuUkycRVbbWDEpo', 8, 1),
(110, '37Tmv4NnfQeb0ZgUC4fOJj', 8, 5),
(111, '4gMgiXfqyzZLMhsksGmbQV', 8, 3),
(112, '0ofHAoxe9vBkTCp2UQIavz', 8, 5),
(113, '5sICkBXVmaCQk5aISGR3x1', 8, 2),
(114, '4aVuWgvD0X63hcOCnZtNFA', 8, 4),
(115, '37Tmv4NnfQeb0ZgUC4fOJj', 9, 5),
(116, '01Txvu3dNthhldq8oR0Pae', 9, 4),
(117, '4aVuWgvD0X63hcOCnZtNFA', 9, 3),
(118, '5e9TFTbltYBg2xThimr0rU', 9, 4),
(119, '4DMKwE2E2iYDKY01C335Uw', 9, 5),
(120, '2kVm4qAAXR7qUfHdiKg0qI', 9, 4),
(121, '3lPr8ghNDBLc2uZovNyLs9', 9, 3),
(122, '7MnT7msJZg3XBAS0OTfGrB', 9, 5),
(123, '2SiXAy7TuUkycRVbbWDEpo', 9, 4),
(124, '4gMgiXfqyzZLMhsksGmbQV', 9, 5),
(125, '1CtAzw53AIXKjAemxy4b1j', 9, 4),
(126, '0pQskrTITgmCMyr85tb9qq', 9, 5),
(127, '0ofHAoxe9vBkTCp2UQIavz', 9, 4),
(128, '31AOj9sFz2gM0O3hMARRBx', 9, 5),
(129, '5sICkBXVmaCQk5aISGR3x1', 9, 5);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_song` (`id_song`);

--
-- Índices de tabela `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id_song`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Índices de tabela `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id_vote`),
  ADD KEY `id_song` (`id_song`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `requests`
--
ALTER TABLE `requests`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `vote`
--
ALTER TABLE `vote`
  MODIFY `id_vote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `id_song` FOREIGN KEY (`id_song`) REFERENCES `song` (`id_song`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`id_song`) REFERENCES `song` (`id_song`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
