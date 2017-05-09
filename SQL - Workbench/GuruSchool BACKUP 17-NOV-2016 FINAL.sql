-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-11-2016 a las 16:29:30
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `GuruSchool`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Certificados_Usuarios`
--

CREATE TABLE `Certificados_Usuarios` (
  `Id_Pk_Certificado` int(11) NOT NULL,
  `Int_Fk_IdUsuario` int(11) NOT NULL,
  `Int_IdCurso` int(11) DEFAULT NULL,
  `Vc_NumberCertified` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Certificados_Usuarios`
--

INSERT INTO `Certificados_Usuarios` (`Id_Pk_Certificado`, `Int_Fk_IdUsuario`, `Int_IdCurso`, `Vc_NumberCertified`) VALUES
(2, 16, 2, '14706917042830'),
(3, 17, 2, '14706957733120'),
(4, 16, 7, '14716439729100'),
(5, 16, 9, '14774575364797');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cobros_Admin`
--

CREATE TABLE `Cobros_Admin` (
  `Id_Pk_Cobros` int(11) NOT NULL,
  `Int_Id_GUsuario` int(11) DEFAULT NULL,
  `Int_Id_Curso` int(11) DEFAULT NULL,
  `Int_MontoCurso` int(11) DEFAULT NULL,
  `Vc_EstadoCobro` varchar(45) DEFAULT NULL,
  `Da_FechaCobro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Cobros_Admin`
--

INSERT INTO `Cobros_Admin` (`Id_Pk_Cobros`, `Int_Id_GUsuario`, `Int_Id_Curso`, `Int_MontoCurso`, `Vc_EstadoCobro`, `Da_FechaCobro`) VALUES
(1, 16, 7, 420000, 'Pending', '2016-08-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cobros_Realizados`
--

