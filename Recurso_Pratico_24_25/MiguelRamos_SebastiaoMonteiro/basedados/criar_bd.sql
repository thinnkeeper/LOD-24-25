-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2024 at 11:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lwbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `estadoinscricao`
--

CREATE TABLE `estadoinscricao` (
  `estado` int(2) NOT NULL,
  `descricao` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estadoinscricao`
--

INSERT INTO `estadoinscricao` (`estado`, `descricao`) VALUES
(0, 'Pre-inscricao'),
(1, 'Inscricao'),
(2, 'InscricaoApagada');

-- --------------------------------------------------------

--
-- Table structure for table `formacao`
--

CREATE TABLE `formacao` (
  `codigoFormacao` int(3) NOT NULL,
  `lotacao` int(2) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `descricao` text NOT NULL,
  `data` date NOT NULL,
  `horaInicio` time NOT NULL,
  `duracao` int(5) NOT NULL,
  `docenteID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formacao`
--

INSERT INTO `formacao` (`codigoFormacao`, `lotacao`, `nome`, `descricao`, `data`, `horaInicio`, `duracao`, `docenteID`) VALUES
(1, 20, 'Formacao 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla lobortis convallis sem, sit amet tristique velit tincidunt et.', '0000-00-00', '16:00:00', 2, 2),
(2, 20, 'Formacao 2', 'Proin viverra ultricies nunc, vitae tristique diam consectetur rutrum. Proin accumsan convallis leo, eu ultricies velit.', '0000-00-00', '14:00:00', 1, 2),
(3, 25, 'Formacao 3', 'Nam massa turpis, elementum quis ante quis, vestibulum feugiat ligula. Morbi vel faucibus neque.', '0000-00-00', '12:00:00', 2, 2),
(4, 18, 'Formacao 4', 'Nam sit amet turpis vel lectus accumsan placerat quis eget ex. Nullam maximus dui eget erat gravida, quis pulvinar ligula suscipit.', '0000-00-00', '10:00:00', 3, 2),
(5, 23, 'Formacao 5', 'Fusce et ornare mi, vitae finibus libero. Donec sed lectus purus. Integer ultricies hendrerit lobortis.', '0000-00-00', '08:00:00', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `inscricao`
--

CREATE TABLE `inscricao` (
  `idInscricao` int(12) NOT NULL,
  `idAluno` int(5) NOT NULL,
  `codigoFormacao` int(3) NOT NULL,
  `dataInscricao` date NOT NULL,
  `estado` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipoutilizador`
--

CREATE TABLE `tipoutilizador` (
  `id` int(2) NOT NULL,
  `descricao` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipoutilizador`
--

INSERT INTO `tipoutilizador` (`id`, `descricao`) VALUES
(1, 'administrador'),
(3, 'aluno'),
(2, 'docente'),
(6, 'utilizador apagado'),
(4, 'visitante'),
(5, 'visitante nao validado');

-- --------------------------------------------------------

--
-- Table structure for table `utilizador`
--

CREATE TABLE `utilizador` (
  `id` int(5) NOT NULL,
  `nomeUtilizador` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tipoUtilizador` int(2) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilizador`
--

INSERT INTO `utilizador` (`id`, `nomeUtilizador`, `password`, `tipoUtilizador`, `email`) VALUES
(1, 'admin', 'admin', 1, 'admin@ipcb.pt'),
(2, 'docente', 'docente', 2, 'docente@ipcb.pt'),
(3, 'aluno', 'aluno', 3, 'aluno@ipcb.pt');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `estadoinscricao`
--
ALTER TABLE `estadoinscricao`
  ADD PRIMARY KEY (`estado`),
  ADD UNIQUE KEY `estado` (`estado`);

--
-- Indexes for table `formacao`
--
ALTER TABLE `formacao`
  ADD PRIMARY KEY (`codigoFormacao`),
  ADD KEY `docenteID` (`docenteID`);

--
-- Indexes for table `inscricao`
--
ALTER TABLE `inscricao`
  ADD PRIMARY KEY (`idInscricao`),
  ADD KEY `codigoFormacao` (`codigoFormacao`),
  ADD KEY `estado` (`estado`),
  ADD KEY `utilizadorInscricao` (`idAluno`);

--
-- Indexes for table `tipoutilizador`
--
ALTER TABLE `tipoutilizador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`);

--
-- Indexes for table `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomeUtilizador` (`nomeUtilizador`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `tipoUtilizador` (`tipoUtilizador`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `formacao`
--
ALTER TABLE `formacao`
  MODIFY `codigoFormacao` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inscricao`
--
ALTER TABLE `inscricao`
  MODIFY `idInscricao` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `tipoutilizador`
--
ALTER TABLE `tipoutilizador`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `formacao`
--
ALTER TABLE `formacao`
  ADD CONSTRAINT `docenteFormacao` FOREIGN KEY (`docenteID`) REFERENCES `utilizador` (`id`);

--
-- Constraints for table `inscricao`
--
ALTER TABLE `inscricao`
  ADD CONSTRAINT `estado` FOREIGN KEY (`estado`) REFERENCES `estadoinscricao` (`estado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `formacao_inscrita` FOREIGN KEY (`codigoFormacao`) REFERENCES `formacao` (`codigoFormacao`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `utilizadorInscricao` FOREIGN KEY (`idAluno`) REFERENCES `utilizador` (`id`);

--
-- Constraints for table `utilizador`
--
ALTER TABLE `utilizador`
  ADD CONSTRAINT `tipoUtilizadorID` FOREIGN KEY (`tipoUtilizador`) REFERENCES `tipoutilizador` (`id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
