-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-05-2026 a las 21:27:39
-- Versión del servidor: 11.8.6-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u569580671_astechcomputer`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `bitacora_logins`
--

INSERT INTO `bitacora_logins` (`id_login`, `id_empleado`, `fecha_hora`, `direccion_ip`) VALUES
(1, 1, '2026-04-16 19:46:51', '189.178.243.64'),
(2, 1, '2026-04-16 23:16:14', '189.178.243.64'),
(3, 1, '2026-04-16 23:49:37', '189.178.243.64'),
(4, 2, '2026-04-16 23:58:35', '189.178.243.64'),
(5, 1, '2026-04-16 23:59:12', '189.178.243.64'),
(6, 2, '2026-04-17 09:53:02', '189.178.243.64'),
(7, 1, '2026-04-17 09:56:10', '189.178.243.64'),
(8, 1, '2026-04-17 17:11:14', '187.190.197.191'),
(9, 1, '2026-04-18 22:17:21', '189.178.243.64'),
(10, 1, '2026-04-18 23:00:11', '189.178.243.64'),
(11, 1, '2026-04-19 16:30:53', '189.178.243.64'),
(12, 1, '2026-04-19 16:57:40', '189.178.243.64'),
(13, 2, '2026-04-19 18:18:05', '189.178.243.64'),
(14, 1, '2026-04-19 18:28:01', '189.178.243.64'),
(15, 2, '2026-04-19 18:40:32', '189.178.243.64'),
(16, 1, '2026-04-19 18:44:30', '189.178.243.64'),
(17, 2, '2026-04-19 18:51:21', '189.178.243.64'),
(18, 1, '2026-04-19 18:57:55', '189.178.243.64'),
(19, 1, '2026-04-19 22:19:42', '189.178.243.64'),
(20, 1, '2026-04-19 22:21:41', '189.178.243.64'),
(21, 1, '2026-04-19 22:58:14', '189.178.243.64'),
(22, 1, '2026-04-19 23:39:14', '189.178.243.64'),
(23, 1, '2026-04-20 00:15:08', '189.178.243.64'),
(24, 1, '2026-04-21 03:14:20', '2806:102e:18:1fbd:e531:9391:6abc:9d9'),
(25, 1, '2026-04-21 03:34:17', '2806:102e:18:1fbd:e531:9391:6abc:9d9'),
(26, 1, '2026-04-21 07:22:56', '2806:102e:18:1fbd:52:3aa7:5bc3:366f'),
(27, 1, '2026-04-21 07:40:47', '2806:102e:18:1fbd:52:3aa7:5bc3:366f'),
(28, 1, '2026-04-21 16:27:28', '2806:102e:18:1fbd:52:3aa7:5bc3:366f'),
(29, 1, '2026-04-22 05:27:18', '2806:102e:18:1fbd:793a:7e2b:f28:ce55'),
(30, 1, '2026-04-22 16:35:10', '2806:102e:18:1fbd:a02d:fc0:ee0e:3ed7'),
(31, 1, '2026-04-22 18:02:39', '2806:102e:18:571f:4d21:8744:ed8c:2849'),
(32, 1, '2026-04-22 20:53:09', '201.116.196.141'),
(33, 1, '2026-04-22 21:10:50', '201.116.196.141'),
(34, 1, '2026-04-22 21:23:21', '201.116.196.141'),
(35, 1, '2026-04-22 22:42:28', '201.116.196.141'),
(36, 1, '2026-04-22 23:14:12', '201.116.196.141'),
(37, 1, '2026-04-23 05:11:46', '2806:102e:18:1fbd:55e5:159d:a5b0:23c4'),
(38, 1, '2026-04-23 16:10:37', '2806:102e:18:1fbd:110c:3e27:30c3:921a'),
(39, 1, '2026-04-24 04:57:06', '189.178.235.37'),
(40, 1, '2026-04-26 22:55:08', '189.178.235.37'),
(41, 1, '2026-04-27 01:29:48', '189.178.250.243'),
(42, 1, '2026-04-27 06:53:28', '189.178.235.37'),
(43, 1, '2026-04-27 06:54:34', '189.178.235.37'),
(44, 1, '2026-04-27 07:06:32', '189.178.235.37'),
(45, 1, '2026-04-27 07:27:15', '189.178.235.37'),
(46, 1, '2026-04-27 07:45:22', '189.178.235.37'),
(47, 1, '2026-04-28 06:38:11', '189.178.235.37'),
(48, 1, '2026-04-28 16:22:44', '189.178.235.37'),
(49, 1, '2026-04-29 02:14:59', '189.178.235.37'),
(50, 1, '2026-04-29 05:45:08', '189.178.235.37'),
(51, 1, '2026-05-01 06:49:59', '189.178.235.37'),
(52, 1, '2026-05-03 04:30:46', '189.178.235.37'),
(53, 1, '2026-05-03 04:31:28', '189.178.235.37'),
(54, 3, '2026-05-03 04:33:21', '189.178.235.37'),
(55, 3, '2026-05-03 07:26:20', '189.178.235.37'),
(56, 3, '2026-05-03 19:23:20', '189.178.235.37'),
(57, 3, '2026-05-03 20:34:41', '189.178.235.37'),
(58, 3, '2026-05-03 21:24:41', '189.178.235.37'),
(59, 3, '2026-05-04 06:04:07', '189.178.235.37'),
(60, 3, '2026-05-04 16:44:08', '189.178.235.37'),
(61, 1, '2026-05-04 16:45:29', '189.178.238.249'),
(62, 3, '2026-05-05 22:35:42', '201.116.196.132'),
(63, 3, '2026-05-05 22:42:51', '201.116.196.132'),
(64, 3, '2026-05-05 23:05:25', '201.116.196.132'),
(65, 3, '2026-05-06 16:30:47', '189.178.235.37'),
(66, 1, '2026-05-06 17:19:09', '189.178.238.249'),
(67, 1, '2026-05-06 21:12:04', '189.178.238.249'),
(68, 3, '2026-05-07 05:47:06', '189.178.235.37'),
(69, 3, '2026-05-07 06:11:06', '189.178.235.37'),
(70, 11, '2026-05-07 06:11:52', '189.178.235.37'),
(71, 3, '2026-05-07 06:12:35', '189.178.235.37'),
(72, 3, '2026-05-07 18:50:37', '189.178.235.37'),
(73, 3, '2026-05-07 18:52:43', '189.178.235.37'),
(74, 3, '2026-05-07 19:03:14', '189.178.235.37'),
(75, 1, '2026-05-07 17:14:40', '189.178.238.249'),
(76, 3, '2026-05-08 00:24:44', '189.178.235.37'),
(77, 3, '2026-05-08 10:13:25', '189.178.235.37'),
(78, 1, '2026-05-08 14:23:53', '189.178.238.249');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `bitacora_movimientos`
--

INSERT INTO `bitacora_movimientos` (`id_movimiento`, `id_empleado`, `accion`, `detalle`, `fecha_hora`) VALUES
(1, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-16 12:48:10'),
(2, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 12:48:11'),
(3, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 19:05:55'),
(4, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-16 19:06:02'),
(5, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-16 19:06:03'),
(6, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-16 19:06:05'),
(7, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-16 19:06:07'),
(8, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-16 19:06:10'),
(9, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-16 19:06:13'),
(10, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-16 19:06:15'),
(11, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-16 19:06:38'),
(12, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 19:06:42'),
(13, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-16 19:17:48'),
(14, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-16 19:17:49'),
(15, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-16 19:17:50'),
(16, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-16 19:17:52'),
(17, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-16 19:17:53'),
(18, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-16 19:17:54'),
(19, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-16 19:17:56'),
(20, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-16 19:17:59'),
(21, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-16 19:17:59'),
(22, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-16 19:18:01'),
(23, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-16 19:18:02'),
(24, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 19:18:04'),
(25, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-16 19:18:05'),
(26, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 19:35:09'),
(27, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-16 19:35:15'),
(28, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-16 19:35:17'),
(29, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-16 19:35:18'),
(30, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 19:46:52'),
(31, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 23:16:14'),
(32, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-16 23:27:52'),
(33, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-16 23:34:49'),
(34, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-16 23:34:50'),
(35, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-16 23:35:18'),
(36, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-16 23:35:23'),
(37, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-16 23:37:35'),
(38, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-16 23:37:36'),
(39, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 23:39:31'),
(40, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-16 23:39:33'),
(41, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 23:45:41'),
(42, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 23:49:37'),
(43, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-16 23:52:16'),
(44, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 23:58:04'),
(45, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-16 23:58:07'),
(46, 2, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 23:58:35'),
(47, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-16 23:58:39'),
(48, 2, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-16 23:58:41'),
(49, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-16 23:59:12'),
(50, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-16 23:59:15'),
(51, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-16 23:59:25'),
(52, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-16 23:59:28'),
(53, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-16 23:59:29'),
(54, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 09:06:56'),
(55, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-17 09:06:59'),
(56, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-17 09:07:01'),
(57, 2, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 09:53:03'),
(58, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 09:53:10'),
(59, 2, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-17 09:53:12'),
(60, 2, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 09:53:13'),
(61, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 09:53:14'),
(62, 2, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-17 09:53:15'),
(63, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 09:53:17'),
(64, 2, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 09:53:17'),
(65, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 09:53:19'),
(66, 2, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-17 09:53:20'),
(67, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 09:53:28'),
(68, 2, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-17 09:55:32'),
(69, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 09:56:11'),
(70, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-17 09:59:22'),
(71, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 10:01:08'),
(72, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-17 10:05:25'),
(73, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-17 10:05:39'),
(74, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-17 10:09:09'),
(75, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-17 10:09:12'),
(76, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-17 10:09:13'),
(77, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 10:09:16'),
(78, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-17 10:09:19'),
(79, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-17 10:09:21'),
(80, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 10:09:24'),
(81, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-17 10:09:26'),
(82, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-17 10:09:29'),
(83, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-17 10:09:47'),
(84, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-17 10:09:49'),
(85, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-17 10:09:53'),
(86, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-17 10:09:55'),
(87, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 10:09:56'),
(88, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-17 10:09:58'),
(89, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-17 10:10:00'),
(90, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 10:10:02'),
(91, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 17:11:14'),
(92, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-17 17:11:29'),
(93, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-17 17:11:35'),
(94, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-17 17:11:51'),
(95, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-17 17:11:57'),
(96, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 17:12:01'),
(97, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-17 17:12:05'),
(98, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-17 17:12:08'),
(99, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-17 17:12:10'),
(100, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-17 17:12:11'),
(101, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-17 17:12:22'),
(102, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-17 17:12:25'),
(103, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-17 17:12:25'),
(104, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 17:12:25'),
(105, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-17 17:12:26'),
(106, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-17 17:12:26'),
(107, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 17:12:26'),
(108, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-17 17:12:27'),
(109, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 17:12:27'),
(110, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-17 17:12:40'),
(111, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-17 17:12:56'),
(112, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 17:16:04'),
(113, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-17 17:16:12'),
(114, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 17:16:16'),
(115, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-17 17:16:26'),
(116, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-17 17:16:41'),
(117, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-17 17:17:26'),
(118, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-17 17:17:31'),
(119, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-17 17:17:52'),
(120, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-17 17:18:03'),
(121, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-18 22:17:21'),
(122, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-18 22:17:38'),
(123, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-18 22:17:42'),
(124, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-18 22:17:43'),
(125, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-18 22:18:07'),
(126, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-18 22:18:12'),
(127, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-18 22:18:26'),
(128, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-18 22:18:35'),
(129, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-18 22:18:39'),
(130, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-18 22:19:14'),
(131, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-18 22:19:15'),
(132, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-18 22:25:17'),
(133, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-18 22:25:21'),
(134, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-18 22:25:23'),
(135, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-18 22:25:27'),
(136, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-18 23:00:11'),
(137, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 16:30:53'),
(138, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-19 16:31:00'),
(139, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 16:31:02'),
(140, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-19 16:31:11'),
(141, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-19 16:31:16'),
(142, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-19 16:31:18'),
(143, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-19 16:31:20'),
(144, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 16:32:03'),
(145, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 16:32:04'),
(146, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 16:32:07'),
(147, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 16:32:09'),
(148, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-19 16:32:12'),
(149, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-19 16:32:13'),
(150, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-19 16:32:15'),
(151, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-19 16:32:17'),
(152, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 16:32:21'),
(153, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 16:32:22'),
(154, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 16:32:39'),
(155, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 16:32:41'),
(156, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 16:32:42'),
(157, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 16:57:40'),
(158, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 16:57:42'),
(159, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 17:00:46'),
(160, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 17:00:48'),
(161, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 17:03:07'),
(162, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 17:03:10'),
(163, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 17:15:09'),
(164, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 17:19:12'),
(165, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 17:19:14'),
(166, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 17:19:56'),
(167, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 17:19:58'),
(168, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 18:17:20'),
(169, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-19 18:17:22'),
(170, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:17:26'),
(171, 2, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 18:18:05'),
(172, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:18:07'),
(173, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 18:28:01'),
(174, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:28:04'),
(175, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 18:39:44'),
(176, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-19 18:39:47'),
(177, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:39:48'),
(178, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-19 18:39:50'),
(179, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:39:51'),
(180, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 18:39:53'),
(181, 2, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 18:40:32'),
(182, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:40:34'),
(183, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 18:44:30'),
(184, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:44:32'),
(185, 2, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 18:51:22'),
(186, 2, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:51:23'),
(187, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 18:57:55'),
(188, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 18:57:57'),
(189, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 19:08:27'),
(190, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-19 19:08:29'),
(191, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-19 19:08:31'),
(192, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 19:11:55'),
(193, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 19:11:57'),
(194, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 19:37:15'),
(195, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 19:37:16'),
(196, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-19 19:39:42'),
(197, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 19:39:45'),
(198, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 19:39:47'),
(199, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 19:56:19'),
(200, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 19:56:31'),
(201, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 20:04:53'),
(202, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 20:57:12'),
(203, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-19 22:02:28'),
(204, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-19 22:02:29'),
(205, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:02:32'),
(206, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 22:19:42'),
(207, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:19:45'),
(208, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 22:21:42'),
(209, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:21:46'),
(210, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-19 22:22:16'),
(211, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:22:17'),
(212, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 22:34:46'),
(213, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:34:49'),
(214, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-19 22:52:37'),
(215, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-19 22:52:44'),
(216, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 22:52:55'),
(217, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 22:52:59'),
(218, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:53:03'),
(219, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 22:58:14'),
(220, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:58:17'),
(221, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 22:58:39'),
(222, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:58:42'),
(223, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 22:59:08'),
(224, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 22:59:42'),
(225, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-19 23:10:36'),
(226, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-19 23:10:38'),
(227, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 23:10:44'),
(228, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 23:31:07'),
(229, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-19 23:31:12'),
(230, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 23:37:27'),
(231, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-19 23:39:15'),
(232, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-19 23:39:18'),
(233, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-20 00:15:08'),
(234, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-20 00:15:12'),
(235, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-20 00:32:50'),
(236, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-20 00:32:52'),
(237, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-20 00:32:55'),
(238, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-20 09:43:17'),
(239, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-20 09:43:22'),
(240, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-20 12:30:30'),
(241, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 03:14:20'),
(242, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-21 03:14:31'),
(243, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-21 03:14:33'),
(244, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 03:34:17'),
(245, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-21 03:34:21'),
(246, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 03:34:30'),
(247, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 07:22:56'),
(248, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-21 07:23:03'),
(249, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-21 07:23:06'),
(250, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-21 07:23:33'),
(251, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-21 07:23:35'),
(252, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-21 07:23:40'),
(253, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-21 07:23:44'),
(254, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 07:23:50'),
(255, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-21 07:33:41'),
(256, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:34:09'),
(257, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 07:37:56'),
(258, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:37:58'),
(259, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 07:38:08'),
(260, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:38:10'),
(261, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 07:38:43'),
(262, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:38:45'),
(263, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 07:40:47'),
(264, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 07:40:49'),
(265, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:40:51'),
(266, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 07:42:30'),
(267, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:42:32'),
(268, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 07:47:42'),
(269, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 07:47:45'),
(270, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 07:47:48'),
(271, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:47:57'),
(272, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 07:48:42'),
(273, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:48:44'),
(274, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-21 07:48:45'),
(275, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:48:47'),
(276, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 07:48:49'),
(277, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:48:51'),
(278, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 07:50:24'),
(279, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 07:50:26'),
(280, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 07:51:21'),
(281, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:53:27'),
(282, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-21 07:54:25'),
(283, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-21 07:54:26'),
(284, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 07:58:44'),
(285, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 07:58:46'),
(286, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 07:59:34'),
(287, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 07:59:36'),
(288, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 07:59:43'),
(289, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:01:22'),
(290, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-21 08:14:39'),
(291, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:14:40'),
(292, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 08:21:22'),
(293, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:21:24'),
(294, 1, 'Navegación', 'Ingresó a la sección: REGISTROSCRUD', '2026-04-21 08:23:04'),
(295, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:23:06'),
(296, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 08:26:07'),
(297, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:26:10'),
(298, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:26:12'),
(299, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:26:29'),
(300, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 08:26:32'),
(301, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:27:02'),
(302, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-21 08:27:06'),
(303, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 08:27:07'),
(304, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:27:11'),
(305, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:27:13'),
(306, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-21 08:27:16'),
(307, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:27:18'),
(308, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:34:26'),
(309, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:36:10'),
(310, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:45:00'),
(311, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:45:04'),
(312, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 08:45:26'),
(313, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:45:29'),
(314, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:45:36'),
(315, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 08:50:09'),
(316, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 08:50:11'),
(317, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-21 08:50:14'),
(318, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:50:30'),
(319, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:50:34'),
(320, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 08:50:35'),
(321, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-21 08:50:38'),
(322, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 08:50:44'),
(323, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 08:50:46'),
(324, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 16:27:28'),
(325, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 16:27:32'),
(326, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 16:37:34'),
(327, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-21 16:45:21'),
(328, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 16:45:48'),
(329, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-21 16:47:52'),
(330, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-21 16:47:54'),
(331, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-21 16:47:59'),
(332, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-21 16:50:36'),
(333, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-21 16:50:49'),
(334, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 16:51:06'),
(335, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-21 16:51:10'),
(336, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-21 16:51:43'),
(337, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 16:52:04'),
(338, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-21 16:52:14'),
(339, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 19:28:34'),
(340, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-21 19:28:40'),
(341, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-21 19:28:43'),
(342, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:28:45'),
(343, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-21 19:28:59'),
(344, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 19:29:04'),
(345, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 19:29:06'),
(346, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:29:08'),
(347, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-21 19:30:47'),
(348, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-21 19:30:58'),
(349, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-21 19:31:00'),
(350, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-21 19:31:03'),
(351, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-21 19:31:05'),
(352, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-21 19:31:07'),
(353, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-21 19:31:08'),
(354, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-21 19:31:10'),
(355, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:32:13'),
(356, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 19:39:25'),
(357, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 19:39:28'),
(358, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:40:04'),
(359, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 19:40:05'),
(360, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:40:11'),
(361, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 19:40:13'),
(362, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:40:56'),
(363, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 19:41:59'),
(364, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-21 19:42:03'),
(365, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-21 19:42:05'),
(366, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 19:42:07'),
(367, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:42:09'),
(368, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 19:42:47'),
(369, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:43:22'),
(370, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 19:44:07'),
(371, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-21 19:44:11'),
(372, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-21 19:44:45'),
(373, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-21 19:44:48'),
(374, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 05:27:18'),
(375, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-22 05:27:22'),
(376, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 05:27:27'),
(377, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 05:27:29'),
(378, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 05:27:31'),
(379, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 05:32:57'),
(380, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 05:33:00'),
(381, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 05:33:02'),
(382, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 05:33:04'),
(383, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-22 05:36:05'),
(384, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 05:36:07'),
(385, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 06:35:18'),
(386, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 06:35:22'),
(387, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 06:36:28'),
(388, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 06:36:34'),
(389, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 06:46:52'),
(390, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 06:46:53'),
(391, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 06:46:57'),
(392, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 07:11:03'),
(393, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-22 07:32:41'),
(394, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-22 07:32:42'),
(395, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-22 07:32:44'),
(396, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-22 07:32:45'),
(397, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-22 07:32:47'),
(398, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 07:32:56'),
(399, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 07:33:03'),
(400, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 16:35:10'),
(401, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 18:02:39'),
(402, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-22 18:02:48'),
(403, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-22 18:02:58'),
(404, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-22 18:03:03'),
(405, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-22 18:03:04'),
(406, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-22 18:03:12'),
(407, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 18:03:15'),
(408, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 18:03:27'),
(409, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-22 18:03:39'),
(410, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-22 18:03:39'),
(411, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 18:04:41'),
(412, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 20:53:09'),
(413, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 20:53:11'),
(414, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 20:53:13'),
(415, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 20:53:18'),
(416, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 20:53:23'),
(417, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 20:53:26'),
(418, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 20:53:28'),
(419, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 20:53:30'),
(420, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 20:53:55'),
(421, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 20:53:56'),
(422, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:03:34'),
(423, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 21:10:51'),
(424, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:10:53'),
(425, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:10:55'),
(426, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:10:57'),
(427, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:11:02'),
(428, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:11:05'),
(429, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:11:07'),
(430, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:11:08'),
(431, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:11:13'),
(432, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:11:16'),
(433, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:11:41'),
(434, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:11:48'),
(435, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:12:13'),
(436, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:12:19'),
(437, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:12:23'),
(438, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:12:25'),
(439, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 21:23:21'),
(440, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:23:24'),
(441, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:23:25'),
(442, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:23:29'),
(443, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:24:02'),
(444, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:24:04'),
(445, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:24:06'),
(446, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:24:09'),
(447, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:24:40'),
(448, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 21:24:42'),
(449, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 21:24:50'),
(450, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 22:42:28'),
(451, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-22 22:42:31'),
(452, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 22:42:32'),
(453, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 22:42:34'),
(454, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 22:42:44'),
(455, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 22:43:20'),
(456, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 22:43:25'),
(457, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 22:44:37'),
(458, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 22:44:45'),
(459, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 22:44:51'),
(460, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 23:01:52'),
(461, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 23:14:12'),
(462, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 23:14:14'),
(463, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-22 23:14:17'),
(464, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 23:14:18'),
(465, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 23:14:21'),
(466, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 23:15:33'),
(467, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 23:15:34'),
(468, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 23:15:37'),
(469, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 23:15:41'),
(470, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 23:16:23'),
(471, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 23:16:27'),
(472, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 23:18:04'),
(473, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 23:18:07'),
(474, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 23:18:09'),
(475, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-22 23:19:26'),
(476, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-22 23:19:30'),
(477, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-22 23:19:32'),
(478, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 05:11:46'),
(479, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-23 05:11:48'),
(480, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:11:49'),
(481, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:11:51'),
(482, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:11:52'),
(483, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:13:32'),
(484, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:13:35'),
(485, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:14:01'),
(486, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:14:02'),
(487, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:14:05'),
(488, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:14:14'),
(489, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:14:17'),
(490, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:14:21'),
(491, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:15:08'),
(492, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:15:09'),
(493, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:15:12'),
(494, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:15:22'),
(495, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 05:49:50'),
(496, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:49:53'),
(497, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:49:55'),
(498, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 05:50:12'),
(499, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 05:50:14'),
(500, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 06:14:34'),
(501, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-23 06:14:38'),
(502, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 06:14:39'),
(503, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 06:14:41'),
(504, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 06:14:56'),
(505, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 06:14:58'),
(506, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 06:15:02'),
(507, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 06:15:03'),
(508, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 06:58:27'),
(509, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-23 06:58:30'),
(510, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 07:02:23'),
(511, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-23 07:02:25'),
(512, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 07:05:07'),
(513, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-23 07:05:08'),
(514, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:05:16'),
(515, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-23 07:05:18'),
(516, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:05:25'),
(517, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:05:33'),
(518, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:14:17'),
(519, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-23 07:14:19'),
(520, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 07:33:05'),
(521, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:33:07'),
(522, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:33:10'),
(523, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:33:27'),
(524, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:33:29'),
(525, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:34:21'),
(526, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:34:26'),
(527, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:34:29'),
(528, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:34:56'),
(529, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:34:58'),
(530, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:35:01'),
(531, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:35:03'),
(532, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:35:48'),
(533, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:36:01'),
(534, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:37:29'),
(535, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-23 07:39:57'),
(536, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:39:59'),
(537, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:40:45'),
(538, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:40:47'),
(539, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:40:52'),
(540, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:41:31'),
(541, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:45:40'),
(542, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:45:42'),
(543, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:46:00'),
(544, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:46:21'),
(545, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:47:00'),
(546, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 07:50:20'),
(547, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-23 07:50:22'),
(548, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-23 07:50:24'),
(549, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-23 07:50:27'),
(550, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:50:30'),
(551, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 07:50:32'),
(552, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-23 07:50:33'),
(553, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 07:50:35'),
(554, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-23 16:10:37'),
(555, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-23 16:11:18'),
(556, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 16:11:20'),
(557, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 16:12:24'),
(558, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-23 16:12:29'),
(559, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-23 16:12:58'),
(560, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-24 04:57:06'),
(561, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-24 04:57:09'),
(562, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-24 04:58:49'),
(563, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-24 04:58:50'),
(564, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-24 04:59:26'),
(565, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-24 04:59:31'),
(566, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-24 04:59:34'),
(567, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-24 04:59:55'),
(568, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-24 04:59:57'),
(569, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-24 04:59:59'),
(570, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-24 05:00:01'),
(571, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-24 05:00:05'),
(572, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-26 22:55:09'),
(573, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-26 22:55:12'),
(574, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 01:29:48'),
(575, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-27 01:29:51'),
(576, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-27 01:29:52'),
(577, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-27 01:29:53'),
(578, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 01:29:54'),
(579, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 01:57:42'),
(580, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 06:53:28'),
(581, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 06:53:30'),
(582, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 06:53:36'),
(583, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 06:53:52'),
(584, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 06:54:34'),
(585, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 06:54:35'),
(586, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 06:54:37'),
(587, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 06:54:43'),
(588, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 06:54:54'),
(589, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 06:55:00'),
(590, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 06:55:45'),
(591, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 06:55:47'),
(592, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 06:55:59'),
(593, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 07:06:32'),
(594, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:06:35'),
(595, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:06:37'),
(596, 1, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-04-27 07:06:47'),
(597, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:09:17'),
(598, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:09:18'),
(599, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:09:23'),
(600, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:09:32'),
(601, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-27 07:10:23'),
(602, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-27 07:10:25'),
(603, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:10:28');
INSERT INTO `bitacora_movimientos` (`id_movimiento`, `id_empleado`, `accion`, `detalle`, `fecha_hora`) VALUES
(604, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:10:29'),
(605, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 07:16:18'),
(606, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:16:20'),
(607, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:17:16'),
(608, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:19:33'),
(609, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 07:27:15'),
(610, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:27:16'),
(611, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:27:26'),
(612, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-27 07:27:29'),
(613, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 07:31:39'),
(614, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:31:40'),
(615, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:32:17'),
(616, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:44:49'),
(617, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-27 07:44:50'),
(618, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:44:52'),
(619, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-27 07:45:22'),
(620, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:45:24'),
(621, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:45:31'),
(622, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:45:33'),
(623, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-27 07:46:14'),
(624, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-27 07:46:16'),
(625, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-28 06:38:11'),
(626, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 06:38:15'),
(627, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 06:38:21'),
(628, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 06:38:24'),
(629, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-28 06:38:28'),
(630, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-28 06:38:30'),
(631, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-28 06:38:31'),
(632, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 06:38:34'),
(633, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-28 06:43:20'),
(634, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-28 06:43:26'),
(635, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-28 06:44:41'),
(636, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-28 06:45:21'),
(637, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-28 06:45:23'),
(638, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 06:45:28'),
(639, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 06:45:33'),
(640, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 06:46:02'),
(641, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 06:46:13'),
(642, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 06:46:15'),
(643, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 06:46:35'),
(644, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-28 06:46:38'),
(645, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 06:46:59'),
(646, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 06:47:02'),
(647, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 06:47:04'),
(648, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 06:47:09'),
(649, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 06:47:10'),
(650, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 06:47:11'),
(651, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 06:47:13'),
(652, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 06:47:14'),
(653, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 06:47:15'),
(654, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 06:47:18'),
(655, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 06:47:19'),
(656, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 06:47:59'),
(657, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 06:48:01'),
(658, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-28 06:48:39'),
(659, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-28 06:50:56'),
(660, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-28 06:51:04'),
(661, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-28 06:51:18'),
(662, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-28 06:51:24'),
(663, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-28 06:51:29'),
(664, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-28 07:03:10'),
(665, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-28 07:03:11'),
(666, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-28 07:06:35'),
(667, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 07:08:45'),
(668, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-28 07:13:30'),
(669, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-28 07:13:31'),
(670, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-28 07:16:37'),
(671, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 07:16:48'),
(672, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-28 16:22:44'),
(673, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-28 16:22:46'),
(674, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-28 16:31:48'),
(675, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-28 16:32:22'),
(676, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-29 02:14:59'),
(677, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-04-29 02:15:02'),
(678, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-04-29 02:15:26'),
(679, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-04-29 02:15:32'),
(680, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-04-29 02:15:46'),
(681, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-29 02:15:50'),
(682, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-29 02:15:53'),
(683, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-04-29 02:16:05'),
(684, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-04-29 02:16:08'),
(685, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-04-29 02:16:11'),
(686, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-04-29 02:16:13'),
(687, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-04-29 02:16:14'),
(688, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-29 02:17:00'),
(689, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-04-29 05:45:08'),
(690, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-01 06:49:59'),
(691, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 04:30:46'),
(692, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 04:30:48'),
(693, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 04:31:28'),
(694, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 04:31:30'),
(695, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 04:33:21'),
(696, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 04:33:23'),
(697, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 07:26:20'),
(698, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-03 07:26:29'),
(699, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-03 07:26:34'),
(700, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 07:26:38'),
(701, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 07:26:40'),
(702, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 07:26:43'),
(703, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-03 07:26:45'),
(704, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-03 07:26:46'),
(705, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-03 07:26:48'),
(706, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-03 07:26:50'),
(707, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-03 07:26:51'),
(708, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 19:23:21'),
(709, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-03 20:33:35'),
(710, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-03 20:33:40'),
(711, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-03 20:33:47'),
(712, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-03 20:33:49'),
(713, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-03 20:33:54'),
(714, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 20:33:59'),
(715, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 20:34:06'),
(716, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 20:34:07'),
(717, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 20:34:41'),
(718, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 20:34:42'),
(719, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 20:35:25'),
(720, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 20:35:27'),
(721, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 20:38:22'),
(722, 3, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-05-03 20:38:43'),
(723, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-03 20:38:46'),
(724, 3, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-05-03 20:38:47'),
(725, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 20:38:58'),
(726, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-03 20:44:24'),
(727, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 20:44:27'),
(728, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 21:19:57'),
(729, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:20:01'),
(730, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 21:20:04'),
(731, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 21:20:12'),
(732, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:23:09'),
(733, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 21:23:10'),
(734, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 21:24:41'),
(735, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 21:24:45'),
(736, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:24:47'),
(737, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 21:24:50'),
(738, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-03 21:27:30'),
(739, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:27:32'),
(740, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-03 21:27:34'),
(741, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-03 21:27:38'),
(742, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:27:42'),
(743, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 21:27:44'),
(744, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:29:28'),
(745, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 21:29:30'),
(746, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:29:35'),
(747, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 21:29:36'),
(748, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 21:32:31'),
(749, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:32:33'),
(750, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-03 21:32:40'),
(751, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-03 21:32:42'),
(752, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 21:32:44'),
(753, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-03 21:33:57'),
(754, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-03 21:33:58'),
(755, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 00:31:23'),
(756, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-04 00:31:25'),
(757, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-04 00:39:07'),
(758, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 06:04:07'),
(759, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-04 06:04:15'),
(760, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 06:13:49'),
(761, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-04 06:13:55'),
(762, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-04 06:13:59'),
(763, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-04 06:14:03'),
(764, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 06:14:20'),
(765, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-04 06:17:26'),
(766, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 06:18:34'),
(767, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 16:44:08'),
(768, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 16:44:09'),
(769, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-04 16:44:11'),
(770, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 16:44:13'),
(771, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 16:44:16'),
(772, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 16:44:19'),
(773, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-04 16:44:20'),
(774, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 16:44:21'),
(775, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 16:44:23'),
(776, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 16:44:25'),
(777, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-04 16:44:26'),
(778, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-04 16:44:27'),
(779, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-04 16:44:29'),
(780, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 16:44:32'),
(781, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 16:45:29'),
(782, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 16:45:32'),
(783, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-04 16:45:37'),
(784, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 16:45:40'),
(785, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 16:45:41'),
(786, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-04 16:45:43'),
(787, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-04 16:45:44'),
(788, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-04 16:45:45'),
(789, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-04 16:46:09'),
(790, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-04 16:46:12'),
(791, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-04 16:46:22'),
(792, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-04 16:46:25'),
(793, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-04 16:46:38'),
(794, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-04 16:47:10'),
(795, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-04 16:53:50'),
(796, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-04 16:54:52'),
(797, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-04 16:54:57'),
(798, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 16:57:39'),
(799, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 16:57:47'),
(800, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-04 16:57:50'),
(801, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-04 16:57:51'),
(802, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-04 16:59:27'),
(803, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 17:00:57'),
(804, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 17:01:18'),
(805, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-04 17:01:54'),
(806, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-04 17:28:26'),
(807, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-04 17:28:28'),
(808, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-04 17:28:30'),
(809, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-05 22:35:42'),
(810, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-05 22:36:04'),
(811, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-05 22:36:07'),
(812, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-05 22:36:20'),
(813, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-05 22:36:42'),
(814, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-05 22:36:50'),
(815, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-05 22:39:55'),
(816, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-05 22:40:00'),
(817, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-05 22:40:04'),
(818, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-05 22:42:51'),
(819, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-05 22:42:54'),
(820, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-05 22:43:03'),
(821, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-05 22:43:08'),
(822, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-05 22:43:11'),
(823, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-05 22:43:18'),
(824, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-05 23:02:48'),
(825, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-05 23:02:56'),
(826, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-05 23:03:00'),
(827, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-05 23:03:11'),
(828, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-05 23:03:35'),
(829, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-05 23:03:47'),
(830, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-05 23:03:59'),
(831, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-05 23:04:01'),
(832, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-05 23:05:25'),
(833, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-05 23:05:32'),
(834, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-05 23:05:34'),
(835, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-05 23:05:59'),
(836, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-05 23:06:04'),
(837, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-05 23:06:06'),
(838, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-05 23:06:22'),
(839, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-05 23:06:27'),
(840, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-05 23:06:29'),
(841, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-06 16:30:47'),
(842, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-06 16:31:12'),
(843, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-06 16:31:14'),
(844, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-06 16:31:16'),
(845, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-06 16:31:22'),
(846, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-06 16:31:24'),
(847, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-06 16:31:27'),
(848, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-06 16:31:32'),
(849, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-06 16:31:34'),
(850, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-06 16:31:40'),
(851, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-06 16:31:44'),
(852, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-06 16:31:47'),
(853, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-06 16:32:06'),
(854, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-06 16:32:17'),
(855, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-06 16:32:19'),
(856, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-06 16:32:33'),
(857, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-06 16:32:42'),
(858, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-06 16:32:50'),
(859, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-06 17:19:09'),
(860, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-06 17:19:13'),
(861, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-06 17:19:14'),
(862, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-06 17:19:33'),
(863, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-06 17:19:38'),
(864, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-06 17:19:50'),
(865, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-06 21:12:04'),
(866, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-06 21:12:07'),
(867, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-06 21:12:21'),
(868, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-06 21:12:26'),
(869, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-06 21:12:32'),
(870, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-06 21:12:35'),
(871, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-06 21:12:37'),
(872, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-06 21:13:23'),
(873, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-06 21:13:25'),
(874, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-06 21:13:32'),
(875, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-06 21:13:35'),
(876, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-06 21:13:37'),
(877, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-06 21:13:46'),
(878, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-06 21:13:47'),
(879, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-06 21:13:48'),
(880, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-06 21:13:50'),
(881, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-06 21:13:54'),
(882, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-06 21:14:00'),
(883, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-06 21:14:01'),
(884, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-06 21:14:03'),
(885, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-06 21:14:05'),
(886, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-06 21:14:07'),
(887, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-06 21:14:12'),
(888, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-06 21:14:14'),
(889, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-06 21:15:41'),
(890, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-06 21:15:52'),
(891, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 05:47:06'),
(892, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-07 05:47:09'),
(893, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-07 06:01:25'),
(894, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-07 06:01:32'),
(895, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-07 06:01:34'),
(896, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 06:01:36'),
(897, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 06:01:40'),
(898, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:01:42'),
(899, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 06:01:46'),
(900, 3, 'Navegación', 'Ingresó a la sección: ACCESO_DENEGADO', '2026-05-07 06:02:06'),
(901, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:04:10'),
(902, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 06:07:41'),
(903, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:07:58'),
(904, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 06:08:04'),
(905, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:09:01'),
(906, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:09:23'),
(907, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 06:11:06'),
(908, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:11:08'),
(909, 11, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 06:11:52'),
(910, 11, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:11:53'),
(911, 11, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-07 06:12:09'),
(912, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 06:12:35'),
(913, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-07 06:12:38'),
(914, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-07 06:12:44'),
(915, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:12:48'),
(916, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-07 06:12:52'),
(917, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:14:00'),
(918, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 06:14:02'),
(919, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:14:03'),
(920, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-07 06:14:05'),
(921, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 06:14:31'),
(922, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-07 06:16:11'),
(923, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-07 06:16:14'),
(924, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-07 06:16:15'),
(925, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-07 06:16:17'),
(926, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 06:16:18'),
(927, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 06:17:22'),
(928, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:17:23'),
(929, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:17:24'),
(930, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-07 06:17:26'),
(931, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:23:16'),
(932, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:23:19'),
(933, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 06:23:28'),
(934, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:23:30'),
(935, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 06:24:49'),
(936, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:24:51'),
(937, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 06:25:16'),
(938, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-07 06:25:17'),
(939, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:25:19'),
(940, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 06:28:57'),
(941, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:28:59'),
(942, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 06:29:05'),
(943, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-07 06:29:07'),
(944, 3, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-07 06:29:08'),
(945, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-07 06:29:10'),
(946, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-07 06:29:11'),
(947, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 06:29:25'),
(948, 3, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-07 06:29:28'),
(949, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 06:29:37'),
(950, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 06:29:39'),
(951, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:29:40'),
(952, 3, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 06:29:42'),
(953, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-07 06:29:43'),
(954, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 06:29:44'),
(955, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 06:29:46'),
(956, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 16:14:45'),
(957, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-07 16:14:49'),
(958, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-07 16:14:51'),
(959, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-07 16:14:54'),
(960, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-07 16:14:55'),
(961, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 16:14:57'),
(962, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 16:14:58'),
(963, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 16:14:59'),
(964, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 16:15:54'),
(965, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 16:15:56'),
(966, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 16:15:59'),
(967, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 16:16:06'),
(968, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 16:16:21'),
(969, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 16:16:32'),
(970, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 16:16:34'),
(971, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 16:16:41'),
(972, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 16:18:41'),
(973, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 16:19:32'),
(974, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 18:50:38'),
(975, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 18:50:40'),
(976, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 18:50:42'),
(977, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 18:51:42'),
(978, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 18:51:48'),
(979, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 18:51:50'),
(980, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 18:52:43'),
(981, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 18:52:45'),
(982, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 18:52:46'),
(983, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 18:57:21'),
(984, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 18:57:25'),
(985, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-07 19:01:58'),
(986, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 19:01:59'),
(987, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 19:03:14'),
(988, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 19:03:16'),
(989, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 21:29:21'),
(990, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 21:29:28'),
(991, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 21:29:30'),
(992, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 21:29:32'),
(993, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 21:36:11'),
(994, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 21:36:26'),
(995, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 21:37:58'),
(996, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 21:37:59'),
(997, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 21:38:01'),
(998, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 21:39:07'),
(999, 3, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-07 15:47:32'),
(1000, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 15:47:34'),
(1001, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 15:48:44'),
(1002, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 15:49:05'),
(1003, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 15:49:08'),
(1004, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 17:14:40'),
(1005, 1, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-07 17:14:54'),
(1006, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-07 17:14:58'),
(1007, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-07 17:15:06'),
(1008, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-07 17:15:11'),
(1009, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-07 17:15:19'),
(1010, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-07 17:15:26'),
(1011, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 17:15:42'),
(1012, 1, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-07 17:15:50'),
(1013, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-07 17:16:05'),
(1014, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-07 17:16:23'),
(1015, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-07 17:16:36'),
(1016, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-08 00:24:44'),
(1017, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-08 00:24:46'),
(1018, 3, 'Navegación', 'Ingresó a la sección: ESTADISTICAS', '2026-05-08 00:28:48'),
(1019, 3, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-08 00:29:05'),
(1020, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-08 00:29:06'),
(1021, 3, 'Navegación', 'Ingresó a la sección: CONTENEDOR', '2026-05-08 00:30:37'),
(1022, 3, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-08 10:13:25'),
(1023, 3, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-08 10:13:27'),
(1024, 3, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-08 10:13:28'),
(1025, 1, 'Navegación', 'Ingresó a la sección: DASHBOARD', '2026-05-08 14:23:53'),
(1026, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-08 14:45:53'),
(1027, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-08 14:45:54'),
(1028, 1, 'Navegación', 'Ingresó a la sección: EMPLEADO', '2026-05-08 14:46:05'),
(1029, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-08 14:46:06'),
(1030, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-08 14:46:07'),
(1031, 1, 'Navegación', 'Ingresó a la sección: SERVICIOS', '2026-05-08 14:46:08'),
(1032, 1, 'Navegación', 'Ingresó a la sección: INICIO', '2026-05-08 14:46:26'),
(1033, 1, 'Navegación', 'Ingresó a la sección: CONTACTO', '2026-05-08 14:46:27'),
(1034, 1, 'Navegación', 'Ingresó a la sección: CITAS', '2026-05-08 14:46:37'),
(1035, 1, 'Navegación', 'Ingresó a la sección: INGRESO', '2026-05-08 14:46:38'),
(1036, 1, 'Navegación', 'Ingresó a la sección: REGISTROS_INGRESADOS_CRUD_VIEW', '2026-05-08 14:46:39');

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
  `id_google_calendar` varchar(255) DEFAULT NULL,
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
  `detalle_falla` text DEFAULT NULL,
  `fecha_cita` date NOT NULL,
  `hora_cita` time NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','atendida','cancelada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `telefono`, `correo`) VALUES
(1, 'JOSE EDUARDO', 'FLORES FRAUSTO', '3331342222', 'yoxej19641@badgerhole.com');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `condiciones_servicio`
--

INSERT INTO `condiciones_servicio` (`id_condicion`, `folio_orden`, `autoriza_revision_costo`, `tiempo_estimado`, `recordatorio_anticipo`, `dudas_cliente`) VALUES
(1, '07052026-1', 'si', '3', 'si', 'sn'),
(2, '07052026-A', 'si', '1', 'si', 'cz'),
(3, '07052026-B', 'si', '11', 'si', 'nada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directorio_socios`
--

