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

 Date: 14/05/2024 08:58:15
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
  `idPostulante` int NOT NULL,
  `fechaAdmision` date NOT NULL,
  `tipoAdmision` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAdmision`) USING BTREE,
  INDEX `fk_admision_anioescolar`(`idAnioEscolar`) USING BTREE,
  INDEX `fk_admision_postulante`(`idPostulante`) USING BTREE,
  CONSTRAINT `fk_admision_postulante` FOREIGN KEY (`idPostulante`) REFERENCES `postulante` (`idPostulante`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of admision
-- ----------------------------
INSERT INTO `admision` VALUES (1, 1, 1, '2024-04-19', '0', '2024-04-19 17:33:49', '2024-04-19 17:33:49', 1, 1);
INSERT INTO `admision` VALUES (2, 1, 2, '2024-04-22', '0', '2024-04-22 09:53:42', '2024-04-22 09:53:42', 1, 1);
INSERT INTO `admision` VALUES (3, 1, 3, '2024-04-22', '0', '2024-04-22 10:00:17', '2024-04-22 10:00:17', 1, 1);
INSERT INTO `admision` VALUES (4, 1, 4, '2024-04-22', '0', '2024-04-22 15:49:47', '2024-04-22 15:49:47', 1, 1);
INSERT INTO `admision` VALUES (5, 1, 5, '2024-04-22', '0', '2024-04-22 15:56:39', '2024-04-22 15:56:39', 1, 1);
INSERT INTO `admision` VALUES (6, 1, 6, '2024-04-22', '0', '2024-04-22 16:07:09', '2024-04-22 16:07:09', 1, 1);
INSERT INTO `admision` VALUES (7, 1, 8, '2024-04-22', '0', '2024-04-22 16:22:02', '2024-04-22 16:22:02', 1, 1);
INSERT INTO `admision` VALUES (8, 1, 8, '2024-04-22', '0', '2024-04-22 16:23:51', '2024-04-22 16:23:51', 1, 1);
INSERT INTO `admision` VALUES (9, 1, 7, '2024-04-22', '0', '2024-04-22 16:24:34', '2024-04-22 16:24:34', 1, 1);
INSERT INTO `admision` VALUES (10, 1, 8, '2024-04-22', '0', '2024-04-22 16:26:05', '2024-04-22 16:26:05', 1, 1);
INSERT INTO `admision` VALUES (11, 1, 7, '2024-04-22', '0', '2024-04-22 16:26:26', '2024-04-22 16:26:26', 1, 1);
INSERT INTO `admision` VALUES (12, 1, 8, '2024-04-22', '0', '2024-04-22 16:28:54', '2024-04-22 16:28:54', 1, 1);
INSERT INTO `admision` VALUES (13, 1, 7, '2024-04-22', '0', '2024-04-22 16:29:15', '2024-04-22 16:29:15', 1, 1);
INSERT INTO `admision` VALUES (14, 1, 9, '2024-04-22', '0', '2024-04-22 16:32:51', '2024-04-22 16:32:51', 1, 1);
INSERT INTO `admision` VALUES (15, 1, 9, '2024-04-22', '0', '2024-04-22 16:34:13', '2024-04-22 16:34:13', 1, 1);
INSERT INTO `admision` VALUES (16, 1, 9, '2024-04-22', '0', '2024-04-22 16:34:30', '2024-04-22 16:34:30', 1, 1);
INSERT INTO `admision` VALUES (17, 1, 9, '2024-04-22', '0', '2024-04-22 16:35:05', '2024-04-22 16:35:05', 1, 1);
INSERT INTO `admision` VALUES (18, 1, 9, '2024-04-22', '0', '2024-04-22 16:36:32', '2024-04-22 16:36:32', 1, 1);
INSERT INTO `admision` VALUES (19, 1, 9, '2024-04-22', '0', '2024-04-22 17:17:22', '2024-04-22 17:17:22', 1, 1);
INSERT INTO `admision` VALUES (20, 1, 8, '2024-04-22', '0', '2024-04-22 17:18:12', '2024-04-22 17:18:12', 1, 1);
INSERT INTO `admision` VALUES (21, 1, 10, '2024-04-23', '0', '2024-04-23 15:07:00', '2024-04-23 15:07:00', 1, 1);
INSERT INTO `admision` VALUES (22, 1, 10, '2024-04-23', '0', '2024-04-23 15:09:30', '2024-04-23 15:09:30', 1, 1);
INSERT INTO `admision` VALUES (23, 1, 10, '2024-04-23', '0', '2024-04-23 15:10:35', '2024-04-23 15:10:35', 1, 1);
INSERT INTO `admision` VALUES (24, 1, 10, '2024-04-23', '0', '2024-04-23 15:11:12', '2024-04-23 15:11:12', 1, 1);
INSERT INTO `admision` VALUES (25, 1, 10, '2024-04-23', '0', '2024-04-23 15:11:55', '2024-04-23 15:11:55', 1, 1);
INSERT INTO `admision` VALUES (26, 1, 10, '2024-04-23', '0', '2024-04-23 15:12:25', '2024-04-23 15:12:25', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAdmisionAlumno`) USING BTREE,
  INDEX `fk_admision_alumno`(`idAdmision`) USING BTREE,
  INDEX `fk_alumno_admision`(`idAlumno`) USING BTREE,
  CONSTRAINT `fk_admision_alumno` FOREIGN KEY (`idAdmision`) REFERENCES `admision` (`idAdmision`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_alumno_admision` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of admision_alumno
-- ----------------------------
INSERT INTO `admision_alumno` VALUES (1, 1, 1, 1, '2024-04-19 17:33:49', '2024-04-19 17:33:49', 1, 1);
INSERT INTO `admision_alumno` VALUES (2, 2, 2, 1, '2024-04-22 09:53:42', '2024-04-22 09:53:42', 1, 1);
INSERT INTO `admision_alumno` VALUES (3, 3, 3, 1, '2024-04-22 10:00:17', '2024-04-22 10:00:17', 1, 1);
INSERT INTO `admision_alumno` VALUES (4, 4, 4, 1, '2024-04-22 15:49:47', '2024-04-22 15:49:47', 1, 1);
INSERT INTO `admision_alumno` VALUES (5, 5, 5, 1, '2024-04-22 15:56:42', '2024-04-22 15:56:42', 1, 1);
INSERT INTO `admision_alumno` VALUES (6, 6, 6, 1, '2024-04-22 16:07:12', '2024-04-22 16:07:12', 1, 1);
INSERT INTO `admision_alumno` VALUES (7, 7, 7, 1, '2024-04-22 16:22:02', '2024-04-22 16:22:02', 1, 1);
INSERT INTO `admision_alumno` VALUES (8, 8, 8, 1, '2024-04-22 16:23:51', '2024-04-22 16:23:51', 1, 1);
INSERT INTO `admision_alumno` VALUES (9, 9, 9, 1, '2024-04-22 16:24:34', '2024-04-22 16:24:34', 1, 1);
INSERT INTO `admision_alumno` VALUES (10, 10, 10, 1, '2024-04-22 16:26:05', '2024-04-22 16:26:05', 1, 1);
INSERT INTO `admision_alumno` VALUES (11, 11, 11, 1, '2024-04-22 16:26:26', '2024-04-22 16:26:26', 1, 1);
INSERT INTO `admision_alumno` VALUES (12, 12, 12, 1, '2024-04-22 16:28:54', '2024-04-22 16:28:54', 1, 1);
INSERT INTO `admision_alumno` VALUES (13, 13, 13, 1, '2024-04-22 16:29:15', '2024-04-22 16:29:15', 1, 1);
INSERT INTO `admision_alumno` VALUES (14, 14, 14, 1, '2024-04-22 16:32:51', '2024-04-22 16:32:51', 1, 1);
INSERT INTO `admision_alumno` VALUES (15, 15, 15, 1, '2024-04-22 16:34:13', '2024-04-22 16:34:13', 1, 1);
INSERT INTO `admision_alumno` VALUES (16, 16, 16, 2, '2024-04-22 16:34:30', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `admision_alumno` VALUES (17, 17, 17, 1, '2024-04-22 16:35:05', '2024-04-22 16:35:05', 1, 1);
INSERT INTO `admision_alumno` VALUES (18, 18, 18, 1, '2024-04-22 16:36:32', '2024-04-22 16:36:32', 1, 1);
INSERT INTO `admision_alumno` VALUES (19, 19, 19, 1, '2024-04-22 17:17:22', '2024-04-22 17:17:22', 1, 1);
INSERT INTO `admision_alumno` VALUES (20, 20, 20, 2, '2024-04-22 17:18:12', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `admision_alumno` VALUES (21, 21, 21, 2, '2024-04-23 15:07:00', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `admision_alumno` VALUES (22, 22, 22, 1, '2024-04-23 15:09:30', '2024-04-23 15:09:30', 1, 1);
INSERT INTO `admision_alumno` VALUES (23, 23, 23, 2, '2024-04-23 15:10:35', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `admision_alumno` VALUES (24, 24, 24, 2, '2024-04-23 15:11:12', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `admision_alumno` VALUES (25, 25, 25, 2, '2024-04-23 15:11:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `admision_alumno` VALUES (26, 26, 26, 2, '2024-04-23 15:12:25', '2024-04-23 15:17:37', 1, 1);

-- ----------------------------
-- Table structure for alumno
-- ----------------------------
DROP TABLE IF EXISTS `alumno`;
CREATE TABLE `alumno`  (
  `idAlumno` int NOT NULL AUTO_INCREMENT,
  `estadoSiagie` int NULL DEFAULT NULL,
  `estadoAlumno` int NULL DEFAULT NULL,
  `estadoMatricula` int NULL DEFAULT NULL,
  `codAlumnoCaja` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombresAlumno` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidosAlumno` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexoAlumno` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dniAlumno` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `direccionAlumno` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `distritoAlumno` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `IEPProcedencia` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `seguroSalud` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaIngresoVolta` date NULL DEFAULT NULL,
  `numeroEmergencia` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `enfermedades` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAlumno`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of alumno
-- ----------------------------
INSERT INTO `alumno` VALUES (1, 1, 1, 1, NULL, 'Angel', 'Reinoso', NULL, '65656565', '2009-07-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-19 17:33:49', '2024-04-19 17:33:49', 1, 1);
INSERT INTO `alumno` VALUES (2, 1, 1, 1, NULL, 'Angela', 'Andrade', NULL, '55556666', '2014-02-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 09:53:42', '2024-04-22 09:53:42', 1, 1);
INSERT INTO `alumno` VALUES (3, 1, 1, 1, NULL, 'Miguel', 'Mendoza', NULL, '11112222', '2009-06-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 10:00:17', '2024-04-22 10:00:17', 1, 1);
INSERT INTO `alumno` VALUES (4, 1, 1, 1, NULL, 'Diana', 'Garcia', NULL, '22228888', '2013-06-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 15:49:47', '2024-04-22 15:49:47', 1, 1);
INSERT INTO `alumno` VALUES (5, 1, 1, 1, NULL, 'Manuel', 'Muñoz', NULL, '99996666', '2024-04-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 15:56:39', '2024-04-22 15:56:39', 1, 1);
INSERT INTO `alumno` VALUES (6, 1, 1, 1, NULL, 'Juan', 'Carpio', NULL, '99991111', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:07:09', '2024-04-22 16:07:09', 1, 1);
INSERT INTO `alumno` VALUES (7, 1, 1, 1, NULL, 'Julian', 'Nico', NULL, '22225555', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:22:02', '2024-04-22 16:22:02', 1, 1);
INSERT INTO `alumno` VALUES (8, 1, 1, 1, NULL, 'Julian', 'Nico', NULL, '22225555', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:23:51', '2024-04-22 16:23:51', 1, 1);
INSERT INTO `alumno` VALUES (9, 1, 1, 1, NULL, 'Karlo', 'Mostajo', NULL, '55551111', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:24:34', '2024-04-22 16:24:34', 1, 1);
INSERT INTO `alumno` VALUES (10, 1, 1, 1, NULL, 'Julian', 'Nico', NULL, '22225555', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:26:05', '2024-04-22 16:26:05', 1, 1);
INSERT INTO `alumno` VALUES (11, 1, 1, 1, NULL, 'Karlo', 'Mostajo', NULL, '55551111', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:26:26', '2024-04-22 16:26:26', 1, 1);
INSERT INTO `alumno` VALUES (12, 1, 1, 1, NULL, 'Julian', 'Nico', NULL, '22225555', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:28:54', '2024-04-22 16:28:54', 1, 1);
INSERT INTO `alumno` VALUES (13, 1, 1, 1, NULL, 'Karlo', 'Mostajo', NULL, '55551111', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:29:15', '2024-04-22 16:29:15', 1, 1);
INSERT INTO `alumno` VALUES (14, 1, 1, 1, NULL, 'Leonardo', 'DiCaprio', NULL, '32323232', '2024-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:32:51', '2024-04-22 16:32:51', 1, 1);
INSERT INTO `alumno` VALUES (15, 1, 1, 1, NULL, 'Leonardo', 'DiCaprio', NULL, '32323232', '2024-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:34:13', '2024-04-22 16:34:13', 1, 1);
INSERT INTO `alumno` VALUES (16, 1, 1, 1, NULL, 'Leonardo', 'DiCaprio', NULL, '32323232', '2024-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:34:30', '2024-04-22 16:34:30', 1, 1);
INSERT INTO `alumno` VALUES (17, 1, 1, 1, NULL, 'Leonardo', 'DiCaprio', NULL, '32323232', '2024-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:35:05', '2024-04-22 16:35:05', 1, 1);
INSERT INTO `alumno` VALUES (18, 1, 1, 1, NULL, 'Leonardo', 'DiCaprio', NULL, '32323232', '2024-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 16:36:32', '2024-04-22 16:36:32', 1, 1);
INSERT INTO `alumno` VALUES (19, 1, 1, 1, NULL, 'Leonardo', 'DiCaprio', NULL, '32323232', '2024-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 17:17:22', '2024-04-22 17:17:22', 1, 1);
INSERT INTO `alumno` VALUES (20, 1, 1, 1, NULL, 'Julian', 'Nico', NULL, '22225555', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-22 17:18:12', '2024-04-22 17:18:12', 1, 1);
INSERT INTO `alumno` VALUES (21, 1, 1, 1, NULL, 'Mauricio', 'Zegarra', NULL, '33221155', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-23 15:07:00', '2024-04-23 15:07:00', 1, 1);
INSERT INTO `alumno` VALUES (22, 1, 1, 1, NULL, 'Mauricio', 'Zegarra', NULL, '33221155', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-23 15:09:30', '2024-04-23 15:09:30', 1, 1);
INSERT INTO `alumno` VALUES (23, 1, 1, 1, NULL, 'Mauricio', 'Zegarra', NULL, '33221155', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-23 15:10:35', '2024-04-23 15:10:35', 1, 1);
INSERT INTO `alumno` VALUES (24, 1, 1, 1, NULL, 'Mauricio', 'Zegarra', NULL, '33221155', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-23 15:11:12', '2024-04-23 15:11:12', 1, 1);
INSERT INTO `alumno` VALUES (25, 1, 1, 1, NULL, 'Mauricio', 'Zegarra', NULL, '33221155', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-23 15:11:55', '2024-04-23 15:11:55', 1, 1);
INSERT INTO `alumno` VALUES (26, 1, 1, 1, NULL, 'Mauricio', 'Zegarra', NULL, '33221155', '2024-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-23 15:12:25', '2024-04-23 15:12:25', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAlumnoGrado`) USING BTREE,
  INDEX `fk_alumno_grado`(`idAlumno`) USING BTREE,
  INDEX `fk_grado_alumno`(`idGrado`) USING BTREE,
  CONSTRAINT `fk_alumno_grado` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_grado_alumno` FOREIGN KEY (`idGrado`) REFERENCES `grado` (`idGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of alumno_grado
