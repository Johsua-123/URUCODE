INSERT INTO `categorias` (`codigo`, `nombre`, `eliminado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Celulares', 0, NULL, NULL),
(2, 'Tablets', 0, NULL, NULL),
(4, 'Destacados', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(5, 'Ofertas', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(6, 'Computadoras y Laptops', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(7, 'Componentes de PC', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(8, 'Periféricos', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(9, 'Software y Licencias', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(10, 'Accesorios de Oficina', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(11, 'Redes y Conectividad', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(12, 'Almacenamiento', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45'),
(13, 'Servicios de Reparación y Soporte Técnico', 0, '2024-11-13 21:10:45', '2024-11-13 21:10:45');

INSERT INTO `imagenes` (`codigo`, `nombre`, `extension`, `eliminado`, `fecha_creacion`) VALUES
(1, 'imagen', '.png', 0, NULL),
(2, 'imagen', '.jpg', 0, NULL),
(3, 'imagen', '.jpg', 0, NULL),
(6, 'imagen-1', '.png', 0, '2024-11-14 01:12:47'),
(7, 'imagen-1', '.png', 0, '2024-11-14 01:15:17'),
(8, 'imagen-1', '.png', 0, '2024-11-14 01:16:09'),
(9, 'imagen-2', '.jpg', 0, '2024-11-14 01:24:40'),
(10, 'imagen-2', '.jpg', 0, '2024-11-14 01:26:33'),
(11, 'imagen-2', '.jpg', 0, '2024-11-14 01:27:00'),
(12, 'imagen-2', '.jpg', 0, '2024-11-14 01:29:56'),
(13, 'imagen-2', '.jpg', 0, '2024-11-14 01:30:27'),
(14, 'imagen-2', '.jpg', 0, '2024-11-14 01:30:48'),
(15, 'imagen-3', '.jpg', 0, '2024-11-14 01:32:09');

INSERT INTO `productos` (`codigo`, `nombre`, `marca`, `modelo`, `cantidad`, `en_venta`, `eliminado`, `imagen_id`, `descripcion`, `precio_venta`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(170, 'Iphone 15', 'Apple', 'Pro', 1, 1, 0, 6, 'Blanco', 1000, '2024-11-14 01:12:47', '2024-11-14 01:12:47'),
(171, 'Iphone 14', 'Apple', 'Pro', 1, 1, 0, 7, '', 0, '2024-11-14 01:15:17', '2024-11-14 01:15:17'),
(172, 'Iphone 13', 'Apple', 'Pro', 1, 1, 0, 8, '', 2000, '2024-11-14 01:16:09', '2024-11-14 01:16:09'),
(176, 'Laptop Prop', 'Asus', '2022', 1, 1, 0, 12, 'Colo blanco', 5000, '2024-11-14 01:29:56', '2024-11-14 01:29:56'),
(177, 'Laptop Pro 2', 'Asus', '2022', 5, 1, 0, 13, 'Colo amarillo', 1000, '2024-11-14 01:30:27', '2024-11-14 01:30:27'),
(178, 'Laptop Pro 3', 'Asus', '2022', 100, 1, 0, 14, 'Color rojo', 1340, '2024-11-14 01:30:48', '2024-11-14 01:30:48'),
(179, 'Teclado', 'Logitech', 'g203', 20, 1, 0, 15, 'Color blanco', 100, '2024-11-14 01:32:09', '2024-11-14 01:32:09');

INSERT INTO `productos_categorias` (`producto_id`, `categoria_id`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(170, 5, '2024-11-14 01:12:47', '2024-11-14 01:12:47'),
(171, 5, '2024-11-14 01:15:17', '2024-11-14 01:15:17'),
(172, 5, '2024-11-14 01:16:09', '2024-11-14 01:16:09'),
(176, 4, '2024-11-14 01:29:56', '2024-11-14 01:29:56'),
(177, 4, '2024-11-14 01:30:27', '2024-11-14 01:30:27'),
(178, 4, '2024-11-14 01:30:48', '2024-11-14 01:30:48'),
(179, 8, '2024-11-14 01:32:09', '2024-11-14 01:32:09');