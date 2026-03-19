-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-03-2026 a las 17:51:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `astech_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_logins`
--

CREATE TABLE `bitacora_logins` (
  `id_login` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_hora` datetime DEFAULT current_timestamp(),
  `direccion_ip` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `bitacora_logins`
--

INSERT INTO `bitacora_logins` (`id_login`, `id_empleado`, `fecha_hora`, `direccion_ip`) VALUES
(1, 1, '2026-03-02 22:52:23', NULL),
(2, 3, '2026-03-18 23:49:49', '::1'),
(3, 3, '2026-03-18 23:55:37', '::1'),
(4, 3, '2026-03-19 00:08:44', '::1'),
(5, 3, '2026-03-19 00:17:33', '::1'),
(6, 3, '2026-03-19 10:30:04', '::1'),
(7, 3, '2026-03-19 10:46:09', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_movimientos`
--

CREATE TABLE `bitacora_movimientos` (
  `id_movimiento` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `detalle` text DEFAULT NULL,
  `fecha_hora` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `causas_servicio`
--

CREATE TABLE `causas_servicio` (
  `id_causa` int(11) NOT NULL,
  `nombre_causa` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_tipo_servicio` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_web`
--

CREATE TABLE `citas_web` (
  `id_cita` int(11) NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `apellido_cliente` varchar(50) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `id_tipo_equipo` int(11) NOT NULL,
  `tipo_equipo_otro` varchar(50) DEFAULT NULL,
  `id_marca` int(11) NOT NULL,
  `marca_otro` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) NOT NULL,
  `numero_serie` varchar(100) DEFAULT NULL,
  `problema_reportado` text NOT NULL,
  `fecha_cita` date NOT NULL,
  `hora_cita` time NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','atendida','cancelada') DEFAULT 'pendiente'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `citas_web`
--

INSERT INTO `citas_web` (`id_cita`, `nombre_cliente`, `apellido_cliente`, `whatsapp`, `id_tipo_equipo`, `tipo_equipo_otro`, `id_marca`, `marca_otro`, `modelo`, `numero_serie`, `problema_reportado`, `fecha_cita`, `hora_cita`, `fecha_registro`, `estado`) VALUES
(9, 'BRITHANY ', 'HERRERA', '3227790871', 5, NULL, 10, NULL, 'TUF GAMING F15', '123456', 'virus', '2026-03-27', '12:40:00', '2026-03-12 23:51:11', 'pendiente'),
(12, 'Ferdán', 'Garrigos', '3227790871', 4, NULL, 11, NULL, 'No visible', '123456', 'OTRO: Pantalla rota', '2026-03-31', '10:00:00', '2026-03-15 22:01:02', 'pendiente'),
(10, 'REYNA', 'GALINDO', '3222429896', 5, NULL, 9, NULL, 'TUF GAMING F15', '123456', 'pantalla', '2026-03-27', '13:00:00', '2026-03-13 00:04:54', 'pendiente'),
(6, 'Ferdán', 'Garrigos', '3227790871', 6, NULL, 9, NULL, 'TUF GAMING F15', 'hgfg', 'pantalla', '2026-03-20', '14:10:00', '2026-03-09 23:08:26', 'pendiente'),
(7, 'REYNA', 'GALINDO', '3227790871', 3, NULL, 11, NULL, 'dcv', '123456', 'lento', '2026-03-23', '11:20:00', '2026-03-09 23:20:13', 'pendiente'),
(8, 'ESPERANZA', 'ULLOA', '3227790871', 3, NULL, 11, NULL, 'TUF GAMING F15', '123456', 'bisagras', '2026-03-27', '13:20:00', '2026-03-09 23:23:47', 'pendiente'),
(11, 'ISMAEL', 'HERRERA', '3227790871', 6, NULL, 9, NULL, 'TUF GAMING F15', '123456', 'Pantalla no funciona', '2026-03-31', '11:20:00', '2026-03-13 00:16:24', 'pendiente'),
(13, 'REYNA', 'HERRERA', '3227790871', 7, 'tuo', 12, 'rt', 'TUF GAMING F15', NULL, 'LENTO: 33333ttt', '2026-03-31', '12:40:00', '2026-03-15 22:14:35', 'pendiente'),
(14, 'REYNA', 'ULLOA', '3222429896', 4, NULL, 4, NULL, 'hgfhncghv', 'hgfg', 'PANTALLA: ', '2026-03-31', '16:00:00', '2026-03-16 00:05:18', 'pendiente'),
(15, 'REYNA', 'GOMEZ', '3222429896', 4, NULL, 5, NULL, 'hgfhncghv', 'hgfg', 'PANTALLA: ', '2026-03-31', '15:40:00', '2026-03-16 00:12:48', 'pendiente'),
(16, 'REYNA', 'yh', '3222429896', 1, NULL, 11, NULL, 'ytuyu', '6666', 'VIRUS: ', '2026-03-31', '14:40:00', '2026-03-16 00:14:00', 'pendiente'),
(17, 'BRITHANY ', 'GALINDO', '3222429896', 1, NULL, 1, NULL, 'hgfhncghv', 'ukhlj.lk', 'VIRUS: ', '2026-03-31', '15:20:00', '2026-03-16 00:14:37', 'pendiente'),
(18, 'SAMANTHA', 'SUAREZ', '3222429896', 6, NULL, 5, NULL, 'TUF GAMING F15', '6666', 'OTRO: ES LENTA Y EL TECLADO TIENEN DIFICULTADES PARA BAJAR', '2026-03-31', '10:20:00', '2026-03-16 00:56:44', 'pendiente'),
(19, 'BRITHANY HERRERA', 'Garrigos', 'dgfngnng', 4, NULL, 1, NULL, 'dcv', '6666', 'LENTO: ', '2026-03-31', '10:40:00', '2026-03-16 01:20:27', 'pendiente'),
(20, 'SAMANTHA', 'ULLOA', '3222429896', 1, NULL, 5, NULL, 'hgfhncghv', 'hgfg', 'PANTALLA: ES LENTA Y EL TECLADO TIENEN DIFICULTADES PARA BAJAR', '2026-03-31', '11:00:00', '2026-03-16 01:20:55', 'pendiente'),
(21, 'BRITHANY HERRERA', 'HERRERA', '3222429896', 6, NULL, 5, NULL, 'ghkjk', 'hgfg', 'PANTALLA: ', '2026-03-31', '11:40:00', '2026-03-16 01:26:01', 'pendiente'),
(30, 'BRITHANY ', 'ULLOA', 'dgfngnng', 3, NULL, 4, NULL, 'TUF GAMING F15', 'hgfg', 'LENTO: ES LENTA Y EL TECLADO TIENEN DIFICULTADES PARA BAJAR', '2026-03-20', '16:00:00', '2026-03-18 23:37:45', 'pendiente'),
(33, 'Brithany ', 'Herrera', '123456789', 1, NULL, 6, NULL, 'TUF GAMING F15', '123456', 'PANTALLA: ', '2026-03-26', '11:20:00', '2026-03-19 10:45:50', 'pendiente'),
(32, 'SAMANTHA', 'SUAREZ', '3227790871', 1, NULL, 5, NULL, 'TUF GAMING F15', '123456', 'No enciende', '2026-03-19', '13:00:00', '2026-03-19 00:08:28', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `telefono`, `correo`) VALUES
(1, 'Ana', 'Martínez', '5598765432', 'ana@email.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condiciones_servicio`
--

CREATE TABLE `condiciones_servicio` (
  `id_condicion` int(11) NOT NULL,
  `folio_orden` varchar(20) NOT NULL,
  `autoriza_revision_costo` enum('si','no') NOT NULL,
  `tiempo_estimado` varchar(100) NOT NULL,
  `recordatorio_anticipo` enum('si','no') NOT NULL,
  `dudas_cliente` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `condiciones_servicio`
--

INSERT INTO `condiciones_servicio` (`id_condicion`, `folio_orden`, `autoriza_revision_costo`, `tiempo_estimado`, `recordatorio_anticipo`, `dudas_cliente`) VALUES
(1, '0603261', 'si', '3 a 5 días', 'si', '¿Se pierden mis archivos si la formatean?');

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
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_puesto` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `telefono`, `correo`, `nombre_usuario`, `contrasena`, `id_puesto`) VALUES
(1, 'Carlos', 'López', '3312345678', 'carlos@astech.com', '', '', 1),
(2, 'Brithany', 'Herrera', '3227790871', 'brithany@gmail.com', 'Brithany Herrera', '$2y$10$gmXPbvO2jK1.Fdi0YF69Pu/TJ8.2iV55VjMyQWqv3ksMINLNeO7AG', 2),
(3, 'Brithany', 'Corona', '3227790871', 'brithany@gmail.com', 'Brithany Corona', '12345', 3);

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
  `numero_serie` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `id_cliente`, `id_marca`, `id_tipo_equipo`, `marca_otro`, `tipo_equipo_otro`, `modelo`, `numero_serie`) VALUES
(1, 1, 1, 1, NULL, NULL, 'ThinkPad T480', 'SN-98765X');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencias_servicio`
--

CREATE TABLE `frecuencias_servicio` (
  `id_frecuencia` int(11) NOT NULL,
  `frecuencia` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `frecuencias_servicio`
--

INSERT INTO `frecuencias_servicio` (`id_frecuencia`, `frecuencia`) VALUES
(1, '1 vez al año o menos'),
(2, '2-3 veces al año'),
(3, 'Más de 3'),
(4, 'Cuando se descompone'),
(5, 'Nunca'),
(6, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gabinetes`
--

CREATE TABLE `gabinetes` (
  `id_gabinete` varchar(10) NOT NULL,
  `tipo_espacio` enum('laptop','computadora_escritorio','otro') NOT NULL,
  `estado` enum('disponible','ocupado','clausurado') DEFAULT 'disponible'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `gabinetes`
--

INSERT INTO `gabinetes` (`id_gabinete`, `tipo_espacio`, `estado`) VALUES
('10', 'laptop', 'disponible'),
('11', 'laptop', 'disponible'),
('12', 'laptop', 'disponible'),
('A', 'computadora_escritorio', 'disponible'),
('B', 'computadora_escritorio', 'disponible'),
('C', 'computadora_escritorio', 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `marca`) VALUES
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
-- Estructura de tabla para la tabla `marketing`
--

CREATE TABLE `marketing` (
  `id_encuesta` int(11) NOT NULL,
  `folio_orden` varchar(20) NOT NULL,
  `id_medio_contacto` int(11) NOT NULL,
  `medio_contacto_otro` varchar(100) DEFAULT NULL,
  `recibir_promociones` enum('si por correo','si por whatsapp','ambos','no') NOT NULL,
  `id_tipo_uso` int(11) NOT NULL,
  `tipo_uso_otro` varchar(100) DEFAULT NULL,
  `es_primera_vez` enum('si','no') NOT NULL,
  `id_frecuencia_servicio` int(11) NOT NULL,
  `frecuencia_servicio_otro` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `marketing`
--

INSERT INTO `marketing` (`id_encuesta`, `folio_orden`, `id_medio_contacto`, `medio_contacto_otro`, `recibir_promociones`, `id_tipo_uso`, `tipo_uso_otro`, `es_primera_vez`, `id_frecuencia_servicio`, `frecuencia_servicio_otro`) VALUES
(1, '0303261', 2, NULL, 'si por whatsapp', 2, NULL, 'si', 4, NULL),
(2, '0603261', 2, NULL, 'si por whatsapp', 2, NULL, 'si', 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medios_contacto`
--

CREATE TABLE `medios_contacto` (
  `id_medio` int(11) NOT NULL,
  `medio` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `medios_contacto`
--

INSERT INTO `medios_contacto` (`id_medio`, `medio`) VALUES
(1, 'Recomendación'),
(2, 'Redes Sociales'),
(3, 'Google/Sitio Web'),
(4, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id_mensaje` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `asunto` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NULL DEFAULT current_timestamp(),
  `estado` enum('nuevo','pendiente','respondido','finalizado') DEFAULT 'nuevo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_ingreso`
--

CREATE TABLE `ordenes_ingreso` (
  `folio` varchar(20) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `id_gabinete` varchar(10) NOT NULL,
  `fecha_ingreso` datetime DEFAULT current_timestamp(),
  `revision_fisica_control` text DEFAULT NULL,
  `condicion_fisica` varchar(255) NOT NULL,
  `accesorios_entregados` varchar(255) NOT NULL,
  `descripcion_problema` text NOT NULL,
  `observaciones_recepcion` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `ordenes_ingreso`
--

INSERT INTO `ordenes_ingreso` (`folio`, `id_equipo`, `id_tecnico`, `id_gabinete`, `fecha_ingreso`, `revision_fisica_control`, `condicion_fisica`, `accesorios_entregados`, `descripcion_problema`, `observaciones_recepcion`) VALUES
('0303261', 1, 1, '', '2026-03-02 22:46:13', NULL, 'Rayones', 'Cargador', 'La pantalla parpadea', 'El cliente indica que se le cayó'),
('0603261', 1, 1, '', '2026-03-06 18:15:45', NULL, 'Rayones', 'Cargador', 'No enciende', 'Golpe en la esquina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id_puesto` int(11) NOT NULL,
  `nombre_puesto` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`id_puesto`, `nombre_puesto`) VALUES
(1, 'Soporte Técnico'),
(2, 'Recepción'),
(3, 'Gerente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion_equipo_marca`
--

CREATE TABLE `relacion_equipo_marca` (
  `id_marca` int(11) NOT NULL,
  `id_tipo_equipo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `relacion_equipo_marca`
--

INSERT INTO `relacion_equipo_marca` (`id_marca`, `id_tipo_equipo`) VALUES
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
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `tipo_servicio` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `tiempo_estimado` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `tipo_servicio`, `descripcion`, `imagen_url`, `tiempo_estimado`, `precio`, `estado`) VALUES
(1, 'Mantenimiento Preventivo', 'Limpieza profunda de componentes internos, cambio de pasta térmica y optimización del sistema operativo.', 'imagenes/servicios/mantenimiento_preventivo.jpg', '1 a 2 horas', 450.00, 'activo'),
(2, 'Formateo y Respaldo', 'Instalación de Windows desde cero con paquetería Office. Incluye respaldo de hasta 50GB de información del cliente.', 'imagenes/servicios/formateo_windows.png', '1 día hábil', 600.00, 'activo'),
(3, 'LIMMPERZA DE VENTILADORES', 'LIMPIEZA PROFUNDA DE LOS VENTILSDORES', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABKkAAAGhCAYAAACqKOd0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAHaOSURBVHhe7b1vbxPX+q/Pq/kJqe/hvA6k/XS/gErn6flK58H3nIqH4DRBiezEVtISBSmJE1KBCiWnaWI1u6CdYlpTqMxGismfGrzBYMDZ90/3WrNmlsdO4', '2 HORAS', 500.00, 'activo'),
(4, 'DRFYGHIJLMK', 'TDFYGUHINJ', '', '9', 90.00, 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_equipo`
--

CREATE TABLE `tipos_equipo` (
  `id_tipo_equipo` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tipos_equipo`
--

INSERT INTO `tipos_equipo` (`id_tipo_equipo`, `tipo`) VALUES
(1, 'Laptop'),
(2, 'PC'),
(3, 'All-in-one'),
(4, 'Minipc'),
(5, 'Consola de videojuegos'),
(6, 'Control gaming'),
(7, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_servicios`
--

CREATE TABLE `tipos_servicios` (
  `id_tipo_servicio` int(11) NOT NULL,
  `nombre_tipo` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tipos_servicios`
--

INSERT INTO `tipos_servicios` (`id_tipo_servicio`, `nombre_tipo`) VALUES
(1, 'Mantenimiento preventivo'),
(2, 'Reparación y Reemplazo'),
(3, 'Instalación de Software'),
(4, 'Servicios de entrega'),
(5, 'Servicios Especializados'),
(1, 'Mantenimiento preventivo'),
(2, 'Reparación y Reemplazo'),
(3, 'Instalación de Software'),
(4, 'Servicios de entrega'),
(5, 'Servicios Especializados'),
(1, 'Mantenimiento preventivo'),
(2, 'Reparación y Reemplazo'),
(3, 'Instalación de Software'),
(4, 'Servicios de entrega'),
(5, 'Servicios Especializados'),
(1, 'Mantenimiento preventivo'),
(2, 'Reparación y Reemplazo'),
(3, 'Instalación de Software'),
(4, 'Servicios de entrega'),
(5, 'Servicios Especializados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_uso`
--

CREATE TABLE `tipos_uso` (
  `id_tipo_uso` int(11) NOT NULL,
  `uso` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tipos_uso`
--

INSERT INTO `tipos_uso` (`id_tipo_uso`, `uso`) VALUES
(1, 'Estudio'),
(2, 'Trabajo'),
(3, 'Diseño/Arquitectura/Edicion'),
(4, 'Gaming'),
(5, 'Otro');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora_logins`
--
ALTER TABLE `bitacora_logins`
  ADD PRIMARY KEY (`id_login`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `bitacora_movimientos`
--
ALTER TABLE `bitacora_movimientos`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `causas_servicio`
--
ALTER TABLE `causas_servicio`
  ADD PRIMARY KEY (`id_causa`),
  ADD KEY `id_tipo_servicio` (`id_tipo_servicio`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `citas_web`
--
ALTER TABLE `citas_web`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_tipo_equipo` (`id_tipo_equipo`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `condiciones_servicio`
--
ALTER TABLE `condiciones_servicio`
  ADD PRIMARY KEY (`id_condicion`),
  ADD KEY `folio_orden` (`folio_orden`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `id_puesto` (`id_puesto`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_marca` (`id_marca`,`id_tipo_equipo`);

--
-- Indices de la tabla `frecuencias_servicio`
--
ALTER TABLE `frecuencias_servicio`
  ADD PRIMARY KEY (`id_frecuencia`);

--
-- Indices de la tabla `gabinetes`
--
ALTER TABLE `gabinetes`
  ADD PRIMARY KEY (`id_gabinete`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `marketing`
--
ALTER TABLE `marketing`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `folio_orden` (`folio_orden`),
  ADD KEY `id_medio_contacto` (`id_medio_contacto`),
  ADD KEY `id_tipo_uso` (`id_tipo_uso`),
  ADD KEY `id_frecuencia_servicio` (`id_frecuencia_servicio`);

--
-- Indices de la tabla `medios_contacto`
--
ALTER TABLE `medios_contacto`
  ADD PRIMARY KEY (`id_medio`);

--
-- Indices de la tabla `ordenes_ingreso`
--
ALTER TABLE `ordenes_ingreso`
  ADD PRIMARY KEY (`folio`),
  ADD KEY `id_equipo` (`id_equipo`),
  ADD KEY `id_tecnico` (`id_tecnico`),
  ADD KEY `id_gabinete` (`id_gabinete`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id_puesto`);

--
-- Indices de la tabla `relacion_equipo_marca`
--
ALTER TABLE `relacion_equipo_marca`
  ADD PRIMARY KEY (`id_marca`,`id_tipo_equipo`),
  ADD KEY `id_tipo_equipo` (`id_tipo_equipo`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `tipos_equipo`
--
ALTER TABLE `tipos_equipo`
  ADD PRIMARY KEY (`id_tipo_equipo`);

--
-- Indices de la tabla `tipos_uso`
--
ALTER TABLE `tipos_uso`
  ADD PRIMARY KEY (`id_tipo_uso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora_logins`
--
ALTER TABLE `bitacora_logins`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `bitacora_movimientos`
--
ALTER TABLE `bitacora_movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas_web`
--
ALTER TABLE `citas_web`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `condiciones_servicio`
--
ALTER TABLE `condiciones_servicio`
  MODIFY `id_condicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `frecuencias_servicio`
--
ALTER TABLE `frecuencias_servicio`
  MODIFY `id_frecuencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `marketing`
--
ALTER TABLE `marketing`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medios_contacto`
--
ALTER TABLE `medios_contacto`
  MODIFY `id_medio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipos_equipo`
--
ALTER TABLE `tipos_equipo`
  MODIFY `id_tipo_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipos_uso`
--
ALTER TABLE `tipos_uso`
  MODIFY `id_tipo_uso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