-- ----------------------------
INSERT INTO `alumno_grado` VALUES (1, 1, 13, 1, '2024-04-19 17:33:49', '2024-04-19 17:33:49', 1, 1);
INSERT INTO `alumno_grado` VALUES (2, 2, 7, 1, '2024-04-22 09:53:42', '2024-04-22 09:53:42', 1, 1);
INSERT INTO `alumno_grado` VALUES (3, 3, 14, 1, '2024-04-22 10:00:17', '2024-04-22 10:00:17', 1, 1);
INSERT INTO `alumno_grado` VALUES (4, 4, 13, 1, '2024-04-22 15:49:47', '2024-04-22 15:49:47', 1, 1);
INSERT INTO `alumno_grado` VALUES (5, 5, 3, 1, '2024-04-22 15:56:39', '2024-04-22 15:56:39', 1, 1);
INSERT INTO `alumno_grado` VALUES (6, 6, 13, 1, '2024-04-22 16:07:09', '2024-04-22 16:07:09', 1, 1);
INSERT INTO `alumno_grado` VALUES (7, 7, 13, 1, '2024-04-22 16:22:02', '2024-04-22 16:22:02', 1, 1);
INSERT INTO `alumno_grado` VALUES (8, 8, 13, 1, '2024-04-22 16:23:51', '2024-04-22 16:23:51', 1, 1);
INSERT INTO `alumno_grado` VALUES (9, 9, 13, 1, '2024-04-22 16:24:34', '2024-04-22 16:24:34', 1, 1);
INSERT INTO `alumno_grado` VALUES (10, 10, 13, 1, '2024-04-22 16:26:05', '2024-04-22 16:26:05', 1, 1);
INSERT INTO `alumno_grado` VALUES (11, 11, 13, 1, '2024-04-22 16:26:26', '2024-04-22 16:26:26', 1, 1);
INSERT INTO `alumno_grado` VALUES (12, 12, 13, 1, '2024-04-22 16:28:54', '2024-04-22 16:28:54', 1, 1);
INSERT INTO `alumno_grado` VALUES (13, 13, 13, 1, '2024-04-22 16:29:15', '2024-04-22 16:29:15', 1, 1);
INSERT INTO `alumno_grado` VALUES (14, 14, 13, 1, '2024-04-22 16:32:51', '2024-04-22 16:32:51', 1, 1);
INSERT INTO `alumno_grado` VALUES (15, 15, 13, 1, '2024-04-22 16:34:13', '2024-04-22 16:34:13', 1, 1);
INSERT INTO `alumno_grado` VALUES (16, 16, 13, 1, '2024-04-22 16:34:30', '2024-04-22 16:34:30', 1, 1);
INSERT INTO `alumno_grado` VALUES (17, 17, 13, 1, '2024-04-22 16:35:05', '2024-04-22 16:35:05', 1, 1);
INSERT INTO `alumno_grado` VALUES (18, 18, 13, 1, '2024-04-22 16:36:32', '2024-04-22 16:36:32', 1, 1);
INSERT INTO `alumno_grado` VALUES (19, 19, 13, 1, '2024-04-22 17:17:22', '2024-04-22 17:17:22', 1, 1);
INSERT INTO `alumno_grado` VALUES (20, 20, 13, 1, '2024-04-22 17:18:12', '2024-04-22 17:18:12', 1, 1);
INSERT INTO `alumno_grado` VALUES (21, 21, 13, 1, '2024-04-23 15:07:00', '2024-04-23 15:07:00', 1, 1);
INSERT INTO `alumno_grado` VALUES (22, 22, 13, 1, '2024-04-23 15:09:30', '2024-04-23 15:09:30', 1, 1);
INSERT INTO `alumno_grado` VALUES (23, 23, 13, 1, '2024-04-23 15:10:35', '2024-04-23 15:10:35', 1, 1);
INSERT INTO `alumno_grado` VALUES (24, 24, 13, 1, '2024-04-23 15:11:12', '2024-04-23 15:11:12', 1, 1);
INSERT INTO `alumno_grado` VALUES (25, 25, 13, 1, '2024-04-23 15:11:55', '2024-04-23 15:11:55', 1, 1);
INSERT INTO `alumno_grado` VALUES (26, 26, 13, 1, '2024-04-23 15:12:25', '2024-04-23 15:12:25', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAlumGradCurso`) USING BTREE,
  INDEX `fk_alumnogrado_curso`(`idAlumnoGrado`) USING BTREE,
  INDEX `fk_curso_alumnogrado`(`idCurso`) USING BTREE,
  CONSTRAINT `fk_alumnogrado_curso` FOREIGN KEY (`idAlumnoGrado`) REFERENCES `alumno_grado` (`idAlumnoGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_curso_alumnogrado` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of alumnogrado_curso
-- ----------------------------

-- ----------------------------
-- Table structure for anio_admision
-- ----------------------------
DROP TABLE IF EXISTS `anio_admision`;
CREATE TABLE `anio_admision`  (
  `idAnioAdmision` int NOT NULL AUTO_INCREMENT,
  `idAnioEscolar` int NOT NULL,
  `idAdmisionAlumno` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAnioAdmision`) USING BTREE,
  INDEX `fk_admision_anio`(`idAdmisionAlumno`) USING BTREE,
  INDEX `fk_anio_admision`(`idAnioEscolar`) USING BTREE,
  CONSTRAINT `fk_admision_anio` FOREIGN KEY (`idAdmisionAlumno`) REFERENCES `admision_alumno` (`idAdmisionAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_anio_admision` FOREIGN KEY (`idAnioEscolar`) REFERENCES `anio_escolar` (`idAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of anio_admision
-- ----------------------------
INSERT INTO `anio_admision` VALUES (1, 1, 1, '2024-04-22 10:00:17', '2024-04-22 10:00:17', 1, 1);
INSERT INTO `anio_admision` VALUES (2, 1, 8, '2024-04-22 16:23:53', '2024-04-22 16:23:53', 1, 1);
INSERT INTO `anio_admision` VALUES (3, 1, 9, '2024-04-22 16:24:37', '2024-04-22 16:24:37', 1, 1);
INSERT INTO `anio_admision` VALUES (4, 1, 10, '2024-04-22 16:26:09', '2024-04-22 16:26:09', 1, 1);
INSERT INTO `anio_admision` VALUES (5, 1, 11, '2024-04-22 16:26:26', '2024-04-22 16:26:26', 1, 1);
INSERT INTO `anio_admision` VALUES (6, 1, 12, '2024-04-22 16:28:54', '2024-04-22 16:28:54', 1, 1);
INSERT INTO `anio_admision` VALUES (7, 1, 13, '2024-04-22 16:29:15', '2024-04-22 16:29:15', 1, 1);
INSERT INTO `anio_admision` VALUES (8, 1, 14, '2024-04-22 16:32:51', '2024-04-22 16:32:51', 1, 1);
INSERT INTO `anio_admision` VALUES (9, 1, 15, '2024-04-22 16:34:13', '2024-04-22 16:34:13', 1, 1);
INSERT INTO `anio_admision` VALUES (10, 1, 16, '2024-04-22 16:34:30', '2024-04-22 16:34:30', 1, 1);
INSERT INTO `anio_admision` VALUES (11, 1, 17, '2024-04-22 16:35:05', '2024-04-22 16:35:05', 1, 1);
INSERT INTO `anio_admision` VALUES (12, 1, 18, '2024-04-22 16:36:32', '2024-04-22 16:36:32', 1, 1);
INSERT INTO `anio_admision` VALUES (13, 1, 19, '2024-04-22 17:17:22', '2024-04-22 17:17:22', 1, 1);
INSERT INTO `anio_admision` VALUES (14, 1, 20, '2024-04-22 17:18:12', '2024-04-22 17:18:12', 1, 1);
INSERT INTO `anio_admision` VALUES (15, 1, 21, '2024-04-23 15:08:21', '2024-04-23 15:08:21', 1, 1);
INSERT INTO `anio_admision` VALUES (16, 1, 22, '2024-04-23 15:09:32', '2024-04-23 15:09:32', 1, 1);
INSERT INTO `anio_admision` VALUES (17, 1, 23, '2024-04-23 15:10:38', '2024-04-23 15:10:38', 1, 1);
INSERT INTO `anio_admision` VALUES (18, 1, 24, '2024-04-23 15:11:12', '2024-04-23 15:11:12', 1, 1);
INSERT INTO `anio_admision` VALUES (19, 1, 25, '2024-04-23 15:11:55', '2024-04-23 15:11:55', 1, 1);
INSERT INTO `anio_admision` VALUES (20, 1, 26, '2024-04-23 15:12:25', '2024-04-23 15:12:25', 1, 1);

-- ----------------------------
-- Table structure for anio_escolar
-- ----------------------------
DROP TABLE IF EXISTS `anio_escolar`;
CREATE TABLE `anio_escolar`  (
  `idAnioEscolar` int NOT NULL AUTO_INCREMENT,
  `descripcionAnio` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estadoAnio` int NOT NULL,
  `costoMatricula` decimal(10, 2) NOT NULL,
  `costoPension` decimal(10, 2) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `UsuarioCreacion` int NOT NULL,
  `UsuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAnioEscolar`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of anio_escolar
-- ----------------------------
INSERT INTO `anio_escolar` VALUES (1, 'Año 2024', 1, 150.00, 330.00, '2024-02-03 11:03:37', '2024-02-03 11:03:40', 1, 1);
INSERT INTO `anio_escolar` VALUES (2, 'Año 2023', 2, 150.00, 350.00, '2024-02-03 11:03:37', '2024-02-03 11:03:37', 1, 1);

-- ----------------------------
-- Table structure for apoderado
-- ----------------------------
DROP TABLE IF EXISTS `apoderado`;
CREATE TABLE `apoderado`  (
  `idApoderado` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NULL DEFAULT NULL,
  `nombreApoderado` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidoApoderado` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dniApoderado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `convivenciaAlumno` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaNacimiento` date NULL DEFAULT NULL,
  `tipoApoderado` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correoApoderado` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `celularApoderado` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dependenciaApoderado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `centroLaboral` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefonoTrabajo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ingresoMensual` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `gradoInstruccion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `profesionApoderado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `listaAlumnos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idApoderado`) USING BTREE,
  INDEX `fk_apoderador_usuario`(`idUsuario`) USING BTREE,
  CONSTRAINT `fk_apoderador_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of apoderado
-- ----------------------------
INSERT INTO `apoderado` VALUES (1, NULL, 'Andre', 'Reinoso', '12345678', 'Si', '2024-04-19', 'Padre', 'areinoso@gmail.com', '95623131', 'Independiente', 'Clinica Arequipa', '-', '4500', 'Superior', 'Medico', NULL, '2024-04-19 16:17:07', '2024-04-19 16:17:07', 1, 1);
INSERT INTO `apoderado` VALUES (2, NULL, '-', '-', '-', 'No', '1996-02-14', 'Madre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-19 16:17:07', '2024-04-19 16:17:07', 1, 1);
INSERT INTO `apoderado` VALUES (3, NULL, '-', '-', '-', 'No', '2024-04-01', 'Padre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-22 09:53:13', '2024-04-22 09:53:35', 1, 1);
INSERT INTO `apoderado` VALUES (4, NULL, '-', '-', '-', 'No', '2024-04-23', 'Madre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-22 09:53:13', '2024-04-22 09:53:35', 1, 1);
INSERT INTO `apoderado` VALUES (5, NULL, '-', '-', '-', 'No', '2024-04-23', 'Padre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-22 10:00:11', '2024-04-22 10:00:11', 1, 1);
INSERT INTO `apoderado` VALUES (6, NULL, '-', '-', '-', 'No', '2024-04-08', 'Madre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-22 10:00:11', '2024-04-22 10:00:11', 1, 1);
INSERT INTO `apoderado` VALUES (7, NULL, '-', '-', '-', 'No', '2024-04-22', 'Padre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-22 15:49:30', '2024-04-22 15:49:30', 1, 1);
INSERT INTO `apoderado` VALUES (8, NULL, '-', '-', '-', 'Si', '2024-04-22', 'Madre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-22 15:49:30', '2024-04-22 15:49:30', 1, 1);
INSERT INTO `apoderado` VALUES (9, NULL, '-', '-', '-', 'No', '2024-04-18', 'Padre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-22 15:56:18', '2024-04-22 15:56:18', 1, 1);
INSERT INTO `apoderado` VALUES (10, NULL, '-', '-', '-', 'Si', '2024-04-21', 'Madre', '-', '-', '-', '-', '-', '-----', '-', '-', NULL, '2024-04-22 15:56:18', '2024-04-22 15:56:18', 1, 1);
INSERT INTO `apoderado` VALUES (11, NULL, 'Paulo', 'Bernardo', '55552222', 'No', '2024-04-15', 'Padre', '-', '-', '-', '-', '-', '-', 'Superior', 'Medico', NULL, '2024-04-22 16:32:44', '2024-04-22 16:32:44', 1, 1);
INSERT INTO `apoderado` VALUES (12, NULL, '-', '-', '-', 'No', '2024-04-15', 'Madre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-22 16:32:44', '2024-04-22 16:32:44', 1, 1);
INSERT INTO `apoderado` VALUES (13, NULL, 'Pedro', 'Diaz', '55554444', 'Si', '2024-04-22', 'Padre', 'pdiaz@gmail.com', '-', '-', '-', '-', '-', 'Superior', 'Arquitecto', NULL, '2024-04-23 15:01:30', '2024-04-23 15:01:30', 1, 1);
INSERT INTO `apoderado` VALUES (14, NULL, '--', '-', '-', 'No', '2024-04-25', 'Madre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-23 15:01:30', '2024-04-23 15:01:30', 1, 1);
INSERT INTO `apoderado` VALUES (15, NULL, 'Adolfo', 'Gutierrez', '1231231231', 'No', '2024-04-17', 'Padre', 'asd@gmail.com', '-', '-', '-', '-', '-', 'Superior', 'Ingeniero', NULL, '2024-04-23 16:34:14', '2024-04-23 16:34:14', 1, 1);
INSERT INTO `apoderado` VALUES (16, NULL, '-', '-', '-', 'No', '2024-04-26', 'Madre', '-', '-', '-', '-', '-', '-', '-', '-', NULL, '2024-04-23 16:34:14', '2024-04-23 16:34:14', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idApoderadoAlumno`) USING BTREE,
  INDEX `fk_apoderado_alumno`(`idApoderado`) USING BTREE,
  INDEX `fk_alumno_apoderado`(`idAlumno`) USING BTREE,
  CONSTRAINT `fk_alumno_apoderado` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_apoderado_alumno` FOREIGN KEY (`idApoderado`) REFERENCES `apoderado` (`idApoderado`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of apoderado_alumno
-- ----------------------------
INSERT INTO `apoderado_alumno` VALUES (1, 26, 13, '2024-04-23 15:12:29', '2024-04-23 15:12:29', 1, 1);
INSERT INTO `apoderado_alumno` VALUES (2, 26, 14, '2024-04-23 15:12:30', '2024-04-23 15:12:30', 1, 1);

-- ----------------------------
-- Table structure for area
-- ----------------------------
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area`  (
  `idArea` int NOT NULL AUTO_INCREMENT,
  `descripcionArea` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idArea`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAsistencia`) USING BTREE,
  INDEX `fk_horario_asistencia`(`idHorario`) USING BTREE,
  CONSTRAINT `fk_horario_asistencia` FOREIGN KEY (`idHorario`) REFERENCES `horario` (`idHorario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idComunicacionPago`) USING BTREE,
  INDEX `fk_comunicacionpago_cronogramapago`(`idCronogramaPago`) USING BTREE,
  CONSTRAINT `fk_comunicacionpago_cronogramapago` FOREIGN KEY (`idCronogramaPago`) REFERENCES `cronograma_pago` (`idCronogramaPago`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of comunicacion_pago
-- ----------------------------
INSERT INTO `comunicacion_pago` VALUES (1, 1, '2024-04-23 09:00:42', '0000-00-00 00:00:00', 1, 0);

-- ----------------------------
-- Table structure for cronograma_pago
-- ----------------------------
DROP TABLE IF EXISTS `cronograma_pago`;
CREATE TABLE `cronograma_pago`  (
  `idCronogramaPago` int NOT NULL AUTO_INCREMENT,
  `idAdmisionAlumno` int NOT NULL,
  `conceptoPago` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `montoPago` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaLimite` date NOT NULL,
  `estadoCronograma` int NOT NULL,
  `mesPago` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idCronogramaPago`) USING BTREE,
  INDEX `fk_cronograma_admisionalumno`(`idAdmisionAlumno`) USING BTREE,
  CONSTRAINT `fk_cronograma_admisionalumno` FOREIGN KEY (`idAdmisionAlumno`) REFERENCES `admision_alumno` (`idAdmisionAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 78 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cronograma_pago
-- ----------------------------
INSERT INTO `cronograma_pago` VALUES (1, 16, 'Matrícula', '150.00', '2021-03-05', 1, 'Matricula', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (2, 16, 'Pensión', '330.00', '2024-03-31', 1, 'Marzo', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (3, 16, 'Pensión', '330.00', '2024-04-30', 1, 'Abril', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (4, 16, 'Pensión', '330.00', '2024-05-31', 1, 'Mayo', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (5, 16, 'Pensión', '330.00', '2024-06-30', 1, 'Junio', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (6, 16, 'Pensión', '330.00', '2024-07-31', 1, 'Julio', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (7, 16, 'Pensión', '330.00', '2024-08-31', 1, 'Agosto', '2024-04-23 08:57:12', '2024-04-23 08:57:20', 1, 1);
INSERT INTO `cronograma_pago` VALUES (8, 16, 'Pensión', '330.00', '2024-09-30', 1, 'Septiembre', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (9, 16, 'Pensión', '330.00', '2024-10-31', 1, 'Octubre', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (10, 16, 'Pensión', '330.00', '2024-11-30', 1, 'Noviembre', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (11, 16, 'Pensión', '330.00', '2024-12-31', 1, 'Diciembre', '2024-04-23 08:57:12', '2024-04-23 08:57:12', 1, 1);
INSERT INTO `cronograma_pago` VALUES (12, 20, 'Matrícula', '150.00', '2021-03-05', 1, 'Matricula', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (13, 20, 'Pensión', '330.00', '2024-03-31', 1, 'Marzo', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (14, 20, 'Pensión', '330.00', '2024-04-30', 1, 'Abril', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (15, 20, 'Pensión', '330.00', '2024-05-31', 1, 'Mayo', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (16, 20, 'Pensión', '330.00', '2024-06-30', 1, 'Junio', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (17, 20, 'Pensión', '330.00', '2024-07-31', 1, 'Julio', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (18, 20, 'Pensión', '330.00', '2024-08-31', 1, 'Agosto', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (19, 20, 'Pensión', '330.00', '2024-09-30', 1, 'Septiembre', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (20, 20, 'Pensión', '330.00', '2024-10-31', 1, 'Octubre', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (21, 20, 'Pensión', '330.00', '2024-11-30', 1, 'Noviembre', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (22, 20, 'Pensión', '330.00', '2024-12-31', 1, 'Diciembre', '2024-04-23 14:59:06', '2024-04-23 14:59:06', 1, 1);
INSERT INTO `cronograma_pago` VALUES (23, 26, 'Matrícula', '150.00', '2021-03-05', 1, 'Matricula', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (24, 26, 'Pensión', '330.00', '2024-03-31', 1, 'Marzo', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (25, 26, 'Pensión', '330.00', '2024-04-30', 1, 'Abril', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (26, 26, 'Pensión', '330.00', '2024-05-31', 1, 'Mayo', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (27, 26, 'Pensión', '330.00', '2024-06-30', 1, 'Junio', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (28, 26, 'Pensión', '330.00', '2024-07-31', 1, 'Julio', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (29, 26, 'Pensión', '330.00', '2024-08-31', 1, 'Agosto', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (30, 26, 'Pensión', '330.00', '2024-09-30', 1, 'Septiembre', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (31, 26, 'Pensión', '330.00', '2024-10-31', 1, 'Octubre', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (32, 26, 'Pensión', '330.00', '2024-11-30', 1, 'Noviembre', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (33, 26, 'Pensión', '330.00', '2024-12-31', 1, 'Diciembre', '2024-04-23 15:17:37', '2024-04-23 15:17:37', 1, 1);
INSERT INTO `cronograma_pago` VALUES (34, 25, 'Matrícula', '150.00', '2021-03-05', 1, 'Matricula', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (35, 25, 'Pensión', '330.00', '2024-03-31', 1, 'Marzo', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (36, 25, 'Pensión', '330.00', '2024-04-30', 1, 'Abril', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (37, 25, 'Pensión', '330.00', '2024-05-31', 1, 'Mayo', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (38, 25, 'Pensión', '330.00', '2024-06-30', 1, 'Junio', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (39, 25, 'Pensión', '330.00', '2024-07-31', 1, 'Julio', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (40, 25, 'Pensión', '330.00', '2024-08-31', 1, 'Agosto', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (41, 25, 'Pensión', '330.00', '2024-09-30', 1, 'Septiembre', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (42, 25, 'Pensión', '330.00', '2024-10-31', 1, 'Octubre', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (43, 25, 'Pensión', '330.00', '2024-11-30', 1, 'Noviembre', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (44, 25, 'Pensión', '330.00', '2024-12-31', 1, 'Diciembre', '2024-04-25 12:00:55', '2024-04-25 12:00:55', 1, 1);
INSERT INTO `cronograma_pago` VALUES (45, 24, 'Matrícula', '150.00', '2021-03-05', 1, 'Matricula', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (46, 24, 'Pensión', '330.00', '2024-03-31', 1, 'Marzo', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (47, 24, 'Pensión', '330.00', '2024-04-30', 1, 'Abril', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (48, 24, 'Pensión', '330.00', '2024-05-31', 1, 'Mayo', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (49, 24, 'Pensión', '330.00', '2024-06-30', 1, 'Junio', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (50, 24, 'Pensión', '330.00', '2024-07-31', 1, 'Julio', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (51, 24, 'Pensión', '330.00', '2024-08-31', 1, 'Agosto', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (52, 24, 'Pensión', '330.00', '2024-09-30', 1, 'Septiembre', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (53, 24, 'Pensión', '330.00', '2024-10-31', 1, 'Octubre', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (54, 24, 'Pensión', '330.00', '2024-11-30', 1, 'Noviembre', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (55, 24, 'Pensión', '330.00', '2024-12-31', 1, 'Diciembre', '2024-04-25 12:01:00', '2024-04-25 12:01:00', 1, 1);
INSERT INTO `cronograma_pago` VALUES (56, 23, 'Matrícula', '150.00', '2021-03-05', 1, 'Matricula', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (57, 23, 'Pensión', '330.00', '2024-03-31', 1, 'Marzo', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (58, 23, 'Pensión', '330.00', '2024-04-30', 1, 'Abril', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (59, 23, 'Pensión', '330.00', '2024-05-31', 1, 'Mayo', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (60, 23, 'Pensión', '330.00', '2024-06-30', 1, 'Junio', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (61, 23, 'Pensión', '330.00', '2024-07-31', 1, 'Julio', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (62, 23, 'Pensión', '330.00', '2024-08-31', 1, 'Agosto', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (63, 23, 'Pensión', '330.00', '2024-09-30', 1, 'Septiembre', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (64, 23, 'Pensión', '330.00', '2024-10-31', 1, 'Octubre', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (65, 23, 'Pensión', '330.00', '2024-11-30', 1, 'Noviembre', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (66, 23, 'Pensión', '330.00', '2024-12-31', 1, 'Diciembre', '2024-04-25 12:08:11', '2024-04-25 12:08:11', 1, 1);
INSERT INTO `cronograma_pago` VALUES (67, 21, 'Matrícula', '150.00', '2021-03-05', 1, 'Matricula', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (68, 21, 'Pensión', '330.00', '2024-03-31', 1, 'Marzo', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (69, 21, 'Pensión', '330.00', '2024-04-30', 1, 'Abril', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (70, 21, 'Pensión', '330.00', '2024-05-31', 1, 'Mayo', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (71, 21, 'Pensión', '330.00', '2024-06-30', 1, 'Junio', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (72, 21, 'Pensión', '330.00', '2024-07-31', 1, 'Julio', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (73, 21, 'Pensión', '330.00', '2024-08-31', 1, 'Agosto', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (74, 21, 'Pensión', '330.00', '2024-09-30', 1, 'Septiembre', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (75, 21, 'Pensión', '330.00', '2024-10-31', 1, 'Octubre', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (76, 21, 'Pensión', '330.00', '2024-11-30', 1, 'Noviembre', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);
INSERT INTO `cronograma_pago` VALUES (77, 21, 'Pensión', '330.00', '2024-12-31', 1, 'Diciembre', '2024-04-25 12:08:28', '2024-04-25 12:08:28', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idCurso`) USING BTREE,
  INDEX `fk_curso_area`(`idArea`) USING BTREE,
  CONSTRAINT `fk_curso_area` FOREIGN KEY (`idArea`) REFERENCES `area` (`idArea`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of curso
-- ----------------------------

-- ----------------------------
-- Table structure for curso_grado
-- ----------------------------
DROP TABLE IF EXISTS `curso_grado`;
CREATE TABLE `curso_grado`  (
  `idCursoGrado` int NOT NULL,
  `idCurso` int NOT NULL,
  `idGrado` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idCursoGrado`) USING BTREE,
  INDEX `fk_grado_curso`(`idGrado`) USING BTREE,
  INDEX `fk_curso_grado`(`idCurso`) USING BTREE,
  CONSTRAINT `fk_curso_grado` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_grado_curso` FOREIGN KEY (`idGrado`) REFERENCES `grado` (`idGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of curso_grado
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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idDetalleComunicacion`) USING BTREE,
  INDEX `fk_detallecomunicacion_comunicacion`(`idComunicacionPago`) USING BTREE,
  CONSTRAINT `fk_detallecomunicacion_comunicacion` FOREIGN KEY (`idComunicacionPago`) REFERENCES `comunicacion_pago` (`idComunicacionPago`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of detalle_comunicacion_pago
-- ----------------------------
INSERT INTO `detalle_comunicacion_pago` VALUES (1, 1, 'Deuda Pendiente Marzo', 'Se le comunico de una deuda pendiente', '2024-04-23', '2024-04-23 09:00:42', '2024-04-23 09:00:51', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idGrado`) USING BTREE,
  INDEX `fk_grado_nivel`(`idNivel`) USING BTREE,
  CONSTRAINT `fk_grado_nivel` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`idNivel`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of grado
-- ----------------------------
INSERT INTO `grado` VALUES (1, 1, '3 Años', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (2, 1, '4 Años', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (3, 1, '5 Años', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (4, 2, '1er Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (5, 2, '2do Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (6, 2, '3er Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (7, 2, '4to Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (8, 2, '5to Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (9, 2, '6to Grado', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (10, 3, '1er Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (11, 3, '2do Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (12, 3, '3er Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (13, 3, '4to Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);
INSERT INTO `grado` VALUES (14, 3, '5to Año', '2024-01-31 09:17:44', '2024-01-31 09:17:44', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idHorario`) USING BTREE,
  INDEX `fk_horario_alumnogrado`(`idAlumGradCurso`) USING BTREE,
  CONSTRAINT `fk_horario_alumnogrado` FOREIGN KEY (`idAlumGradCurso`) REFERENCES `alumnogrado_curso` (`idAlumGradCurso`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idNivel`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nivel
-- ----------------------------
INSERT INTO `nivel` VALUES (1, 'Inicial', '2024-01-31 09:14:10', '2024-01-31 09:14:10', 1, 1);
INSERT INTO `nivel` VALUES (2, 'Primaria', '2024-01-31 09:14:10', '2024-01-31 09:14:10', 1, 1);
INSERT INTO `nivel` VALUES (3, 'Secundaria', '2024-01-31 09:14:10', '2024-01-31 09:14:10', 1, 1);

-- ----------------------------
-- Table structure for pago
-- ----------------------------
DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago`  (
  `idPago` int NOT NULL AUTO_INCREMENT,
  `idTipoPago` int NOT NULL,
  `idCronogramaPago` int NULL DEFAULT NULL,
  `fechaPago` date NOT NULL,
  `cantidadPago` decimal(8, 2) NOT NULL,
  `metodoPago` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroComprobante` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `moraPago` decimal(10, 2) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idPago`) USING BTREE,
  INDEX `fk_pago_tipopago`(`idTipoPago`) USING BTREE,
  INDEX `fk_pago_cronogramapago`(`idCronogramaPago`) USING BTREE,
  CONSTRAINT `fk_pago_cronogramapago` FOREIGN KEY (`idCronogramaPago`) REFERENCES `cronograma_pago` (`idCronogramaPago`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_pago_tipopago` FOREIGN KEY (`idTipoPago`) REFERENCES `tipo_pago` (`idTipoPago`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idPersonal`) USING BTREE,
  INDEX `fk_personal_tipopersonal`(`idTipoPersonal`) USING BTREE,
  INDEX `fk_personal_usuario`(`idUsuario`) USING BTREE,
  CONSTRAINT `fk_personal_tipopersonal` FOREIGN KEY (`idTipoPersonal`) REFERENCES `tipo_personal` (`idTipoPersonal`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_personal_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal
-- ----------------------------
INSERT INTO `personal` VALUES (1, 2, 4, NULL, NULL, 'mcervantes@gmail.com', 'Miguel', 'Cervantes', '2024-05-04 10:31:33', '2024-05-04 10:31:33', 1, 1);

-- ----------------------------
-- Table structure for postulante
-- ----------------------------
DROP TABLE IF EXISTS `postulante`;
CREATE TABLE `postulante`  (
  `idPostulante` int NOT NULL AUTO_INCREMENT,
  `nombrePostulante` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidoPostulante` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexoPostulante` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dniPostulante` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaNacimiento` date NULL DEFAULT NULL,
  `lugarNacimiento` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `gradoPostulacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `domicilioPostulante` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `colegioProcedencia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dificultadPostulante` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dificultadObservacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipoAtencionPostulante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tratamientoPostulante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaPostulacion` date NOT NULL,
  `listaApoderados` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichaPostulante` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaFichaPost` date NULL DEFAULT NULL,
  `estadoFichaPostulante` int NULL DEFAULT NULL,
  `fechaEntrevista` date NULL DEFAULT NULL,
  `estadoEntrevista` int NULL DEFAULT NULL,
  `informePsicologico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaInformePsicologico` date NULL DEFAULT NULL,
  `estadoInformePsicologico` int NULL DEFAULT NULL,
  `fechaConstanciaAdeudo` date NULL DEFAULT NULL,
  `cartaAdmision` bit(1) NULL DEFAULT NULL,
  `fechaCartaAdmision` date NULL DEFAULT NULL,
  `pagoMatricula` int NULL DEFAULT NULL,
  `fechaPagoMatricula` date NULL DEFAULT NULL,
  `contrato` bit(1) NULL DEFAULT NULL,
  `fechaContrato` date NULL DEFAULT NULL,
  `constanciaVacante` bit(1) NULL DEFAULT NULL,
  `fechaConstanciaVacante` date NULL DEFAULT NULL,
  `estadoPostulante` int NOT NULL,
  `fechaCreacion` datetime NULL DEFAULT NULL,
  `fechaActualizacion` datetime NULL DEFAULT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idPostulante`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of postulante
-- ----------------------------
INSERT INTO `postulante` VALUES (1, 'Angel', 'Reinoso', 'Masculino', '65656565', '2009-07-19', 'Arequi', '13', 'Urb. Nueva Esperanza N1', 'Alexander Fleming', 'Ninguna', '-', 'SIS', '-', '2024-04-12', '{\"idPadre\":1,\"idMadre\":2}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-04-19 16:17:07', '2024-04-19 17:33:49', 1, 1);
INSERT INTO `postulante` VALUES (2, 'Angela', 'Andrade', 'Masculino', '55556666', '2014-02-05', 'Arequipa', '7', 'Urb. Escondida c1', 'Mercedario', 'Ninguna', '*-', '-', '-', '2024-04-24', '{\"idPadre\":3,\"idMadre\":4}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2024-04-22 09:53:13', '2024-04-22 09:53:42', 1, 1);
INSERT INTO `postulante` VALUES (3, 'Miguel', 'Mendoza', 'Masculino', '11112222', '2009-06-22', 'Arequipa', '14', 'Urb. Esperanza a1', '-', 'Ninguna', '-', '-', '-', '2024-04-25', '{\"idPadre\":5,\"idMadre\":6}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2024-04-22 10:00:11', '2024-04-22 10:00:17', 1, 1);
INSERT INTO `postulante` VALUES (4, 'Diana', 'Garcia', 'Femenino', '22228888', '2013-06-04', 'Arequipa', '13', 'Urb. Cerrada C1', 'Pilar', 'Ninguna', '-', '-', '-', '2024-04-19', '{\"idPadre\":7,\"idMadre\":8}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-04-22 15:49:30', '2024-04-22 15:49:47', 1, 1);
INSERT INTO `postulante` VALUES (5, 'Manuel', 'Muñoz', 'Masculino', '99996666', '2024-04-29', 'Arequipa', '3', 'Urb. Cerrado', 'Cercadito', 'Ninguna', '-', '-', '-', '2024-04-22', '{\"idPadre\":7,\"idMadre\":8}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-04-22 15:56:18', '2024-04-22 15:56:39', 1, 1);
INSERT INTO `postulante` VALUES (6, 'Juan', 'Carpio', 'Masculino', '99991111', '2024-04-22', 'Arequipa', '13', 'Urb. Cerrada C1', 'Pilar', 'Ninguna', '+', '+', '+', '2024-04-22', '{\"idPadre\":7,\"idMadre\":8}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-04-22 16:20:38', '2024-04-22 16:07:09', 1, 1);
INSERT INTO `postulante` VALUES (7, 'Karlo', 'Mostajo', 'Masculino', '55551111', '2024-04-22', 'Arequipa', '13', 'Urb. Cerrada C1', 'Pilar', NULL, NULL, NULL, NULL, '0000-00-00', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-04-22 16:20:38', '2024-04-22 16:29:15', 1, 1);
INSERT INTO `postulante` VALUES (8, 'Julian', 'Nico', 'Masculino', '22225555', '2024-04-22', 'Arequipa', '13', 'Urb. Cerrada C1', 'Pilar', NULL, NULL, NULL, NULL, '0000-00-00', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-04-22 16:20:38', '2024-04-22 17:18:12', 1, 1);
INSERT INTO `postulante` VALUES (9, 'Leonardo', 'DiCaprio', 'Masculino', '32323232', '2024-04-30', 'Arequipa', '13', 'Urb. Esperanza', '-', 'Ninguna', '-', '-', '-', '2024-04-23', '{\"idPadre\":11,\"idMadre\":12}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-04-22 16:32:44', '2024-04-22 17:17:22', 1, 1);
INSERT INTO `postulante` VALUES (10, 'Mauricio', 'Zegarra', 'Masculino', '33221155', '2024-04-22', 'Arequipa', '13', 'Urb. Cerrada', 'Pilar', 'Ninguna', '-', '-', '-', '2024-04-25', '{\"idPadre\":13,\"idMadre\":14}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2024-04-23 15:01:30', '2024-04-23 15:12:25', 1, 1);
INSERT INTO `postulante` VALUES (11, 'Angel', 'Carrillo', 'Masculino', '12345678', '2024-04-23', 'Arequipa', '12', 'Urb. Cerrada 11', 'Pilar', 'Ninguna', '-', '-', '-', '2024-04-09', '{\"idPadre\":15,\"idMadre\":16}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 16:34:14', '2024-04-23 16:34:14', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idRecordNota`) USING BTREE,
  INDEX `fk_recordnota_tiponota`(`idTipoNota`) USING BTREE,
  INDEX `fk_recordnota_alumnogrado`(`idAlumnoGrado`) USING BTREE,
  CONSTRAINT `fk_recordnota_alumnogrado` FOREIGN KEY (`idAlumnoGrado`) REFERENCES `alumno_grado` (`idAlumnoGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_recordnota_tiponota` FOREIGN KEY (`idTipoNota`) REFERENCES `tipo_nota` (`idTipoNota`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idTipoNota`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idTipoPago`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_pago
-- ----------------------------
INSERT INTO `tipo_pago` VALUES (1, 'Pago Matrícula', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);
INSERT INTO `tipo_pago` VALUES (2, 'Pago Pensión', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);

-- ----------------------------
-- Table structure for tipo_personal
-- ----------------------------
DROP TABLE IF EXISTS `tipo_personal`;
CREATE TABLE `tipo_personal`  (
  `idTipoPersonal` int NOT NULL AUTO_INCREMENT,
  `descripcionTipo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idTipoPersonal`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_personal
-- ----------------------------
INSERT INTO `tipo_personal` VALUES (1, 'Docente Inicial', '2024-03-01 17:11:47', '2024-03-01 17:11:47', 1, 1);
INSERT INTO `tipo_personal` VALUES (2, 'Docente Primaria', '2024-03-01 17:11:47', '2024-03-01 17:11:47', 1, 1);
INSERT INTO `tipo_personal` VALUES (3, 'Docente Secundaria', '2024-03-01 17:11:47', '2024-03-01 17:11:47', 1, 1);
INSERT INTO `tipo_personal` VALUES (4, 'Docente General', '2024-03-01 17:11:47', '2024-03-01 17:11:47', 1, 1);
INSERT INTO `tipo_personal` VALUES (5, 'Dirección', '2024-03-01 17:11:47', '2024-03-01 17:11:47', 1, 1);
INSERT INTO `tipo_personal` VALUES (6, 'Administrativo', '2024-03-01 17:11:47', '2024-03-01 17:11:47', 1, 1);

-- ----------------------------
-- Table structure for tipo_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario`  (
  `idTipoUsuario` int NOT NULL AUTO_INCREMENT,
  `descripcionTipoUsuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idTipoUsuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_usuario
-- ----------------------------
INSERT INTO `tipo_usuario` VALUES (1, 'Administrador', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);
INSERT INTO `tipo_usuario` VALUES (2, 'Docente', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);
INSERT INTO `tipo_usuario` VALUES (3, 'Administrativo', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);
INSERT INTO `tipo_usuario` VALUES (4, 'Apoderado', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idUsuario`) USING BTREE,
  INDEX `fk_usuario_tipousuario`(`idTipoUsuario`) USING BTREE,
  CONSTRAINT `fk_usuario_tipousuario` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tipo_usuario` (`idTipoUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (1, 3, 'admin@gmail.com', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', 'David', 'Poblette', '98745632', 1, '2024-05-14 08:35:30', '2024-01-29 12:51:49', '2024-01-29 12:51:49', 1, 1);
INSERT INTO `usuario` VALUES (2, 2, 'mcervantes@gmail.com', '$argon2id$v=19$m=4096,t=2,p=2$SjJibWhBY2hvOXdocy5KTA$znK5Zqve3pFqF70MMCUhEG6u90YrXDT7zJ1vIzNSDOM', 'Miguel', 'Cervantes', '85858585', 1, '0000-00-00 00:00:00', '2024-05-04 10:31:33', '2024-05-04 10:31:33', 1, 1);

SET FOREIGN_KEY_CHECKS = 1;
