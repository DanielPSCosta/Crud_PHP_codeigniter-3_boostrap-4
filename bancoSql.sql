-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 26-Abr-2023 às 19:03
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbadm`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `almoxarifados`
--

CREATE TABLE `almoxarifados` (
  `ID` int(11) NOT NULL,
  `codalm` int(11) NOT NULL,
  `descricao` varchar(11) NOT NULL,
  `dtfechmto` date NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `almoxarifados`
--

INSERT INTO `almoxarifados` (`ID`, `codalm`, `descricao`, `dtfechmto`, `status`) VALUES
(1, 10, 'ARMAZENA', '2023-04-18', ''),
(2, 22, 'DISPOSITIVO', '2023-04-20', ''),
(3, 45, 'MATERIAL DO', '2023-04-20', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `anc`
--

CREATE TABLE `anc` (
  `id` int(11) NOT NULL,
  `dtbaixa` date NOT NULL,
  `produto` varchar(11) NOT NULL,
  `tpdoc` varchar(11) NOT NULL,
  `ndoc` int(11) NOT NULL,
  `almox` int(11) NOT NULL,
  `cod` varchar(11) NOT NULL,
  `qtde` int(11) NOT NULL,
  `observacao` varchar(800) NOT NULL,
  `cod_defeito` varchar(255) NOT NULL,
  `cecus` varchar(255) NOT NULL,
  `chapaop` varchar(255) NOT NULL,
  `nmaquina` varchar(255) NOT NULL,
  `status` varchar(2) NOT NULL,
  `operacao` varchar(10) NOT NULL,
  `OrdProd` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `anc`
--

INSERT INTO `anc` (`id`, `dtbaixa`, `produto`, `tpdoc`, `ndoc`, `almox`, `cod`, `qtde`, `observacao`, `cod_defeito`, `cecus`, `chapaop`, `nmaquina`, `status`, `operacao`, `OrdProd`) VALUES
(31, '2023-04-25', 'C10350093S', 'RR', 45, 45, 'FO01', 5, 'GRAVAÇÃO IRREGULAR', '', '100244', '513849', '875', '', '546b', '2'),
(32, '2023-04-25', 'C10350093S', 'RR', 46, 45, 'FU12  ', 123, '', '', '100244', '123', '123', '', '123', '123'),
(33, '2023-04-25', 'C10350093S', 'RR', 47, 10, 'FO02', 25, 'PRODUTO QUEBRADO', '', '100244', '111', '222', '', '333', '321'),
(34, '2023-04-26', 'C47330027J', 'RR', 48, 10, 'FO02', 6, '', '', '100244', '5', '4', '', '3A', '2'),
(35, '2023-04-25', 'C10350093S', 'RR', 49, 22, 'FO02', 2, 'PRODUTO DANIFICADO NA QUEDA', '', '100244', '78655', '45655', '', '45', '465'),
(36, '2023-04-26', 'C10350093S', 'RR', 50, 10, 'FO01', 4, 'PRODUTO DANIFICADO NA MOVIMENTAÇÃO', '', '100255', '543', '543', '', '54', '654'),
(37, '2023-04-26', 'C10350093S', 'RR', 51, 22, 'FO02', 2, '', '', '100244', '127', '38', '', '9k', '14'),
(38, '2023-04-27', 'C47330027J', 'RR', 52, 10, 'FO01', 4, '', '', '100255', '26', '8', '', '54l', '7'),
(39, '2023-04-26', 'C47330027J', 'RR', 53, 45, 'FU12  ', 3, '', '', '100244', '26', '9', '', '45', '1'),
(40, '2023-04-26', 'C10350093S', 'RR', 54, 45, 'FO02', 2, 'DANIFICADO EM QUEDA', '', '100244', '11', '44', '', '350', '9'),
(41, '2023-04-26', 'C10350093S', 'RR', 55, 10, 'FU12  ', 2, '', '', '100244', '11', '22', 'D', '350', '18'),
(42, '2023-04-26', 'C10350093S', 'RR', 56, 22, 'FU12  ', 5, '', '', '100255', '45', '34', 'D', '23', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cecusto`
--

