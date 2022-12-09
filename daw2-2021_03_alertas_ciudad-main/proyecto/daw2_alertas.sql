-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-01-2022 a las 03:03:31
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `daw2_alertas`
--
CREATE DATABASE IF NOT EXISTS `daw2_alertas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `daw2_alertas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas`
--

DROP TABLE IF EXISTS `alertas`;
CREATE TABLE `alertas` (
  `id` int(12) UNSIGNED NOT NULL,
  `titulo` text NOT NULL COMMENT 'Titulo corto para la alerta.',
  `descripcion` text DEFAULT NULL COMMENT 'Descripción breve de la alerta o NULL si no es necesaria.',
  `fecha_inicio` datetime DEFAULT NULL COMMENT 'Fecha y Hora de inicio/activación de la alerta o NULL si no se conoce (mostrar próximamente).',
  `duracion_estimada` int(6) NOT NULL DEFAULT 0 COMMENT 'Tiempo en Minutos de duración estimada de la alerta, si es CERO no se conoce o no es relevante.',
  `direccion` text DEFAULT NULL COMMENT 'Dirección concreta del lugar de la alerta o NULL si no se conoce, aunque no debería estar vacío este dato.',
  `notas_lugar` text DEFAULT NULL COMMENT 'Notas adicionales sobre el lugar de la alerta que no forman parte de la dirección o de las indicaciones, o NULL si no hay.',
  `area_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Area/Zona de la alerta o CERO si no existe o aún no está indicado (como si fuera NULL).',
  `detalles` text DEFAULT NULL COMMENT 'Detalles de la alerta si es necesario o NULL si no hay.',
  `notas` text DEFAULT NULL COMMENT 'Notas adicionales sobre la alerta que no forman parte de las posibles notas anteriores o NULL si no hay.',
  `url` text DEFAULT NULL COMMENT 'Dirección web externa (opcional) que enlaza con otra página o NULL si no hay.',
  `imagen_id` varchar(40) DEFAULT NULL COMMENT 'Nombre identificativo (fichero interno) con la imagen principal o "de presentación" de la alerta, o NULL si no hay.',
  `imagen_revisada` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicador de imagen revisada por un administrador o moderador: 0=No, 1=Si.',
  `categoria_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Categoría de la alerta o CERO si no existe o aún no está indicada (como si fuera NULL).',
  `activada` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Indicador de alerta para mostrar la alerta a los usuarios o solo para los creadores/administraddores: 0=Desactivada, 1=Activa.',
  `visible` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Indicador de alerta visible a los usuarios o invisible (se está manteniendo): 0=Invisible, 1=Visible.',
  `terminada` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicador de alerta terminada: 0=No, 1=Realizada, 2=Suspendida, 3=Cancelada por Inadecuada, ...',
  `fecha_terminacion` datetime DEFAULT NULL COMMENT 'Fecha y Hora de terminación de la alerta. Debería estar a NULL si no está terminada.',
  `notas_terminacion` text DEFAULT NULL COMMENT 'Notas visibles sobre el motivo de la terminación de la alerta.',
  `num_denuncias` int(9) NOT NULL DEFAULT 0 COMMENT 'Contador de denuncias de la alerta o CERO si no ha tenido.',
  `fecha_denuncia1` datetime DEFAULT NULL COMMENT 'Fecha y Hora de la primera denuncia. Debería estar a NULL si no tiene denuncias (contador a cero), o si el contador se reinicia.',
  `bloqueada` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicador de alerta bloqueada: 0=No, 1=Si(bloqueada por denuncias), 2=Si(bloqueada por administrador), 3=Si(bloqueada por moderador), ...',
  `bloqueo_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha bloqueado la alerta o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.',
  `bloqueo_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora del bloqueo de la alerta. Debería estar a NULL si no está bloqueada o si se desbloquea.',
  `bloqueo_notas` text DEFAULT NULL COMMENT 'Notas visibles sobre el motivo del bloqueo de la alerta o NULL si no hay -se muestra por defecto según indique "bloqueada"-.',
  `crea_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha creado la alerta o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `crea_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora de creación de la alerta o NULL si no se conoce por algún motivo.',
  `modi_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha modificado la alerta por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `modi_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora de la última modificación de la alerta o NULL si no se conoce por algún motivo.',
  `notas_admin` text DEFAULT NULL COMMENT 'Notas adicionales para los administradores sobre la alerta o NULL si no hay.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alertas`
