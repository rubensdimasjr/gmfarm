-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Abr-2023 às 01:25
-- Versão do servidor: 8.0.30
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gmfarm`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `material`
--

CREATE TABLE `material` (
  `id_material` int NOT NULL,
  `reagente` varchar(255) NOT NULL,
  `lote` varchar(255) NOT NULL,
  `fabricante` varchar(255) NOT NULL,
  `fabricacao` varchar(20) NOT NULL,
  `validade` varchar(20) NOT NULL,
  `embalagem_original` varchar(10) NOT NULL,
  `quantidade` int NOT NULL,
  `cas` varchar(255) NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `material`
--

INSERT INTO `material` (`id_material`, `reagente`, `lote`, `fabricante`, `fabricacao`, `validade`, `embalagem_original`, `quantidade`, `cas`, `user_id`) VALUES
(3, 'Dipirona', '01', 'Neoquimica', '2023-03', '2024-03', 'Sim', 1, '01892', 1),
(4, 'Dipirona 2', '03', 'Neoquimica', '2023-03', '2023-07', 'Não', 4, '01892asd', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `paciente`
--

CREATE TABLE `paciente` (
  `id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contato` varchar(20) NOT NULL,
  `genero` varchar(5) NOT NULL,
  `situacao` varchar(15) NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `paciente`
--

INSERT INTO `paciente` (`id`, `nome`, `email`, `contato`, `genero`, `situacao`, `user_id`) VALUES
(2, 'Lucas', 'lucas@gmail.com', '61994480357', 'M', 'Indeferido', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` varchar(10) NOT NULL DEFAULT 'aluno'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `matricula`, `senha`, `tipo_usuario`) VALUES
(1, 'Admin', 'admin@gmail.com', '0013970', '$2y$10$c47NbrGr3Cr4p8uvtQHkcuHKIjhvPGIjr1U0jaGtiHyRvdsZUBjwu', 'admin'),
(2, 'Aluno Teste', 'teste@teste.com', '0013970', '$2y$10$xj0MSSCxXBD6fkSiGfyUlu2/FVNc31HEWRm4aYhi7KlPb2o5DjzFG', 'aluno');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id_material`),
  ADD KEY `USER_CREATE_MATERIAL` (`user_id`);

--
-- Índices para tabela `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `USER_CREATE_PATIENT` (`user_id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `material`
--
ALTER TABLE `material`
  MODIFY `id_material` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `USER_CREATE_MATERIAL` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `USER_CREATE_PATIENT` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