CREATE TABLE `cecusto` (
  `id` int(11) NOT NULL,
  `codcc` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cecusto`
--

INSERT INTO `cecusto` (`id`, `codcc`, `descricao`, `status`) VALUES
(1, 100255, 'RESTAURANTE', ''),
(2, 100244, 'TORNO VERTICAL', ''),
(3, 245767, 'FORJARIA', ''),
(4, 346431, 'FUNDIÇÃO', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `defeitos`
--

CREATE TABLE `defeitos` (
  `id` int(255) NOT NULL,
  `id_defeitos` int(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `cod_defeito` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dtcria` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `defeitos`
--

INSERT INTO `defeitos` (`id`, `id_defeitos`, `local`, `cod_defeito`, `descricao`, `status`, `dtcria`) VALUES
(1, 1, 'FORJARIA', 'FO01', 'AMASSADO', '', '2023-04-18'),
(2, 2, 'FORJARIA', 'FO02', 'BATIDA', '', '2023-04-18'),
(3, 45, 'FUNDIÇÃO', 'FU12  ', 'COMPRIMENTO MAIOR (PEÇA CUMPRIDA)', '', '2023-04-19'),
(4, 7, 'FORJARIA', 'FO13  ', 'FORJAMENTO INCOMPLETO', '', '2023-04-26'),
(5, 8, 'FUNDIÇÃO', 'FU03  ', 'TRINCA', '', '2023-04-26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `docum`
--

CREATE TABLE `docum` (
  `id` int(11) NOT NULL,
  `tpdoc` varchar(255) NOT NULL,
  `nrodoc` int(11) NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `docum`
--

INSERT INTO `docum` (`id`, `tpdoc`, `nrodoc`, `status`) VALUES
(1, 'RR', 56, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `email`
--

CREATE TABLE `email` (
  `id` int(50) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `data` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `email`
--

INSERT INTO `email` (`id`, `nome`, `email`, `status`, `data`, `telefone`) VALUES
(0, 'MAURICIO', 'mauricio@hotmail.com', '', '23/05/2022', '(11) 94371-1551'),
(1, 'DANIEL ', 'daniel@hotmail.com', '', '23/05/2022', '(11) 98351-0051'),
(2, 'MARCIO', 'Marcio@hotmail.com', '', '23/05/2022', '(11) 96399-9551'),
(4, 'ANDRE', 'andre@hotmail.com', '', '23/05/2022', '(11) 96599-9551'),
(5, 'ELIEL', 'eliel@hotmail.com', '', '23/05/2022', '(11) 96599-9551'),
(6, 'FERNANDO', 'fernando@hotmail.com', NULL, '23/05/2022', '(11) 95354-4561');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `ID` int(50) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `dtadm` date DEFAULT NULL,
  `dtdesligamento` date DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `setor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`ID`, `usuario`, `senha`, `status`, `dtadm`, `dtdesligamento`, `cargo`, `setor`) VALUES
(0, 'MAURICIO', 'ADMIN', NULL, '2023-03-10', NULL, 'FULLSTACK', '10001'),
(1, 'DANIEL', 'ADMIN', '', '2023-03-10', '0000-00-00', 'FULLSTACK', '10001'),
(2, 'MARCIO ', 'ADMIN', NULL, '2023-03-10', NULL, 'ANALISTA PHP', '10001'),
(4, 'ANDRE', 'ADMIN', NULL, '2023-03-10', NULL, 'ANALISTA ', '10001'),
(5, 'ELIEL', 'ADMIN', NULL, '2023-03-10', NULL, 'ANALISTA', '10001'),
(6, 'FERNANDO', 'ADMIN', NULL, '2023-03-10', NULL, 'ANALISTA', '10001');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(255) NOT NULL,
  `registro` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` tinyint(3) NOT NULL,
  `uni_med` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `registro`, `nome`, `preco`, `uni_med`) VALUES
(2, 'C10350093S', 'UVA', 21, 'PC'),
(5, 'C47330027J', 'BANANA', 28, 'PC'),
(6, 'C30354493S', 'MORANGO', 40, 'PC');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `almoxarifados`
--
ALTER TABLE `almoxarifados`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `anc`
--
ALTER TABLE `anc`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cecusto`
--
ALTER TABLE `cecusto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `defeitos`
--
ALTER TABLE `defeitos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `docum`
--
ALTER TABLE `docum`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `almoxarifados`
--
ALTER TABLE `almoxarifados`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `anc`
--
ALTER TABLE `anc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `cecusto`
--
ALTER TABLE `cecusto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `defeitos`
--
ALTER TABLE `defeitos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `docum`
--
ALTER TABLE `docum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `email`
--
ALTER TABLE `email`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