--

INSERT INTO `alertas` (`id`, `titulo`, `descripcion`, `fecha_inicio`, `duracion_estimada`, `direccion`, `notas_lugar`, `area_id`, `detalles`, `notas`, `url`, `imagen_id`, `imagen_revisada`, `categoria_id`, `activada`, `visible`, `terminada`, `fecha_terminacion`, `notas_terminacion`, `num_denuncias`, `fecha_denuncia1`, `bloqueada`, `bloqueo_usuario_id`, `bloqueo_fecha`, `bloqueo_notas`, `crea_usuario_id`, `crea_fecha`, `modi_usuario_id`, `modi_fecha`, `notas_admin`) VALUES
(4859720, 'Atasco', 'Ha habido un atasco ', '2022-01-04 23:10:41', 3, 'avenida manolita', 'Colisión entre dos coches', 1, 'La gente está agresiva', 'Se necesita policía', '', 'https://www.google.com/url?sa=i&url=http', 1, 2, 1, 1, 1, '2022-01-04 23:10:41', 'Resstablecer alarma', 9, '2022-01-04 23:10:41', 2, 3, '2022-01-04 23:10:41', '', 0, '2022-01-04 23:10:41', 0, '2022-01-04 23:10:41', '---'),
(8952410, 'Atraco ', 'Atraco a mano armada en tienda', '2022-01-04 23:47:34', 0, 'c/cuatro caminos ', 'Robo en joyeria lobres a punta de pistola ', 2, 'El atracador es agresivo y tiene varias armas', 'Se necesita policia y ambulancia', '', 'https://www.google.com/url?sa=i&url=http', 0, 1, 1, 1, 0, '2022-01-23 23:47:34', 'El atracador ha sido ejecutado', 5, '2022-01-04 23:47:34', 0, 0, '2022-01-04 23:47:34', 'La alarma ha sido destruida por el atracador', 0, '2022-01-04 23:47:34', 0, '2022-01-04 23:47:34', '---'),
(8974521, 'Accidente de tráfico', 'Colisión frontal entre turismo y motocicleta', '2022-01-05 23:10:41', 1, 'Avenida chamartín', 'Tráfico cortado', 3, 'No hay detalles', 'Se necesita grúa', NULL, 'https://www.google.com/url?sa=i&url=http', 0, 0, 1, 1, 1, '2022-01-06 23:10:41', 'El conductor de la motocicleta ha fallecido', 1, '2022-01-05 23:10:41', 0, 0, '2022-01-04 23:10:41', '---', 0, '2022-01-04 23:10:41', 0, '2022-01-04 23:10:41', '---');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerta_comentarios`
--

DROP TABLE IF EXISTS `alerta_comentarios`;
CREATE TABLE `alerta_comentarios` (
  `id` int(12) UNSIGNED NOT NULL,
  `alerta_id` int(12) UNSIGNED NOT NULL COMMENT 'Alerta relacionada',
  `crea_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha creado el comentario o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `crea_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora de creación del comentario o NULL si no se conoce por algún motivo.',
  `modi_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha modificado el comentario por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `modi_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora de la última modificación del comentario o NULL si no se conoce por algún motivo.',
  `texto` text NOT NULL COMMENT 'El texto del comentario.',
  `comentario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Comentario relacionado, si se permiten encadenar respuestas. Nodo padre de la jerarquia de comentarios, CERO si es nodo raiz.',
  `cerrado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicador de cierre de los comentarios: 0=No, 1=Si(No se puede responder al comentario)',
  `num_denuncias` int(9) NOT NULL DEFAULT 0 COMMENT 'Contador de denuncias del comentario o CERO si no ha tenido.',
  `fecha_denuncia1` datetime DEFAULT NULL COMMENT 'Fecha y Hora de la primera denuncia. Debería estar a NULL si no tiene denuncias (contador a cero), o si el contador se reinicia.',
  `bloqueado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicador de comentario bloqueado: 0=No, 1=Si(bloqueado por denuncias), 2=Si(bloqueado por administrador), 3=Si(bloqueado por moderador), ...',
  `bloqueo_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha bloqueado el comentario o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.',
  `bloqueo_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora del bloqueo del comentario. Debería estar a NULL si no está bloqueado o si se desbloquea.',
  `bloqueo_notas` text DEFAULT NULL COMMENT 'Notas visibles sobre el motivo del bloqueo del comentario o NULL si no hay -se muestra por defecto según indique "bloqueado"-.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alerta_comentarios`
