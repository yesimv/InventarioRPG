SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `detalle_ventas` (
  `id` int(15) NOT NULL,
  `id_venta` int(15) NOT NULL,
  `id_producto` int(15) NOT NULL,
  `cantidad` int(15) NOT NULL,
  `precio_unitario` decimal(15,2) DEFAULT NULL,
  `total_producto` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `total_producto`) VALUES
(27, 18, 1, 30, 5000.00, 150000.00),
(28, 18, 63, 1, 2200.00, 2200.00),
(29, 19, 63, 1, 2200.00, 2200.00),
(30, 19, 40, 3, 100.00, 300.00),
(31, 19, 32, 1, 1800.00, 1800.00);


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

CREATE TABLE `inventario` (
  `id` INT(15) NOT NULL AUTO_INCREMENT,
  `nombre_producto` VARCHAR(100) DEFAULT NULL,
  `stock` INT(15) DEFAULT NULL,
  `precio_venta` DECIMAL(15,2) DEFAULT NULL,
  `tipo` ENUM('Cabeza', 'Pies', 'Torso', 'ArmaPrimaria', 'ArmaSecundaria') NOT NULL,
  `descripcion` TEXT DEFAULT NULL,
  `rareza` ENUM('Comun', 'Rara', 'Epica', 'Legendaria') NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO inventario (nombre_producto, tipo, stock, precio_venta, rareza, image, descripcion) VALUES

('Armadura de Runa del Guardián', 'Torso', 10, 1500.00, 'Legendaria', 'images/armadura_guardian.webp', 'Una armadura imbuida con runas de protección y resistencia.'),
('Armadura de Runa del Caído', 'Torso', 8, 1200.00, 'Epica', 'images/armadura_caido.webp', 'Forjada con las almas de guerreros caídos, otorga gran defensa.'),
('Armadura de Runa del Dragón', 'Torso', 12, 1800.00, 'Legendaria', 'images/armadura_dragon.webp', 'Cubierta de runas que aumentan la resistencia a los elementos.'),


('Casco de Runa Lunar', 'Cabeza', 15, 800.00, 'Rara', 'images/casco_lunar.webp', 'Un casco con runas que aumentan la percepción nocturna.'),
('Casco de Runa del Fénix', 'Cabeza', 10, 950.00, 'Epica', 'images/casco_fenix.webp', 'Forjado en fuego, aumenta la resistencia al calor.'),
('Casco de Runa del Centinela', 'Cabeza', 12, 1100.00, 'Legendaria', 'images/casco_centinela.webp', 'Otorga visión mágica para detectar enemigos ocultos.'),


('Botas de Runa del Viento', 'Pies', 20, 700.00, 'Rara', 'images/botas_viento.webp', 'Permiten al usuario moverse con gran agilidad.'),
('Botas de Runa de Fuego', 'Pies', 15, 900.00, 'Epica', 'images/botas_fuego.webp', 'Incrementan la velocidad al máximo nivel.'),
('Botas de Runa de la Sombra', 'Pies', 18, 1200.00, 'Legendaria', 'images/botas_sombra.webp', 'Permiten moverse en silencio absoluto.'),


('Guantes de Runa del Hechicero', 'ArmaSecundaria', 10, 600.00, 'Rara', 'images/guantes_hechicero.webp', 'Mejoran la precisión de hechizos.'),
('Guantes de Runa del Guerrero', 'ArmaSecundaria', 8, 850.00, 'Epica', 'images/guantes_guerrero.webp', 'Otorgan un golpe más poderoso.'),
('Guantes de Runa del Destino', 'ArmaSecundaria', 12, 1000.00, 'Legendaria', 'images/guantes_destino.webp', 'Permiten predecir los movimientos del enemigo.'),

('Escudo de Runa de la Montaña', 'ArmaSecundaria', 10, 1100.00, 'Epica', 'images/escudo_montana.webp', 'Irrompible gracias a sus runas antiguas.'),
('Escudo de Runa del Ocaso', 'ArmaSecundaria', 8, 1250.00, 'Legendaria', 'images/escudo_ocaso.webp', 'Absorbe la luz del entorno y la usa como defensa.'),
('Escudo de Runa Sagrada', 'ArmaSecundaria', 12, 1400.00, 'Legendaria', 'images/escudo_sagrado.webp', 'Emite un aura de protección divina.'),


('Espada de Runa Celestial', 'ArmaPrimaria', 5, 2500.00, 'Legendaria', 'images/espada_celestial.webp', 'Una espada imbuida con el poder de los dioses.'),
('Espada de Runa Santa', 'ArmaPrimaria', 6, 2300.00, 'Epica', 'images/espada_santa.webp', 'Drena la energía de los enemigos no muertos al golpear.'),

('Libro de Runa Arcana', 'ArmaPrimaria', 3, 1800.00, 'Legendaria', 'images/libro_arcano.webp', 'Contiene hechizos prohibidos de gran poder.'),


('Hacha de Runa de Fuego', 'ArmaPrimaria', 4, 2200.00, 'Comun', 'images/hacha_fuego.webp', 'Cada golpe genera una llamarada.'),


('Mazo de Runa del Trueno', 'ArmaPrimaria', 3, 2000.00, 'Epica', 'images/mazo_trueno.webp', 'Causa temblores y descargas electricas al impactar.'),


('Vara Corta de Runa Astral', 'ArmaPrimaria', 5, 1600.00, 'Rara', 'images/vara_astral.webp', 'Amplifica la canalización de hechizos.'),
('Vara Larga de Runa Celestial', 'ArmaPrimaria', 4, 1900.00, 'Legendaria', 'images/vara_celestial.webp', 'Otorga gran poder mágico.'),


('Kunai Doble de Runa Sombría', 'ArmaPrimaria', 6, 1500.00, 'Epica', 'images/kunai_sombrio.webp', 'Perfectos para ataques veloces y silenciosos.'),


('Arco de Runa del Destino', 'ArmaPrimaria', 4, 2400.00, 'Legendaria', 'images/arco_destino.webp', 'Las flechas siempre encuentran su objetivo.'),


('Daga de Runa del Lobo', 'ArmaPrimaria', 7, 1300.00, 'Rara', 'images/daga_lobo.webp', 'Otorga velocidad al usuario.');




CREATE TABLE `stats` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `inventario_id` INT NOT NULL,
  `vida` INT NOT NULL DEFAULT 0 CHECK (vida BETWEEN 0 AND 999),
  `ataque` INT NOT NULL DEFAULT 0 CHECK (ataque BETWEEN 0 AND 999),
  `defensa` INT NOT NULL DEFAULT 0 CHECK (defensa BETWEEN 0 AND 999),
  `suerte` INT NOT NULL DEFAULT 0 CHECK (suerte BETWEEN 0 AND 999),
  `velocidad` INT NOT NULL DEFAULT 0 CHECK (velocidad BETWEEN 0 AND 999),
  `resistencia` INT NOT NULL DEFAULT 0 CHECK (resistencia BETWEEN 0 AND 999),
  `efectividad` INT NOT NULL DEFAULT 0 CHECK (efectividad BETWEEN 0 AND 999),
  FOREIGN KEY (`inventario_id`) REFERENCES `inventario`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO stats (inventario_id, vida, ataque, defensa, suerte, velocidad, resistencia, efectividad) VALUES
(1, 50, 0, 80, 10, 20, 70, 30),
(2, 40, 0, 75, 15, 25, 60, 40),
(3, 60, 0, 85, 5, 15, 80, 20),

(4, 20, 5, 30, 10, 25, 40, 35),
(5, 25, 10, 40, 5, 20, 45, 30),
(6, 30, 15, 50, 5, 15, 50, 40),

(7, 10, 5, 15, 20, 50, 20, 30),
(8, 5, 10, 10, 30, 60, 10, 40),
(9, 15, 15, 20, 25, 70, 15, 50),

(10, 0, 20, 10, 15, 30, 10, 40),
(11, 0, 30, 15, 10, 40, 15, 50),
(12, 0, 40, 20, 5, 50, 20, 60),

(13, 0, 10, 80, 20, 10, 90, 40),
(14, 0, 20, 90, 10, 5, 95, 50),
(15, 0, 15, 85, 15, 15, 85, 45),

(16, 0, 90, 10, 5, 10, 10, 80),
(17, 0, 85, 15, 10, 15, 15, 75),

(18, 0, 60, 5, 30, 5, 10, 70),
(19, 0, 70, 10, 25, 10, 15, 65),
(20, 0, 50, 15, 40, 15, 20, 60),

(21, 0, 20, 5, 50, 25, 10, 55),
(22, 0, 40, 10, 40, 20, 15, 50),

(23, 0, 35, 5, 35, 35, 10, 45),
(24, 0, 25, 10, 20, 50, 15, 40),

(25, 0, 45, 15, 25, 45, 15, 60);


CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'vendedor'),
(2, 'comprador');


CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `usuarios` (`id`, `username`, `password`, `rol_id`) VALUES
(1, 'vendedor', 'vendedor', 1),
(2, 'comprador', 'comprador', 2);


CREATE TABLE `ventas` (
  `id` int(15) NOT NULL,
  `fecha` date DEFAULT NULL,
  `total_final` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
(14, '2024-12-09', 20000.00),
(15, '2024-12-14', 30000.00),
(16, '2024-12-14', 35200.00),
(17, '2024-12-14', 30000.00),
(18, '2024-12-14', 304400.00),
(19, '2024-12-14', 8600.00);

ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);


ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `detalle_ventas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;


ALTER TABLE `inventario`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;


ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `ventas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;


ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `inventario` (`id`) ON DELETE CASCADE;
COMMIT;