CREATE TABLE `directorio_socios` (
  `id_socio` int(11) NOT NULL,
  `nombre_empresa` varchar(150) NOT NULL,
  `tipo_asociacion` enum('convenio','proveedor','marca','partner') NOT NULL,
  `numero_convenio` varchar(50) DEFAULT NULL,
  `nombre_contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `id_puesto` int(11) NOT NULL,
  `secreto_2fa` varchar(32) DEFAULT NULL,
  `is_2fa_activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `telefono`, `correo`, `nombre_usuario`, `contrasena`, `id_puesto`, `secreto_2fa`, `is_2fa_activo`) VALUES
(1, 'Ferdan', 'Garrillo', '3222362505', 'ferdan.garrigos@astechcomputer.com', 'Ferdan-01', 'admin', 4, '47W4KT2QCN4HVXFQNNO5QAVL4PZQLEC5', 1),
(2, 'Lino', 'Gonzales', '3221234560', 'lino@astech.com', 'lino-02', '$2y$10$jERP0zRXP5Gllg4aBo7iWeMdrTCiZsFzl4tgSDOnsS9425eHM/GgS', 1, NULL, 0),
(3, 'Eduardo', 'Flores', '3221014500', 'floresfraustoj4@gmail.com', 'Jose-01', '$2y$10$YsOcVQYvy0.ElSCUTxTrW.Lp98wNnOS4KmYiTW5uoTAWZAFBeXmLq', 4, 'OCDTJZODLRH2B2PTKHQFOQVM7QMGL72Y', 1),
(4, 'Brithany', 'Herrera', '3227790871', 'brithanymil@gmail.com', 'Brit', '12345', 4, 'OGIADOJCKZC45HO7J6RA7S66ED77PMCV', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `id_cliente`, `id_marca`, `id_tipo_equipo`, `marca_otro`, `tipo_equipo_otro`, `modelo`, `numero_serie`) VALUES
(1, 1, 10, 5, NULL, NULL, 'switch', 'sn'),
(2, 1, 9, 5, NULL, NULL, 'zxc', 'sn'),
(3, 1, 9, 5, NULL, NULL, 'xbox', 'sn');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencias_servicio`
--

CREATE TABLE `frecuencias_servicio` (
  `id_frecuencia` int(11) NOT NULL,
  `frecuencia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `gabinetes`
