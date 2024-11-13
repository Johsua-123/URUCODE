-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2024 a las 20:44:06
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
-- Base de datos: `urucode`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos`
--

CREATE TABLE `codigos` (
  `codigo` int(11) NOT NULL,
  `tipo` enum('verificar-cuenta','resetear-cuenta','eliminar-cuenta') DEFAULT NULL,
  `valor` varchar(60) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `codigo` int(11) NOT NULL,
  `estado` enum('pago','pendiente','vencido') DEFAULT 'pendiente',
  `numero` int(11) NOT NULL,
  `metodo` enum('Tarjeta','PayPal','Mercado Pago','Transferencia') DEFAULT NULL,
  `valor` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `codigo` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `enlace` text DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `codigo` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `leido` tinyint(1) DEFAULT 0,
  `nombre` varchar(60) NOT NULL,
  `asunto` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `codigo` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `estado` enum('completado','pendiente','vencido') DEFAULT 'pendiente',
  `fecha_creacion` datetime NOT NULL,
  `fecha_actualizacion` datetime NOT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `marca` varchar(70) DEFAULT NULL,
  `modelo` varchar(70) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1,
  `en_venta` tinyint(1) DEFAULT 0,
  `eliminado` tinyint(1) DEFAULT 0,
  `imagen_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_venta` decimal(10,0) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_categorias`
--

CREATE TABLE `productos_categorias` (
  `eliminado` tinyint(1) DEFAULT 0,
  `producto_id` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_imagenes`
--

CREATE TABLE `productos_imagenes` (
  `eliminado` tinyint(1) DEFAULT 0,
  `imagen_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `precio` decimal(10,0) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `imagen_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `codigo` int(11) NOT NULL,
  `rol` enum('dueño','supervisor','admin','empleado','usuario') DEFAULT 'usuario',
  `email` varchar(150) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `apellido` varchar(30) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `verificado` tinyint(1) DEFAULT 0,
  `imagen_id` int(11) DEFAULT NULL,
  `contrasena` varchar(60) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `idx_eliminado` (`eliminado`);

--
-- Indices de la tabla `codigos`
--
ALTER TABLE `codigos`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `tipo` (`tipo`,`usuario_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `idx_eliminado` (`eliminado`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_nombre` (`nombre`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `productos_imagenes`
--
ALTER TABLE `productos_imagenes`
  ADD UNIQUE KEY `imagen_id` (`imagen_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `idx_eliminado` (`eliminado`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `imagen_id` (`imagen_id`),
  ADD KEY `idx_precio` (`precio`),
  ADD KEY `idx_eliminado` (`eliminado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `imagen_id` (`imagen_id`),
  ADD KEY `idx_nombre` (`nombre`),
  ADD KEY `idx_apellido` (`apellido`),
  ADD KEY `idx_telefono` (`telefono`),
  ADD KEY `idx_eliminado` (`eliminado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `codigos`
--
ALTER TABLE `codigos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `codigos`
--
ALTER TABLE `codigos`
  ADD CONSTRAINT `codigos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`codigo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ordenes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `productos` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ordenes_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `servicios` (`codigo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD CONSTRAINT `productos_categorias_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_categorias_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`codigo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos_imagenes`
--
ALTER TABLE `productos_imagenes`
  ADD CONSTRAINT `productos_imagenes_ibfk_1` FOREIGN KEY (`imagen_id`) REFERENCES `imagenes` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_imagenes_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`codigo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`imagen_id`) REFERENCES `imagenes` (`codigo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`imagen_id`) REFERENCES `imagenes` (`codigo`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