--

INSERT INTO `alerta_comentarios` (`id`, `alerta_id`, `crea_usuario_id`, `crea_fecha`, `modi_usuario_id`, `modi_fecha`, `texto`, `comentario_id`, `cerrado`, `num_denuncias`, `fecha_denuncia1`, `bloqueado`, `bloqueo_usuario_id`, `bloqueo_fecha`, `bloqueo_notas`) VALUES
(8974525, 4859720, 0, NULL, 0, NULL, 'El atasco aun no se ha resuelto', 0, 0, 0, NULL, 0, 0, NULL, ''),
(8974526, 8952410, 0, NULL, 0, NULL, 'El atraco se realiza a mano armada', 0, 0, 0, NULL, 0, 0, NULL, ''),
(8974527, 8974521, 0, NULL, 0, NULL, 'se han chocado dos coches xd', 0, 0, 0, NULL, 0, 0, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerta_etiquetas`
--

DROP TABLE IF EXISTS `alerta_etiquetas`;
CREATE TABLE `alerta_etiquetas` (
  `id` int(12) UNSIGNED NOT NULL,
  `alerta_id` int(12) UNSIGNED NOT NULL COMMENT 'Alerta relacionada',
  `etiqueta_id` int(12) UNSIGNED NOT NULL COMMENT 'Etiqueta relacionada.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alerta_etiquetas`
--

INSERT INTO `alerta_etiquetas` (`id`, `alerta_id`, `etiqueta_id`) VALUES
(1, 4859720, 2514759),
(2, 8952410, 9654712),
(3, 8974521, 231546);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerta_imagenes`
--

DROP TABLE IF EXISTS `alerta_imagenes`;
CREATE TABLE `alerta_imagenes` (
  `id` int(12) UNSIGNED NOT NULL,
  `alerta_id` int(12) UNSIGNED NOT NULL COMMENT 'Alerta relacionada',
  `orden` int(3) NOT NULL DEFAULT 0 COMMENT 'Orden de aparición de la imagen dentro del grupo de imagenes de la alerta. Opcional.',
  `imagen_id` varchar(40) NOT NULL COMMENT 'Nombre identificativo (fichero interno) con la imagen para la alerta, aqui no puede ser NULL si no hay.',
  `imagen_revisada` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicador de imagen revisada por un administrador o moderador: 0=No, 1=Si.',
  `crea_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha creado la alerta o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `crea_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora de creación de la alerta o NULL si no se conoce por algún motivo.',
  `modi_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha modificado la alerta por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `modi_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora de la última modificación de la alerta o NULL si no se conoce por algún motivo.',
  `notas_admin` text DEFAULT NULL COMMENT 'Notas adicionales para los administradores sobre la alerta o NULL si no hay.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alerta_imagenes`
--

INSERT INTO `alerta_imagenes` (`id`, `alerta_id`, `orden`, `imagen_id`, `imagen_revisada`, `crea_usuario_id`, `crea_fecha`, `modi_usuario_id`, `modi_fecha`, `notas_admin`) VALUES
(1, 4859720, 0, 'https://www.google.com/url?sa=i&url=http', 1, 0, '2022-01-06 21:50:09', 0, '2022-01-06 21:50:09', 'No hay notas'),
(2, 8952410, 0, 'https://www.google.com/url?sa=i&url=http', 0, 0, '2022-01-06 21:50:09', 0, '2022-01-06 21:50:09', 'No hay notas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(12) UNSIGNED NOT NULL,
  `clase_area_id` tinyint(2) NOT NULL COMMENT 'Código de clase de area: 0=Planeta, 1=Continente, 2=Pais, 3=Estado, 4=Region, 5=Provincia, 6=Municipio, 7=Localidad, 8=Barrio, 9=Zona, ...',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre del area que lo identifica.',
  `area_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Area relacionada. Nodo padre de la jerarquia o CERO si es nodo raiz.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `clase_area_id`, `nombre`, `area_id`) VALUES
(1, 1, 'europa', 0),
(2, 1, 'españa', 1),
(3, 1, 'italia', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(12) UNSIGNED NOT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `descripcion` text DEFAULT NULL COMMENT 'Texto adicional que describe la categoria o clasificación para las etiquetas que engloba.',
  `categoria_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Categoria relacionada. Nodo padre de la jerarquia o CERO si es nodo raiz.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `categoria_id`) VALUES
(1, 'Evento', 'Cualquier evento', NULL),
(2, 'Climatológica', 'Cualquier alerta climatológica', NULL),
(3, 'Tráfico', 'Cualquier alerta de tráfico', NULL),
(4, 'Sucesos', 'Cualquier alerta de sucesos', NULL),
(5, 'Incidencias ciudad', 'Cualquier tipo de incidencia en ciudad', NULL),
(6, 'Concierto', 'Evento concierto', 1),
(7, 'Evento Deportivo', 'Cualquier evento deportivo', 1),
(8, 'Fiesta popular', 'Evento fiesta popular', 1),
(9, 'Fútbol', 'Evento futbolístico', 7),
(10, 'Baloncesto', 'Evento baloncestístico', 7),
(11, 'Tenis', 'Evento tenístico', 7),
(12, 'Comilona', 'Evento de comida popular', 8),
(13, 'Fiesta local', 'Fiestas locales-patronales...', 8),
(14, 'Viento', 'Alerta de viento', 2),
(15, 'Lluvia', 'Alerta de lluvia ', 2),
(16, 'Atasco', 'Alerta de atasco', 3),
(17, 'Accidente', 'Alerta de accidente', 3),
(18, 'Radar', 'Alerta de radar', 3),
(19, 'Robo', 'Alerta de robo', 4),
(20, 'Desperfectos', 'Alerta de desperfectos en mobiliario, aceras...', 5),
(21, 'Otras', 'Cualquier otro tipo no definido', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_etiquetas`
--

DROP TABLE IF EXISTS `categorias_etiquetas`;
CREATE TABLE `categorias_etiquetas` (
  `id` int(12) UNSIGNED NOT NULL,
  `categoria_id` int(12) UNSIGNED NOT NULL COMMENT 'Clasificacion relacionada, para saber a que grupo pertenece.',
  `etiqueta_id` int(12) UNSIGNED NOT NULL COMMENT 'Etiqueta relacionada.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
CREATE TABLE `configuraciones` (
  `variable` varchar(40) NOT NULL,
  `valor` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuraciones`
--

INSERT INTO `configuraciones` (`variable`, `valor`) VALUES
('dias_incidencias_borradas', '30'),
('dias_incidencias_leidas', '60'),
('numero_alertas_portada', '30'),
('numero_denuncias_alerta', '7'),
('numero_denuncias_comentario', '3'),
('numero_intentos_usuario', '5'),
('numero_lineas_pagina', '25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE `etiquetas` (
  `id` int(12) UNSIGNED NOT NULL,
  `nombre` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `etiquetas`
--

INSERT INTO `etiquetas` (`id`, `nombre`) VALUES
(1, 'atraco'),
(2, 'atasco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(12) UNSIGNED NOT NULL,
  `crea_fecha` datetime NOT NULL COMMENT 'Fecha y Hora del mensaje de LOG.',
  `clase_log_id` char(1) NOT NULL COMMENT 'código de clase de log: E=Error, A=Aviso, S=Seguimiento, I=Información, D=Depuración, ...',
  `modulo` varchar(40) DEFAULT 'app' COMMENT 'Modulo o Sección de la aplicación que ha generado el mensaje de LOG.',
  `texto` text DEFAULT NULL COMMENT 'Texto con el mensaje de LOG.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(12) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'Correo Electronico y "login" del usuario.',
  `password` varchar(60) NOT NULL,
  `nick` varchar(25) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL COMMENT 'Fecha de nacimiento del usuario o NULL si no lo quiere informar.',
  `direccion` text DEFAULT NULL COMMENT 'Direccion del usuario o NULL si no quiere informar.',
  `area_id` int(12) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Area/Zona de localización del usuario o CERO si no lo quiere informar (como si fuera NULL), aunque es recomendable.',
  `rol` char(1) NOT NULL COMMENT 'Código de la Clase / Tipo de Perfil: N=Normal, M=Moderador, A=Administrador, S=SysAdmin',
  `fecha_registro` datetime DEFAULT NULL COMMENT 'Fecha y Hora de registro del usuario o NULL si no se conoce por algún motivo (que no debería ser).',
  `confirmado` tinyint(1) NOT NULL COMMENT 'Indicador de usuario ha confirmado su registro o no.',
  `fecha_acceso` datetime DEFAULT NULL COMMENT 'Fecha y Hora del ultimo acceso del usuario. Debería estar a NULL si no ha accedido nunca.',
  `num_accesos` int(9) NOT NULL DEFAULT 0 COMMENT 'Contador de accesos fallidos del usuario o CERO si no ha tenido o se ha reiniciado por un acceso valido o por un administrador.',
  `bloqueado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicador de usuario bloqueado: 0=No, 1=Si(bloqueado por fallos de acceso), 2=Si(bloqueado por administrador), 3=Si(bloqueado por moderador), ...',
  `bloqueo_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario que ha bloqueado el usuario o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.',
  `bloqueo_fecha` datetime DEFAULT NULL COMMENT 'Fecha y Hora del bloqueo del usuario. Debería estar a NULL si no está bloqueado o si se desbloquea.',
  `bloqueo_notas` text DEFAULT NULL COMMENT 'Notas visibles sobre el motivo del bloqueo del usuario o NULL si no hay -se muestra por defecto según indique "bloqueado"-.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nick`, `nombre`, `apellidos`, `fecha_nacimiento`, `direccion`, `area_id`, `rol`, `fecha_registro`, `confirmado`, `fecha_acceso`, `num_accesos`, `bloqueado`, `bloqueo_usuario_id`, `bloqueo_fecha`, `bloqueo_notas`) VALUES
(7, 'sysadmin@usuarioyii.com', 'fstC9C5R8CAkI', 'sysAdmin', 'sysAdmin', 'Apellido1 Apellido2', NULL, '', 0, 'S', '2022-01-11 00:39:52', 1, NULL, 0, 0, 0, NULL, NULL),
(8, 'administrador@usuarioyii.com', 'fsP33Rmej4VL6', 'administrador', 'administrador', 'Apellido1 Apellido2', NULL, NULL, 0, 'A', '2022-01-11 00:46:10', 1, NULL, 0, 0, 0, NULL, NULL),
(9, 'moderador@usuarioyii.com', 'fsZOZB6hXbXOM', 'moderador', 'moderador', 'Apellido1 Apellido2', NULL, NULL, 0, 'M', '2022-01-11 00:46:38', 1, NULL, 0, 0, 0, NULL, NULL),
(10, 'usuariovalido@usuarioyii.com', 'fsMQwHSDJFkrU', 'usuariovalido', 'usuariovalido', 'Apellido1 Apellido2', NULL, NULL, 0, 'N', '2022-01-11 00:47:26', 1, NULL, 0, 0, 0, NULL, NULL),
(11, 'usuariobloqueado@usuarioyii.com', 'fsTi8Xqurf5Vc', 'usuariobloqueado', 'usuariobloqueado', 'Apellido1 Apellido2', NULL, NULL, 0, 'N', '2022-01-11 00:48:09', 1, NULL, 0, 1, 0, NULL, NULL),
(12, 'usuariosinconfirmar@usuariosyii.com', 'fsFdjWyrVuluY', 'usuariosinconfirmar', 'usuariosinconfirmar', 'Apellido1 Apellido2', NULL, NULL, 0, 'N', '2022-01-11 00:49:21', 0, NULL, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_area_moderacion`
--

DROP TABLE IF EXISTS `usuarios_area_moderacion`;
CREATE TABLE `usuarios_area_moderacion` (
  `id` int(12) UNSIGNED NOT NULL,
  `usuario_id` int(12) UNSIGNED NOT NULL COMMENT 'Usuario relacionado con un Area para su moderación.',
  `area_id` int(12) UNSIGNED NOT NULL COMMENT 'Area relacionada con el Usuario que puede moderarla.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_incidencias`
--

DROP TABLE IF EXISTS `usuario_incidencias`;
CREATE TABLE `usuario_incidencias` (
  `id` int(12) UNSIGNED NOT NULL,
  `crea_fecha` datetime NOT NULL COMMENT 'Fecha y Hora de creación de la incidencia.',
  `clase_incidencia_id` char(1) NOT NULL DEFAULT 'M' COMMENT 'código de clase de incidencia: A=Aviso, N=Notificación, D=Denuncia, C=Consulta, M=Mensaje Genérico,...',
  `texto` text DEFAULT NULL COMMENT 'Texto con el mensaje de incidencia.',
  `destino_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario relacionado, destinatario de la incidencia, o NULL si no es para administración y no está gestionado.',
  `origen_usuario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Usuario relacionado, origen de la incidencia, o NULL si es del sistema.',
  `alerta_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'alerta relacionada o NULL si no tiene que ver con una alerta.',
  `comentario_id` int(12) UNSIGNED DEFAULT 0 COMMENT 'Comentario relacionado o NULL si no tiene que ver con un comentario.',
  `fecha_lectura` datetime DEFAULT NULL COMMENT 'Fecha y Hora de lectura de la incidencia o NULL si no se ha leido o se ha desmarcado como tal.',
  `fecha_borrado` datetime DEFAULT NULL COMMENT 'Fecha y Hora de la marca de borrado de la incidencia o NULL si no se ha marcado como borrado.',
  `fecha_aceptado` datetime DEFAULT NULL COMMENT 'Fecha y Hora de aceptación de la incidencia o NULL si no se ha aceptado para su gestión por un moderador o administrador. No se usa en otros usuarios.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `alerta_comentarios`
--
ALTER TABLE `alerta_comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `alerta_etiquetas`
--
ALTER TABLE `alerta_etiquetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `alerta_imagenes`
--
ALTER TABLE `alerta_imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias_etiquetas`
--
ALTER TABLE `categorias_etiquetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD PRIMARY KEY (`variable`);

--
-- Indices de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indices de la tabla `usuarios_area_moderacion`
--
ALTER TABLE `usuarios_area_moderacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_incidencias`
--
ALTER TABLE `usuario_incidencias`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas`
--
ALTER TABLE `alertas`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8974522;

--
-- AUTO_INCREMENT de la tabla `alerta_comentarios`
--
ALTER TABLE `alerta_comentarios`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8974528;

--
-- AUTO_INCREMENT de la tabla `alerta_etiquetas`
--
ALTER TABLE `alerta_etiquetas`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `alerta_imagenes`
--
ALTER TABLE `alerta_imagenes`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `categorias_etiquetas`
--
ALTER TABLE `categorias_etiquetas`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33800;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios_area_moderacion`
--
ALTER TABLE `usuarios_area_moderacion`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_incidencias`
--
ALTER TABLE `usuario_incidencias`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4859736;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
