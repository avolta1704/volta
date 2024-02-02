/*
 Navicat Premium Data Transfer

 Source Server         : db_conections
 Source Server Type    : MySQL
 Source Server Version : 100432
 Source Host           : localhost:3306
 Source Schema         : db_volta

 Target Server Type    : MySQL
 Target Server Version : 100432
 File Encoding         : 65001

 Date: 02/02/2024 17:35:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admision
-- ----------------------------
DROP TABLE IF EXISTS `admision`;
CREATE TABLE `admision`  (
  `idAdmision` int NOT NULL AUTO_INCREMENT,
  `idAnioEscolar` int NOT NULL,
  `fechaAdmision` date NOT NULL,
  `tipoAdmision` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idAdmision`) USING BTREE,
  INDEX `fk_admision_anioescolar`(`idAnioEscolar`) USING BTREE,
  CONSTRAINT `fk_admision_anioescolar` FOREIGN KEY (`idAnioEscolar`) REFERENCES `anio_escolar` (`idAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admision
-- ----------------------------

-- ----------------------------
-- Table structure for admision_alumno
-- ----------------------------
DROP TABLE IF EXISTS `admision_alumno`;
CREATE TABLE `admision_alumno`  (
  `idAdmisionAlumno` int NOT NULL AUTO_INCREMENT,
  `idAdmision` int NOT NULL,
  `idAlumno` int NOT NULL,
  `estadoAdmisionAlumno` int NULL DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idAdmisionAlumno`) USING BTREE,
  INDEX `fk_admision_alumno`(`idAdmision`) USING BTREE,
  INDEX `fk_alumno_admision`(`idAlumno`) USING BTREE,
  CONSTRAINT `fk_admision_alumno` FOREIGN KEY (`idAdmision`) REFERENCES `admision` (`idAdmision`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_alumno_admision` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admision_alumno
-- ----------------------------

-- ----------------------------
-- Table structure for alumno
-- ----------------------------
DROP TABLE IF EXISTS `alumno`;
CREATE TABLE `alumno`  (
  `idAlumno` int NOT NULL AUTO_INCREMENT,
  `codAlumnoCaja` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombresAlumno` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidosAlumno` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexoAlumno` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dniAlumno` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `direccionAlumno` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `distritoAlumno` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IEPProcedencia` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seguroSalud` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaIngresoVolta` date NOT NULL,
  `numeroEmergencia` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `enfermedades` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `estadoSiagie` int NULL DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idAlumno`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of alumno
-- ----------------------------
INSERT INTO `alumno` VALUES (1, '0044300543\r\n', 'VIANCA ALIZEE', 'GUTIERREZ GUTIERREZ', 'FEMENINO', '85123654', '2010-01-31', 'Urb. Escondida Nro 123', 'Characato', '-', '-', '2024-01-01', '987564235', '-', 1, '2024-01-31 09:24:16', '2024-01-31 09:24:16');
INSERT INTO `alumno` VALUES (6, NULL, 'Ysabel', 'Pajuelo', 'Femenino', '89756326', '2010-02-10', 'Urb. Escondido ABC 1', 'Characato', '-', '-', '2024-01-31', '987563251', '-', NULL, '2024-01-31 15:29:20', '2024-01-31 15:29:20');
INSERT INTO `alumno` VALUES (7, NULL, 'Pedro', 'Suarez Llosa', 'Masculino', '985653625', '2011-02-10', 'Urb. Encalada abc123', 'Characato', '-', '-', '2024-02-02', '9856562315', '-', NULL, '2024-02-01 10:56:04', '2024-02-01 10:56:04');
INSERT INTO `alumno` VALUES (8, NULL, 'Paula', 'Mariño', 'Femenino', '8978564215', '2009-03-04', 'Urb. Perdida ZX 98', 'Characato', '-', '-', '2024-02-01', '985632258', '-', NULL, '2024-02-01 11:00:33', '2024-02-01 11:00:33');
INSERT INTO `alumno` VALUES (9, NULL, 'Paula', 'Mariño', 'Femenino', '8978564215', '2009-03-04', 'Urb. Perdida ZX 98', 'Characato', '-', '-', '2024-02-01', '985632258', '-', NULL, '2024-02-01 11:01:16', '2024-02-01 11:01:16');
INSERT INTO `alumno` VALUES (10, NULL, 'Paula', 'Mariño', 'Femenino', '8978564215', '2009-03-04', 'Urb. Perdida ZX 98', 'Characato', '-', '-', '2024-02-01', '985632258', '-', NULL, '2024-02-01 11:01:17', '2024-02-01 11:01:17');

-- ----------------------------
-- Table structure for alumno_grado
-- ----------------------------
DROP TABLE IF EXISTS `alumno_grado`;
CREATE TABLE `alumno_grado`  (
  `idAlumnoGrado` int NOT NULL AUTO_INCREMENT,
  `idAlumno` int NOT NULL,
  `idGrado` int NOT NULL,
  `estadoGradoAlumno` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idAlumnoGrado`) USING BTREE,
  INDEX `fk_alumno_grado`(`idAlumno`) USING BTREE,
  INDEX `fk_grado_alumno`(`idGrado`) USING BTREE,
  CONSTRAINT `fk_alumno_grado` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_grado_alumno` FOREIGN KEY (`idGrado`) REFERENCES `grado` (`idGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of alumno_grado
-- ----------------------------
INSERT INTO `alumno_grado` VALUES (1, 1, 11, 1, '2024-01-31 09:25:35', '2024-01-31 09:25:35');
INSERT INTO `alumno_grado` VALUES (2, 7, 10, 1, '2024-02-01 10:56:40', '2024-02-01 10:56:40');
INSERT INTO `alumno_grado` VALUES (3, 8, 7, 1, '2024-02-01 11:00:33', '2024-02-01 11:00:33');
INSERT INTO `alumno_grado` VALUES (4, 9, 7, 1, '2024-02-01 11:01:16', '2024-02-01 11:01:16');
INSERT INTO `alumno_grado` VALUES (5, 10, 7, 1, '2024-02-01 11:01:18', '2024-02-01 11:01:18');

-- ----------------------------
-- Table structure for alumnogrado_curso
-- ----------------------------
DROP TABLE IF EXISTS `alumnogrado_curso`;
CREATE TABLE `alumnogrado_curso`  (
  `idAlumGradCurso` int NOT NULL AUTO_INCREMENT,
  `idAlumnoGrado` int NOT NULL,
  `idCurso` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idAlumGradCurso`) USING BTREE,
  INDEX `fk_alumnogrado_curso`(`idAlumnoGrado`) USING BTREE,
  INDEX `fk_curso_alumnogrado`(`idCurso`) USING BTREE,
  CONSTRAINT `fk_alumnogrado_curso` FOREIGN KEY (`idAlumnoGrado`) REFERENCES `alumno_grado` (`idAlumnoGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_curso_alumnogrado` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of alumnogrado_curso
-- ----------------------------

-- ----------------------------
-- Table structure for anio_escolar
-- ----------------------------
DROP TABLE IF EXISTS `anio_escolar`;
CREATE TABLE `anio_escolar`  (
  `idAnioEscolar` int NOT NULL AUTO_INCREMENT,
  `descripcionAnio` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `costoMatricula` decimal(10, 2) NOT NULL,
  `costoPension` decimal(10, 2) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idAnioEscolar`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of anio_escolar
-- ----------------------------

-- ----------------------------
-- Table structure for apoderado
-- ----------------------------
DROP TABLE IF EXISTS `apoderado`;
CREATE TABLE `apoderado`  (
  `idApoderado` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NULL DEFAULT NULL,
  `numeroApoderado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipoApoderado` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `listaAlumnos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `correoApoderado` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombreApoderado` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidoApoderado` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `convivenciaAlumno` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idApoderado`) USING BTREE,
  INDEX `fk_apoderador_usuario`(`idUsuario`) USING BTREE,
  CONSTRAINT `fk_apoderador_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of apoderado
-- ----------------------------
INSERT INTO `apoderado` VALUES (3, NULL, '987563245', 'Madre', NULL, 'rgonzales@gmail.com', 'Rubi', 'Gonzales', NULL, '2024-01-31 15:29:20', '2024-01-31 15:29:20');
INSERT INTO `apoderado` VALUES (4, NULL, '987569856', 'Padre', NULL, 'rvizcarra', 'Renato', 'Vizcarra', NULL, '2024-01-31 15:29:29', '2024-01-31 15:29:29');
INSERT INTO `apoderado` VALUES (5, NULL, '986565656', 'Madre', NULL, 'allosa', 'Andrea', 'LLosa', NULL, '2024-02-01 10:56:25', '2024-02-01 10:56:25');
INSERT INTO `apoderado` VALUES (6, NULL, '985665523', 'Padre', NULL, 'pmariño@gmail.com', 'Pedro', 'Mariño', NULL, '2024-02-01 11:00:33', '2024-02-01 11:00:33');
INSERT INTO `apoderado` VALUES (7, NULL, '985665523', 'Padre', NULL, 'pmariño@gmail.com', 'Pedro', 'Mariño', NULL, '2024-02-01 11:01:16', '2024-02-01 11:01:16');
INSERT INTO `apoderado` VALUES (8, NULL, '985665523', 'Padre', NULL, 'pmariño@gmail.com', 'Pedro', 'Mariño', NULL, '2024-02-01 11:01:18', '2024-02-01 11:01:18');

-- ----------------------------
-- Table structure for apoderado_alumno
-- ----------------------------
DROP TABLE IF EXISTS `apoderado_alumno`;
CREATE TABLE `apoderado_alumno`  (
  `idApoderadoAlumno` int NOT NULL AUTO_INCREMENT,
  `idAlumno` int NOT NULL,
  `idApoderado` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idApoderadoAlumno`) USING BTREE,
  INDEX `fk_apoderado_alumno`(`idApoderado`) USING BTREE,
  INDEX `fk_alumno_apoderado`(`idAlumno`) USING BTREE,
  CONSTRAINT `fk_alumno_apoderado` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_apoderado_alumno` FOREIGN KEY (`idApoderado`) REFERENCES `apoderado` (`idApoderado`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of apoderado_alumno
-- ----------------------------
INSERT INTO `apoderado_alumno` VALUES (1, 6, 3, '2024-01-31 15:29:27', '2024-01-31 15:29:27');
INSERT INTO `apoderado_alumno` VALUES (2, 6, 4, '2024-01-31 15:29:31', '2024-01-31 15:29:31');
INSERT INTO `apoderado_alumno` VALUES (3, 7, 5, '2024-02-01 10:56:34', '2024-02-01 10:56:34');
INSERT INTO `apoderado_alumno` VALUES (4, 8, 6, '2024-02-01 11:00:33', '2024-02-01 11:00:33');
INSERT INTO `apoderado_alumno` VALUES (5, 9, 7, '2024-02-01 11:01:16', '2024-02-01 11:01:16');
INSERT INTO `apoderado_alumno` VALUES (6, 10, 8, '2024-02-01 11:01:18', '2024-02-01 11:01:18');

-- ----------------------------
-- Table structure for area
-- ----------------------------
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area`  (
  `idArea` int NOT NULL AUTO_INCREMENT,
  `descripcionArea` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idArea`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of area
-- ----------------------------

-- ----------------------------
-- Table structure for asistencia
-- ----------------------------
DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE `asistencia`  (
  `idAsistencia` int NOT NULL AUTO_INCREMENT,
  `idHorario` int NOT NULL,
  `concurrencia` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idAsistencia`) USING BTREE,
  INDEX `fk_horario_asistencia`(`idHorario`) USING BTREE,
  CONSTRAINT `fk_horario_asistencia` FOREIGN KEY (`idHorario`) REFERENCES `horario` (`idHorario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of asistencia
-- ----------------------------

-- ----------------------------
-- Table structure for comunicacion_pago
-- ----------------------------
DROP TABLE IF EXISTS `comunicacion_pago`;
CREATE TABLE `comunicacion_pago`  (
  `idComunicacionPago` int NOT NULL AUTO_INCREMENT,
  `idCronogramaPago` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idComunicacionPago`) USING BTREE,
  INDEX `fk_comunicacionpago_cronogramapago`(`idCronogramaPago`) USING BTREE,
  CONSTRAINT `fk_comunicacionpago_cronogramapago` FOREIGN KEY (`idCronogramaPago`) REFERENCES `cronograma_pago` (`idCronogramaPago`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comunicacion_pago
-- ----------------------------

-- ----------------------------
-- Table structure for cronograma_pago
-- ----------------------------
DROP TABLE IF EXISTS `cronograma_pago`;
CREATE TABLE `cronograma_pago`  (
  `idCronogramaPago` int NOT NULL AUTO_INCREMENT,
  `idAdmisionAlumno` int NOT NULL,
  `estadoCronograma` int NOT NULL,
  `mesPago` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idCronogramaPago`) USING BTREE,
  INDEX `fk_cronograma_admisionalumno`(`idAdmisionAlumno`) USING BTREE,
  CONSTRAINT `fk_cronograma_admisionalumno` FOREIGN KEY (`idAdmisionAlumno`) REFERENCES `admision_alumno` (`idAdmisionAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cronograma_pago
-- ----------------------------

-- ----------------------------
-- Table structure for curso
-- ----------------------------
DROP TABLE IF EXISTS `curso`;
CREATE TABLE `curso`  (
  `idCurso` int NOT NULL AUTO_INCREMENT,
  `idArea` int NOT NULL,
  `descripcionCurso` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idCurso`) USING BTREE,
  INDEX `fk_curso_area`(`idArea`) USING BTREE,
  CONSTRAINT `fk_curso_area` FOREIGN KEY (`idArea`) REFERENCES `area` (`idArea`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of curso
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_comunicacion_pago
-- ----------------------------
DROP TABLE IF EXISTS `detalle_comunicacion_pago`;
CREATE TABLE `detalle_comunicacion_pago`  (
  `idDetalleComunicacion` int NOT NULL AUTO_INCREMENT,
  `idComunicacionPago` int NOT NULL,
  `tituloComunicacion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalleComunicacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaComunicacion` date NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idDetalleComunicacion`) USING BTREE,
  INDEX `fk_detallecomunicacion_comunicacion`(`idComunicacionPago`) USING BTREE,
  CONSTRAINT `fk_detallecomunicacion_comunicacion` FOREIGN KEY (`idComunicacionPago`) REFERENCES `comunicacion_pago` (`idComunicacionPago`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_comunicacion_pago
-- ----------------------------

-- ----------------------------
-- Table structure for grado
-- ----------------------------
DROP TABLE IF EXISTS `grado`;
CREATE TABLE `grado`  (
  `idGrado` int NOT NULL AUTO_INCREMENT,
  `idNivel` int NOT NULL,
  `descripcionGrado` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idGrado`) USING BTREE,
  INDEX `fk_grado_nivel`(`idNivel`) USING BTREE,
  CONSTRAINT `fk_grado_nivel` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`idNivel`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grado
-- ----------------------------
INSERT INTO `grado` VALUES (1, 1, '3 Años', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (2, 1, '4 Años', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (3, 1, '5 Años', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (4, 2, '1er Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (5, 2, '2do Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (6, 2, '3er Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (7, 2, '4to Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (8, 2, '5to Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (9, 2, '6to Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (10, 3, '1er Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (11, 3, '2do Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (12, 3, '3er Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (13, 3, '4to Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44');
INSERT INTO `grado` VALUES (14, 3, '5to Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44');

-- ----------------------------
-- Table structure for horario
-- ----------------------------
DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario`  (
  `idHorario` int NOT NULL AUTO_INCREMENT,
  `idAlumGradCurso` int NOT NULL,
  `horarioCurso` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idHorario`) USING BTREE,
  INDEX `fk_horario_alumnogrado`(`idAlumGradCurso`) USING BTREE,
  CONSTRAINT `fk_horario_alumnogrado` FOREIGN KEY (`idAlumGradCurso`) REFERENCES `alumnogrado_curso` (`idAlumGradCurso`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of horario
-- ----------------------------

-- ----------------------------
-- Table structure for nivel
-- ----------------------------
DROP TABLE IF EXISTS `nivel`;
CREATE TABLE `nivel`  (
  `idNivel` int NOT NULL AUTO_INCREMENT,
  `descripcionNivel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idNivel`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nivel
-- ----------------------------
INSERT INTO `nivel` VALUES (1, 'Inicial', '2024-01-31 09:14:10', '2024-01-31 09:14:10');
INSERT INTO `nivel` VALUES (2, 'Primaria', '2024-01-31 09:14:10', '2024-01-31 09:14:10');
INSERT INTO `nivel` VALUES (3, 'Secundaria', '2024-01-31 09:14:10', '2024-01-31 09:14:10');

-- ----------------------------
-- Table structure for pago
-- ----------------------------
DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago`  (
  `idPago` int NOT NULL AUTO_INCREMENT,
  `idTipoPago` int NOT NULL,
  `idCronogramaPago` int NOT NULL,
  `fechaPago` date NOT NULL,
  `cantidadPago` decimal(8, 2) NOT NULL,
  `metodoPago` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conceptoPago` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idPago`) USING BTREE,
  INDEX `fk_pago_tipopago`(`idTipoPago`) USING BTREE,
  INDEX `fk_pago_cronogramapago`(`idCronogramaPago`) USING BTREE,
  CONSTRAINT `fk_pago_cronogramapago` FOREIGN KEY (`idCronogramaPago`) REFERENCES `cronograma_pago` (`idCronogramaPago`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_pago_tipopago` FOREIGN KEY (`idTipoPago`) REFERENCES `tipo_pago` (`idTipoPago`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pago
-- ----------------------------

-- ----------------------------
-- Table structure for personal
-- ----------------------------
DROP TABLE IF EXISTS `personal`;
CREATE TABLE `personal`  (
  `idPersonal` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `idTipoPersonal` int NOT NULL,
  `celularPersonal` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaContratacion` date NULL DEFAULT NULL,
  `correoPersonal` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombrePersonal` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidoPersonal` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idPersonal`) USING BTREE,
  INDEX `fk_personal_tipopersonal`(`idTipoPersonal`) USING BTREE,
  INDEX `fk_personal_usuario`(`idUsuario`) USING BTREE,
  CONSTRAINT `fk_personal_tipopersonal` FOREIGN KEY (`idTipoPersonal`) REFERENCES `tipo_personal` (`idTipoPersonal`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_personal_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal
-- ----------------------------

-- ----------------------------
-- Table structure for postulante
-- ----------------------------
DROP TABLE IF EXISTS `postulante`;
CREATE TABLE `postulante`  (
  `idPostulante` int NOT NULL AUTO_INCREMENT,
  `nombrePostulante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidoPostulante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dniPostulante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaPostulacion` date NOT NULL,
  `fechaNacimiento` date NULL DEFAULT NULL,
  `gradoPostulacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichaPostulante` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cartaAdeudo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `constanciaVacante` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fichaMatricula` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `certificadoNotas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `copiaDNI` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `libretaNotas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `estadoPostulante` int NOT NULL,
  `fechaCreacion` datetime NULL DEFAULT NULL,
  `fechaActualizacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`idPostulante`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of postulante
-- ----------------------------
INSERT INTO `postulante` VALUES (5, 'Fernando', 'Juarez', '98563265', '2024-02-01', '2024-02-01', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-02-01 12:30:01', '2024-02-01 12:30:01');
INSERT INTO `postulante` VALUES (6, 'Fernando', 'Juarez', '98563265', '2024-02-01', '2024-02-01', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-02-01 12:30:25', '2024-02-01 12:30:25');
INSERT INTO `postulante` VALUES (7, 'Fernando', 'Juarez', '98563265', '2024-02-01', '2024-02-01', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-02-01 12:33:06', '2024-02-01 12:33:06');
INSERT INTO `postulante` VALUES (8, 'Fernando', 'Juarez', '98563265', '2024-02-01', '2024-02-01', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-02-01 12:33:12', '2024-02-01 12:33:12');
INSERT INTO `postulante` VALUES (9, 'Paolo', 'Gallegos', '1231231231', '2024-02-02', '2024-02-01', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-02-01 12:37:22', '2024-02-01 12:37:22');
INSERT INTO `postulante` VALUES (10, 'Paolo', 'Gallegos', '1231231231', '2024-02-02', '2024-02-01', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-02-01 12:38:09', '2024-02-01 12:38:09');
INSERT INTO `postulante` VALUES (11, 'Guillermo', 'Tejada', '1231231231', '2024-02-29', '2024-02-01', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-02-01 12:47:29', '2024-02-02 16:55:04');
INSERT INTO `postulante` VALUES (12, 'Juan', 'Gutierrez', '989898989', '2024-02-02', '2024-02-02', '8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-02-02 15:14:40', '2024-02-02 15:14:40');

-- ----------------------------
-- Table structure for postulante_admision
-- ----------------------------
DROP TABLE IF EXISTS `postulante_admision`;
CREATE TABLE `postulante_admision`  (
  `idPostulanteAdmision` int NOT NULL AUTO_INCREMENT,
  `idPostulante` int NOT NULL,
  `idAdmision` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idPostulanteAdmision`) USING BTREE,
  INDEX `fk_postulante_admision`(`idPostulante`) USING BTREE,
  INDEX `fk_admision_postulante`(`idAdmision`) USING BTREE,
  CONSTRAINT `fk_admision_postulante` FOREIGN KEY (`idAdmision`) REFERENCES `admision` (`idAdmision`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_postulante_admision` FOREIGN KEY (`idPostulante`) REFERENCES `postulante` (`idPostulante`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of postulante_admision
-- ----------------------------

-- ----------------------------
-- Table structure for record_nota
-- ----------------------------
DROP TABLE IF EXISTS `record_nota`;
CREATE TABLE `record_nota`  (
  `idRecordNota` int NOT NULL AUTO_INCREMENT,
  `idAlumnoGrado` int NOT NULL,
  `idTipoNota` int NOT NULL,
  `nota` decimal(4, 2) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idRecordNota`) USING BTREE,
  INDEX `fk_recordnota_tiponota`(`idTipoNota`) USING BTREE,
  INDEX `fk_recordnota_alumnogrado`(`idAlumnoGrado`) USING BTREE,
  CONSTRAINT `fk_recordnota_alumnogrado` FOREIGN KEY (`idAlumnoGrado`) REFERENCES `alumno_grado` (`idAlumnoGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_recordnota_tiponota` FOREIGN KEY (`idTipoNota`) REFERENCES `tipo_nota` (`idTipoNota`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of record_nota
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_nota
-- ----------------------------
DROP TABLE IF EXISTS `tipo_nota`;
CREATE TABLE `tipo_nota`  (
  `idTipoNota` int NOT NULL AUTO_INCREMENT,
  `descripcionTipo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idTipoNota`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_nota
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_pago
-- ----------------------------
DROP TABLE IF EXISTS `tipo_pago`;
CREATE TABLE `tipo_pago`  (
  `idTipoPago` int NOT NULL AUTO_INCREMENT,
  `descripcionTipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idTipoPago`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_pago
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_personal
-- ----------------------------
DROP TABLE IF EXISTS `tipo_personal`;
CREATE TABLE `tipo_personal`  (
  `idTipoPersonal` int NOT NULL AUTO_INCREMENT,
  `descripcionTipo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idTipoPersonal`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_personal
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario`  (
  `idTipoUsuario` int NOT NULL AUTO_INCREMENT,
  `descripcionTipoUsuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idTipoUsuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_usuario
-- ----------------------------
INSERT INTO `tipo_usuario` VALUES (1, 'Administrador', '2024-01-29 12:50:58', '2024-01-29 12:50:58');
INSERT INTO `tipo_usuario` VALUES (2, 'Docente', '2024-01-29 12:50:58', '2024-01-29 12:50:58');
INSERT INTO `tipo_usuario` VALUES (3, 'Administrativo', '2024-01-29 12:50:58', '2024-01-29 12:50:58');
INSERT INTO `tipo_usuario` VALUES (4, 'Apoderado', '2024-01-29 12:50:58', '2024-01-29 12:50:58');

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `idTipoUsuario` int NOT NULL,
  `correoUsuario` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombreUsuario` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidoUsuario` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `dniUsuario` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estadoUsuario` int NOT NULL,
  `ultimaConexion` datetime NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`idUsuario`) USING BTREE,
  INDEX `fk_usuario_tipousuario`(`idTipoUsuario`) USING BTREE,
  CONSTRAINT `fk_usuario_tipousuario` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tipo_usuario` (`idTipoUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (1, 1, 'admin@gmail.com', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', 'David', 'Poblette', '98745632', 1, '2024-02-02 09:39:09', '2024-01-29 12:51:49', '0000-00-00 00:00:00');
INSERT INTO `usuario` VALUES (2, 3, 'david@gmail.com', '$argon2id$v=19$m=4096,t=2,p=2$NFcuQ2FoejF2ZkFpaU1YRQ$LY+w25WxkXWoq4o7606EKXD86jX4iZ8PJlpZjVx6O8c', 'Josesito', 'Traca', '123123', 1, '0000-00-00 00:00:00', '2024-02-01 12:48:10', '0000-00-00 00:00:00');
INSERT INTO `usuario` VALUES (3, 1, 'mgutierrez@gmail.com', '$argon2id$v=19$m=4096,t=2,p=2$cTBmblk0eVI4L1dDb2s1Wg$rkPhD0JVvQprJUQmorzwQbhQDX9jmty1H4RCFQMf+cE', 'Mauricio', 'Toledo', '55555', 1, '0000-00-00 00:00:00', '2024-02-01 12:50:04', '0000-00-00 00:00:00');

SET FOREIGN_KEY_CHECKS = 1;