--

INSERT INTO `gabinetes` (`id_gabinete`, `tipo_espacio`, `estado`) VALUES
('1', 'laptop', 'disponible'),
('10', 'laptop', 'disponible'),
('11', 'laptop', 'disponible'),
('12', 'laptop', 'disponible'),
('13', 'laptop', 'disponible'),
('14', 'laptop', 'disponible'),
('2', 'laptop', 'disponible'),
('3', 'laptop', 'disponible'),
('4', 'laptop', 'disponible'),
('5', 'laptop', 'disponible'),
('6', 'laptop', 'disponible'),
('7', 'laptop', 'disponible'),
('8', 'laptop', 'disponible'),
('9', 'laptop', 'disponible'),
('A', 'computadora_escritorio', 'ocupado'),
('B', 'computadora_escritorio', 'ocupado'),
('C', 'computadora_escritorio', 'disponible'),
('D', 'computadora_escritorio', 'disponible'),
('E', 'computadora_escritorio', 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_index`
--

CREATE TABLE `informacion_index` (
  `id` int(11) NOT NULL,
  `quienes_somos` text NOT NULL,
  `mision` text NOT NULL,
  `vision` text NOT NULL,
  `frase_fundador` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `informacion_index`
--

INSERT INTO `informacion_index` (`id`, `quienes_somos`, `mision`, `vision`, `frase_fundador`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Somos AsTech Computer, una empresa especializada en soluciones tecnológicas (B2C, B2B Y B2B2C) enfocada en la reparación, mantenimiento y optimización de equipos de cómputo. Trabajamos bajo procesos y manuales operativos estandar que garantizan calidad en cada servicio, con responsabilidad, precisión y un compromiso constante con la mejora continua donde nuestros valores se reflejan en cada acción.', '\"Brindamos una experiencia integral a nuestros clientes con servicios de reparación, mantenimiento, asesoría computacional y soporte a MiPymes de la región, garantizando la privacidad de datos y ofreciendo garantía en todos nuestros servicios, con principios de transparencia, honestidad y respeto para cumplir las expectativas y brindar soluciones confiables y vanguardistas.\"', '\"En AsTech Computer soñamos con un 2030 donde seamos la empresa de servicios tecnológicos de referencia en Puerto Vallarta, reconocida por nuestra excelencia, compromiso, innovación y la confianza que nos brinda nuestra comunidad. Creceremos junto a nuestros clientes y aliados estratégicos, compartiendo una misma visión de futuro: desarrollar talento local, promover la tecnología responsable y generar un impacto positivo en nuestro entorno\"', '“Reparar es fácil, hacerlo bien es lo que nos define; porque detrás de cada servicio hay un proceso, y detrás de cada proceso, un compromiso con la confianza de nuestros clientes.\"', '0000-00-00 00:00:00', '2026-05-04 17:40:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `marca`) VALUES
(1, 'Lenovo'),
(2, 'HP'),
(3, 'Dell'),
(4, ' Huawei'),
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `marketing`
--

INSERT INTO `marketing` (`id_encuesta`, `folio_orden`, `id_medio_contacto`, `medio_contacto_otro`, `recibir_promociones`, `id_tipo_uso`, `tipo_uso_otro`, `es_primera_vez`, `id_frecuencia_servicio`, `frecuencia_servicio_otro`) VALUES
(1, '07052026-1', 3, NULL, 'si por whatsapp', 1, NULL, 'si', 1, NULL),
(2, '07052026-A', 4, 'cucosta', 'si por whatsapp', 3, NULL, 'si', 3, NULL),
(3, '07052026-B', 4, 'cartel', 'ambos', 3, NULL, 'si', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medios_contacto`
--

CREATE TABLE `medios_contacto` (
  `id_medio` int(11) NOT NULL,
  `medio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

--
-- Volcado de datos para la tabla `mensajes_contacto`
--

INSERT INTO `mensajes_contacto` (`id_mensaje`, `nombre`, `correo`, `asunto`, `mensaje`, `fecha_envio`, `estado`) VALUES
(1, 'Allen Bell', 'allen.bell3456@gmail.com', 'Hi,\r\n\r\nI recently came across your website and noticed a few areas where improvements could significantly enhance your visibility on Google.\r\n\r\nWith a', 'Hi,\r\n\r\nI recently came across your website and noticed a few areas where improvements could significantly enhance your visibility on Google.\r\n\r\nWith a well-planned SEO strategy, you can attract more relevant traffic, improve your search rankings, and generate higher-quality inquiries for your business.\r\n\r\nI’d be glad to share insights on how we can strengthen your online presence, along with details of my SEO services and pricing.\r\n\r\nLet me know a convenient time to connect.\r\n\r\nRegards,\r\n\r\nAllen', '2026-04-22 12:24:21', 'nuevo'),
(2, 'Theresa Caskey', 'domains@search-astechcomputer.com', 'Hi\r\n\r\nAdd astechcomputer.com in GoogleSearchIndex to appear in google search results!\r\n\r\nEnlist astechcomputer.com now: https://searchregister.org', 'Hey\r\n\r\nEnlist astechcomputer.com in GoogleSearchIndex so it can be visible in web search results!\r\n\r\nInsert astechcomputer.com now: https://searchregister.org', '2026-05-02 08:26:20', 'nuevo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id_metodo` int(11) NOT NULL,
  `nombre_metodo` varchar(100) NOT NULL,
  `detalles` text DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `fecha_listo` datetime DEFAULT NULL,
  `condicion_fisica` varchar(255) NOT NULL,
  `accesorios_entregados` varchar(255) NOT NULL,
  `descripcion_problema` text NOT NULL,
  `observaciones_recepcion` text NOT NULL,
  `estado` enum('recibido','listo','entregado') DEFAULT 'recibido',
  `fecha_entrega` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `ordenes_ingreso`
--

INSERT INTO `ordenes_ingreso` (`folio`, `id_equipo`, `id_tecnico`, `id_gabinete`, `fecha_ingreso`, `fecha_listo`, `condicion_fisica`, `accesorios_entregados`, `descripcion_problema`, `observaciones_recepcion`, `estado`, `fecha_entrega`) VALUES
('07052026-1', 1, 2, '1', '2026-05-07 00:00:00', '2026-05-07 21:37:07', 'rayones', 'cargador', 'ninguno', 'as', 'entregado', '2026-05-07 21:37:26'),
('07052026-A', 2, 2, 'A', '2026-05-07 00:00:00', '2026-04-29 15:39:13', 'desarmado', 'cargador', 'ningu', 'sa', 'listo', NULL),
('07052026-B', 3, 2, 'B', '2026-05-07 00:00:00', NULL, 'desarmado', 'cargador', 'ninguno', 'aa', 'recibido', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id_puesto` int(11) NOT NULL,
  `nombre_puesto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`id_puesto`, `nombre_puesto`) VALUES
(1, 'Técnico'),
(2, 'Atencion al Cliente'),
(3, 'Gerente'),
(4, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion_equipo_marca`
--

CREATE TABLE `relacion_equipo_marca` (
  `id_marca` int(11) NOT NULL,
  `id_tipo_equipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `codigo_servicio` varchar(30) DEFAULT NULL,
  `id_tipo_servicio` int(11) DEFAULT NULL,
  `tipo_servicio` varchar(100) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `procedimiento` text NOT NULL,
  `beneficios` text NOT NULL,
  `indicaciones` text NOT NULL,
  `exclusiones` text NOT NULL,
  `tiempo_estimado` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `imagen_servicio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `codigo_servicio`, `id_tipo_servicio`, `tipo_servicio`, `descripcion`, `procedimiento`, `beneficios`, `indicaciones`, `exclusiones`, `tiempo_estimado`, `precio`, `estado`, `imagen_servicio`) VALUES
(1, 'MLA-002', 1, 'Mantenimiento preventivo para equipos portátiles de alto rendimiento', 'Mantén tu laptop gamer y de trabajo en optima condición. El mantenimiento preventivo es clave para prolongar la vida útil de tu equipo, prevenir problemas de sobrecalentamiento, y asegurar que siempre funcione al máximo nivel con insumos de alto rendimiento de la marca THERMAL GRIZZLY.', 'Durante el servicio se realiza:\r\n\r\n∆ Revisión de los componentes electrónicos y sus conexiones. \r\n\r\n∆ Usamos herramientas y productos especializados para limpiar a fondo los componentes eléctricos y electrónicos. \r\n\r\n∆ Limpiamos a profundidad los ventiladores y el disipador para optimizar el flujo de aire y evitar que la temperatura afecte el rendimiento.\r\n\r\n∆ Reemplazamos la pasta térmica del procesador (CPU) y del procesador de gráficos (GPU) con una de alta calidad. Esto mejora drásticamente la disipación del calor.\r\n\r\n∆ Sustituimos los pads termicos de chipset, reguladores de voltaje (VRM) y memorias de video (Vram) para una transferencia de calor óptima.\r\n\r\nTu laptop lucirá impecable, libre de polvo y suciedad. ', '\r\nBeneficios de traer tu equipo con nosotros \r\n\r\n✓ Ahorro de tiempo y esfuerzo al contar con atención profesional.\r\n✓ Uso de herramientas y repuestos de alta calidad.\r\n✓ Seguimiento puntual del estado de tu servicio.\r\n✓ Garantía en todos nuestros servicios respaldada por procedimientos estandarizados y apoyo con manuales de servicio', 'Respaldo de información: Aunque el proceso es físico, siempre recomendamos tener una copia de seguridad de tus archivos importantes.', '*Importante* \r\nEste precio no incluye refacciones \r\n', '1 día hábil', 1450.00, 'activo', 'Miniaturas_500px_Preventivo_Portatil_AR.png'),
(2, 'MLO-001', 1, 'Mantenimiento preventivo para equipos portátiles de oficina', 'Mantén tu laptop en optima condición. Nuestro servicio de mantenimiento preventivo completo ayuda a prevenir problemas de sobrecalentamiento, y asegurar que siempre funcione al máximo nivel sin interrupciones.', '∆ Desensamble parcial del equipo.\n∆ Limpieza interna con aire comprimido y brochas antiestáticas.\n∆ Limpieza de ventiladores y disipadores.\n∆ Revisión de puertos, teclado y batería.\n∆ Aplicación de pasta térmica si es necesario.', '✓ Mejora el rendimiento general.\n✓ Previene sobrecalentamiento.\n✓ Prolonga la vida útil del equipo.\n✓ Reduce fallas inesperadas.', 'Se recomienda respaldar la información antes del servicio.', 'No incluye refacciones ni reparación de componentes dañados.', '1 día hábil', 690.00, 'activo', 'Miniaturas_500px_Preventivo_Portatil_Ofi.png'),
(3, 'MG-003', 1, 'Mantenimiento preventivo para gabinetes mid tower', 'Tu PC merece un cuidado completo. Este servicio esta diseñado para prevenir problemas, mejorar el rendimiento y prolongar la vida útil de tu equipo.', '∆ Limpieza interna completa del gabinete.\n∆ Limpieza de ventiladores, fuente de poder y disipadores.\n∆ Organización de cableado.\n∆ Revisión de temperaturas.', '✓ Mejor flujo de aire.\n✓ Menor temperatura de operación.\n✓ Mayor estabilidad del sistema.', 'Apagar correctamente el equipo antes del servicio.', 'No incluye cambio de piezas dañadas.', '1 día hábil', 920.00, 'activo', 'Miniaturas_500px_Preventivo_Mid.png'),
(4, 'MG-001', 1, 'Mantenimiento preventivo para gabinetes de oficina', 'Tu PC de oficina merece un cuidado completo. Este servicio está diseñado para prevenir problemas, mejorar el rendimiento y prolongar la vida útil de tu equipo. Realizamos una limpieza profunda y optimizamos el flujo de aire para asegurar que tu gabinete funcione al 100%.', '∆ Limpieza básica interna.\n∆ Eliminación de polvo en componentes.\n∆ Revisión de conexiones.\n∆ Verificación de funcionamiento general.', '✓ Previene fallas comunes.\n✓ Mejora el desempeño básico.', 'Equipo debe entregarse con cables y accesorios.', 'No incluye mantenimiento profundo ni refacciones.', '1 día hábil', 680.00, 'activo', 'Miniaturas_500px_Diagnostico_Gab_Ofi.png'),
(5, 'MG-002', 1, 'Mantenimiento preventivo para gabinetes full tower', 'Tu PC merece un cuidado completo. Este servicio está diseñado para prevenir problemas, mejorar el rendimiento y prolongar la vida útil de tu equipo. Realizamos una limpieza profunda y optimizamos el flujo de aire para asegurar que tu gabinete funcione al 100% y que tus componentes se mantengan a la temperatura ideal.', '∆ Limpieza profunda de gabinete full tower.\n∆ Mantenimiento de múltiples ventiladores.\n∆ Revisión de GPU, CPU y fuente.\n∆ Ordenamiento de cableado.', '✓ Optimiza equipos de alto consumo.\n✓ Reduce temperaturas críticas.', 'Respaldar información importante.', 'No incluye upgrades de hardware.', '1 día hábil', 1490.00, 'activo', 'Miniaturas_500px_Preventivo_FullTower.png'),
(6, 'MLA-001', 1, 'Mantenimiento preventivo de alto rendimiento para equipos portátiles con metal liquido', 'Mantén tu laptop de alto rendimiento en óptimas condiciones. El mantenimiento preventivo es clave para prolongar la vida útil de tu equipo, prevenir problemas de sobrecalentamiento, y asegurar que siempre funcione al máximo nivel.', '∆ Limpieza especializada de alto rendimiento.\n∆ Aplicación de metal líquido en CPU/GPU.\n∆ Sustitución de pads térmicos.\n∆ Pruebas de temperatura.', '✓ Máxima disipación de calor.\n✓ Mejor rendimiento en gaming y diseño.', 'Equipo debe ser compatible con metal líquido.', 'No aplica para equipos de oficina estándar.', '1 día hábil', 2180.00, 'activo', 'Miniaturas_500px_Metal_Liquido_.png'),
(7, 'RRLA-004', 2, 'Reparación de sistema de bisagras (Laptops de alto rendimiento)', 'Las bisagras de tu laptop, con el uso constante, suelen aflojarse o romperse, dañando los anclajes internos, la carcasa y poniendo en riesgo la pantalla. Nuestro servicio busca devolverle estabilidad al equipo y prevenir que el daño avance. ', '∆ Desensamble de pantalla.\n∆ Reparación o reemplazo de bisagras.\n∆ Ajuste estructural.\n∆ Reensamble completo.', '✓ Evita daño en pantalla.\n✓ Mejora apertura y cierre.', 'No forzar el equipo antes de reparación.', 'No incluye cambio de carcasa.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 570.00, 'activo', 'Miniaturas_500px_Reparacion_Bisagras_AR.png'),
(8, 'RRT-003', 2, 'Reemplazo de unidad de almacenamiento', 'Realizamos el reemplazo seguro de discos duros (HDD) o unidades de estado sólido (SSD) para mejorar la capacidad y velocidad de tu equipo', '∆ Instalación de HDD o SSD.\n∆ Configuración en BIOS.\n∆ Formateo si aplica.\n∆ Pruebas de funcionamiento.', '✓ Mayor almacenamiento.\n✓ Mejora de velocidad (SSD).', 'Elegir capacidad adecuada.', 'No incluye sistema operativo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 450.00, 'activo', 'Miniaturas_500px_Reemplazo_Almacenamiento.png'),
(9, 'RRL-002', 2, 'Reemplazo de teclado para portátiles de oficina', 'Los teclados pueden presentar fallas en las teclas, pérdida de sensibilidad o desgaste estético. Nuestro servicio de reemplazo devuelve la funcionalidad', '∆ Desensamble de teclado.\n∆ Instalación de nuevo teclado.\n∆ Pruebas de funcionamiento.', '✓ Recupera funcionalidad del equipo.', 'Confirmar compatibilidad del modelo.', 'No incluye daños en tarjeta madre.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 890.00, 'activo', 'Miniaturas_500px_Reemplazo_Teclado.png'),
(10, 'RRT-004', 2, 'Reemplazo de ventiladores', 'Con el tiempo y uso, los ventiladores de enfriamiento pueden desgastarse o llenarse de polvo hasta terminar de averiarse o fallar lo que reduce la circulación de aire y provoca sobrecalentamiento.', '∆ Retiro de ventiladores dañados.\n∆ Instalación de nuevos ventiladores.\n∆ Pruebas de flujo de aire.', '✓ Reduce sobrecalentamiento.', 'Seleccionar ventiladores compatibles.', 'No incluye mantenimiento adicional.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 260.00, 'activo', 'Miniaturas_500px_Reemplazo_Ventiladores.png'),
(11, 'RRT-001', 2, 'Reemplazo de Memoria RAM DDR2/3/4', 'La memoria RAM puede quedarse corta o presentar fallas que vuelven lento el equipo. Nuestro servicio de reemplazo o ampliación mejora el rendimiento y la capacidad de respuesta de tu computadora.', '∆ Instalación de módulos RAM.\n∆ Configuración automática.\n∆ Pruebas de estabilidad.', '✓ Mejora el rendimiento multitarea.', 'Verificar compatibilidad.', 'No incluye actualización de BIOS.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 330.00, 'activo', 'Miniaturas_500px_ReemplazoRAM2-3-4.png'),
(12, 'IST-003', 3, 'Instalación de Microsoft Office 2016 con clave de producto original', '¿Necesitas activar, instalar o reinstalar Microsoft Office 2016 en tu equipo? Nosotros nos encargamos del proceso, asegurando que tu suite de productividad quede perfectamente configurada y lista para usar.? Este servicio es ideal para garantizar un funcionamiento óptimo y evitar problemas de compatibilidad.', '∆ Instalación de Office.\n∆ Activación con clave original.\n∆ Configuración inicial.', '✓ Software legal y funcional.', 'Requiere conexión a internet.', 'No incluye capacitación.', '1 día hábil', 699.00, 'activo', 'Miniaturas_500px_Office_2016.png'),
(13, 'IST-001', 3, 'Clave de producto Windows 10 Professional', 'Obtén tu clave de producto original de Windows 10 para activar tu sistema operativo de forma legal y permanente.Una clave original es tu garantía para recibir todas las actualizaciones de seguridad y acceder a las funcionalidades completas que ofrece Microsoft.', '∆ Activación de Windows.\n∆ Configuración del sistema.', '✓ Sistema operativo original.', 'Requiere versión compatible.', 'No incluye instalación.', '1 día hábil', 499.00, 'activo', 'Miniaturas_500px_Windows_10.png'),
(14, 'IST-004', 3, 'Instalación de Microsoft Office 2019 con clave de producto', '¿Necesitas activar, instalar o reinstalar Microsoft Office 2019 en tu equipo? Nosotros nos encargamos del proceso, asegurando que tu suite de productividad quede perfectamente configurada y lista para usar.? Este servicio es ideal para garantizar un funcionamiento óptimo y evitar problemas de compatibilidad.', '∆ Instalación de Office 2019.\n∆ Activación.\n∆ Configuración.', '✓ Acceso a herramientas profesionales.', 'Internet requerido.', 'No incluye soporte extendido.', '1 día hábil', 930.00, 'activo', 'Miniaturas_500px_Office_2019.png'),
(15, 'IST-002', 3, 'Clave de producto Windows 11 Professional', 'Obtén tu clave de producto original de Windows 11 para activar tu sistema operativo de forma legal y permanente.🫱🏽‍🫲🏼 Una clave original es tu garantía para recibir todas las actualizaciones de seguridad y acceder a las funcionalidades completas que ofrece Microsoft.', '∆ Activación de Windows 11.\n∆ Configuración inicial.', '✓ Sistema actualizado.', 'Equipo compatible.', 'No incluye instalación.', '1 día hábil', 699.00, 'activo', 'Miniaturas_500px_Windows_11.png'),
(16, 'IST-009', 3, 'Reinstalación de sistema operativo con respaldo de información', 'Realizamos la instalación del sistema operativo de tu computadora, asegurando que tus archivos importantes se respalden y se restauren correctamente.', '∆ Respaldo de información.\n∆ Formateo.\n∆ Instalación de sistema.\n∆ Restauración de datos.', '✓ Sistema limpio.\n✓ Recuperación de archivos.', 'Tiempo depende del respaldo.', 'No incluye software adicional.', '1 día hábil', 520.00, 'activo', 'Miniaturas_500px_Reinstalacion_de_sistema.png'),
(17, 'TL-001', 4, 'Servicio de recolección y entrega a domicilio (1 traslado)', 'Ofrecemos un servicio seguro y rápido para recoger y entregar tu equipo portátil (Laptop) directamente en tu domicilio o negocio mediante transporte en motocicleta.', '∆ Recolección del equipo.\n∆ Traslado seguro.\n∆ Entrega posterior.', '✓ Comodidad para el cliente.', 'Confirmar dirección.', 'No incluye servicio técnico.', '1 día hábil', 75.00, 'activo', 'Miniaturas_500px_Recoleccion_Motocicleta.png'),
(18, 'TG-001', 4, 'Servicio de recolección y entrega a domicilio Automovil (1 traslado)', 'Ofrecemos un servicio seguro y confiable para recoger y entregar tu equipo de cómputo directamente en tu domicilio o negocio mediante transporte en automóvil, ideal para uno o varios equipos de mayor tamaño o volumen. ', '∆ Recolección en automóvil.\n∆ Transporte seguro.\n∆ Entrega.', '✓ Mayor cobertura.', 'Coordinar horario.', 'No incluye diagnóstico.', '1 día hábil', 150.00, 'activo', 'Miniaturas_500px_Recoleccion_Automovil.png'),
(19, 'AT-001', 5, 'Servicio de asistencia remota', '¿Tienes un problema de software y necesitas una solución rápida sin salir de casa? 🏠 Nuestro servicio de asistencia remota te conecta con un técnico experto que puede resolver fallas comunes de forma segura y eficiente a través de internet.', '∆ Conexión remota.\n∆ Diagnóstico.\n∆ Solución de software.', '✓ Atención inmediata.', 'Requiere internet.', 'No aplica para fallas físicas.', '1 día hábil', 460.00, 'activo', 'Miniaturas_500px_Asistencia_Remota.png'),
(20, 'SET-001', 5, 'Servicio de recuperación de información con software especializado', 'Cuando tu información corre riesgo por fallas en la unidad de almacenamiento, realizamos la recuperación de datos de HDD, SSD, USB o tarjetas de memoria, utilizando herramientas y software profesional para proteger y rescatar tu información importante.', '∆ Escaneo con software especializado.\n∆ Recuperación de archivos.\n∆ Validación.', '✓ Recupera información perdida.', 'Evitar usar el equipo.', 'No garantiza recuperación total.', '1 día hábil', 750.00, 'activo', 'Miniaturas_500px_Recuperacion_De_Info.png'),
(21, 'DLG-001', 5, 'Diagnóstico básico de  equipo de computo', '¿Tu equipo no enciende, está lento o presenta un problema general y no sabes por qué? Nuestro diagnóstico básico es el primer paso para identificar la causa de la falla. Realizamos una revisión completa para determinar si el origen del problema es de software, de hardware o dar seguimiento a un problema para así poder ofrecerte la solución adecuada.🛠️\r\n', '∆ Revisión general.\n∆ Pruebas básicas.\n∆ Informe técnico.', '✓ Identificación de fallas.', 'Describir el problema.', 'No incluye reparación.', '1 día hábil', 560.00, 'activo', 'Miniaturas_500px_Diagnostico_Basico.png'),
(22, 'RRG-005', 2, 'Reemplazo de tarjeta gráfica', 'Con el tiempo, las tarjetas gráficas pueden fallar o quedarse cortas frente a las nuevas exigencias de rendimiento. Nuestro servicio de reemplazo permite restaurar el funcionamiento de tu computadora o actualizarla con un modelo más potente.', '∆ Retiro de GPU.\n∆ Instalación de nueva tarjeta.\n∆ Configuración y pruebas.', '✓ Mejora gráfica.', 'Fuente compatible requerida.', 'No incluye drivers avanzados.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 450.00, 'activo', 'Miniaturas_500px_Reemplazo_Tarjeta_Grafica.png'),
(23, 'AG-001', 5, 'Asesoría de ensamble de equipo de computo', 'Recibe orientación profesional para el ensamble de tu equipo de cómputo según tus necesidades, ya sea para gaming, trabajo o uso general. Te ayudamos a elegir componentes compatibles y de alto rendimiento para asegurar un funcionamiento óptimo desde el inicio.', 'Durante el servicio se realiza:\r\n\r\n∆ Análisis de tus necesidades (gaming, diseño, oficina, etc.).\r\n\r\n∆ Recomendación de componentes compatibles (CPU, tarjeta madre, RAM, almacenamiento, GPU, fuente de poder, gabinete).\r\n\r\n∆ Asesoría sobre balance entre rendimiento y presupuesto.\r\n\r\n∆ Guía paso a paso para el ensamble correcto del equipo.\r\n\r\n∆ Recomendaciones de configuración inicial y buenas prácticas.\r\n\r\n∆ Resolución de dudas durante el proceso de armado.', 'Beneficios de recibir asesoría con nosotros:\r\n\r\n✓ Evita errores de compatibilidad entre componentes.\r\n✓ Ahorro de dinero al elegir correctamente desde el inicio.\r\n✓ Optimización del rendimiento según el uso que le darás.\r\n✓ Acompañamiento profesional durante el proceso.\r\n✓ Mayor seguridad al ensamblar tu equipo.', 'Se recomienda contar con un presupuesto estimado y una idea del uso principal del equipo (gaming, edición, oficina, etc.). En caso de ya tener componentes, proporcionar la lista para validar compatibilidad.', '*Importante*\r\nEste servicio es únicamente de asesoría.\r\nNo incluye ensamble físico del equipo ni instalación de componentes.\r\nNo incluye refacciones o piezas.', '1 día hábil', 0.00, 'activo', 'Miniaturas_500px_Asesoria_de_Ensamble.png'),
(24, 'SEL-001', 5, 'Diagnóstico Especializado de equipo de computo', 'Identificamos fallas en tu equipo de cómputo mediante un diagnóstico especializado, detectando problemas de hardware y software que afectan su rendimiento o funcionamiento. Ideal para equipos que presentan errores, lentitud o fallas inesperadas.', 'Durante el servicio se realiza:\r\n\r\n∆ Inspección general del equipo y sus componentes.\r\n\r\n∆ Pruebas de encendido, estabilidad y rendimiento.\r\n\r\n∆ Diagnóstico de fallas en hardware (RAM, disco duro, fuente de poder, etc.).\r\n\r\n∆ Revisión del sistema operativo y posibles errores de software.\r\n\r\n∆ Detección de sobrecalentamiento o problemas térmicos.\r\n\r\n∆ Entrega de reporte con resultados y recomendaciones de solución.', 'Beneficios de realizar un diagnóstico con nosotros:\r\n\r\n✓ Identificación precisa de fallas.\r\n✓ Ahorro de dinero al evitar reparaciones innecesarias.\r\n✓ Recomendaciones claras y profesionales.\r\n✓ Mayor vida útil del equipo al detectar problemas a tiempo.\r\n✓ Atención técnica especializada.', 'Se recomienda entregar el equipo con sus accesorios principales (cargador, cables, etc.). En caso de presentar fallas específicas, describir el problema con el mayor detalle posible.', '*Importante*\r\nEste servicio no incluye reparación ni refacciones.\r\nEl costo del diagnóstico no es reembolsable.\r\nCualquier reparación o cambio de piezas se cotiza por separado.', '1 día hábil', 800.00, 'activo', 'Miniaturas_500px_Diag_PlacaBase.png'),
(25, 'SEL-002', 2, 'Reparación a nivel componente de placa base para equipos de computo', 'Servicio especializado en la reparación de fallas a nivel componente en la placa base de equipos de cómputo. Se trabaja directamente sobre los circuitos electrónicos para restaurar el funcionamiento del equipo sin necesidad de reemplazar toda la tarjeta madre.', 'Durante el servicio se realiza:\r\n\r\n∆ Diagnóstico electrónico de la placa base.\r\n\r\n∆ Identificación de componentes dañados (capacitores, resistencias, IC, etc.).\r\n\r\n∆ Uso de herramientas especializadas como estación de calor y microscopio.\r\n\r\n∆ Reemplazo o reparación de componentes defectuosos.\r\n\r\n∆ Pruebas de funcionamiento y estabilidad del equipo.\r\n\r\n∆ Limpieza del área trabajada.', 'Beneficios de este servicio:\r\n\r\n✓ Ahorro económico frente al reemplazo completo de la placa.\r\n✓ Reparación precisa y profesional.\r\n✓ Recuperación del funcionamiento original del equipo.\r\n✓ Uso de herramientas y técnicas especializadas.\r\n✓ Diagnóstico detallado del problema.', 'El equipo debe ser entregado completo para realizar pruebas adecuadas. Se recomienda no manipular previamente la placa si no se cuenta con experiencia técnica.', '*Importante*\r\nNo todas las placas son reparables.\r\nEl costo puede variar según el daño detectado.\r\nNo incluye refacciones de alto costo sin previa autorización.\r\nDaños severos o irreversibles serán notificados.', '3 a 5 días hábiles', 3000.00, 'activo', 'Miniaturas_500px_Reparacion_Componentes_PlacaBase_AR.png'),
(26, NULL, 2, 'Reparación a nivel componente de placa base para equipos de computo avanzada', 'Servicio avanzado enfocado en la reparación de placas base con fallas complejas a nivel componente. Se emplean técnicas especializadas para solucionar problemas críticos en circuitos electrónicos de alta precisión.', 'Durante el servicio se realiza:\r\n\r\n∆ Diagnóstico avanzado con herramientas especializadas.\r\n\r\n∆ Análisis de líneas de voltaje y señales electrónicas.\r\n\r\n∆ Identificación de fallas complejas en chips, controladores y circuitos integrados.\r\n\r\n∆ Reparación mediante micro soldadura de precisión.\r\n\r\n∆ Reemplazo de componentes críticos (IC, MOSFET, controladores, etc.).\r\n\r\n∆ Pruebas exhaustivas de funcionamiento y estrés del sistema.', 'Beneficios de este servicio:\r\n\r\n✓ Solución a fallas complejas que otros servicios no cubren.\r\n✓ Ahorro significativo frente al reemplazo total.\r\n✓ Intervención técnica de alto nivel.\r\n✓ Mayor probabilidad de recuperación del equipo.\r\n✓ Diagnóstico profundo y preciso.', 'Se recomienda proporcionar información detallada sobre la falla. El equipo debe entregarse completo para pruebas integrales. Este servicio está orientado a casos complejos.', '*Importante*\r\nNo se garantiza reparación en todos los casos.\r\nEl tiempo de entrega puede ser mayor debido a la complejidad.\r\nNo incluye refacciones sin autorización previa.\r\nDaños irreversibles serán informados.', '5', 5000.00, 'activo', 'Miniaturas_500px_Reparacion_Componentes_PlacaBase.png'),
(27, 'IST-005', 3, 'Instalación de Microsoft Office 2021 con clave digital', 'Instalación profesional de Microsoft Office 2021 con activación mediante clave digital. Disfruta de herramientas como Word, Excel y PowerPoint listas para usarse de manera segura y optimizada.', 'Durante el servicio se realiza:\r\n\r\n∆ Descarga e instalación de Microsoft Office 2021.\r\n\r\n∆ Activación del producto mediante clave digital.\r\n\r\n∆ Configuración inicial de las aplicaciones (Word, Excel, PowerPoint, etc.).\r\n\r\n∆ Verificación de correcto funcionamiento.\r\n\r\n∆ Asesoría básica de uso si el cliente lo requiere.', 'Beneficios de este servicio:\r\n\r\n✓ Software listo para usarse inmediatamente.\r\n✓ Activación correcta y segura.\r\n✓ Evita errores durante la instalación.\r\n✓ Ahorro de tiempo.\r\n✓ Soporte técnico durante el proceso.', 'El equipo debe contar con conexión a internet para la instalación y activación. Se recomienda no tener versiones previas conflictivas instaladas.', '*Importante*\r\nLa licencia es válida únicamente para un equipo.\r\nNo incluye suscripción a servicios adicionales de Microsoft 365.\r\nNo incluye soporte posterior prolongado.\r\nNo se realizan reembolsos una vez activada la clave digital.', '1 día hábil', 1250.00, 'activo', 'Miniaturas_500px_Office_2021.png'),
(28, 'IST-006', 3, 'Instalación de Microsoft Office 2024 con clave digital', 'Instalación profesional de Microsoft Office 2024 con activación mediante clave digital. Incluye aplicaciones esenciales como Word, Excel y PowerPoint listas para usarse de forma segura y optimizada.', 'Durante el servicio se realiza:\r\n\r\n∆ Descarga e instalación de Microsoft Office 2024.\r\n\r\n∆ Activación del producto mediante clave digital.\r\n\r\n∆ Configuración inicial de las aplicaciones.\r\n\r\n∆ Verificación de funcionamiento correcto.\r\n\r\n∆ Asesoría básica de uso si el cliente lo requiere.', 'Beneficios de este servicio:\r\n\r\n✓ Software completamente funcional desde el primer uso.\r\n✓ Activación segura y correcta.\r\n✓ Evita errores de instalación.\r\n✓ Ahorro de tiempo.\r\n✓ Soporte técnico durante el proceso.', 'El equipo debe contar con conexión a internet. Se recomienda desinstalar versiones previas para evitar conflictos durante la instalación.', '*Importante*\r\nLa licencia es válida únicamente para un equipo.\r\nNo incluye servicios adicionales de suscripción.\r\nNo incluye soporte prolongado posterior.\r\nNo se realizan reembolsos una vez activada la licencia.', '1 día hábil', 1499.00, 'activo', 'Miniaturas_500px_Office_2024.png'),
(29, 'IST-007', 3, 'Instalación y licencia de AutoCAD Architecture', 'Instalación y activación de AutoCAD Architecture, software especializado para diseño arquitectónico. Ideal para profesionales y estudiantes que requieren herramientas avanzadas de dibujo y modelado.', 'Durante el servicio se realiza:\r\n\r\n∆ Instalación del software AutoCAD Architecture.\r\n\r\n∆ Activación mediante licencia digital.\r\n\r\n∆ Configuración inicial del entorno de trabajo.\r\n\r\n∆ Verificación del correcto funcionamiento.\r\n\r\n∆ Ajustes básicos según necesidades del usuario.', 'Beneficios de este servicio:\r\n\r\n✓ Software listo para proyectos arquitectónicos.\r\n✓ Activación correcta y funcional.\r\n✓ Ahorro de tiempo en instalación compleja.\r\n✓ Configuración optimizada.\r\n✓ Soporte técnico durante el proceso.', 'Se requiere un equipo con características adecuadas para software de diseño (RAM suficiente, procesador y espacio en disco). Es necesaria conexión a internet.', '*Importante*\r\nLa licencia es válida para un solo equipo.\r\nNo incluye capacitación avanzada.\r\nNo incluye soporte técnico prolongado.\r\nNo se realizan reembolsos una vez instalado y activado el software.', '1 día hábil', 930.00, 'activo', 'Miniaturas_500px_AutoCad.png'),
(30, 'IST-008', 3, 'Instalación y licencia de Autodesk Revit 2026', 'Instalación y activación de Autodesk Revit 2026, software especializado en modelado BIM para arquitectura, ingeniería y construcción. Ideal para proyectos profesionales y académicos.', 'Durante el servicio se realiza:\r\n\r\n∆ Instalación de Autodesk Revit 2026.\r\n\r\n∆ Activación mediante licencia digital.\r\n\r\n∆ Configuración inicial del entorno BIM.\r\n\r\n∆ Verificación de funcionamiento.\r\n\r\n∆ Ajustes básicos para optimizar el rendimiento.', 'Beneficios de este servicio:\r\n\r\n✓ Software listo para modelado BIM.\r\n✓ Activación segura y funcional.\r\n✓ Ahorro de tiempo en procesos complejos.\r\n✓ Configuración optimizada.\r\n✓ Soporte técnico durante la instalación.', 'El equipo debe cumplir con requisitos de hardware para software BIM (memoria RAM alta, buena tarjeta gráfica y espacio en disco). Se requiere conexión a internet.', '*Importante*\r\nLa licencia es válida para un solo equipo.\r\nNo incluye capacitación especializada.\r\nNo incluye soporte posterior prolongado.\r\nNo se realizan reembolsos una vez activado el software.', '1 día hábil', 930.00, 'activo', 'Miniaturas_500px_Revit_.png'),
(31, 'RRLA-001', 2, 'Reemplazo de Batería', 'Sustitución de batería para laptops, restaurando la autonomía y el correcto funcionamiento del equipo.', '∆ Diagnóstico de batería.\r\n∆ Retiro de batería dañada.\r\n∆ Instalación de batería nueva.\r\n∆ Pruebas de carga y duración.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 345.00, 'activo', 'Miniaturas_500px_Batería.png'),
(32, 'RRLA-002', 2, 'Reemplazo de Motherboard para PC y laptop', 'Sustitución de la tarjeta madre en equipos de escritorio y portátiles, solucionando fallas críticas del sistema.', '∆ Diagnóstico de placa.\r\n∆ Desmontaje del equipo.\r\n∆ Instalación de nueva motherboard.\r\n∆ Pruebas de funcionamiento.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 980.00, 'activo', 'Miniaturas_500px_Reemplazo_Motherboard.png'),
(33, 'RRLA-003', 2, 'Reemplazo de teclado para equipos portátiles', 'Cambio de teclado en laptops por fallas de teclas, desgaste o daño físico.', '∆ Evaluación del teclado.\r\n∆ Desmontaje del equipo.\r\n∆ Instalación de nuevo teclado.\r\n∆ Pruebas de funcionamiento.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 1690.00, 'activo', 'Miniaturas_500px_Reemplazo_Motherboard_AR.png'),
(34, 'RRG-001', 2, 'Reemplazo de CPU para equipos de escritorio', 'Sustitución del procesador para mejorar el rendimiento o reemplazar uno dañado.', '∆ Verificación de compatibilidad.\r\n∆ Retiro del CPU.\r\n∆ Instalación del nuevo procesador.\r\n∆ Aplicación de pasta térmica.\r\n∆ Pruebas de rendimiento.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 645.00, 'activo', 'Miniaturas_500px_Reemplazo_CPU.png'),
(35, 'RRG-002', 2, 'Reemplazo de fuente de poder', 'Cambio de fuente de poder para garantizar un suministro eléctrico estable y seguro.', '∆ Diagnóstico de energía.\r\n∆ Retiro de fuente dañada.\r\n∆ Instalación de nueva fuente.\r\n∆ Pruebas de voltaje.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 490.00, 'activo', 'Miniaturas_500px_Reemplazo_FuenteDePoder.png'),
(36, 'RRG-003', 2, 'Reemplazo de sistema de refrigeración líquida AIO para equipos de alto rendimiento', 'Sustitución de sistema de enfriamiento líquido AIO para mantener temperaturas óptimas en equipos de alto rendimiento.', '∆ Retiro del sistema AIO.\r\n∆ Limpieza del área.\r\n∆ Instalación del nuevo sistema.\r\n∆ Pruebas térmicas.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 730.00, 'activo', 'Miniaturas_500px_Refrigeracion_Liquida_AIO.png'),
(37, 'RRG-004', 2, 'Reemplazo de sistema de refrigeración para equipos de escritorio', 'Cambio del sistema de enfriamiento por aire para mejorar la disipación térmica del equipo.', '∆ Retiro del disipador.\r\n∆ Limpieza.\r\n∆ Instalación del nuevo sistema.\r\n∆ Pruebas de temperatura.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 650.00, 'activo', 'Miniaturas_500px_Reemplazo_Refrigeracion_Disipador.png'),
(38, 'RRL-001', 2, 'Reemplazo de pantalla', 'Sustitución de pantalla dañada en laptops, devolviendo la calidad de imagen y funcionalidad.', '∆ Diagnóstico de pantalla.\r\n∆ Desmontaje.\r\n∆ Instalación de nueva pantalla.\r\n∆ Pruebas de imagen.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 840.00, 'activo', 'Miniaturas_500px_Reemplazo_Pantalla.png'),
(39, 'RRL-003', 2, 'Reparación de sistema de bisagras para laptops', 'Reparación de bisagras dañadas para restaurar la apertura y cierre correcto del equipo.', '∆ Evaluación de bisagras.\r\n∆ Desmontaje parcial.\r\n∆ Reparación o ajuste.\r\n∆ Pruebas de apertura.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 450.00, 'activo', 'Miniaturas_500px_Reparacion_Bisagras.png'),
(40, 'RRT-002', 2, 'Reemplazo de Memoria RAM DDR5', 'Sustitución o ampliación de memoria RAM DDR5 para mejorar el rendimiento del sistema.', '∆ Verificación de compatibilidad.\r\n∆ Instalación de RAM.\r\n∆ Pruebas de rendimiento.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 375.00, 'activo', 'Miniaturas_500px_ReemplazoRAM5.png'),
(41, 'RRGL-003', 2, 'Reemplazo de Motherboard', 'Cambio de tarjeta madre en equipos de cómputo para solucionar fallas graves del sistema.', '∆ Diagnóstico.\r\n∆ Desmontaje.\r\n∆ Instalación de nueva placa.\r\n∆ Pruebas.', '✓ Mayor vida útil del equipo.\r\n✓ Mejor rendimiento.\r\n✓ Diagnóstico profesional.\r\n✓ Uso de refacciones de calidad.\r\n✓ Garantía en el servicio.', 'Se recomienda entregar el equipo completo y respaldar la información antes del servicio.', '*Importante*\r\nNo incluye refacciones.\r\nEl costo puede variar según el modelo del equipo.\r\nSujeto a diagnóstico previo.', '1 día hábil. Sujeto a disponibilidad de refacciones.', 645.00, 'activo', 'Miniaturas_500px_Reemplazo_Motherboard.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_equipo`
--

CREATE TABLE `tipos_equipo` (
  `id_tipo_equipo` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tipos_equipo`
--

INSERT INTO `tipos_equipo` (`id_tipo_equipo`, `tipo`) VALUES
(1, 'Laptop'),
(2, 'PC'),
(3, 'All-in-one'),
(4, 'Minipc'),
(5, 'Consola de videojuegos'),
(7, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_servicios`
--

CREATE TABLE `tipos_servicios` (
  `id_tipo_servicio` int(11) NOT NULL,
  `nombre_tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tipos_servicios`
--

INSERT INTO `tipos_servicios` (`id_tipo_servicio`, `nombre_tipo`) VALUES
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  ADD PRIMARY KEY (`id_login`);

--
-- Indices de la tabla `bitacora_movimientos`
--
ALTER TABLE `bitacora_movimientos`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `causas_servicio`
--
ALTER TABLE `causas_servicio`
  ADD PRIMARY KEY (`id_causa`);

--
-- Indices de la tabla `citas_web`
--
ALTER TABLE `citas_web`
  ADD PRIMARY KEY (`id_cita`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `condiciones_servicio`
--
ALTER TABLE `condiciones_servicio`
  ADD PRIMARY KEY (`id_condicion`);

--
-- Indices de la tabla `directorio_socios`
--
ALTER TABLE `directorio_socios`
  ADD PRIMARY KEY (`id_socio`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`);

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
-- Indices de la tabla `informacion_index`
--
ALTER TABLE `informacion_index`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `marketing`
--
ALTER TABLE `marketing`
  ADD PRIMARY KEY (`id_encuesta`);

--
-- Indices de la tabla `medios_contacto`
--
ALTER TABLE `medios_contacto`
  ADD PRIMARY KEY (`id_medio`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id_mensaje`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id_metodo`);

--
-- Indices de la tabla `ordenes_ingreso`
--
ALTER TABLE `ordenes_ingreso`
  ADD PRIMARY KEY (`folio`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id_puesto`);

--
-- Indices de la tabla `relacion_equipo_marca`
--
ALTER TABLE `relacion_equipo_marca`
  ADD PRIMARY KEY (`id_marca`,`id_tipo_equipo`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `id_tipo_servicio` (`id_tipo_servicio`);

--
-- Indices de la tabla `tipos_equipo`
--
ALTER TABLE `tipos_equipo`
  ADD PRIMARY KEY (`id_tipo_equipo`);

--
-- Indices de la tabla `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  ADD PRIMARY KEY (`id_tipo_servicio`);

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
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `bitacora_movimientos`
--
ALTER TABLE `bitacora_movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1037;

--
-- AUTO_INCREMENT de la tabla `causas_servicio`
--
ALTER TABLE `causas_servicio`
  MODIFY `id_causa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas_web`
--
ALTER TABLE `citas_web`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `condiciones_servicio`
--
ALTER TABLE `condiciones_servicio`
  MODIFY `id_condicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `directorio_socios`
--
ALTER TABLE `directorio_socios`
  MODIFY `id_socio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `frecuencias_servicio`
--
ALTER TABLE `frecuencias_servicio`
  MODIFY `id_frecuencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `informacion_index`
--
ALTER TABLE `informacion_index`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `marketing`
--
ALTER TABLE `marketing`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `medios_contacto`
--
ALTER TABLE `medios_contacto`
  MODIFY `id_medio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_metodo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tipos_equipo`
--
ALTER TABLE `tipos_equipo`
  MODIFY `id_tipo_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  MODIFY `id_tipo_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipos_uso`
--
ALTER TABLE `tipos_uso`
  MODIFY `id_tipo_uso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
