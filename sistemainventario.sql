-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-02-2025 a las 19:15:19
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
-- Base de datos: `sistemainventario`
--
CREATE DATABASE sistemainventario;
-- --------------------------------------------------------
USE DATABASE sistemainventario;
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
(27, 18, 1, 30, 5000.00, 150000.00),
(28, 18, 63, 1, 2200.00, 2200.00),
(29, 19, 63, 1, 2200.00, 2200.00),
(30, 19, 40, 3, 100.00, 300.00),
(31, 19, 32, 1, 1800.00, 1800.00);

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
  `nombre_producto` varchar(100) DEFAULT NULL,
  `stock` int(15) DEFAULT NULL,
  `precio_venta` decimal(15,2) DEFAULT NULL,
  `tipo` enum('Cabeza','Pies','Torso','ArmaPrimaria','ArmaSecundaria') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `rareza` enum('Comun','Rara','Epica','Legendaria') NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `nombre_producto`, `stock`, `precio_venta`, `tipo`, `descripcion`, `rareza`, `image`) VALUES
(1, 'Armadura de Runa del Guardián', 10, 1500.00, 'Torso', 'Una armadura imbuida con runas de protección y resistencia.', 'Legendaria', 'http://localhost/InventarioRPG/images/armadura_guardian.webp'),
(2, 'Armadura de Runa del Caído', 8, 1200.00, 'Torso', 'Forjada con las almas de guerreros caídos, otorga gran defensa.', 'Epica', 'http://localhost/InventarioRPG/images/armadura_caido.webp'),
(3, 'Armadura de Runa del Dragón', 12, 1800.00, 'Torso', 'Cubierta de runas que aumentan la resistencia a los elementos.', 'Legendaria', 'http://localhost/InventarioRPG/images/armadura_dragon.webp'),
(4, 'Casco de Runa Lunar', 15, 800.00, 'Cabeza', 'Un casco con runas que aumentan la percepción nocturna.', 'Rara', 'http://localhost/InventarioRPG/images/casco_lunar.webp'),
(5, 'Casco de Runa del Fénix', 10, 950.00, 'Cabeza', 'Forjado en fuego, aumenta la resistencia al calor.', 'Epica', 'http://localhost/InventarioRPG/images/casco_fenix.webp'),
(6, 'Casco de Runa del Centinela', 12, 1100.00, 'Cabeza', 'Otorga visión mágica para detectar enemigos ocultos.', 'Legendaria', 'http://localhost/InventarioRPG/images/casco_centinela.webp'),
(7, 'Botas de Runa del Viento', 20, 700.00, 'Pies', 'Permiten al usuario moverse con gran agilidad.', 'Rara', 'http://localhost/InventarioRPG/images/botas_viento.webp'),
(8, 'Botas de Runa de Fuego', 15, 900.00, 'Pies', 'Incrementan la velocidad al máximo nivel.', 'Epica', 'http://localhost/InventarioRPG/images/botas_fuego.webp'),
(9, 'Botas de Runa de la Sombra', 18, 1200.00, 'Pies', 'Permiten moverse en silencio absoluto.', 'Legendaria', 'http://localhost/InventarioRPG/images/botas_sombra.webp'),
(10, 'Guantes de Runa del Hechicero', 10, 600.00, 'ArmaSecundaria', 'Mejoran la precisión de hechizos.', 'Rara', 'http://localhost/InventarioRPG/images/guantes_hechicero.webp'),
(11, 'Guantes de Runa del Guerrero', 8, 850.00, 'ArmaSecundaria', 'Otorgan un golpe más poderoso.', 'Epica', 'http://localhost/InventarioRPG/images/guantes_guerrero.webp'),
(12, 'Guantes de Runa del Destino', 12, 1000.00, 'ArmaSecundaria', 'Permiten predecir los movimientos del enemigo.', 'Legendaria', 'http://localhost/InventarioRPG/images/guantes_destino.webp'),
(13, 'Escudo de Runa de la Montaña', 10, 1100.00, 'ArmaSecundaria', 'Irrompible gracias a sus runas antiguas.', 'Epica', 'http://localhost/InventarioRPG/images/escudo_montana.webp'),
(14, 'Escudo de Runa del Ocaso', 8, 1250.00, 'ArmaSecundaria', 'Absorbe la luz del entorno y la usa como defensa.', 'Legendaria', 'http://localhost/InventarioRPG/images/escudo_ocaso.webp'),
(15, 'Escudo de Runa Sagrada', 12, 1400.00, 'ArmaSecundaria', 'Emite un aura de protección divina.', 'Legendaria', 'http://localhost/InventarioRPG/images/escudo_sagrado.webp'),
(16, 'Espada de Runa Celestial', 5, 2500.00, 'ArmaPrimaria', 'Una espada imbuida con el poder de los dioses.', 'Legendaria', 'http://localhost/InventarioRPG/images/espada_celestial.webp'),
(17, 'Espada de Runa Santa', 6, 2300.00, 'ArmaPrimaria', 'Drena la energía de los enemigos no muertos al golpear.', 'Epica', 'http://localhost/InventarioRPG/images/espada_santa.webp'),
(18, 'Libro de Runa Arcana', 3, 1800.00, 'ArmaPrimaria', 'Contiene hechizos prohibidos de gran poder.', 'Legendaria', 'http://localhost/InventarioRPG/images/libro_arcano.webp'),
(19, 'Hacha de Runa de Fuego', 4, 2200.00, 'ArmaPrimaria', 'Cada golpe genera una llamarada.', 'Comun', 'http://localhost/InventarioRPG/images/hacha_fuego.webp'),
(20, 'Mazo de Runa del Trueno', 3, 2000.00, 'ArmaPrimaria', 'Causa temblores y descargas electricas al impactar.', 'Epica', 'http://localhost/InventarioRPG/images/mazo_trueno.webp'),
(21, 'Vara Corta de Runa Astral', 5, 1600.00, 'ArmaPrimaria', 'Amplifica la canalización de hechizos.', 'Rara', 'http://localhost/InventarioRPG/images/vara_astral.webp'),
(22, 'Vara Larga de Runa Celestial', 4, 1900.00, 'ArmaPrimaria', 'Otorga gran poder mágico.', 'Legendaria', 'http://localhost/InventarioRPG/images/vara_celestial.webp'),
(23, 'Kunai Doble de Runa Sombría', 6, 1500.00, 'ArmaPrimaria', 'Perfectos para ataques veloces y silenciosos.', 'Epica', 'http://localhost/InventarioRPG/images/kunai_sombrio.webp'),
(24, 'Arco de Runa del Destino', 4, 2400.00, 'ArmaPrimaria', 'Las flechas siempre encuentran su objetivo.', 'Legendaria', 'http://localhost/InventarioRPG/images/arco_destino.webp'),
(25, 'Daga de Runa del Lobo', 7, 1300.00, 'ArmaPrimaria', 'Otorga velocidad al usuario.', 'Rara', 'http://localhost/InventarioRPG/images/daga_lobo.webp');

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
(2, 'comprador'),
(1, 'vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stats`
--

CREATE TABLE `stats` (
  `id` int(11) NOT NULL,
  `inventario_id` int(11) NOT NULL,
  `vida` int(11) NOT NULL DEFAULT 0 CHECK (`vida` between 0 and 999),
  `ataque` int(11) NOT NULL DEFAULT 0 CHECK (`ataque` between 0 and 999),
  `defensa` int(11) NOT NULL DEFAULT 0 CHECK (`defensa` between 0 and 999),
  `suerte` int(11) NOT NULL DEFAULT 0 CHECK (`suerte` between 0 and 999),
  `velocidad` int(11) NOT NULL DEFAULT 0 CHECK (`velocidad` between 0 and 999),
  `resistencia` int(11) NOT NULL DEFAULT 0 CHECK (`resistencia` between 0 and 999),
  `efectividad` int(11) NOT NULL DEFAULT 0 CHECK (`efectividad` between 0 and 999)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stats`
--

INSERT INTO `stats` (`id`, `inventario_id`, `vida`, `ataque`, `defensa`, `suerte`, `velocidad`, `resistencia`, `efectividad`) VALUES
(1, 1, 50, 0, 80, 10, 20, 70, 30),
(2, 2, 40, 0, 75, 15, 25, 60, 40),
(3, 3, 60, 0, 85, 5, 15, 80, 20),
(4, 4, 20, 5, 30, 10, 25, 40, 35),
(5, 5, 25, 10, 40, 5, 20, 45, 30),
(6, 6, 30, 15, 50, 5, 15, 50, 40),
(7, 7, 10, 5, 15, 20, 50, 20, 30),
(8, 8, 5, 10, 10, 30, 60, 10, 40),
(9, 9, 15, 15, 20, 25, 70, 15, 50),
(10, 10, 0, 20, 10, 15, 30, 10, 40),
(11, 11, 0, 30, 15, 10, 40, 15, 50),
(12, 12, 0, 40, 20, 5, 50, 20, 60),
(13, 13, 0, 10, 80, 20, 10, 90, 40),
(14, 14, 0, 20, 90, 10, 5, 95, 50),
(15, 15, 0, 15, 85, 15, 15, 85, 45),
(16, 16, 0, 90, 10, 5, 10, 10, 80),
(17, 17, 0, 85, 15, 10, 15, 15, 75),
(18, 18, 0, 60, 5, 30, 5, 10, 70),
(19, 19, 0, 70, 10, 25, 10, 15, 65),
(20, 20, 0, 50, 15, 40, 15, 20, 60),
(21, 21, 0, 20, 5, 50, 25, 10, 55),
(22, 22, 0, 40, 10, 40, 20, 15, 50),
(23, 23, 0, 35, 5, 35, 35, 10, 45),
(24, 24, 0, 25, 10, 20, 50, 15, 40),
(25, 25, 0, 45, 15, 25, 45, 15, 60);

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
(1, 'vendedor', '$2y$10$yIfvn16Gn.B1xMOsFJf3beorJk99HFBpmJV4Dp4nll.AflBp7pgnW', 1),
(2, 'comprador', '$2y$10$d6xXURSMUiNHf5ek/ViHLuCxTN/pQ8.CX7rnd9EjLWQQXWyg68zRi', 2);

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
-- Indices de la tabla `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventario_id` (`inventario_id`);

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
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `stats`
--
ALTER TABLE `stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `stats`
--
ALTER TABLE `stats`
  ADD CONSTRAINT `stats_ibfk_1` FOREIGN KEY (`inventario_id`) REFERENCES `inventario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
