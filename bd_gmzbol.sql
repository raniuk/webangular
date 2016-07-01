-- phpMyAdmin SQL Dump
-- version 4.4.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2016 at 12:37 AM
-- Server version: 5.6.25
-- PHP Version: 5.4.43

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_gmzbol`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoriaser`
--

CREATE TABLE IF NOT EXISTS `categoriaser` (
  `idcats` int(11) NOT NULL,
  `descripcioncats` text NOT NULL,
  `estadocats` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categoriaser`
--

INSERT INTO `categoriaser` (`idcats`, `descripcioncats`, `estadocats`) VALUES
(1, 'PRUEBAS ELECTRICAS A TRANSFORMADORES DE POTENCIA', '1'),
(2, 'PRUEBAS A TRANSFORMADORES DE DISTRIBUCION', '1'),
(3, 'PRUEBAS ELECTRICAS A TRANSFORMADORES DE ELECTROFILTROS', '1'),
(4, 'PRUEBAS ELECTRICAS A INTERRUPTORES EN ACEITE DE ALTA TENSION', '1');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `idcli` int(11) NOT NULL,
  `nombrecli` varchar(200) NOT NULL,
  `cinitcli` varchar(50) NOT NULL,
  `telefonocli` int(11) NOT NULL,
  `celularcli` int(11) NOT NULL,
  `correocli` varchar(100) NOT NULL,
  `tipocli` tinyint(4) NOT NULL,
  `razonempcli` varchar(100) NOT NULL,
  `fecharegcli` date NOT NULL,
  `ciudadcli` int(11) NOT NULL,
  `direccioncli` varchar(255) NOT NULL,
  `estadocli` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `idemp` int(11) NOT NULL,
  `razonemp` varchar(50) NOT NULL,
  `direccionemp` varchar(100) NOT NULL,
  `numeroemp` varchar(20) NOT NULL,
  `zonaemp` varchar(50) NOT NULL,
  `telefonoemp` varchar(50) NOT NULL,
  `correoemp` varchar(100) NOT NULL,
  `bancoemp` varchar(50) NOT NULL,
  `cuentamnemp` varchar(20) NOT NULL,
  `cuentasusemp` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`idemp`, `razonemp`, `direccionemp`, `numeroemp`, `zonaemp`, `telefonoemp`, `correoemp`, `bancoemp`, `cuentamnemp`, `cuentasusemp`) VALUES
(1, 'GAZMAZBOL S.R.L.', 'C. Guerrilleros Lanza', '1292', 'Miraflores', '(591) 2-224928', 'gmzbol@gazmazbol.com', 'Banco Nacional de Bolivia', '150-0621954', '190-0431437');

-- --------------------------------------------------------

--
-- Table structure for table `prestarserv`
--

CREATE TABLE IF NOT EXISTS `prestarserv` (
  `idpse` int(11) NOT NULL,
  `idu` int(11) NOT NULL,
  `idcli` int(11) NOT NULL,
  `servicios` varchar(255) NOT NULL,
  `formapse` tinyint(4) NOT NULL,
  `tiempopse` varchar(20) NOT NULL,
  `descuentopse` tinyint(4) NOT NULL,
  `numeropse` bigint(20) NOT NULL,
  `fechapse` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `idpro` int(11) NOT NULL,
  `idprv` int(11) NOT NULL,
  `nombrepro` varchar(100) NOT NULL,
  `descripcionpro` varchar(255) NOT NULL,
  `cantidadpro` int(11) NOT NULL,
  `unidadpro` varchar(20) NOT NULL,
  `precioupro` double(10,2) NOT NULL,
  `fechapro` date NOT NULL,
  `fotopro` varchar(50) NOT NULL,
  `estadopro` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `idprv` int(11) NOT NULL,
  `nombresprv` varchar(100) NOT NULL,
  `apellidosprv` varchar(150) NOT NULL,
  `cedulaprv` int(15) NOT NULL,
  `lugarprv` int(11) NOT NULL,
  `fechaiprv` date NOT NULL,
  `telefonoprv` int(15) NOT NULL,
  `direccionprv` varchar(255) NOT NULL,
  `estadoprv` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE IF NOT EXISTS `servicios` (
  `idser` int(11) NOT NULL,
  `idcats` int(11) NOT NULL,
  `descripcionser` text NOT NULL,
  `fechaser` date NOT NULL,
  `costo` double(10,2) NOT NULL,
  `observacionser` varchar(255) NOT NULL,
  `estadoser` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `servicios`
--

INSERT INTO `servicios` (`idser`, `idcats`, `descripcionser`, `fechaser`, `costo`, `observacionser`, `estadoser`) VALUES
(1, 1, 'Factor de potencia en devanados', '2016-03-10', 10.00, 'Ninguna', '1'),
(2, 1, 'Factor de potencia asiladores de AT', '2016-03-09', 10.00, 'Ninguna', '1'),
(3, 1, 'Prueba de corriente de excitaciÃ³n devanados y nÃºcleo', '2016-03-09', 10.00, 'Ninguna', '1'),
(4, 1, 'Prueba de relaciÃ³n de transformaciÃ³n', '2016-03-17', 10.00, 'Ninguna', '1'),
(5, 1, 'Prueba de resistencia Ã³hmica de devanados', '2016-03-09', 10.00, 'Ninguna', '1'),
(6, 1, 'Indices de absorciÃ³n y polarizaciÃ³n', '2016-03-09', 56.00, 'Ninguna', '1'),
(7, 1, 'MediciÃ³n de propiedades fisicoquÃ­micas del aceite', '2016-03-09', 10.00, 'Ninguna', '1'),
(8, 1, 'MediciÃ³n de la humedad del papel', '2016-02-09', 10.00, 'Ninguna', '1'),
(9, 1, 'MediciÃ³n del productos de deterioro del aceite', '2016-03-09', 10.00, 'Ninguna', '1'),
(10, 1, 'CromatografÃ­a de gases disueltos', '2016-03-09', 10.00, 'Ninguna', '1'),
(11, 1, 'MediciÃ³n de contenidos furanicos', '2016-03-09', 10.00, 'Ninguna', '1'),
(12, 1, 'IdentificaciÃ³n de defectos', '2016-03-09', 10.00, 'Ninguna', '1'),
(13, 1, 'Espectropia en el dominio del tiempo y frecuencia para el cÃ¡lculo de humedad (DIRANA) - El equipo DIRANA permite medir la humedad en el papel y en el aceite sin un anÃ¡lisis de aceite en condiciones ambientales de alta humedad', '2016-03-09', 10.00, 'Ninguna', '1'),
(14, 2, 'Factor de potencia en devanados', '2016-03-09', 5.00, 'Ninguna', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tventas`
--

CREATE TABLE IF NOT EXISTS `tventas` (
  `idu` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `cantidadven` int(11) NOT NULL,
  `fechaven` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unidades`
--

CREATE TABLE IF NOT EXISTS `unidades` (
  `idun` int(11) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `estadoun` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unidades`
--

INSERT INTO `unidades` (`idun`, `unidad`, `estadoun`) VALUES
(1, 'pieza', '1');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idu` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasenha` varchar(50) NOT NULL,
  `nombreus` varchar(150) NOT NULL,
  `cedulaus` int(8) NOT NULL,
  `expedidous` char(2) NOT NULL,
  `cargous` varchar(50) NOT NULL,
  `telefonous` int(11) NOT NULL,
  `correous` varchar(100) NOT NULL,
  `fechaus` date NOT NULL,
  `direccionus` varchar(200) NOT NULL,
  `funcionus` char(1) NOT NULL,
  `estadous` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`idu`, `usuario`, `contrasenha`, `nombreus`, `cedulaus`, `expedidous`, `cargous`, `telefonous`, `correous`, `fechaus`, `direccionus`, `funcionus`, `estadous`) VALUES
(1, 'admin', 'f4e8e264f772f199fa1860a9d1c9364c', 'Administrador', 10101010, '1', '', 0, '', '2015-10-06', '', 'a', 0),
(2, 'operadoruno', '72091caa83933e760c985ca1acd61ed0', 'Operador uno', 1111111, '1', '', 0, '', '2015-10-01', '', 'o', 0),
(3, 'operadordos', 'e420fd603d47964c19ff164517766a31', 'Operador', 2222222, '2', '', 0, '', '2016-05-16', '', 'o', 0),
(4, 'operadortres', 'e3aec7de858ef27e1f24cb1c49fb4053', 'Operador', 3333333, '2', '', 0, '', '2016-05-16', '', 'o', 0),
(5, 'operadorcuatro', 'fd3f8c0cfa004435f3d05b509ced90bd', 'Operador', 4444444, '2', '', 0, '', '2016-05-16', '', 'o', 0),
(6, 'operadorcinco', '52f21ac256e16cd20b3a6213196e13ef', 'Operador', 5555555, '2', '', 0, '', '2016-05-16', '', 'o', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ventaprods`
--

CREATE TABLE IF NOT EXISTS `ventaprods` (
  `idvpr` bigint(20) NOT NULL,
  `idven` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `cantidadven` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE IF NOT EXISTS `ventas` (
  `idven` int(11) NOT NULL,
  `idu` int(11) NOT NULL,
  `idcli` int(11) NOT NULL,
  `formaven` tinyint(4) NOT NULL,
  `tiempoven` varchar(20) NOT NULL,
  `descuentoven` tinyint(4) NOT NULL,
  `numeroven` bigint(20) NOT NULL,
  `fechaven` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoriaser`
--
ALTER TABLE `categoriaser`
  ADD PRIMARY KEY (`idcats`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcli`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idemp`);

--
-- Indexes for table `prestarserv`
--
ALTER TABLE `prestarserv`
  ADD PRIMARY KEY (`idpse`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idpro`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idprv`);

--
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`idser`);

--
-- Indexes for table `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`idun`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idu`);

--
-- Indexes for table `ventaprods`
--
ALTER TABLE `ventaprods`
  ADD PRIMARY KEY (`idvpr`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idven`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoriaser`
--
ALTER TABLE `categoriaser`
  MODIFY `idcats` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcli` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idemp` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `prestarserv`
--
ALTER TABLE `prestarserv`
  MODIFY `idpse` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `idpro` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idprv` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idser` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `unidades`
--
ALTER TABLE `unidades`
  MODIFY `idun` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ventaprods`
--
ALTER TABLE `ventaprods`
  MODIFY `idvpr` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idven` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
