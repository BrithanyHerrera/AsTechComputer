-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql113.infinityfree.com
-- Tiempo de generación: 22-03-2026 a las 02:13:19
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
(1, 1, '2026-03-02 22:52:23', NULL);

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
  `id_puesto` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `telefono`, `correo`, `nombre_usuario`, `contrasena`, `id_puesto`) VALUES
(1, 'Carlos', 'López', '3312345678', 'carlos@astech.com', '', '', 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `condicion_fisica` varchar(255) NOT NULL,
  `accesorios_entregados` varchar(255) NOT NULL,
  `descripcion_problema` text NOT NULL,
  `observaciones_recepcion` text NOT NULL,
  `estado` enum('recibido','entregado') DEFAULT 'recibido',
  `fecha_entrega` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `id_tipo_servicio` int(11) DEFAULT NULL,
  `imagen_servicio` longtext DEFAULT NULL,
  `tipo_servicio` varchar(100) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `tiempo_estimado` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `id_tipo_servicio`, `imagen_servicio`, `tipo_servicio`, `descripcion`, `tiempo_estimado`, `precio`, `estado`) VALUES
(1, 1, NULL, 'Mantenimiento preventivo para equipos portátiles de alto rendimiento', 'Mantén tu laptop gamer y de trabajo en optima condición. El mantenimiento preventivo es clave para prolongar la vida útil de tu equipo, prevenir problemas de sobrecalentamiento, y asegurar que siempre funcione al máximo nivel con insumos de alto rendimiento de la marca THERMAL GRIZZLY.', '1 día hábil', '1450.00', 'activo'),
(2, 1, NULL, 'Mantenimiento preventivo para equipos portátiles de oficina', 'Mantén tu laptop en optima condición. Nuestro servicio de mantenimiento preventivo completo ayuda a prevenir problemas de sobrecalentamiento, y asegurar que siempre funcione al máximo nivel sin interrupciones.', '1 día hábil', '690.00', 'activo'),
(3, 1, NULL, 'Mantenimiento preventivo para gabinetes mid tower', 'Tu PC merece un cuidado completo. Este servicio esta diseñado para prevenir problemas, mejorar el rendimiento y prolongar la vida útil de tu equipo.', '1 día hábil', '920.00', 'activo'),
(4, 1, NULL, 'Mantenimiento preventivo para gabinetes de oficina', 'Tu PC de oficina merece un cuidado completo. Este servicio está diseñado para prevenir problemas, mejorar el rendimiento y prolongar la vida útil de tu equipo. Realizamos una limpieza profunda y optimizamos el flujo de aire para asegurar que tu gabinete funcione al 100%.', '1 día hábil', '680.00', 'activo'),
(5, 1, NULL, 'Mantenimiento preventivo para gabinetes full tower', 'Tu PC merece un cuidado completo. Este servicio está diseñado para prevenir problemas, mejorar el rendimiento y prolongar la vida útil de tu equipo. Realizamos una limpieza profunda y optimizamos el flujo de aire para asegurar que tu gabinete funcione al 100% y que tus componentes se mantengan a la temperatura ideal.', '1 día hábil.', '1490.00', 'activo'),
(6, 1, NULL, 'Mantenimiento preventivo de alto rendimiento para equipos portátiles con metal liquido', 'Mantén tu laptop de alto rendimiento en óptimas condiciones. El mantenimiento preventivo es clave para prolongar la vida útil de tu equipo, prevenir problemas de sobrecalentamiento, y asegurar que siempre funcione al máximo nivel.', '1 día hábil.', '2180.00', 'activo'),
(7, 2, NULL, 'Reparación de sistema de bisagras (Laptops de alto rendimiento)', 'Las bisagras de tu laptop, con el uso constante, suelen aflojarse o romperse, dañando los anclajes internos, la carcasa y poniendo en riesgo la pantalla. Nuestro servicio busca devolverle estabilidad al equipo y prevenir que el daño avance. ', '1 día hábil. Sujeto a disponibilidad de refacciones. ', '570.00', 'activo'),
(8, 2, NULL, 'Instalación de unidad de almacenamiento', 'Realizamos el reemplazo seguro de discos duros (HDD) o unidades de estado sólido (SSD) para mejorar la capacidad y velocidad de tu equipo', '1 día hábil. Sujeto a disponibilidad de refacciones.', '450.00', 'activo'),
(9, 2, NULL, 'Reemplazo de teclado para portátiles de oficina', 'Los teclados pueden presentar fallas en las teclas, pérdida de sensibilidad o desgaste estético. Nuestro servicio de reemplazo devuelve la funcionalidad', '1 día hábil. Sujeto a disponibilidad de refacciones.', '890.00', 'activo'),
(10, 2, NULL, 'Reemplazo de ventiladores', 'Con el tiempo y uso, los ventiladores de enfriamiento pueden desgastarse o llenarse de polvo hasta terminar de averiarse o fallar lo que reduce la circulación de aire y provoca sobrecalentamiento.', '1 día hábil. Sujeto a disponibilidad de refacciones.', '260.00', 'activo'),
(11, 2, NULL, 'Reemplazo de Memoria RAM DDR2/3/4', 'La memoria RAM puede quedarse corta o presentar fallas que vuelven lento el equipo. Nuestro servicio de reemplazo o ampliación mejora el rendimiento y la capacidad de respuesta de tu computadora.', '1 día hábil. Sujeto a disponibilidad de refacciones.', '330.00', 'activo'),
(12, 3, NULL, 'Instalación de Microsoft Office 2016 con clave de producto original', '¿Necesitas activar, instalar o reinstalar Microsoft Office 2016 en tu equipo? Nosotros nos encargamos del proceso, asegurando que tu suite de productividad quede perfectamente configurada y lista para usar.? Este servicio es ideal para garantizar un funcionamiento óptimo y evitar problemas de compatibilidad.', '1 día hábil.', '699.00', 'activo'),
(13, 3, NULL, 'Clave de producto Windows 10 Professional', 'Obtén tu clave de producto original de Windows 10 para activar tu sistema operativo de forma legal y permanente.Una clave original es tu garantía para recibir todas las actualizaciones de seguridad y acceder a las funcionalidades completas que ofrece Microsoft.', '1 día hábil.', '499.00', 'activo'),
(14, 3, NULL, 'Instalación de Microsoft Office 2019 con clave de producto', '¿Necesitas activar, instalar o reinstalar Microsoft Office 2019 en tu equipo? Nosotros nos encargamos del proceso, asegurando que tu suite de productividad quede perfectamente configurada y lista para usar.? Este servicio es ideal para garantizar un funcionamiento óptimo y evitar problemas de compatibilidad.', '1 día hábil.', '930.00', 'activo'),
(15, 3, NULL, 'Clave de producto Windows 11 Professional', 'Obtén tu clave de producto original de Windows 11 para activar tu sistema operativo de forma legal y permanente.🫱🏽‍🫲🏼 Una clave original es tu garantía para recibir todas las actualizaciones de seguridad y acceder a las funcionalidades completas que ofrece Microsoft.', '1 día hábil.', '699.00', 'activo'),
(16, 3, NULL, 'Reinstalación de sistema operativo con respaldo de información', 'Realizamos la instalación del sistema operativo de tu computadora, asegurando que tus archivos importantes se respalden y se restauren correctamente.', '1 día hábil.', '520.00', 'activo'),
(17, 4, NULL, 'Servicio de recolección y entrega a domicilio (1 traslado)', 'Ofrecemos un servicio seguro y rápido para recoger y entregar tu equipo portátil (Laptop) directamente en tu domicilio o negocio mediante transporte en motocicleta.', '1 dia', '75.00', 'activo'),
(18, 4, NULL, 'Servicio de recolección y entrega a domicilio Automovil (1 traslado)', 'Ofrecemos un servicio seguro y confiable para recoger y entregar tu equipo de cómputo directamente en tu domicilio o negocio mediante transporte en automóvil, ideal para uno o varios equipos de mayor tamaño o volumen. ', '1 dia ', '150.00', 'activo'),
(19, 5, NULL, 'Servicio de asistencia remota', '¿Tienes un problema de software y necesitas una solución rápida sin salir de casa? 🏠 Nuestro servicio de asistencia remota te conecta con un técnico experto que puede resolver fallas comunes de forma segura y eficiente a través de internet.', '1 día hábil.', '460.00', 'activo'),
(20, 5, NULL, 'Servicio de recuperación de información con software especializado', 'Cuando tu información corre riesgo por fallas en la unidad de almacenamiento, realizamos la recuperación de datos de HDD, SSD, USB o tarjetas de memoria, utilizando herramientas y software profesional para proteger y rescatar tu información importante.', '1 día hábil.', '750.00', 'activo'),
(21, 5, NULL, 'Diagnóstico básico de computo', '¿Tu equipo no enciende, está lento o presenta un problema general y no sabes por qué? Nuestro diagnóstico básico es el primer paso para identificar la causa de la falla. Realizamos una revisión completa para determinar si el origen del problema es de software, de hardware o dar seguimiento a un problema para así poder ofrecerte la solución adecuada.🛠️\r\n', '1 día hábil.', '560.00', 'activo'),
(22, 5, NULL, 'Asesoría de ensamble de equipo de computo', 'Nos encargamos de guiarte en la elección de los componentes y de ensamblar tu computadora de forma profesional, asegurando compatibilidad, rendimiento y una instalación limpia y ordenada. Ideal para equipos de oficina, diseño, programación, gaming o uso profesional intensivo.', '1 día hábil.', '100.00', 'activo');

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
-- Indices de la tabla `directorio_socios`
--
ALTER TABLE `directorio_socios`
  ADD PRIMARY KEY (`id_socio`);

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
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id_mensaje`);

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
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `condiciones_servicio`
--
ALTER TABLE `condiciones_servicio`
  MODIFY `id_condicion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `directorio_socios`
--
ALTER TABLE `directorio_socios`
  MODIFY `id_socio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medios_contacto`
--
ALTER TABLE `medios_contacto`
  MODIFY `id_medio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `causas_servicio`
--
ALTER TABLE `causas_servicio`
  ADD CONSTRAINT `causas_servicio_ibfk_1` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tipos_servicios` (`id_tipo_servicio`),
  ADD CONSTRAINT `causas_servicio_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