CREATE TABLE `Cobros_Realizados` (
  `Id_Pk_CobrosRelizados` int(11) NOT NULL,
  `Int_Id_GUsuario` int(11) DEFAULT NULL,
  `Int_Id_Curso` int(11) DEFAULT NULL,
  `Int_MontoCurso` int(11) DEFAULT NULL,
  `Vc_EstadoCobro` varchar(45) DEFAULT NULL,
  `Da_FechaPago` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cobros_Usuarios`
--

CREATE TABLE `Cobros_Usuarios` (
  `Id_Pk_CobrosUsuarios` int(11) NOT NULL,
  `Int_Fk_GUsuario` int(11) DEFAULT NULL,
  `Int_Id_Curso` int(11) DEFAULT NULL,
  `Int_MontoCobrado` int(11) DEFAULT NULL,
  `Vc_EstadoCobro` varchar(50) DEFAULT NULL,
  `Da_FechaCobro` date DEFAULT NULL,
  `Int_NumerPay` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Cobros_Usuarios`
--

INSERT INTO `Cobros_Usuarios` (`Id_Pk_CobrosUsuarios`, `Int_Fk_GUsuario`, `Int_Id_Curso`, `Int_MontoCobrado`, `Vc_EstadoCobro`, `Da_FechaCobro`, `Int_NumerPay`) VALUES
(1, 16, 7, 420000, 'Execute', '2016-08-24', 2147483647);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Categorias`
--

CREATE TABLE `G_Categorias` (
  `Id_Pk_Categorias` int(11) NOT NULL,
  `Vc_NombreCat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Categorias`
--

INSERT INTO `G_Categorias` (`Id_Pk_Categorias`, `Vc_NombreCat`) VALUES
(8, 'TecnologÃ­a'),
(9, 'Negocios'),
(10, 'Productividad'),
(11, 'Desarrollo-Personal'),
(12, 'Idiomas'),
(13, 'GastronomÃ­a'),
(14, 'Cultura'),
(15, 'AcadÃ©micos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Comments_Foro`
--

CREATE TABLE `G_Comments_Foro` (
  `Id_Pk_CommentsForo` int(11) NOT NULL,
  `Int_Fk_IdPreguntaForo` int(11) NOT NULL,
  `Int_Usuario` int(11) DEFAULT NULL,
  `Txt_Comment` text,
  `Vc_DateAdded` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Comments_Foro`
--

INSERT INTO `G_Comments_Foro` (`Id_Pk_CommentsForo`, `Int_Fk_IdPreguntaForo`, `Int_Usuario`, `Txt_Comment`, `Vc_DateAdded`) VALUES
(1, 5, 16, 'Si seÃ±or, pierda cuidado', NULL),
(2, 5, 16, 'si seÃ±or, como no.', NULL),
(3, 5, 17, 'no seÃ±or, no pued epreguntar ahora', NULL),
(4, 6, 16, 'Para que publica, si no hay nada qu e peguntar??', NULL),
(5, 7, 16, 'Ese curso estÃ¡ como que fallando, toca tener paciencia mientras lo arreglan.', NULL),
(6, 7, 18, 'Ahhh perfecto, muchas gracias caballero', NULL),
(7, 5, 16, 'Bueno, ya preguntarÃ©', NULL),
(8, 6, 16, 'jajajajaja', NULL),
(9, 7, 16, 'De nada, es para servirle.', NULL),
(10, 7, 16, 'asdasdad', NULL),
(11, 7, 16, 'asdasdasd', NULL),
(12, 7, 16, 'funciona?\n', NULL),
(13, 7, 18, 'Ya funciona, mil gracias\n', NULL),
(14, 7, 16, 'esoa sdas', NULL),
(15, 6, 16, 'pregunta pues', NULL),
(16, 6, 17, 'ya ome', NULL),
(17, 9, 21, 'aahh ya lo logreÃ¡', NULL),
(18, 9, 16, 'si?', NULL),
(19, 9, 16, 'cuenteme\n', NULL),
(20, 9, 16, 'como?', NULL),
(21, 6, 16, 'ESTOY PREGUNTANDO', NULL),
(22, 6, 17, 'pregunte amigo.', NULL),
(23, 6, 17, 'ya ando en esas', NULL),
(24, 6, 16, 'por eso le pregunto viejo.', NULL),
(25, 6, 16, 'No pregunte pendejadas', NULL),
(26, 6, 17, 'No jodas', NULL),
(27, 10, 16, 'respuesta', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Cuenta_Usuario`
--

CREATE TABLE `G_Cuenta_Usuario` (
  `Id_Pk_CuentaUsuario` int(11) NOT NULL,
  `Vc_Cuenta` varchar(180) DEFAULT NULL,
  `Int_Fk_DatosUsuario` int(11) NOT NULL,
  `Vc_EmailPaypal` varchar(100) DEFAULT NULL,
  `Vc_Banco` varchar(100) DEFAULT NULL,
  `Int_Total_Cuenta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Cuenta_Usuario`
--

INSERT INTO `G_Cuenta_Usuario` (`Id_Pk_CuentaUsuario`, `Vc_Cuenta`, `Int_Fk_DatosUsuario`, `Vc_EmailPaypal`, `Vc_Banco`, `Int_Total_Cuenta`) VALUES
(1, 'VmtaYVUxRnJNWEpPV0VaYVpXdEtVRlpyV25KbFJsSllXWHBzVVZWVU1Eaz0rUA==', 16, NULL, 'Quiero Recibir Pagos por Efecty', NULL),
(2, 'VmtaYVUxTnRWbkpOV0VaVFYwaENUMVpyVm5OT2JGSlpZMFZ3VVZWVU1Eaz0rUA==', 17, NULL, 'Davivienda', NULL),
(3, 'VmtaYVUxTnRWbkpPVlZaWFZrVndVRnBYTVdwTlZsRjNWV3RhVVZWVU1Eaz0rUA==', 18, NULL, 'Bancolombia', NULL),
(4, 'VmtaYVUxRnJNWEpPV0VaYVpXdEtVRlpyV25KbFJsSllXWHBzVVZWVU1Eaz0rUA==', 21, NULL, 'Quiero Recibir Pagos por Efecty', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Cursos`
--

CREATE TABLE `G_Cursos` (
  `Id_Pk_Curso` int(11) NOT NULL,
  `Int_Fk_IdCat` int(11) NOT NULL,
  `Int_Fk_IdUsuario` int(11) NOT NULL,
  `Vc_NombreCurso` varchar(150) DEFAULT NULL,
  `Vc_ResumenCurso` varchar(250) DEFAULT NULL,
  `Txt_DescripcionCompleta` text,
  `Vc_Categoria` varchar(50) DEFAULT NULL,
  `Vc_SubCategoria` varchar(50) DEFAULT NULL,
  `Vc_Imagen_Promocional` varchar(150) DEFAULT NULL,
  `Vc_VideoPromocional` varchar(150) DEFAULT NULL,
  `Vc_TipoCurso` varchar(50) DEFAULT NULL,
  `Vc_EstadoCurso` varchar(45) DEFAULT NULL,
  `Int_PrecioCurso` int(11) DEFAULT NULL,
  `Txt_Nota` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Cursos`
--

INSERT INTO `G_Cursos` (`Id_Pk_Curso`, `Int_Fk_IdCat`, `Int_Fk_IdUsuario`, `Vc_NombreCurso`, `Vc_ResumenCurso`, `Txt_DescripcionCompleta`, `Vc_Categoria`, `Vc_SubCategoria`, `Vc_Imagen_Promocional`, `Vc_VideoPromocional`, `Vc_TipoCurso`, `Vc_EstadoCurso`, `Int_PrecioCurso`, `Txt_Nota`) VALUES
(2, 8, 16, 'Desarrollo Web con PHP', 'A veces no hace falta pasar por B para ir de A a C. Con este curso tu cerebro creará nuevas interconexiones neuronales sobre la marcha, sin que te des cuenta.', '<p>Aprende PHP bajo otro punto de vista. PHP guay es un curso din�mico de naturaleza no lineal. Con este curso aprender�s un mont�n de cosas de forma r�pida y efectiva porque cada video trata un tema nuevo que te invita a trabajar y a investigar cosas por tu cuenta. Hay ejercicios. Por eso no es lineal, para que tus neuronas se esfuercen un poco m�s y tu cerebro vaya creando nuevas interconexiones neuronales sobre la marcha, sin que te des cuenta. Este curso es din�mico porque cada x d�as subir� un video nuevo. Deja de pasar por B y por C para ir de A a D. �Ap�ntate a PHP guay y sum�rgete ya en su torrente de informaci�n din�mica! Ideal para personas con conocimientos b�sicos de programaci�n en otros lenguajes que quieren aprender PHP r�pido. No te lo pierdas. El curso incluye ejercicios pr�cticos disponibles en GitHub</p>', 'Tecnología', 'Desarrollo Web', 'phpero.jpg', 'EscAWcHsTPg', 'Gratis', 'Publicado', 0, 'Felicidades'),
(3, 8, 17, 'Diseño Web con css3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad ', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'Tecnología', 'Desarrollo Web', 'cssero.jpg', '8J1MCby80po', 'Gratis', 'Publicado', 0, NULL),
(6, 11, 16, 'SuperaciÃ³n Personal ', 'Css3 es una herramienta que te permitirÃ¡ llegar lo suficientemente lejos a ti y a tu imaginaciÃ³n, logrando llenar expectativas muy hermosas, intentalo con este curso hoy mismo. ', '<p>Css3 es una herramienta que te permitir&aacute; llegar lo suficientemente lejos a ti y a tu imaginaci&oacute;n, logrando llenar expectativas muy hermosas, intentalo con este curso hoy mismo.</p>', 'Desarrollo-Personal', 'Desarrollo profesional', 'Res_Curso_superacion2.jpg', 'Ujqdle7CvIU', 'Gratis', 'Publicado', 0, 'Bien, su curso ha sido publicado.'),
(7, 11, 16, 'Aprende a conseguir mÃ¡s dinero', 'En este curso aprenderÃ¡s a conseguir el dinero que necesitas, aprenderÃ¡s a invertir en tu tiempo libre con optimismo a ser una persona mÃ¡s emprendedora', '<p>En este curso aprenderás a conseguir el dinero que necesitas, aprenderás a invertir en tu tiempo libre con optimismo a ser una persona más emprendedora En este curso aprenderás a conseguir el dinero que necesitas, aprenderás a invertir en tu tiempo libre con optimismo a ser una persona más emprendedora</p>', 'Desarrollo-Personal', 'Liderazgo', 'Res_Curso_superacion.jpg', NULL, 'De Pago', 'Publicado', 15000, 'Muy buen vÃ­deo, ahora goza junto tus alumnos, que la fuerza te acompaÃ±e.'),
(8, 8, 18, 'curso de mecatrÃ³nica basica', 'La ingenierÃ­a mecatrÃ³nica es una disciplina que une la ingenierÃ­a mecÃ¡nica, ingenierÃ­a electrÃ³nica, ingenierÃ­a de control e ingenierÃ­a informÃ¡tica, y sirve para diseÃ±ar', '<p>la ingeniera mecatr&oacute;nica es una de las ciencias que no te puede faltar en casa la ingeniera mecatr&oacute;nica es una de las ciencias que no te puede faltar en casa la ingeniera mecatr&oacute;nica es una de las ciencias que no te puede faltar en casa.</p>\r\n<p>la ingeniera mecatr&oacute;nica es una de las ciencias que no te puede faltar en casa la ingeniera mecatr&oacute;nica es una de las ciencias que no te puede faltar en casa la ingeniera mecatr&oacute;nica es una de las ciencias que no te puede faltar en casa.</p>\r\n<p>&nbsp;</p>', 'TecnologÃ­a', 'Hardware', 'Res_Curso_1477450131_mecatronica-1024x683.jpg', '1W4b_lEBWJQ', 'Gratis', 'Publicado', 0, 'Feliciades, tu curso ha sido publicado, ahora continÃºa con los siguientes pasos.'),
(9, 8, 17, 'Material design bÃ¡sico', 'Material design es una normativa de diseÃ±o enfocado en la visualizaciÃ³n del sistema operativo Android , ademÃ¡s en la web y en cualquier plataforma. Fue desarrollado por Google y anunciado en la conferencia Google I/O celebrada el 25 de junio de 20', '<p>Material design es una normativa de dise&ntilde;o enfocado en la visualizaci&oacute;n del sistema operativo Android , adem&aacute;s en la web y en cualquier plataforma. Fue desarrollado por Google y anunciado en la conferencia Google I/O celebrada el 25 de junio de 2014.</p>\r\n<p>Material design es una normativa de dise&ntilde;o enfocado en la visualizaci&oacute;n del sistema operativo Android , adem&aacute;s en la web y en cualquier plataforma. Fue desarrollado por Google y anunciado en la conferencia Google I/O celebrada el 25 de junio de 2014.</p>', 'TecnologÃ­a', 'Desarrollo Web', 'Res_Curso_1477452718_Google-material-design.jpg', 'KF-OddyWamg', 'Gratis', 'Publicado', 0, 'Felicidades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Datos_Usuario`
--

CREATE TABLE `G_Datos_Usuario` (
  `Id_Pk_DatosUsuario` int(11) NOT NULL,
  `Int_Fk_IdUsuario` int(11) NOT NULL,
  `Vc_NombreUsuario` varchar(100) DEFAULT NULL,
  `Int_Cedula` int(11) DEFAULT NULL,
  `Int_Edad` int(11) DEFAULT NULL,
  `Vc_Pais` varchar(50) DEFAULT NULL,
  `Vc_Ciudad` varchar(50) DEFAULT NULL,
  `Txt_ImagenUsuario` text,
  `Txt_ImagenMin` text,
  `Vc_Telefono` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Datos_Usuario`
--

INSERT INTO `G_Datos_Usuario` (`Id_Pk_DatosUsuario`, `Int_Fk_IdUsuario`, `Vc_NombreUsuario`, `Int_Cedula`, `Int_Edad`, `Vc_Pais`, `Vc_Ciudad`, `Txt_ImagenUsuario`, `Txt_ImagenMin`, `Vc_Telefono`) VALUES
(3, 16, 'Alonso Velez Marulanda', 1066745652, 21, 'Colombia', 'Moniquira', 'res_1469292255_imagen.jpg', 'min_1469292255_imagen.jpg', '3204880761'),
(4, 17, 'Ramon Valdez', 1066745652, 22, 'Colombia', 'Pereira', 'res_1469306071_Foto-perfil.jpg', 'min_1469306071_Foto-perfil.jpg', NULL),
(5, 18, 'Elizabeth Lopez Hernandez', 12312312, 24, 'Colombia', 'Moniquira', 'res_1470431122_woman-left-no-smile.jpg', 'min_1470431122_woman-left-no-smile.jpg', NULL),
(6, 21, 'Jose fajardo perez', 1066745652, 22, 'Colombia', 'Pereira', 'res_1477280816_perfil.jpg', 'min_1477280816_perfil.jpg', '3204880761');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Foro_Curso`
--

CREATE TABLE `G_Foro_Curso` (
  `Id_Pk_ForoCurso` int(11) NOT NULL,
  `Int_Fk_IdCurso` int(11) NOT NULL,
  `Int_Usuario` int(11) DEFAULT NULL,
  `Vc_Pregunta` varchar(200) DEFAULT NULL,
  `Txt_DescripcionPregunta` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Foro_Curso`
--

INSERT INTO `G_Foro_Curso` (`Id_Pk_ForoCurso`, `Int_Fk_IdCurso`, `Int_Usuario`, `Vc_Pregunta`, `Txt_DescripcionPregunta`) VALUES
(5, 2, 16, 'Buenas quiero hacer una pregunta?', 'pregunto?'),
(6, 2, 17, 'Hola, yo tambiÃ©n quisiera, hacer una pregunta.', 'pregunto? ya??'),
(7, 3, 18, 'Buenos dÃ­as, quisiera hacer una pregunta', 'como funcona el curso nÃºmero 3?'),
(8, 2, 16, 'Como es que funciona el curso?', 'Quisiera saber de que forma trabaja el curso?'),
(9, 2, 21, 'No he aprendido a manejar la plataforma', 'buenas, como aprendo a manejar la plataforma?'),
(10, 9, 16, 'pregunta', 'pregunta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Profesion_Usuario`
--

CREATE TABLE `G_Profesion_Usuario` (
  `Id_Pk_DatosProfesionalUser` int(11) NOT NULL,
  `Int_Fk_DatosUsuario` int(11) DEFAULT NULL,
  `Txt_Biografia` text,
  `Vc_Profesion` varchar(100) DEFAULT NULL,
  `Txt_Facebook` text,
  `Txt_Twitter` text,
  `Txt_Google` text,
  `Txt_LinkedIn` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Profesion_Usuario`
--

INSERT INTO `G_Profesion_Usuario` (`Id_Pk_DatosProfesionalUser`, `Int_Fk_DatosUsuario`, `Txt_Biografia`, `Vc_Profesion`, `Txt_Facebook`, `Txt_Twitter`, `Txt_Google`, `Txt_LinkedIn`) VALUES
(1, 16, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>', 'Ingeniero en sistemas, especialista en tecnologÃ­as de internet', 'https://www.facebook.com/AVMsolucion/', 'https://twitter.com/avmsolucion', 'https://plus.google.com/u/0/103163402104525523775/posts', ''),
(2, 17, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'Ingeniero en sistemas, tecnÃ³logo en desarrollo Web', 'https://www.facebook.com/escarimovy', '', '', ''),
(3, 18, '<p><span style="color: #333333; font-family: Lato, sans-serif; font-size: 17px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</span></p>', 'ingeniera mecatrÃ³nica', 'https://www.facebook.com/escarimovy', '', '', ''),
(4, 21, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>', 'Desarrollador de software', 'https://www.facebook.com/escarimovy', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Sub_Categoria`
--

CREATE TABLE `G_Sub_Categoria` (
  `Id_Pk_SubCategoria` int(11) NOT NULL,
  `Int_Fk_IdCat` int(11) NOT NULL,
  `Vc_SubCat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Sub_Categoria`
--

INSERT INTO `G_Sub_Categoria` (`Id_Pk_SubCategoria`, `Int_Fk_IdCat`, `Vc_SubCat`) VALUES
(5, 8, 'Desarrollo Web'),
(6, 8, 'Desarrollo de Software'),
(7, 8, 'Desarrollo MÃ³vil'),
(8, 8, 'DiseÃ±o GrÃ¡fico'),
(9, 8, 'Video-juegos'),
(10, 8, 'Bases de Datos'),
(11, 8, 'ProducciÃ³n de Video'),
(12, 8, 'ProducciÃ³n de FotografÃ­a'),
(13, 8, 'Marketing Digital'),
(14, 8, 'Software'),
(15, 8, 'Hardware'),
(16, 8, 'Redes'),
(17, 8, 'Seguridad InformÃ¡tica'),
(48, 9, 'Emprender'),
(49, 9, 'Finanzas'),
(50, 9, 'Ventas'),
(51, 9, 'ComunicaciÃ³n Social'),
(52, 9, 'PromociÃ³n de Ventas'),
(53, 9, 'GestiÃ³n de Proyectos'),
(54, 9, 'Bienes RaÃ­ces'),
(55, 9, 'Recursos Humanos'),
(56, 9, 'Salud Ocupacional'),
(58, 10, 'OfimÃ¡tica'),
(59, 10, 'Software de Oficina'),
(60, 10, 'Sistemas Operativos'),
(61, 11, 'Productividad'),
(62, 11, 'Liderazgo'),
(63, 11, 'Productividad en el Hogar'),
(64, 11, 'Desarrollo profesional'),
(65, 11, 'Deportes'),
(66, 11, 'EstÃ©tica'),
(67, 11, 'Salud'),
(68, 11, 'Hobbies'),
(69, 11, 'MotivaciÃ³n'),
(70, 11, 'Otros'),
(71, 12, 'InglÃ©s'),
(72, 12, 'EspaÃ±ol'),
(73, 12, 'Chino'),
(74, 12, 'ProtuguÃ©s'),
(75, 12, 'FrancÃ©s'),
(76, 12, 'Mandarin'),
(77, 12, 'Italiano'),
(78, 12, 'Ruso'),
(79, 12, 'AlemÃ¡n'),
(80, 12, 'Hebreo'),
(81, 12, 'JaponÃ©s'),
(82, 12, 'LatÃ­n'),
(83, 12, 'Otros'),
(84, 13, 'Aprender a Cocinar'),
(85, 13, 'Recetas'),
(86, 13, 'Bebidas'),
(87, 13, 'ReposterÃ­a'),
(88, 13, 'Tecno GastronomÃ­a'),
(89, 14, 'MÃºsica'),
(90, 14, 'Cine'),
(91, 14, 'Canto'),
(92, 14, 'Arte y Pintura'),
(93, 14, 'Baile'),
(94, 14, 'Manualidades'),
(95, 14, 'PolÃ­tica'),
(96, 14, 'Oratoria'),
(97, 14, 'Otros'),
(98, 15, 'Ciencias Naturales'),
(99, 15, 'Ciencias Sociales'),
(100, 15, 'MatemÃ¡ticas'),
(101, 15, 'QuÃ­mica'),
(102, 15, 'Agricultura'),
(103, 15, 'GanaderÃ­a'),
(104, 15, 'FÃ­sica MatemÃ¡tica'),
(105, 15, 'Ã‰tica'),
(106, 15, 'Historia'),
(107, 15, 'Derecho'),
(108, 15, 'EstadÃ­stica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Usuario`
--

CREATE TABLE `G_Usuario` (
  `Id_Pk_Usuario` int(11) NOT NULL,
  `Vc_Correo` varchar(45) DEFAULT NULL,
  `Vc_Password` varchar(150) DEFAULT NULL,
  `Int_NivelUsuario` int(11) DEFAULT NULL,
  `Vc_Rescue_Token` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Usuario`
--

INSERT INTO `G_Usuario` (`Id_Pk_Usuario`, `Vc_Correo`, `Vc_Password`, `Int_NivelUsuario`, `Vc_Rescue_Token`) VALUES
(16, 'avmsolucion@hotmail.com', '$2y$11$Wr5HbenDXnbBT/aj2eO7z.EHjoVOijVBnNUK7PNa3If0kTsO0yC5K', 1, NULL),
(17, 'escarimovy@hotmail.com', '$2y$11$3f4N.6.kxeJDm4TVaMS8FeoMEcU6jQhZF.scY8Hqsq3zXh62umQsG', 1, NULL),
(18, 'eliza@hotmail.com', '$2y$11$YEA9etQTaWhPd0RS61qIaumPhlfLNXNCjNpYeKMze2HlEjUCC0t9K', 1, NULL),
(19, 'admin@hotmail.com', '$2y$11$Is17eBv9xMTIoXuWF.1p2uo4gptFfbmM27nMqJ.ESg9Gxvevd6yLC', 0, NULL),
(20, 'foo-bar@example.com', '$2y$11$dAH9MnnkLxOg2P0A4zyZZOxu5RfUiyfpU9a8I5ANZgX1lCzRJgY.q', 1, NULL),
(21, 'jose@hotmail.com', '$2y$11$MwEcMXxLJVBDQ82y9lekGOsvLf5YgS5AkmQNk4pQsPXMoHzvsUiXu', 1, NULL),
(22, 'nuevo@hotmail.com', '$2y$11$JjtreNz1dBnCShyQKvxTWekPGAVC.4fYI8RoJwqW6oEsQnzmdD1QK', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Usuarios_Cursos`
--

CREATE TABLE `G_Usuarios_Cursos` (
  `Id_Pk_CursosApuntados` int(11) NOT NULL,
  `Int_Fk_IdCurso` int(11) NOT NULL,
  `Int_Fk_IdUsuario` int(11) NOT NULL,
  `Vc_NombreVideo` varchar(100) DEFAULT NULL,
  `Vc_EstadoVideo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Usuarios_Cursos`
--

INSERT INTO `G_Usuarios_Cursos` (`Id_Pk_CursosApuntados`, `Int_Fk_IdCurso`, `Int_Fk_IdUsuario`, `Vc_NombreVideo`, `Vc_EstadoVideo`) VALUES
(1, 2, 16, 'Introduccion', 'Completo'),
(2, 2, 16, 'Parte 1, como funciona PHP', 'Completo'),
(3, 2, 16, 'Parte 2, Que es PHP?', 'Completo'),
(4, 2, 16, 'Parte 3, PHP y sus partes', 'Completo'),
(5, 2, 16, 'Parte 4, Bucles y Arrays', 'Completo'),
(21, 2, 17, 'Introduccion', 'Completo'),
(22, 2, 17, 'Parte 1, como funciona PHP', 'Completo'),
(23, 2, 17, 'Parte 2, Que es PHP?', 'Completo'),
(24, 2, 17, 'Parte 3, PHP y sus partes', 'Completo'),
(25, 2, 17, 'Parte 4, Bucles y Arrays', 'Completo'),
(30, 3, 18, 'Empezamos con renderizando', 'Completo'),
(31, 3, 18, 'Vamos Utilizando las rejillas', 'Incompleto'),
(32, 3, 18, 'Que es Bootstrap 3', 'Incompleto'),
(33, 3, 18, 'Vamos con pseudoselectores', 'Incompleto'),
(34, 7, 17, 'Aprende a Pensar en Grande', 'Completo'),
(35, 7, 17, 'Como Ganar Dinero en 2 Pasos', 'Incompleto'),
(36, 7, 17, 'Aprnedamos el Abc del Triunfo', 'Incompleto'),
(37, 7, 16, 'Aprende a Pensar en Grande', 'Completo'),
(38, 7, 16, 'Como Ganar Dinero en 2 Pasos', 'Completo'),
(39, 7, 16, 'Aprnedamos el Abc del Triunfo', 'Completo'),
(40, 6, 16, 'Aprende de superaciÃ³n', 'Completo'),
(41, 6, 16, 'Que es superaciÃ³n Personal?', 'Completo'),
(42, 6, 16, 'superemos en 2 pasos', 'Incompleto'),
(43, 6, 18, 'Aprende de superaciÃ³n', 'Incompleto'),
(44, 6, 18, 'Que es superaciÃ³n Personal?', 'Incompleto'),
(45, 6, 18, 'superemos en 2 pasos', 'Incompleto'),
(46, 3, 17, 'Empezamos con renderizando', 'Incompleto'),
(47, 3, 17, 'Vamos Utilizando las rejillas', 'Incompleto'),
(48, 3, 17, 'Que es Bootstrap 3', 'Incompleto'),
(49, 3, 17, 'Vamos con pseudoselectores', 'Incompleto'),
(55, 8, 17, 'Empecemos, que es mecatrÃ³nica?', 'Completo'),
(56, 8, 17, 'Para que sirve la mecatrÃ³nica?', 'Completo'),
(57, 8, 17, 'Las matemÃ¡ticas en la mecatrÃ³nica', 'Incompleto'),
(58, 8, 17, 'Que necesita saber un ingeniero mecatrÃ³nico?', 'Incompleto'),
(59, 8, 17, 'Aprende a realizar tu tesis', 'Incompleto'),
(60, 8, 17, 'Proyecto final.', 'Incompleto'),
(65, 8, 16, 'Empecemos, que es mecatrÃ³nica?', 'Completo'),
(66, 8, 16, 'Para que sirve la mecatrÃ³nica?', 'Completo'),
(67, 8, 16, 'Las matemÃ¡ticas en la mecatrÃ³nica', 'Incompleto'),
(68, 8, 16, 'Que necesita saber un ingeniero mecatrÃ³nico?', 'Incompleto'),
(69, 8, 16, 'Aprende a realizar tu tesis', 'Incompleto'),
(70, 8, 16, 'Proyecto final.', 'Incompleto'),
(76, 9, 16, 'IntroducciÃ³n', 'Completo'),
(77, 9, 16, 'Landing Page', 'Completo'),
(78, 9, 16, 'Desplegado Vertical', 'Completo'),
(79, 9, 16, 'Tarjetas Circulares', 'Completo'),
(80, 9, 21, 'IntroducciÃ³n', 'Incompleto'),
(81, 9, 21, 'Landing Page', 'Incompleto'),
(82, 9, 21, 'Desplegado Vertical', 'Incompleto'),
(83, 9, 21, 'Tarjetas Circulares', 'Incompleto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Vacantes`
--

CREATE TABLE `G_Vacantes` (
  `Id_Pk_Vacante` int(11) NOT NULL,
  `Int_Fk_IdUsuario` int(11) NOT NULL,
  `Vc_Empresa` varchar(100) DEFAULT NULL,
  `Vc_NombreVacante` varchar(150) DEFAULT NULL,
  `Vc_Pais` varchar(70) DEFAULT NULL,
  `Vc_Ciudad` varchar(70) DEFAULT NULL,
  `Vc_Categoria` varchar(70) DEFAULT NULL,
  `Vc_TipoVacante` varchar(12) DEFAULT NULL,
  `Int_Salario` int(11) DEFAULT NULL,
  `Int_NumVacantes` int(11) DEFAULT NULL,
  `Vc_Correo` varchar(40) DEFAULT NULL,
  `Txt_DescripcionVacante` text,
  `Vc_EstadoVacante` varchar(45) DEFAULT NULL,
  `Da_Fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Vacantes`
--

INSERT INTO `G_Vacantes` (`Id_Pk_Vacante`, `Int_Fk_IdUsuario`, `Vc_Empresa`, `Vc_NombreVacante`, `Vc_Pais`, `Vc_Ciudad`, `Vc_Categoria`, `Vc_TipoVacante`, `Int_Salario`, `Int_NumVacantes`, `Vc_Correo`, `Txt_DescripcionVacante`, `Vc_EstadoVacante`, `Da_Fecha`) VALUES
(6, 16, 'AVM soluciÃ³n', 'Necesitamos desarrollador web', 'Colombia', 'Pereira', 'Productividad', 'Freelance', 900000, 2, 'avmsolucion@gmail.com', '<p>Necesitamos desarrollador web, con conocimientos en: bootstrap, juery, css3,html5,PHP, MDB, Mysql, POO, etc.. en lo posible que sea productivo y constante.</p>', 'Public', NULL),
(14, 17, 'Soluciones inmediatas', 'Se solicita conductor', 'Colombia', 'Moniquira', 'Productividad', 'Presencial', 600000, 2, 'escarimovy@hotmail.com', '<p>Se necesita barrendero disponible, apto y productivo que no le de pereza venir al trabajo, que est&eacute; siempre al tanto de todo lo que pase on su vehiculo, que jamas se desligue de su trabajo, que sea productivo y amplio para darme dinero.</p>', 'Public', '2016-09-28'),
(15, 16, 'GurÃº School', 'Se solicita Desarrollador web', 'Colombia', 'Pereira', 'Negocios', 'Freelance', 800000, 2, 'guru@hotmail.com', '<p>Se solicita persona proactiva, con capacidades cognitivas para responder a todo lo que se ofrezca, el postulado debe de tener conocimientos previos en:</p>\r\n<p>&nbsp;</p>\r\n<p>-bootstrap</p>\r\n<p>-jquery</p>\r\n<p>.php</p>', 'Public', '2016-09-28'),
(16, 16, 'GurÃº School', 'Necesitamos desarrollador Front End', 'Colombia', 'Pereira', 'TecnologÃ­a', 'Presencial', 1000000, 1, 'avmsolucion@gmail.com', '<p>Necesitamos desarrollador web, proactivo con ganas de aprender. Indispensable que tenga conocimiento en: Bootstrap, jquery, PHP, NODE.JS, LARAVEL, entre otro tipo de tecnolog&iacute;as.</p>', 'Public', '2016-10-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `G_Videos_Curso`
--

CREATE TABLE `G_Videos_Curso` (
  `Id_Pk_VideosCurso` int(11) NOT NULL,
  `Int_Fk_IdCurso` int(11) NOT NULL,
  `Txt_NombreVideo` text,
  `Vc_VideoArchivo` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `G_Videos_Curso`
--

INSERT INTO `G_Videos_Curso` (`Id_Pk_VideosCurso`, `Int_Fk_IdCurso`, `Txt_NombreVideo`, `Vc_VideoArchivo`) VALUES
(1, 2, 'Introduccion', '9UDBb-Xk_3k'),
(2, 2, 'Parte 1, como funciona PHP', 'zLX_GcXt2pI'),
(3, 2, 'Parte 2, Que es PHP?', 'iqFHC2buUrI'),
(4, 2, 'Parte 3, PHP y sus partes', 'ufsOw7_lvx8'),
(5, 2, 'Parte 4, Bucles y Arrays', 'AcsvYXtk6Qo'),
(10, 3, 'Empezamos con renderizando', 'nLgYGD0I3lc'),
(11, 3, 'Vamos Utilizando las rejillas', 'YIOgaqkx6Cs'),
(12, 3, 'Que es Bootstrap 3', 'P6DSr_wEzOY'),
(13, 3, 'Vamos con pseudoselectores', 'YIOgaqkx6Cs'),
(14, 6, 'Aprende de superaciÃ³n', 'eGH4k57Q68k'),
(15, 6, 'Que es superaciÃ³n Personal?', '6U2acJOc1_A'),
(31, 6, 'superemos en 2 pasos', 'AcsvYXtk6Qo'),
(34, 7, 'Aprende a Pensar en Grande', 'Aprende-a-Pensar-en-Grande_1469223658.mp4'),
(35, 7, 'Como Ganar Dinero en 2 Pasos', 'Como-Ganar-Dinero-en-2-Pasos_1469462417.mp4'),
(36, 7, 'Aprnedamos el Abc del Triunfo', 'Aprnedamos-el-Abc-del-Triunfo_1469462431.mp4'),
(40, 8, 'Empecemos, que es mecatrÃ³nica?', '-5Bz2pdgIJI'),
(41, 8, 'Para que sirve la mecatrÃ³nica?', 'axA2hLokzls'),
(42, 8, 'Las matemÃ¡ticas en la mecatrÃ³nica', 'EeIXWOdSNKE'),
(43, 8, 'Que necesita saber un ingeniero mecatrÃ³nico?', 'drLuASvcoFU'),
(44, 8, 'Aprende a realizar tu tesis', 'XFnEkQF0jd8'),
(45, 8, 'Proyecto final.', 'WHr1f-b2yj4'),
(46, 9, 'IntroducciÃ³n', 'Q8TXgCzxEnw'),
(47, 9, 'Landing Page', 'rrT6v5sOwJg'),
(48, 9, 'Desplegado Vertical', 'di43j_NCFwM'),
(49, 9, 'Tarjetas Circulares', '4T4xIoWz4ss');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Historial_Pagos`
--

CREATE TABLE `Historial_Pagos` (
  `Id_Pk_CursosPorPago` int(11) NOT NULL,
  `Vc_StatePol` varchar(50) DEFAULT NULL,
  `Vc_Response_Code_Pol` varchar(45) DEFAULT NULL,
  `Vc_Response_Message_Pol` varchar(100) DEFAULT NULL,
  `Vc_Payment_Method_Type` varchar(45) DEFAULT NULL,
  `Vc_Reference_Sale` varchar(45) DEFAULT NULL,
  `Txt_NameCourse` text,
  `Int_MontoCurso` int(11) DEFAULT NULL,
  `Vc_Nickname_Buyer` varchar(150) DEFAULT NULL,
  `Vc_Email_Buyer` varchar(150) DEFAULT NULL,
  `Int_Id_UsuarioVende` int(11) DEFAULT NULL,
  `Int_Id_CursoComprado` int(11) DEFAULT NULL,
  `Int_Id_UsuarioCompro` int(11) DEFAULT NULL,
  `Vc_Transaction_Date` date DEFAULT NULL,
  `Int_Reference_Pol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Historial_Pagos`
--

INSERT INTO `Historial_Pagos` (`Id_Pk_CursosPorPago`, `Vc_StatePol`, `Vc_Response_Code_Pol`, `Vc_Response_Message_Pol`, `Vc_Payment_Method_Type`, `Vc_Reference_Sale`, `Txt_NameCourse`, `Int_MontoCurso`, `Vc_Nickname_Buyer`, `Vc_Email_Buyer`, `Int_Id_UsuarioVende`, `Int_Id_CursoComprado`, `Int_Id_UsuarioCompro`, `Vc_Transaction_Date`, `Int_Reference_Pol`) VALUES
(6, '4', '1', 'APPROVED', '2', '14716250702561', 'Aprende a conseguir mÃ¡s dinero', 15000, 'Alonso Velez Marulanda', 'avmsolucion@hotmail.com', 16, 7, 16, '2016-08-19', 846605804),
(7, '4', '1', 'APPROVED', '2', '14716373838478', 'Aprende a conseguir mÃ¡s dinero', 15000, 'Ramon Valdez', 'escarimovy@hotmail.com', 16, 7, 17, '2016-08-19', 846624992);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pagos_Admin`
--

CREATE TABLE `Pagos_Admin` (
  `Id_Pk_Pagos` int(11) NOT NULL,
  `Vc_NameBuyer` varchar(150) DEFAULT NULL,
  `Int_Day` int(11) DEFAULT NULL,
  `Int_Month` int(11) DEFAULT NULL,
  `Int_Year` int(11) DEFAULT NULL,
  `Int_Ammount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Pagos_Admin`
--

INSERT INTO `Pagos_Admin` (`Id_Pk_Pagos`, `Vc_NameBuyer`, `Int_Day`, `Int_Month`, `Int_Year`, `Int_Ammount`) VALUES
(1, 'Alonso Velez Marulanda', 19, 8, 2016, 4500),
(2, 'Ramon Valdez', 19, 8, 2016, 4500),
(3, 'Camilo botero', 20, 8, 2016, 4500),
(4, 'Juan Gabriel', 29, 8, 2016, 15000),
(5, 'juan roberto', 1, 9, 2016, 4500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pagos_Usuarios`
--

CREATE TABLE `Pagos_Usuarios` (
  `Id_Pk_PagosUsuarios` int(11) NOT NULL,
  `Int_Fk_GUsuario` int(11) NOT NULL,
  `Int_Id_Curso` int(11) DEFAULT NULL,
  `Int_MontoCurso` int(11) DEFAULT NULL,
  `Int_MontoGuru` int(11) DEFAULT NULL,
  `Vc_EstadoCobro` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Paises`
--

CREATE TABLE `Paises` (
  `Id_Pk_Paises` int(11) NOT NULL,
  `Pais` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Paises`
--

INSERT INTO `Paises` (`Id_Pk_Paises`, `Pais`) VALUES
(1, 'Australia'),
(2, 'China'),
(3, 'Japan'),
(4, 'Thailand'),
(5, 'India'),
(6, 'Malaysia'),
(7, 'Kore'),
(8, 'Hong Kong'),
(9, 'Taiwan'),
(10, 'Philippines'),
(11, 'Vietnam'),
(12, 'France'),
(13, 'Europe'),
(14, 'Germany'),
(15, 'Sweden'),
(16, 'Italy'),
(17, 'Greece'),
(18, 'Spain'),
(19, 'Austria'),
(20, 'United Kingdom'),
(21, 'Netherlands'),
(22, 'Belgium'),
(23, 'Switzerland'),
(24, 'United Arab Emirates'),
(25, 'Israel'),
(26, 'Ukraine'),
(27, 'Russian Federation'),
(28, 'Kazakhstan'),
(29, 'Portugal'),
(30, 'Saudi Arabia'),
(31, 'Denmark'),
(32, 'Ira'),
(33, 'Norway'),
(34, 'United States'),
(35, 'Mexico'),
(36, 'Canada'),
(37, 'Anonymous Proxy'),
(38, 'Syrian Arab Republic'),
(39, 'Cyprus'),
(40, 'Czech Republic'),
(41, 'Iraq'),
(42, 'Turkey'),
(43, 'Romania'),
(44, 'Lebanon'),
(45, 'Hungary'),
(46, 'Georgia'),
(47, 'Brazil'),
(48, 'Azerbaijan'),
(49, 'Satellite Provider'),
(50, 'Palestinian Territory'),
(51, 'Lithuania'),
(52, 'Oman'),
(53, 'Slovakia'),
(54, 'Serbia'),
(55, 'Finland'),
(56, 'Iceland'),
(57, 'Bulgaria'),
(58, 'Slovenia'),
(59, 'Moldov'),
(60, 'Macedonia'),
(61, 'Liechtenstein'),
(62, 'Jersey'),
(63, 'Poland'),
(64, 'Croatia'),
(65, 'Bosnia and Herzegovina'),
(66, 'Estonia'),
(67, 'Latvia'),
(68, 'Jordan'),
(69, 'Kyrgyzstan'),
(70, 'Reunion'),
(71, 'Ireland'),
(72, 'Libya'),
(73, 'Luxembourg'),
(74, 'Armenia'),
(75, 'Virgin Island'),
(76, 'Yemen'),
(77, 'Belarus'),
(78, 'Gibraltar'),
(79, 'Martinique'),
(80, 'Panama'),
(81, 'Dominican Republic'),
(82, 'Guam'),
(83, 'Puerto Rico'),
(84, 'Virgin Island'),
(85, 'Mongolia'),
(86, 'New Zealand'),
(87, 'Singapore'),
(88, 'Indonesia'),
(89, 'Nepal'),
(90, 'Papua New Guinea'),
(91, 'Pakistan'),
(92, 'Asia/Pacific Region'),
(93, 'Bahamas'),
(94, 'Saint Lucia'),
(95, 'Argentina'),
(96, 'Bangladesh'),
(97, 'Tokelau'),
(98, 'Cambodia'),
(99, 'Macau'),
(100, 'Maldives'),
(101, 'Afghanistan'),
(102, 'New Caledonia'),
(103, 'Fiji'),
(104, 'Wallis and Futuna'),
(105, 'Qatar'),
(106, 'Albania'),
(107, 'Belize'),
(108, 'Uzbekistan'),
(109, 'Kuwait'),
(110, 'Montenegro'),
(111, 'Peru'),
(112, 'Bermuda'),
(113, 'Curacao'),
(114, 'Colombia'),
(115, 'Venezuela'),
(116, 'Chile'),
(117, 'Ecuador'),
(118, 'South Africa'),
(119, 'Isle of Man'),
(120, 'Bolivia'),
(121, 'Guernsey'),
(122, 'Malta'),
(123, 'Tajikistan'),
(124, 'Seychelles'),
(125, 'Bahrain'),
(126, 'Egypt'),
(127, 'Zimbabwe'),
(128, 'Liberia'),
(129, 'Kenya'),
(130, 'Ghana'),
(131, 'Nigeria'),
(132, 'Tanzani'),
(133, 'Zambia'),
(134, 'Madagascar'),
(135, 'Angola'),
(136, 'Namibia'),
(137, 'Cote D''Ivoire'),
(138, 'Sudan'),
(139, 'Cameroon'),
(140, 'Malawi'),
(141, 'Gabon'),
(142, 'Mali'),
(143, 'Benin'),
(144, 'Chad'),
(145, 'Botswana'),
(146, 'Cape Verde'),
(147, 'Rwanda'),
(148, 'Congo'),
(149, 'Uganda'),
(150, 'Mozambique'),
(151, 'Gambia'),
(152, 'Lesotho'),
(153, 'Mauritius'),
(154, 'Morocco'),
(155, 'Algeria'),
(156, 'Guinea'),
(157, 'Cong'),
(158, 'Swaziland'),
(159, 'Burkina Faso'),
(160, 'Sierra Leone'),
(161, 'Somalia'),
(162, 'Niger'),
(163, 'Central African Republic'),
(164, 'Togo'),
(165, 'Burundi'),
(166, 'Equatorial Guinea'),
(167, 'South Sudan'),
(168, 'Senegal'),
(169, 'Mauritania'),
(170, 'Djibouti'),
(171, 'Comoros'),
(172, 'British Indian Ocean Territory'),
(173, 'Tunisia'),
(174, 'Greenland'),
(175, 'Holy See (Vatican City State)'),
(176, 'Costa Rica'),
(177, 'Cayman Islands'),
(178, 'Jamaica'),
(179, 'Guatemala'),
(180, 'Marshall Islands'),
(181, 'Antarctica'),
(182, 'Barbados'),
(183, 'Aruba'),
(184, 'Monaco'),
(185, 'Anguilla'),
(186, 'Saint Kitts and Nevis'),
(187, 'Grenada'),
(188, 'Paraguay'),
(189, 'Montserrat'),
(190, 'Turks and Caicos Islands'),
(191, 'Antigua and Barbuda'),
(192, 'Tuvalu'),
(193, 'French Polynesia'),
(194, 'Solomon Islands'),
(195, 'Vanuatu'),
(196, 'Eritrea'),
(197, 'Trinidad and Tobago'),
(198, 'Andorra'),
(199, 'Haiti'),
(200, 'Saint Helena'),
(201, 'Micronesi'),
(202, 'El Salvador'),
(203, 'Honduras'),
(204, 'Uruguay'),
(205, 'Sri Lanka'),
(206, 'Western Sahara'),
(207, 'Christmas Island'),
(208, 'Samoa'),
(209, 'Suriname'),
(210, 'Cook Islands'),
(211, 'Kiribati'),
(212, 'Niue'),
(213, 'Tonga'),
(214, 'French Southern Territories'),
(215, 'Mayotte'),
(216, 'Norfolk Island'),
(217, 'Brunei Darussalam'),
(218, 'Turkmenistan'),
(219, 'Pitcairn Islands'),
(220, 'San Marino'),
(221, 'Aland Islands'),
(222, 'Faroe Islands'),
(223, 'Svalbard and Jan Mayen'),
(224, 'Cocos (Keeling) Islands'),
(225, 'Nauru'),
(226, 'South Georgia and the South Sandwich Islands'),
(227, 'United States Minor Outlying Islands'),
(228, 'Guinea-Bissau'),
(229, 'Palau'),
(230, 'American Samoa'),
(231, 'Bhutan'),
(232, 'French Guiana'),
(233, 'Guadeloupe'),
(234, 'Saint Martin'),
(235, 'Saint Vincent and the Grenadines'),
(236, 'Saint Pierre and Miquelon'),
(237, 'Saint Barthelemy'),
(238, 'Dominica'),
(239, 'Sao Tome and Principe'),
(240, 'Kore'),
(241, 'Falkland Islands (Malvinas)'),
(242, 'Northern Mariana Islands'),
(243, 'Timor-Leste'),
(244, 'Bonair'),
(245, 'Myanmar'),
(246, 'Nicaragua'),
(247, 'Sint Maarten (Dutch part)'),
(248, 'Guyana'),
(249, 'Lao People''s Democratic Republic'),
(250, 'Cuba'),
(251, 'Ethiopia');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_seleccioncursos`
--
CREATE TABLE `vw_seleccioncursos` (
`Id_Pk_Curso` int(11)
,`Int_Fk_IdUsuario` int(11)
,`Vc_NombreCurso` varchar(150)
,`Vc_Imagen_Promocional` varchar(150)
,`Int_PrecioCurso` int(11)
,`Vc_TipoCurso` varchar(50)
,`Vc_SubCategoria` varchar(50)
,`Vc_NombreUsuario` varchar(100)
,`Vc_EstadoCurso` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_vacantes`
--
CREATE TABLE `vw_vacantes` (
`Id_Pk_Vacante` int(11)
,`Vc_Empresa` varchar(100)
,`Vc_NombreVacante` varchar(150)
,`Txt_DescripcionVacante` text
,`Vc_Categoria` varchar(70)
,`Vc_Pais` varchar(70)
,`Vc_Ciudad` varchar(70)
,`Vc_EstadoVacante` varchar(45)
,`Da_Fecha` date
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_seleccioncursos`
--
DROP TABLE IF EXISTS `vw_seleccioncursos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `guruschool`.`vw_seleccioncursos`  AS  select `a`.`Id_Pk_Curso` AS `Id_Pk_Curso`,`a`.`Int_Fk_IdUsuario` AS `Int_Fk_IdUsuario`,`a`.`Vc_NombreCurso` AS `Vc_NombreCurso`,`a`.`Vc_Imagen_Promocional` AS `Vc_Imagen_Promocional`,`a`.`Int_PrecioCurso` AS `Int_PrecioCurso`,`a`.`Vc_TipoCurso` AS `Vc_TipoCurso`,`a`.`Vc_SubCategoria` AS `Vc_SubCategoria`,`b`.`Vc_NombreUsuario` AS `Vc_NombreUsuario`,`a`.`Vc_EstadoCurso` AS `Vc_EstadoCurso` from (`guruschool`.`g_cursos` `a` join `guruschool`.`g_datos_usuario` `b` on((`a`.`Int_Fk_IdUsuario` = `b`.`Int_Fk_IdUsuario`))) where (`a`.`Vc_EstadoCurso` = 'Publicado') ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_vacantes`
--
DROP TABLE IF EXISTS `vw_vacantes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `guruschool`.`vw_vacantes`  AS  select `guruschool`.`g_vacantes`.`Id_Pk_Vacante` AS `Id_Pk_Vacante`,`guruschool`.`g_vacantes`.`Vc_Empresa` AS `Vc_Empresa`,`guruschool`.`g_vacantes`.`Vc_NombreVacante` AS `Vc_NombreVacante`,`guruschool`.`g_vacantes`.`Txt_DescripcionVacante` AS `Txt_DescripcionVacante`,`guruschool`.`g_vacantes`.`Vc_Categoria` AS `Vc_Categoria`,`guruschool`.`g_vacantes`.`Vc_Pais` AS `Vc_Pais`,`guruschool`.`g_vacantes`.`Vc_Ciudad` AS `Vc_Ciudad`,`guruschool`.`g_vacantes`.`Vc_EstadoVacante` AS `Vc_EstadoVacante`,`guruschool`.`g_vacantes`.`Da_Fecha` AS `Da_Fecha` from `guruschool`.`g_vacantes` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Certificados_Usuarios`
--
ALTER TABLE `Certificados_Usuarios`
  ADD PRIMARY KEY (`Id_Pk_Certificado`),
  ADD KEY `IX_INDICE_Certificado` (`Int_Fk_IdUsuario`);

--
-- Indices de la tabla `Cobros_Admin`
--
ALTER TABLE `Cobros_Admin`
  ADD PRIMARY KEY (`Id_Pk_Cobros`);

--
-- Indices de la tabla `Cobros_Realizados`
--
ALTER TABLE `Cobros_Realizados`
  ADD PRIMARY KEY (`Id_Pk_CobrosRelizados`);

--
-- Indices de la tabla `Cobros_Usuarios`
--
ALTER TABLE `Cobros_Usuarios`
  ADD PRIMARY KEY (`Id_Pk_CobrosUsuarios`),
  ADD KEY `IX_INDICE_IdUsuario` (`Int_Fk_GUsuario`);

--
-- Indices de la tabla `G_Categorias`
--
ALTER TABLE `G_Categorias`
  ADD PRIMARY KEY (`Id_Pk_Categorias`);

--
-- Indices de la tabla `G_Comments_Foro`
--
ALTER TABLE `G_Comments_Foro`
  ADD PRIMARY KEY (`Id_Pk_CommentsForo`),
  ADD KEY `IX_INDICE_QuestForo` (`Int_Fk_IdPreguntaForo`);

--
-- Indices de la tabla `G_Cuenta_Usuario`
--
ALTER TABLE `G_Cuenta_Usuario`
  ADD PRIMARY KEY (`Id_Pk_CuentaUsuario`),
  ADD KEY `IX_indice G_Datos` (`Int_Fk_DatosUsuario`);

--
-- Indices de la tabla `G_Cursos`
--
ALTER TABLE `G_Cursos`
  ADD PRIMARY KEY (`Id_Pk_Curso`),
  ADD KEY `IX_INDICE_Cat` (`Int_Fk_IdCat`),
  ADD KEY `IX_INDICE_Usuario` (`Int_Fk_IdUsuario`);
ALTER TABLE `G_Cursos` ADD FULLTEXT KEY `Vc_NombreCurso` (`Vc_NombreCurso`);
ALTER TABLE `G_Cursos` ADD FULLTEXT KEY `Vc_NombreCurso_2` (`Vc_NombreCurso`);
ALTER TABLE `G_Cursos` ADD FULLTEXT KEY `Vc_NombreCurso_3` (`Vc_NombreCurso`);

--
-- Indices de la tabla `G_Datos_Usuario`
--
ALTER TABLE `G_Datos_Usuario`
  ADD PRIMARY KEY (`Id_Pk_DatosUsuario`),
  ADD KEY `IX_INDICE_IdUsuario` (`Int_Fk_IdUsuario`);
ALTER TABLE `G_Datos_Usuario` ADD FULLTEXT KEY `Vc_NombreUsuario` (`Vc_NombreUsuario`);

--
-- Indices de la tabla `G_Foro_Curso`
--
ALTER TABLE `G_Foro_Curso`
  ADD PRIMARY KEY (`Id_Pk_ForoCurso`),
  ADD KEY `IX_INDICE_IdCurso` (`Int_Fk_IdCurso`);

--
-- Indices de la tabla `G_Profesion_Usuario`
--
ALTER TABLE `G_Profesion_Usuario`
  ADD PRIMARY KEY (`Id_Pk_DatosProfesionalUser`),
  ADD KEY `IX_indice G_Datos` (`Int_Fk_DatosUsuario`);

--
-- Indices de la tabla `G_Sub_Categoria`
--
ALTER TABLE `G_Sub_Categoria`
  ADD PRIMARY KEY (`Id_Pk_SubCategoria`),
  ADD KEY `IX_INDICE_IdCat` (`Int_Fk_IdCat`);

--
-- Indices de la tabla `G_Usuario`
--
ALTER TABLE `G_Usuario`
  ADD PRIMARY KEY (`Id_Pk_Usuario`);

--
-- Indices de la tabla `G_Usuarios_Cursos`
--
ALTER TABLE `G_Usuarios_Cursos`
  ADD PRIMARY KEY (`Id_Pk_CursosApuntados`),
  ADD KEY `IX_INDICE_IdCurso` (`Int_Fk_IdCurso`),
  ADD KEY `IX_INDICE_IdUsuario` (`Int_Fk_IdUsuario`);

--
-- Indices de la tabla `G_Vacantes`
--
ALTER TABLE `G_Vacantes`
  ADD PRIMARY KEY (`Id_Pk_Vacante`),
  ADD KEY `IX_INDICE_Vacantes` (`Int_Fk_IdUsuario`);
ALTER TABLE `G_Vacantes` ADD FULLTEXT KEY `Vc_Empresa` (`Vc_Empresa`);

--
-- Indices de la tabla `G_Videos_Curso`
--
ALTER TABLE `G_Videos_Curso`
  ADD PRIMARY KEY (`Id_Pk_VideosCurso`),
  ADD KEY `IX_INDICE_IdCurso` (`Int_Fk_IdCurso`);

--
-- Indices de la tabla `Historial_Pagos`
--
ALTER TABLE `Historial_Pagos`
  ADD PRIMARY KEY (`Id_Pk_CursosPorPago`);
ALTER TABLE `Historial_Pagos` ADD FULLTEXT KEY `Txt_NameCourse` (`Txt_NameCourse`);
ALTER TABLE `Historial_Pagos` ADD FULLTEXT KEY `Vc_Nickname_Buyer` (`Vc_Nickname_Buyer`);
ALTER TABLE `Historial_Pagos` ADD FULLTEXT KEY `Vc_Email_Buyer` (`Vc_Email_Buyer`);

--
-- Indices de la tabla `Pagos_Admin`
--
ALTER TABLE `Pagos_Admin`
  ADD PRIMARY KEY (`Id_Pk_Pagos`);

--
-- Indices de la tabla `Pagos_Usuarios`
--
ALTER TABLE `Pagos_Usuarios`
  ADD PRIMARY KEY (`Id_Pk_PagosUsuarios`),
  ADD KEY `IX_INDICE_IdUsuario` (`Int_Fk_GUsuario`);

--
-- Indices de la tabla `Paises`
--
ALTER TABLE `Paises`
  ADD PRIMARY KEY (`Id_Pk_Paises`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Certificados_Usuarios`
--
ALTER TABLE `Certificados_Usuarios`
  MODIFY `Id_Pk_Certificado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Cobros_Admin`
--
ALTER TABLE `Cobros_Admin`
  MODIFY `Id_Pk_Cobros` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Cobros_Realizados`
--
ALTER TABLE `Cobros_Realizados`
  MODIFY `Id_Pk_CobrosRelizados` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Cobros_Usuarios`
--
ALTER TABLE `Cobros_Usuarios`
  MODIFY `Id_Pk_CobrosUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `G_Categorias`
--
ALTER TABLE `G_Categorias`
  MODIFY `Id_Pk_Categorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `G_Comments_Foro`
--
ALTER TABLE `G_Comments_Foro`
  MODIFY `Id_Pk_CommentsForo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `G_Cuenta_Usuario`
--
ALTER TABLE `G_Cuenta_Usuario`
  MODIFY `Id_Pk_CuentaUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `G_Cursos`
--
ALTER TABLE `G_Cursos`
  MODIFY `Id_Pk_Curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `G_Datos_Usuario`
--
ALTER TABLE `G_Datos_Usuario`
  MODIFY `Id_Pk_DatosUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `G_Foro_Curso`
--
ALTER TABLE `G_Foro_Curso`
  MODIFY `Id_Pk_ForoCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `G_Profesion_Usuario`
--
ALTER TABLE `G_Profesion_Usuario`
  MODIFY `Id_Pk_DatosProfesionalUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `G_Sub_Categoria`
--
ALTER TABLE `G_Sub_Categoria`
  MODIFY `Id_Pk_SubCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT de la tabla `G_Usuario`
--
ALTER TABLE `G_Usuario`
  MODIFY `Id_Pk_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `G_Usuarios_Cursos`
--
ALTER TABLE `G_Usuarios_Cursos`
  MODIFY `Id_Pk_CursosApuntados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT de la tabla `G_Vacantes`
--
ALTER TABLE `G_Vacantes`
  MODIFY `Id_Pk_Vacante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `G_Videos_Curso`
--
ALTER TABLE `G_Videos_Curso`
  MODIFY `Id_Pk_VideosCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT de la tabla `Historial_Pagos`
--
ALTER TABLE `Historial_Pagos`
  MODIFY `Id_Pk_CursosPorPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `Pagos_Admin`
--
ALTER TABLE `Pagos_Admin`
  MODIFY `Id_Pk_Pagos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Pagos_Usuarios`
--
ALTER TABLE `Pagos_Usuarios`
  MODIFY `Id_Pk_PagosUsuarios` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Paises`
--
ALTER TABLE `Paises`
  MODIFY `Id_Pk_Paises` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Certificados_Usuarios`
--
ALTER TABLE `Certificados_Usuarios`
  ADD CONSTRAINT `RI_G_Usuario-Certificados_Usuarios` FOREIGN KEY (`Int_Fk_IdUsuario`) REFERENCES `G_Usuario` (`Id_Pk_Usuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Cobros_Usuarios`
--
ALTER TABLE `Cobros_Usuarios`
  ADD CONSTRAINT `RI_G_Usuario-G_Cobros_Usuarios` FOREIGN KEY (`Int_Fk_GUsuario`) REFERENCES `G_Usuario` (`Id_Pk_Usuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Comments_Foro`
--
ALTER TABLE `G_Comments_Foro`
  ADD CONSTRAINT `RI_G_Foro_Curso-G_Comments_Foro` FOREIGN KEY (`Int_Fk_IdPreguntaForo`) REFERENCES `G_Foro_Curso` (`Id_Pk_ForoCurso`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Cuenta_Usuario`
--
ALTER TABLE `G_Cuenta_Usuario`
  ADD CONSTRAINT `RI_G_Datos_Usuario-G_Cuenta_Usuario` FOREIGN KEY (`Int_Fk_DatosUsuario`) REFERENCES `G_Datos_Usuario` (`Int_Fk_IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Cursos`
--
ALTER TABLE `G_Cursos`
  ADD CONSTRAINT `RI_G_Categorias-G_Cursos_Como_Profesor` FOREIGN KEY (`Int_Fk_IdCat`) REFERENCES `G_Categorias` (`Id_Pk_Categorias`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `RI_G_Usuario-G_Cursos_Como_Profesor` FOREIGN KEY (`Int_Fk_IdUsuario`) REFERENCES `G_Usuario` (`Id_Pk_Usuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Datos_Usuario`
--
ALTER TABLE `G_Datos_Usuario`
  ADD CONSTRAINT `RI_G_Usuario-G_Datos_Usuario` FOREIGN KEY (`Int_Fk_IdUsuario`) REFERENCES `G_Usuario` (`Id_Pk_Usuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Foro_Curso`
--
ALTER TABLE `G_Foro_Curso`
  ADD CONSTRAINT `RI_G_Cursos-G_Foro_Curso` FOREIGN KEY (`Int_Fk_IdCurso`) REFERENCES `G_Cursos` (`Id_Pk_Curso`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Profesion_Usuario`
--
ALTER TABLE `G_Profesion_Usuario`
  ADD CONSTRAINT `RI_G_Datos_Usuario-G_Profesion_Usuario` FOREIGN KEY (`Int_Fk_DatosUsuario`) REFERENCES `G_Datos_Usuario` (`Int_Fk_IdUsuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Sub_Categoria`
--
ALTER TABLE `G_Sub_Categoria`
  ADD CONSTRAINT `RI_G_Categorias-G_Sub_Categoria` FOREIGN KEY (`Int_Fk_IdCat`) REFERENCES `G_Categorias` (`Id_Pk_Categorias`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Usuarios_Cursos`
--
ALTER TABLE `G_Usuarios_Cursos`
  ADD CONSTRAINT `RI_G_Curso-G_Usuarios_Cursos` FOREIGN KEY (`Int_Fk_IdCurso`) REFERENCES `G_Cursos` (`Id_Pk_Curso`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `RI_G_Usuario-G_Usuarios_Cursos` FOREIGN KEY (`Int_Fk_IdUsuario`) REFERENCES `G_Usuario` (`Id_Pk_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Vacantes`
--
ALTER TABLE `G_Vacantes`
  ADD CONSTRAINT `RI_G_Usuario-G_Vacantes` FOREIGN KEY (`Int_Fk_IdUsuario`) REFERENCES `G_Usuario` (`Id_Pk_Usuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `G_Videos_Curso`
--
ALTER TABLE `G_Videos_Curso`
  ADD CONSTRAINT `RI_G_Cursos-G_Videos_Curso` FOREIGN KEY (`Int_Fk_IdCurso`) REFERENCES `G_Cursos` (`Id_Pk_Curso`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Pagos_Usuarios`
--
ALTER TABLE `Pagos_Usuarios`
  ADD CONSTRAINT `RI_G_Usuario-G_Pagos_Usuarios` FOREIGN KEY (`Int_Fk_GUsuario`) REFERENCES `G_Usuario` (`Id_Pk_Usuario`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
