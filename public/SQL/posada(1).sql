-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 11-01-2025 a las 06:15:08
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `posada`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `habitacion_id` int NOT NULL,
  `num` int DEFAULT NULL,
  `num_camas` int DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `estado` enum('libre','ocupada','reservada','no_disponible') DEFAULT 'libre',
  `fecha` datetime DEFAULT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`habitacion_id`, `num`, `num_camas`, `precio`, `estado`, `fecha`, `observaciones`) VALUES
(1, 12, 2, 3000, 'libre', '2025-01-11 02:22:08', 'Sin observaciones 2222'),
(2, 1, 1, 2300, 'libre', '2025-01-10 20:16:52', 'Habitacion para reservada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loginfails`
--

CREATE TABLE `loginfails` (
  `id_fail` int UNSIGNED NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `loginfails`
--

INSERT INTO `loginfails` (`id_fail`, `user_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(0, '1', '127.0.0.1', NULL, NULL),
(0, '1', '127.0.0.1', NULL, NULL),
(0, '1', '127.0.0.1', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rentas`
--

CREATE TABLE `rentas` (
  `renta_id` int NOT NULL,
  `num_habitacion` int DEFAULT NULL,
  `tipo` int DEFAULT NULL,
  `nombre_huesped` varchar(200) DEFAULT NULL,
  `num_noches` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  `observaciones` text,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `reservacion_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido_p` varchar(45) NOT NULL,
  `apellido_m` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `admin` int DEFAULT '0',
  `empleado` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `nombre`, `apellido_p`, `apellido_m`, `email`, `user`, `password`, `type`, `created_at`, `updated_at`, `deleted_at`, `admin`, `empleado`) VALUES
(1, 'Roberto', 'Vásquez', 'Alcántara', 'roberto_ale@live.com.mx', 'roberto', '$2y$10$Uqr0ya9BbE44cqnKPbdlTe/9X.m7jw4cLEPaMYpVgJ0GieB.Tnd/C', '1', '2023-03-28 00:55:24', NULL, NULL, 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`habitacion_id`);

--
-- Indices de la tabla `rentas`
--
ALTER TABLE `rentas`
  ADD PRIMARY KEY (`renta_id`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`reservacion_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `habitacion_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rentas`
--
ALTER TABLE `rentas`
  MODIFY `renta_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `reservacion_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
