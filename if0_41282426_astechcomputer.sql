-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql113.infinityfree.com
-- Tiempo de generación: 02-03-2026 a las 01:04:57
-- Versión del servidor: 11.4.10-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_41282426_astechcomputer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_frecuencias_servicio`
--

CREATE TABLE `catalogo_frecuencias_servicio` (
  `id_frecuencia` int(11) NOT NULL,
  `frecuencia` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `catalogo_frecuencias_servicio`
--

INSERT INTO `catalogo_frecuencias_servicio` (`id_frecuencia`, `frecuencia`) VALUES
(1, '1 vez al año o menos'),
(2, '2-3 veces al año'),
(3, 'Más de 3'),
(4, 'Cuando se descompone'),
(5, 'Nunca'),
(6, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_marcas`
--

CREATE TABLE `catalogo_marcas` (
  `id_marca` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `catalogo_marcas`
--

INSERT INTO `catalogo_marcas` (`id_marca`, `marca`) VALUES
(1, 'Lenovo'),
(2, 'HP'),
(3, 'Dell'),
(4, 'Apple'),
(5, 'Asus'),
(6, 'Acer'),
(7, 'MSI'),
(8, 'Sony'),
(9, 'Microsoft'),
(10, 'Nintendo'),
(11, 'NV (No Visible)'),
(12, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_medios_contacto`
--

CREATE TABLE `catalogo_medios_contacto` (
  `id_medio` int(11) NOT NULL,
  `medio` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `catalogo_medios_contacto`
--

INSERT INTO `catalogo_medios_contacto` (`id_medio`, `medio`) VALUES
(1, 'Recomendación'),
(2, 'Redes Sociales'),
(3, 'Google/Sitio Web'),
(4, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_puestos`
--

CREATE TABLE `catalogo_puestos` (
  `id_puesto` int(11) NOT NULL,
  `nombre_puesto` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `catalogo_puestos`
--

INSERT INTO `catalogo_puestos` (`id_puesto`, `nombre_puesto`) VALUES
(1, 'Soporte Técnico'),
(2, 'Recepción'),
(3, 'Gerente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_tipos_equipo`
--

CREATE TABLE `catalogo_tipos_equipo` (
  `id_tipo_equipo` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `catalogo_tipos_equipo`
--

INSERT INTO `catalogo_tipos_equipo` (`id_tipo_equipo`, `tipo`) VALUES
(1, 'Laptop'),
(2, 'PC'),
(3, 'All-in-one'),
(4, 'Minipc'),
(5, 'Consola de videojuegos'),
(6, 'Control gaming'),
(7, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_tipos_uso`
--

CREATE TABLE `catalogo_tipos_uso` (
  `id_tipo_uso` int(11) NOT NULL,
  `uso` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `catalogo_tipos_uso`
--

INSERT INTO `catalogo_tipos_uso` (`id_tipo_uso`, `uso`) VALUES
(1, 'Estudio'),
(2, 'Trabajo'),
(3, 'Diseño/Arquitectura/Edicion'),
(4, 'Gaming'),
(5, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `id_medio_contacto` int(11) NOT NULL,
  `medio_contacto_otro` varchar(100) DEFAULT NULL,
  `recibir_promociones` enum('si por correo','si por whatsapp','ambos','no') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `telefono`, `correo`, `id_medio_contacto`, `medio_contacto_otro`, `recibir_promociones`) VALUES
(1, 'Ana', 'Martínez', '5598765432', 'ana@email.com', 2, NULL, 'si por whatsapp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `id_puesto` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `telefono`, `correo`, `id_puesto`) VALUES
(1, 'Carlos', 'López', '3312345678', 'carlos@astech.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `id_tipo_equipo` int(11) NOT NULL,
  `marca_otro` varchar(50) DEFAULT NULL,
  `tipo_equipo_otro` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT 'NV',
  `numero_serie` varchar(100) DEFAULT NULL,
  `id_tipo_uso` int(11) NOT NULL,
  `tipo_uso_otro` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `id_cliente`, `id_marca`, `id_tipo_equipo`, `marca_otro`, `tipo_equipo_otro`, `modelo`, `numero_serie`, `id_tipo_uso`, `tipo_uso_otro`) VALUES
(1, 1, 1, 1, NULL, NULL, 'ThinkPad T480', 'SN-98765X', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca_tipo_equipo`
--

CREATE TABLE `marca_tipo_equipo` (
  `id_marca` int(11) NOT NULL,
  `id_tipo_equipo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `marca_tipo_equipo`
--

INSERT INTO `marca_tipo_equipo` (`id_marca`, `id_tipo_equipo`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 7),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 7),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 7),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 7),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 6),
(5, 7),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 7),
(7, 1),
(7, 2),
(7, 4),
(7, 6),
(7, 7),
(8, 5),
(8, 6),
(8, 7),
(9, 5),
(9, 6),
(9, 7),
(10, 5),
(10, 6),
(10, 7),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(11, 6),
(11, 7),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(12, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_ingreso`
--

CREATE TABLE `ordenes_ingreso` (
  `folio` varchar(20) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `fecha_ingreso` datetime DEFAULT current_timestamp(),
  `revision_fisica_control` text DEFAULT NULL,
  `condicion_fisica` varchar(255) NOT NULL,
  `accesorios_entregados` varchar(255) NOT NULL,
  `descripcion_problema` text NOT NULL,
  `observaciones_recepcion` text NOT NULL,
  `autoriza_revision_costo` enum('si','no') NOT NULL,
  `tiempo_estimado` varchar(100) NOT NULL,
  `dudas_cliente` text DEFAULT NULL,
  `es_primera_vez` enum('si','no') NOT NULL,
  `id_frecuencia_servicio` int(11) NOT NULL,
  `frecuencia_servicio_otro` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `ordenes_ingreso`
--

INSERT INTO `ordenes_ingreso` (`folio`, `id_equipo`, `id_tecnico`, `fecha_ingreso`, `revision_fisica_control`, `condicion_fisica`, `accesorios_entregados`, `descripcion_problema`, `observaciones_recepcion`, `autoriza_revision_costo`, `tiempo_estimado`, `dudas_cliente`, `es_primera_vez`, `id_frecuencia_servicio`, `frecuencia_servicio_otro`) VALUES
('2602261', 1, 1, '2026-03-01 21:59:31', NULL, 'Rayones en la carcasa', 'Cargador original', 'La pantalla parpadea y se apaga a los 10 minutos', 'El cliente indica que se le cayó de la cama', 'si', '3 a 5 días hábiles', NULL, 'si', 4, NULL),
('1508261', 1, 1, '2026-03-01 22:00:32', NULL, 'Manchas pegajosas en el teclado', 'Ninguno (No trajo cargador)', 'Se derramó café sobre el teclado, algunas teclas ya no responden', 'El equipo enciende, pero se recomienda limpieza interna urgente', 'si', '2 días hábiles', NULL, 'no', 2, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo_frecuencias_servicio`
--
ALTER TABLE `catalogo_frecuencias_servicio`
  ADD PRIMARY KEY (`id_frecuencia`);

--
-- Indices de la tabla `catalogo_marcas`
--
ALTER TABLE `catalogo_marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `catalogo_medios_contacto`
--
ALTER TABLE `catalogo_medios_contacto`
  ADD PRIMARY KEY (`id_medio`);

--
-- Indices de la tabla `catalogo_puestos`
--
ALTER TABLE `catalogo_puestos`
  ADD PRIMARY KEY (`id_puesto`);

--
-- Indices de la tabla `catalogo_tipos_equipo`
--
ALTER TABLE `catalogo_tipos_equipo`
  ADD PRIMARY KEY (`id_tipo_equipo`);

--
-- Indices de la tabla `catalogo_tipos_uso`
--
ALTER TABLE `catalogo_tipos_uso`
  ADD PRIMARY KEY (`id_tipo_uso`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_medio_contacto` (`id_medio_contacto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_puesto` (`id_puesto`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_tipo_uso` (`id_tipo_uso`),
  ADD KEY `id_marca` (`id_marca`,`id_tipo_equipo`);

--
-- Indices de la tabla `marca_tipo_equipo`
--
ALTER TABLE `marca_tipo_equipo`
  ADD PRIMARY KEY (`id_marca`,`id_tipo_equipo`),
  ADD KEY `id_tipo_equipo` (`id_tipo_equipo`);

--
-- Indices de la tabla `ordenes_ingreso`
--
ALTER TABLE `ordenes_ingreso`
  ADD PRIMARY KEY (`folio`),
  ADD KEY `id_equipo` (`id_equipo`),
  ADD KEY `id_tecnico` (`id_tecnico`),
  ADD KEY `id_frecuencia_servicio` (`id_frecuencia_servicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo_frecuencias_servicio`
--
ALTER TABLE `catalogo_frecuencias_servicio`
  MODIFY `id_frecuencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `catalogo_marcas`
--
ALTER TABLE `catalogo_marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `catalogo_medios_contacto`
--
ALTER TABLE `catalogo_medios_contacto`
  MODIFY `id_medio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `catalogo_puestos`
--
ALTER TABLE `catalogo_puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `catalogo_tipos_equipo`
--
ALTER TABLE `catalogo_tipos_equipo`
  MODIFY `id_tipo_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `catalogo_tipos_uso`
--
ALTER TABLE `catalogo_tipos_uso`
  MODIFY `id_tipo_uso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
