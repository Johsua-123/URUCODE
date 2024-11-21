
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `categorias` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `codigos` (
  `codigo` int(11) NOT NULL,
  `tipo` enum('verificar-cuenta','resetear-cuenta','eliminar-cuenta') DEFAULT NULL,
  `valor` varchar(60) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `imagenes` (
  `codigo` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `extension` enum('.png','.jpg','.jpeg','.webp') DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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

CREATE TABLE `ordenes` (
  `codigo` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `item_tipo` enum('producto','servicio') DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `direccion` varchar(80) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1,
  `precio_unitario` decimal(10,2) DEFAULT 0.00,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `estado` enum('completado','pendiente','cancelada') DEFAULT 'pendiente',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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


CREATE TABLE `productos_categorias` (
  `producto_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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


INSERT INTO `usuarios` (`codigo`, `rol`, `email`, `nombre`, `apellido`, `telefono`, `ubicacion`, `direccion`, `verificado`, `imagen_id`, `contrasena`, `eliminado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'usuario', 'usuario@gmail.com', 'usuario', NULL, NULL, NULL, NULL, 0, NULL, '$2y$10$GsSD/PqZxi8zfxfdv25GT.bPOBUwXN2KHH0KnQLJsTaiSVNNwp9ki', 0, '2024-11-14 00:50:38', '2024-11-14 00:50:38'),
(2, 'dueño', 'dueño@gmail.com', 'dueño', NULL, NULL, NULL, NULL, 0, NULL, '$2y$10$k/.fqcbAky0hch8jpRp8webLHhLLz3zprlS.BmNMy.AtsOBM9SYDK', 0, '2024-11-18 23:52:18', '2024-11-18 23:52:18'),
(3, 'empleado', 'empleado@gmail.com', 'empleado', NULL, NULL, NULL, NULL, 0, NULL, '$2y$10$ffehjZRZ1yIOBaa5wS7FPu2YmE38wXjP5/RBJ2jw7EieETP77EoRq', 0, '2024-11-19 00:29:54', '2024-11-19 00:29:54'),
(4, 'admin', 'admin@gmail.com', 'admin', NULL, NULL, NULL, NULL, 0, NULL, '$2y$10$vboQfmi3Q9GmE8865YoH8ef5tksxGVqimIVepVl0LoejgNRyGQ1I6', 0, '2024-11-19 00:30:09', '2024-11-19 00:30:09'),
(5, 'supervisor', 'supervisor@gmail.com', 'supervisor', NULL, NULL, NULL, NULL, 0, NULL, '$2y$10$7UwoD/GjWmQKRJopNK6n3eHoZEIEd.pnZl26/YIwVyfq78xZIypZ2', 0, '2024-11-19 00:31:05', '2024-11-19 00:31:05');


-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `idx_eliminado` (`eliminado`);


-- Indices de la tabla `codigos`

ALTER TABLE `codigos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `usuario_id` (`usuario_id`);


-- Indices de la tabla `imagenes`

ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `idx_eliminado` (`eliminado`);


-- Indices de la tabla `mensajes`

ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_nombre` (`nombre`);


-- Indices de la tabla `ordenes`

ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `item_id` (`item_id`);


-- Indices de la tabla `productos`

ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `imagen_id` (`imagen_id`),
  ADD KEY `idx_venta` (`en_venta`),
  ADD KEY `idx_precio` (`precio_venta`),
  ADD KEY `idx_eliminado` (`eliminado`);


-- Indices de la tabla `productos_categorias`

ALTER TABLE `productos_categorias`
  ADD PRIMARY KEY (`producto_id`,`categoria_id`),
  ADD KEY `categoria_id` (`categoria_id`);


-- Indices de la tabla `servicios`

ALTER TABLE `servicios`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `imagen_id` (`imagen_id`),
  ADD KEY `idx_precio` (`precio`),
  ADD KEY `idx_eliminado` (`eliminado`);


-- Indices de la tabla `usuarios`

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `imagen_id` (`imagen_id`),
  ADD KEY `idx_nombre` (`nombre`),
  ADD KEY `idx_apellido` (`apellido`),
  ADD KEY `idx_telefono` (`telefono`),
  ADD KEY `idx_eliminado` (`eliminado`);


-- AUTO_INCREMENT de las tablas volcadas

-- AUTO_INCREMENT de la tabla `categorias`

ALTER TABLE `categorias`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


-- AUTO_INCREMENT de la tabla `codigos`

ALTER TABLE `codigos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT de la tabla `imagenes`

ALTER TABLE `imagenes`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


-- AUTO_INCREMENT de la tabla `mensajes`

ALTER TABLE `mensajes`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT de la tabla `ordenes`

ALTER TABLE `ordenes`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


-- AUTO_INCREMENT de la tabla `productos`

ALTER TABLE `productos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


-- AUTO_INCREMENT de la tabla `servicios`

ALTER TABLE `servicios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT de la tabla `usuarios`

ALTER TABLE `usuarios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


-- Restricciones para tablas volcadas


--
-- Filtros para la tabla `codigos`

ALTER TABLE `codigos`
  ADD CONSTRAINT `codigos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `codigos` (`codigo`) ON UPDATE CASCADE;


-- Filtros para la tabla `ordenes`

ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ordenes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `productos` (`codigo`) ON UPDATE CASCADE;


-- Filtros para la tabla `productos`

ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`imagen_id`) REFERENCES `imagenes` (`codigo`) ON UPDATE CASCADE;


-- Filtros para la tabla `productos_categorias`

ALTER TABLE `productos_categorias`
  ADD CONSTRAINT `productos_categorias_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_categorias_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`codigo`) ON UPDATE CASCADE;


-- Filtros para la tabla `servicios`

ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`imagen_id`) REFERENCES `imagenes` (`codigo`) ON UPDATE CASCADE;


-- Filtros para la tabla `usuarios`

ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`imagen_id`) REFERENCES `imagenes` (`codigo`) ON UPDATE CASCADE;
COMMIT;
