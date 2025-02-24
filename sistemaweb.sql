-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2024 a las 20:05:19
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
-- Base de datos: `sistemaweb`
--

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(15) NOT NULL,
  `id_venta` int(15) NOT NULL,
  `id_producto` int(15) NOT NULL,
  `cantidad` int(15) NOT NULL,
  `precio_unitario` decimal(15,2) DEFAULT NULL,
  `total_producto` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `total_producto`) VALUES
(1, 7, 1, 1, 5000.00, 5000.00),
(2, 8, 48, 1, 300.00, 300.00),
(3, 8, 1, 5, 5000.00, 25000.00),
(4, 8, 2, 1, 15000.00, 15000.00),
(5, 9, 2, 1, 15000.00, 15000.00),
(6, 9, 16, 5, 1200.00, 6000.00),
(7, 10, 1, 1, 5000.00, 5000.00),
(8, 10, 45, 1, 80.00, 80.00),
(9, 11, 1, 1, 5000.00, 5000.00),
(10, 11, 15, 1, 15000.00, 15000.00),
(11, 11, 12, 1, 800.00, 800.00),
(12, 11, 9, 10, 5000.00, 50000.00),
(13, 11, 7, 1, 18000.00, 18000.00),
(14, 11, 45, 2, 80.00, 160.00),
(15, 12, 2, 1, 15000.00, 15000.00),
(16, 12, 5, 1, 12000.00, 12000.00),
(17, 12, 7, 1, 18000.00, 18000.00),
(18, 12, 8, 1, 2000.00, 2000.00),
(19, 13, 8, 1, 2000.00, 2000.00),
(20, 13, 6, 1, 4500.00, 4500.00),
(21, 14, 1, 2, 5000.00, 10000.00);

--
-- Disparadores `detalle_ventas`
--
DELIMITER $$
CREATE TRIGGER `actualizar_stock` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
    UPDATE inventario 
    SET stock = stock - NEW.cantidad
    WHERE id = NEW.id_producto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcular_total_producto` BEFORE INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
    DECLARE precio DECIMAL(15,2);
    SELECT precio_venta INTO precio FROM inventario WHERE id = NEW.id_producto;
    SET NEW.precio_unitario = precio;
    SET NEW.total_producto = precio * NEW.cantidad;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcular_total_venta` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
    UPDATE ventas 
    SET total_final = total_final + NEW.total_producto
    WHERE id = NEW.id_venta;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(15) NOT NULL,
  `nombre_producto` varchar(30) DEFAULT NULL,
  `stock` int(15) DEFAULT NULL,
  `precio_venta` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `nombre_producto`, `stock`, `precio_venta`) VALUES
(1, 'Televisión', 33, 5000.00),
(2, 'Laptop', 7, 15000.00),
(5, 'Refrigerador', 4, 12000.00),
(6, 'Microondas', 7, 4500.00),
(7, 'Aire acondicionado', 4, 18000.00),
(8, 'Bocinas', 18, 2000.00),
(9, 'Smartwatch', 20, 5000.00),
(11, 'Teclado', 40, 1200.00),
(12, 'Mouse', 49, 800.00),
(13, 'Impresora', 7, 4000.00),
(14, 'Cámara', 9, 9500.00),
(15, 'Drone', 3, 15000.00),
(16, 'Videojuego', 30, 1200.00),
(17, 'Consola de videojuegos', 6, 9000.00),
(18, 'Cafetera', 14, 3000.00),
(19, 'Licuadora', 18, 2500.00),
(21, 'Parrilla eléctrica', 5, 4000.00),
(22, 'Horno eléctrico', 3, 5000.00),
(23, 'Plancha', 19, 1500.00),
(24, 'Batería externa', 25, 2000.00),
(25, 'Proyector', 2, 8500.00),
(26, 'Servidor NAS', 3, 25000.00),
(27, 'Cable HDMI', 60, 300.00),
(28, 'Router', 10, 2800.00),
(29, 'Switch de red', 8, 5000.00),
(30, 'Disco duro externo', 12, 4000.00),
(31, 'Memoria USB', 50, 800.00),
(32, 'Cargador portátil', 20, 1800.00),
(40, 'Cargador', 50, 100.00),
(42, 'Secadora de cabello', 20, 150.00),
(44, 'Plancha de cabello', 54, 200.00),
(45, 'Cepillo electrico', 42, 80.00),
(46, 'Quita pelusa recargable', 15, 110.00),
(47, 'Placha de vapor', 23, 2300.00),
(48, 'Plancha de ropa', 24, 300.00),
(49, 'Computadora de escritorio', 12, 8000.00),
(50, 'Ventilador', 15, 2500.00),
(51, 'Calentador de agua', 10, 3000.00),
(52, 'Cámara de seguridad', 8, 5500.00),
(53, 'Termómetro digital', 20, 800.00),
(54, 'Humidificador', 18, 1800.00),
(55, 'Deshumidificador', 6, 7500.00),
(56, 'Purificador de aire', 10, 6000.00),
(57, 'Linterna recargable', 25, 1200.00),
(58, 'Cortadora de cabello', 15, 2200.00),
(59, 'Base para laptop', 30, 1300.00),
(60, 'Mochila para laptop', 12, 2500.00),
(61, 'Protector de pantalla', 60, 200.00),
(62, 'Funda para tablet', 20, 400.00),
(63, 'Cargador inalámbrico', 18, 2200.00),
(64, 'Soporte para monitor', 12, 1800.00),
(65, 'Estabilizador de voltaje', 8, 3500.00),
(66, 'Almohadilla ergonómica', 25, 800.00),
(67, 'Auriculares gaming', 10, 3500.00),
(68, 'Control remoto universal', 50, 500.00),
(69, 'Cable USB-C', 60, 300.00),
(70, 'Cable Lightning', 40, 400.00),
(71, 'Adaptador de corriente', 30, 1200.00),
(72, 'Disco SSD', 10, 6500.00),
(73, 'Tarjeta gráfica', 5, 15000.00),
(74, 'Placa base', 7, 12000.00),
(75, 'Procesador', 6, 20000.00),
(76, 'Memoria RAM', 20, 5000.00),
(77, 'Fuente de poder', 10, 4500.00),
(78, 'Teclado mecánico', 15, 3000.00),
(79, 'Silla ergonómica', 8, 9500.00),
(80, 'Panel solar portátil', 5, 18000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'administrador'),
(2, 'empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `rol_id`) VALUES
(1, 'admin', '$2y$10$otCVFDBaiI2g/Z1KArIHwOVuGr.1.b7.MPtGOgeVWM2eeZ0TZPSrG', 1),
(2, 'empleado', '$2y$10$uJ/ezuRLh9Xj/xvdiwZmI.bkfZFQPlOhbt9S05LzpUQLN1fWHE.by', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(15) NOT NULL,
  `fecha` date DEFAULT NULL,
  `total_final` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `total_final`) VALUES
(1, '2020-03-02', 0.00),
(2, '2021-03-03', 5000.00),
(3, '2020-03-04', 0.00),
(4, '2024-03-05', 0.00),
(5, '2020-03-06', 0.00),
(6, '2024-12-01', 5000.00),
(7, '2024-12-01', 10000.00),
(8, '2024-12-05', 80600.00),
(9, '2024-12-05', 42000.00),
(10, '2024-12-07', 10160.00),
(11, '2024-12-07', 177920.00),
(12, '2024-12-09', 94000.00),
(13, '2024-12-09', 13000.00),
(14, '2024-12-09', 20000.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `inventario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
