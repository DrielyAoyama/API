-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10-Nov-2016 às 19:11
-- Versão do servidor: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `service`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `algoritmos`
--

CREATE TABLE `algoritmos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `media_tempo_processamento` float DEFAULT '0',
  `qtde_execucoes` int(11) NOT NULL DEFAULT '0',
  `tipo_texto` varchar(20) NOT NULL DEFAULT 'TEXTO',
  `tipo_cifra` varchar(20) NOT NULL DEFAULT 'ASSIMETRICA',
  `decodificavel` varchar(1) NOT NULL DEFAULT 'S',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `algoritmos`
--

INSERT INTO `algoritmos` (`id`, `nome`, `media_tempo_processamento`, `qtde_execucoes`, `tipo_texto`, `tipo_cifra`, `decodificavel`, `updated_at`, `created_at`) VALUES
(1, 'AES_128_BITS', 0.00166975, 12, 'TEXTO', 'SIMETRICO', 'S', '2016-11-04 23:50:48', NULL),
(2, 'AES_192_BITS', 0.00187659, 2, 'TEXTO', 'SIMETRICO', 'S', '2016-11-04 21:36:38', NULL),
(3, 'AES_256_BITS', 0.00219798, 1, 'TEXTO', 'SIMETRICO', 'S', '2016-11-04 12:52:17', NULL),
(4, 'MD5', 0.000020206, 4, 'TEXTO', 'HASH', 'N', '2016-11-04 23:08:06', NULL),
(5, '3DES', 0.000781217, 3, 'TEXTO', 'SIMETRICO', 'S', '2016-10-26 11:58:31', NULL),
(6, 'RSA', 17.8452, 0, 'TEXTO', 'ASSIMETRICA', 'S', '2016-08-29 23:50:36', NULL),
(7, 'ECC', 0.412727, 7, 'TEXTO', 'ASSIMETRICA', 'S', '2016-11-09 13:20:23', NULL),
(8, 'SHA1', 0.0000240008, 72, 'TEXTO', 'HASH', 'N', '2016-11-10 16:19:10', NULL),
(9, 'SHA256', 0.00000214577, 0, 'TEXTO', 'HASH', 'N', '2016-08-29 23:50:36', NULL),
(10, 'SHA512', 0.00000214577, 0, 'TEXTO', 'HASH', 'N', '2016-08-29 23:50:36', NULL),
(11, 'SIMON', 0.00112915, 0, 'ARRAY', 'LEVE', 'S', '2016-08-29 23:47:28', NULL),
(12, 'SPECK', 0.00362611, 2, 'ARRAY', 'LEVE', 'N', '2016-11-10 17:22:37', NULL),
(13, 'DES', 0.000636721, 38, 'TEXTO', 'ASSIMETRICA', 'S', '2016-11-10 18:07:06', NULL),
(14, 'SIMECK', 0.00089407, 1, 'TEXTO', 'ASSIMETRICA', 'S', '2016-11-04 12:52:47', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `faixas_tamanho`
--

CREATE TABLE `faixas_tamanho` (
  `id` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `de` float NOT NULL,
  `ate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `faixas_tamanho`
--

INSERT INTO `faixas_tamanho` (`id`, `peso`, `de`, `ate`) VALUES
(1, 1, 0, 9.99),
(2, 2, 10, 19.99),
(3, 3, 20, 29.99),
(4, 4, 30, 39.99),
(5, 5, 40, 49.99),
(6, 6, 50, 59.99),
(7, 7, 60, 1e16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `faixas_tempo`
--

CREATE TABLE `faixas_tempo` (
  `id` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `de` float NOT NULL,
  `ate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `faixas_tempo`
--

INSERT INTO `faixas_tempo` (`id`, `peso`, `de`, `ate`) VALUES
(1, 1, 0, 10),
(2, 2, 10.01, 20),
(3, 3, 20.01, 30),
(4, 4, 30.01, 40),
(5, 5, 40.01, 50),
(6, 6, 50.01, 60),
(7, 7, 60.01, 100000000000000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `algoritmo_id` int(11) DEFAULT NULL,
  `algoritmo_desc` varchar(200) DEFAULT NULL,
  `tempo_processamento` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `log`
--

INSERT INTO `log` (`id`, `descricao`, `usuario`, `algoritmo_id`, `algoritmo_desc`, `tempo_processamento`, `created_at`, `updated_at`) VALUES
(1, 'Codificação', 1, 5, '3DES', 0.00108194, '2016-10-26 11:42:48', NULL),
(2, 'Codificação', 1, 5, '3DES', 0.000651836, '2016-10-26 11:44:19', NULL),
(3, 'Codificação', 1, 7, 'ECC', 0.684548, '2016-10-26 11:51:41', NULL),
(4, 'Codificação', 1, 7, 'ECC', 0.140906, '2016-10-26 11:52:37', NULL),
(5, 'Codificação', 1, 4, 'MD5', 0.0000200272, '2016-10-26 11:53:41', NULL),
(6, 'Codificação', 1, 4, 'MD5', 0.0000209808, '2016-10-26 11:54:33', NULL),
(7, 'Codificação', 1, 5, '3DES', 0.000609875, '2016-10-26 11:58:31', NULL),
(8, 'Codificação', 1, 13, 'DES', 0.000715017, '2016-10-26 18:41:44', NULL),
(9, 'Codificação', 1, 13, 'DES', 0.000849009, '2016-10-26 18:44:41', NULL),
(10, 'Codificação', 1, 13, 'DES', 0.000586987, '2016-10-26 18:46:23', NULL),
(11, 'Codificação', 1, 13, 'DES', 0.0007689, '2016-11-03 19:00:38', NULL),
(12, 'Codificação', 1, 13, 'DES', 0.000598907, '2016-11-03 19:02:15', NULL),
(13, 'Codificação', 1, 13, 'DES', 0.000826836, '2016-11-03 19:02:25', NULL),
(14, 'Codificação', 1, 13, 'DES', 0.00057888, '2016-11-03 19:02:38', NULL),
(15, 'Codificação', 1, 13, 'DES', 0.00089097, '2016-11-03 19:03:46', NULL),
(16, 'Codificação', 1, 13, 'DES', 0.00057292, '2016-11-03 19:04:09', NULL),
(17, 'Codificação', 1, 13, 'DES', 0.000873089, '2016-11-03 19:04:28', NULL),
(18, 'Codificação', 1, 13, 'DES', 0.000570059, '2016-11-03 19:04:43', NULL),
(19, 'Codificação', 1, 13, 'DES', 0.000569105, '2016-11-03 19:05:07', NULL),
(20, 'Codificação', 1, 13, 'DES', 0.000586987, '2016-11-03 19:05:18', NULL),
(21, 'Codificação', 1, 13, 'DES', 0.000550032, '2016-11-03 19:05:23', NULL),
(22, 'Codificação', 1, 13, 'DES', 0.000567913, '2016-11-03 19:05:31', NULL),
(23, 'Codificação', 1, 13, 'DES', 0.000589848, '2016-11-03 19:29:41', NULL),
(24, 'Codificação', 1, 13, 'DES', 0.000599861, '2016-11-03 19:31:05', NULL),
(25, 'Codificação', 1, 13, 'DES', 0.000560999, '2016-11-03 19:31:45', NULL),
(26, 'Codificação', 1, 13, 'DES', 0.000583887, '2016-11-03 19:31:59', NULL),
(27, 'Codificação', 1, 13, 'DES', 0.000571966, '2016-11-03 19:32:30', NULL),
(28, 'Codificação', 1, 13, 'DES', 0.00057292, '2016-11-03 19:32:36', NULL),
(29, 'Codificação', 1, 13, 'DES', 0.000595093, '2016-11-03 19:33:43', NULL),
(30, 'Codificação', 1, 13, 'DES', 0.000582933, '2016-11-03 19:34:18', NULL),
(31, 'Codificação', 1, 13, 'DES', 0.000568151, '2016-11-03 19:34:33', NULL),
(32, 'Codificação', 1, 13, 'DES', 0.000706911, '2016-11-03 19:34:53', NULL),
(33, 'Codificação', 1, 13, 'DES', 0.000559092, '2016-11-03 19:35:00', NULL),
(34, 'Codificação', 1, 13, 'DES', 0.000795126, '2016-11-03 19:36:16', NULL),
(35, 'Codificação', 1, 13, 'DES', 0.00058198, '2016-11-03 19:38:04', NULL),
(36, 'Codificação', 1, 13, 'DES', 0.000575066, '2016-11-03 19:38:52', NULL),
(37, 'Codificação', 1, 13, 'DES', 0.000552177, '2016-11-03 19:38:59', NULL),
(38, 'Codificação', 1, 2, 'AES_192_BITS', 0.00187302, '2016-11-04 12:51:57', NULL),
(39, 'Codificação', 1, 3, 'AES_256_BITS', 0.00219798, '2016-11-04 12:52:16', NULL),
(40, 'Codificação', 1, 12, 'SPECK', 0.00362611, '2016-11-04 12:52:30', NULL),
(41, 'Codificação', 1, 14, 'SIMECK', 0.00089407, '2016-11-04 12:52:47', NULL),
(42, 'Codificação', 1, 2, 'AES_192_BITS', 0.00188017, '2016-11-04 21:36:38', NULL),
(43, 'Codificação', 1, 4, 'MD5', 0.0000200272, '2016-11-04 21:36:45', NULL),
(44, 'Codificação', 1, 4, 'MD5', 0.0000197887, '2016-11-04 23:08:06', NULL),
(45, 'Codificação', 1, 1, 'AES_128_BITS', 0.00184393, '2016-11-04 23:15:46', NULL),
(46, 'Codificação', 1, 1, 'AES_128_BITS', 0.00157404, '2016-11-04 23:16:43', NULL),
(47, 'Codificação', 1, 1, 'AES_128_BITS', 0.00158191, '2016-11-04 23:17:11', NULL),
(48, 'Codificação', 1, 1, 'AES_128_BITS', 0.00163198, '2016-11-04 23:17:37', NULL),
(49, 'Codificação', 1, 1, 'AES_128_BITS', 0.00229311, '2016-11-04 23:17:39', NULL),
(50, 'Codificação', 1, 1, 'AES_128_BITS', 0.00161195, '2016-11-04 23:17:40', NULL),
(51, 'Codificação', 1, 1, 'AES_128_BITS', 0.00156307, '2016-11-04 23:17:42', NULL),
(52, 'Codificação', 1, 1, 'AES_128_BITS', 0.00157905, '2016-11-04 23:17:43', NULL),
(53, 'Codificação', 1, 1, 'AES_128_BITS', 0.00156188, '2016-11-04 23:17:46', NULL),
(54, 'Codificação', 1, 1, 'AES_128_BITS', 0.00155997, '2016-11-04 23:18:36', NULL),
(55, 'Codificação', 1, 1, 'AES_128_BITS', 0.00163794, '2016-11-04 23:21:23', NULL),
(56, 'Codificação', 1, 1, 'AES_128_BITS', 0.00159812, '2016-11-04 23:50:48', NULL),
(57, 'Codificação', 1, 8, 'SHA1', 0.0000209808, '2016-11-05 02:16:19', NULL),
(58, 'Codificação', 1, 8, 'SHA1', 0.0000219345, '2016-11-05 02:20:52', NULL),
(59, 'Codificação', 1, 8, 'SHA1', 0.0000290871, '2016-11-06 13:57:28', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `niveis`
--

CREATE TABLE `niveis` (
  `id` int(11) NOT NULL,
  `id_algoritmo` int(11) NOT NULL,
  `algoritmo` varchar(100) NOT NULL,
  `ano_criacao` varchar(4) DEFAULT NULL,
  `ataques` varchar(2000) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `niveis`
--

INSERT INTO `niveis` (`id`, `id_algoritmo`, `algoritmo`, `ano_criacao`, `ataques`, `nivel`) VALUES
(1, 1, 'AES_128_BITS', '2002', 'não publicado oficialmente', 1),
(2, 2, 'AES_192_BITS', '2002', 'não publicado oficialmente', 1),
(3, 3, 'AES_256_BITS', '2002', 'não publicado oficialmente', 1),
(4, 5, '3DES', '1993', 'Não publicado oficialmente', 2),
(5, 8, 'SHA1', '1995', 'Ataques de colisão, 2008 - (Sotirov et al,2008)', 3),
(6, 9, 'SHA256', '2001', 'Ataques de colisão, 2008 - (Sotirov et al,2008)', 2),
(7, 4, 'MD5', '1991', 'Ataques de colisão, 2004 - (Sotirov et al,2008)', 3),
(8, 6, 'RSA', '1978', 'Chave 512 bits fatorada, 1999 - (valenta et al,2015)', 1),
(9, 7, 'ECC', '1985', '-2003- Birthday Atack', 1),
(10, 11, 'SIMON', '2013', 'Criptoanálise diferencial em algumas rodadas (abed et al,2014)', 2),
(11, 12, 'SPECK', '2013', 'Criptoanálise diferencial em algumas rodadas (abed et al,2014)', 2),
(12, 13, 'DES', '1976', 'Ataque de força bruta - 1997 (vogt,2003)', 3),
(13, 14, 'SIMECK', '2015', 'Não publicado oficialmente', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pesos`
--

CREATE TABLE `pesos` (
  `id` int(11) NOT NULL,
  `id_algoritmo` int(11) NOT NULL,
  `nome_algoritmo` varchar(100) DEFAULT NULL,
  `_1` double DEFAULT '0',
  `_2` double DEFAULT '0',
  `_3` double DEFAULT '0',
  `_4` double DEFAULT '0',
  `_5` double DEFAULT '0',
  `_6` double DEFAULT '0',
  `_7` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pesos`
--

INSERT INTO `pesos` (`id`, `id_algoritmo`, `nome_algoritmo`, `_1`, `_2`, `_3`, `_4`, `_5`, `_6`, `_7`) VALUES
(1, 1, 'AES_128_BITS', 1, 1, 2, 3, 4, 5, 5),
(2, 2, 'AES_192_BITS', 1, 2, 3, 4, 5, 6, 6),
(3, 3, 'AES_256_BITS', 1, 2, 3, 4, 6, 7, 7),
(4, 4, 'MD5', 1, 1, 1, 1, 1, 1, 1),
(5, 5, '3DES', 1, 1, 2, 2, 3, 4, 4),
(6, 6, 'RSA', 5, 7, 7, 7, 7, 7, 7),
(7, 7, 'ECC', 7, 7, 7, 7, 7, 7, 7),
(8, 8, 'SHA1', 1, 1, 1, 1, 1, 1, 1),
(9, 9, 'SHA256', 1, 1, 1, 1, 1, 1, 1),
(10, 10, 'SHA512', 1, 1, 1, 1, 1, 1, 1),
(11, 11, 'SIMON', 1, 1, 1, 2, 2, 2, 2),
(12, 12, 'SPECK', 1, 1, 1, 1, 2, 2, 2),
(13, 13, 'DES', 1, 1, 2, 2, 3, 3, 3),
(14, 14, 'SIMECK', 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `protocolos`
--

CREATE TABLE `protocolos` (
  `protocolo` varchar(100) NOT NULL,
  `chave_privada` longtext NOT NULL,
  `algoritmo` int(11) NOT NULL,
  `tempo_processamento` float NOT NULL,
  `origem` longtext NOT NULL,
  `client_id` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `protocolos`
--

INSERT INTO `protocolos` (`protocolo`, `chave_privada`, `algoritmo`, `tempo_processamento`, `origem`, `client_id`) VALUES
('a4984c4c5efc37953340930d7c1b85d8544fd5cf', '0209b38f80a2153dd17492042c425728f59a58ad', 13, 0.00205493, 'EST6MyCO88xfy086g70y7pGSgmTgg+2oubnL1rJQxg0=', 'e8dcdfd79e471bb794e80fcc056d876752fcc8c6'),
('a66b0850835aebb2e86c371e5289b13a59f42820', '399db3463eb0aea018d167fdc3edabc130b6bf60', 13, 0.00180006, '6u0/s2YgqirAkj/ZoQwBQ0CSDVokViDPT1v+7lYsqKo=', 'e8dcdfd79e471bb794e80fcc056d876752fcc8c6'),
('e872a10e93e7e1c4191b7aadfd9336331daebd3f', 'd9c0b682327db8445942c30741c58217239a18a4', 13, 0.00200415, 'Ffd1ilOirJknoxIPV3ablpgmYwDvmcZaot9OlDS2Fr4=', 'e8dcdfd79e471bb794e80fcc056d876752fcc8c6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `testes_velocidade`
--

CREATE TABLE `testes_velocidade` (
  `id` int(11) NOT NULL,
  `algoritimo` varchar(100) DEFAULT NULL,
  `tempo_seg` float NOT NULL,
  `peso_tempo` int(11) NOT NULL,
  `peso_tamanho` int(11) NOT NULL DEFAULT '1',
  `tamanho` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `testes_velocidade`
--

INSERT INTO `testes_velocidade` (`id`, `algoritimo`, `tempo_seg`, `peso_tempo`, `peso_tamanho`, `tamanho`) VALUES
(1, 'AES_128_BITS', 0.879639, 1, 1, '1'),
(2, 'AES_128_BITS', 8.79639, 1, 2, '10'),
(3, 'AES_128_BITS', 17.5928, 2, 3, '20'),
(4, 'AES_128_BITS', 26.3892, 3, 4, '30'),
(5, 'AES_128_BITS', 35.1855, 4, 5, '40'),
(6, 'AES_128_BITS', 43.9819, 5, 6, '50'),
(7, 'AES_128_BITS', 43.9819, 5, 7, '1000'),
(8, 'AES_192_BITS', 1.05591, 1, 1, '1'),
(9, 'AES_192_BITS', 10.5591, 2, 2, '10'),
(10, 'AES_192_BITS', 21.1182, 3, 3, '20'),
(11, 'AES_192_BITS', 31.6772, 4, 4, '30'),
(12, 'AES_192_BITS', 42.2363, 5, 5, '40'),
(13, 'AES_192_BITS', 52.7954, 6, 6, '50'),
(14, 'AES_192_BITS', 52.7954, 6, 7, '1000'),
(15, 'AES_256_BITS', 1.27686, 1, 1, '1'),
(16, 'AES_256_BITS', 12.7686, 2, 2, '10'),
(17, 'AES_256_BITS', 25.5371, 3, 3, '20'),
(18, 'AES_256_BITS', 38.3057, 4, 4, '30'),
(19, 'AES_256_BITS', 51.0742, 6, 5, '40'),
(20, 'AES_256_BITS', 63.8428, 7, 6, '50'),
(21, 'AES_256_BITS', 63.8428, 7, 7, '1000'),
(22, 'MD5', 0.0236816, 1, 1, '1'),
(23, 'MD5', 0.236816, 1, 2, '10'),
(24, 'MD5', 0.473633, 1, 3, '20'),
(25, 'MD5', 0.710449, 1, 4, '30'),
(26, 'MD5', 0.947266, 1, 5, '40'),
(27, 'MD5', 1.18408, 1, 6, '50'),
(28, 'MD5', 1.18408, 1, 7, '1000'),
(29, '3DES', 0.616455, 1, 1, '1'),
(30, '3DES', 6.16455, 1, 2, '10'),
(31, '3DES', 12.3291, 2, 3, '20'),
(32, '3DES', 18.4937, 2, 4, '30'),
(33, '3DES', 24.6582, 3, 5, '40'),
(34, '3DES', 30.8228, 4, 6, '50'),
(35, '3DES', 30.8228, 4, 7, '1000'),
(36, 'RSA', 48.3513, 5, 1, '1'),
(37, 'RSA', 483.513, 7, 2, '10'),
(38, 'RSA', 967.026, 7, 3, '20'),
(39, 'RSA', 1450.54, 7, 4, '30'),
(40, 'RSA', 1934.05, 7, 5, '40'),
(41, 'RSA', 2417.57, 7, 6, '50'),
(42, 'RSA', 2417.57, 7, 7, '1000'),
(43, 'ECC', 112.398, 7, 1, '1'),
(44, 'ECC', 1123.98, 7, 2, '10'),
(45, 'ECC', 2247.97, 7, 3, '20'),
(46, 'ECC', 3371.95, 7, 4, '30'),
(47, 'ECC', 4495.94, 7, 5, '40'),
(48, 'ECC', 5619.92, 7, 6, '50'),
(49, 'ECC', 5619.92, 7, 7, '1000'),
(50, 'SHA1', 0.0227051, 1, 1, '1'),
(51, 'SHA1', 0.227051, 1, 2, '10'),
(52, 'SHA1', 0.454102, 1, 3, '20'),
(53, 'SHA1', 0.681152, 1, 4, '30'),
(54, 'SHA1', 0.908203, 1, 5, '40'),
(55, 'SHA1', 1.13525, 1, 6, '50'),
(56, 'SHA1', 1.13525, 1, 7, '1000'),
(57, 'SHA256', 0.0327148, 1, 1, '1'),
(58, 'SHA256', 0.327148, 1, 2, '10'),
(59, 'SHA256', 0.654297, 1, 3, '20'),
(60, 'SHA256', 0.981445, 1, 4, '30'),
(61, 'SHA256', 1.30859, 1, 5, '40'),
(62, 'SHA256', 1.63574, 1, 6, '50'),
(63, 'SHA256', 1.63574, 1, 7, '1000'),
(64, 'SHA512', 0.0275879, 1, 1, '1'),
(65, 'SHA512', 0.275879, 1, 2, '10'),
(66, 'SHA512', 0.551758, 1, 3, '20'),
(67, 'SHA512', 0.827637, 1, 4, '30'),
(68, 'SHA512', 1.10352, 1, 5, '40'),
(69, 'SHA512', 1.37939, 1, 6, '50'),
(70, 'SHA512', 1.37939, 1, 7, '1000'),
(71, 'SIMON', 0.352295, 1, 1, '1'),
(72, 'SIMON', 3.52295, 1, 2, '10'),
(73, 'SIMON', 7.0459, 1, 3, '20'),
(74, 'SIMON', 10.5688, 2, 4, '30'),
(75, 'SIMON', 14.0918, 2, 5, '40'),
(76, 'SIMON', 17.6147, 2, 6, '50'),
(77, 'SIMON', 17.6147, 2, 7, '1000'),
(78, 'SPECK', 0.293945, 1, 1, '1'),
(79, 'SPECK', 2.93945, 1, 2, '10'),
(80, 'SPECK', 5.87891, 1, 3, '20'),
(81, 'SPECK', 8.81836, 1, 4, '30'),
(82, 'SPECK', 11.7578, 2, 5, '40'),
(83, 'SPECK', 14.6973, 2, 6, '50'),
(84, 'SPECK', 14.6973, 2, 7, '1000'),
(85, 'DES', 0.555176, 1, 1, '1'),
(86, 'DES', 5.55176, 1, 2, '10'),
(87, 'DES', 11.1035, 2, 3, '20'),
(88, 'DES', 16.6553, 2, 4, '30'),
(89, 'DES', 22.207, 3, 5, '40'),
(90, 'DES', 27.7588, 3, 6, '50'),
(91, 'DES', 27.7588, 3, 7, '1000'),
(92, 'SIMECK', 0.102295, 1, 1, '1'),
(93, 'SIMECK', 1.02295, 1, 2, '10'),
(94, 'SIMECK', 2.0459, 1, 3, '20'),
(95, 'SIMECK', 3.06885, 1, 4, '30'),
(96, 'SIMECK', 4.0918, 1, 5, '40'),
(97, 'SIMECK', 5.11475, 1, 6, '50'),
(98, 'SIMECK', 5.11475, 1, 7, '1000');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `client_id` varchar(500) NOT NULL,
  `client_token` varchar(500) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `client_id`, `client_token`, `updated_at`, `created_at`) VALUES
(1, 'Driely da Silva Aoyama', 'root', '7b24afc8bc80e548d66c4e7ff72171c5', 'e8dcdfd79e471bb794e80fcc056d876752fcc8c6', '9fa41145a075ee591b8d07cafd0e9fac5384eb08', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `algoritmos`
--
ALTER TABLE `algoritmos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faixas_tamanho`
--
ALTER TABLE `faixas_tamanho`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faixas_tempo`
--
ALTER TABLE `faixas_tempo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `niveis`
--
ALTER TABLE `niveis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesos`
--
ALTER TABLE `pesos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `protocolos`
--
ALTER TABLE `protocolos`
  ADD PRIMARY KEY (`protocolo`);

--
-- Indexes for table `testes_velocidade`
--
ALTER TABLE `testes_velocidade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `algoritmos`
--
ALTER TABLE `algoritmos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `faixas_tamanho`
--
ALTER TABLE `faixas_tamanho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `faixas_tempo`
--
ALTER TABLE `faixas_tempo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `niveis`
--
ALTER TABLE `niveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `pesos`
--
ALTER TABLE `pesos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `testes_velocidade`
--
ALTER TABLE `testes_velocidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
