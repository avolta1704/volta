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

 Date: 25/06/2024 15:39:01
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
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAdmisionAlumno`) USING BTREE,
  INDEX `fk_admision_alumno`(`idAdmision`) USING BTREE,
  INDEX `fk_alumno_admision`(`idAlumno`) USING BTREE,
  CONSTRAINT `fk_admision_alumno` FOREIGN KEY (`idAdmision`) REFERENCES `admision` (`idAdmision`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_alumno_admision` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of admision_alumno
-- ----------------------------

-- ----------------------------
-- Table structure for alumno
-- ----------------------------
DROP TABLE IF EXISTS `alumno`;
CREATE TABLE `alumno`  (
  `idAlumno` int NOT NULL AUTO_INCREMENT,
  `estadoSiagie` int NULL DEFAULT NULL,
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
  `nuevoAlumno` bit(1) NULL DEFAULT NULL,
  `numeroEmergencia` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `enfermedades` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAlumno`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 54 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of alumno
-- ----------------------------

-- ----------------------------
-- Table structure for alumno_anio_escolar
-- ----------------------------
DROP TABLE IF EXISTS `alumno_anio_escolar`;
CREATE TABLE `alumno_anio_escolar`  (
  `idAlumnoAnioEscolar` int NOT NULL AUTO_INCREMENT,
  `idAlumno` int NOT NULL,
  `idAnioEscolar` int NOT NULL,
  `idGrado` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAlumnoAnioEscolar`) USING BTREE,
  INDEX `fk_anio_escolar`(`idAnioEscolar`) USING BTREE,
  INDEX `fk_alumno`(`idAlumno`) USING BTREE,
  INDEX `fk_grado`(`idGrado`) USING BTREE,
  INDEX `idAlumnoAnioEscolar`(`idAlumnoAnioEscolar`) USING BTREE,
  CONSTRAINT `fk_alumno` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_anio_escolar` FOREIGN KEY (`idAnioEscolar`) REFERENCES `anio_escolar` (`idAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_grado` FOREIGN KEY (`idGrado`) REFERENCES `grado` (`idGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of alumno_anio_escolar
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
) ENGINE = InnoDB AUTO_INCREMENT = 47 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of anio_admision
-- ----------------------------

-- ----------------------------
-- Table structure for anio_cursogrado
-- ----------------------------
DROP TABLE IF EXISTS `anio_cursogrado`;
CREATE TABLE `anio_cursogrado`  (
  `idAnioCursoPersonal` int NOT NULL AUTO_INCREMENT,
  `idAnioEscolar` int NOT NULL,
  `idCursogradoPersonal` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAnioCursoPersonal`) USING BTREE,
  INDEX `fk_anio_cursogrado`(`idAnioEscolar`) USING BTREE,
  INDEX `fk_cursogrado_anio`(`idCursogradoPersonal`) USING BTREE,
  CONSTRAINT `fk_anio_cursogrado` FOREIGN KEY (`idAnioEscolar`) REFERENCES `anio_escolar` (`idAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_cursogrado_anio` FOREIGN KEY (`idCursogradoPersonal`) REFERENCES `cursogrado_personal` (`idCursogradoPersonal`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of anio_cursogrado
-- ----------------------------

-- ----------------------------
-- Table structure for anio_escolar
-- ----------------------------
DROP TABLE IF EXISTS `anio_escolar`;
CREATE TABLE `anio_escolar`  (
  `idAnioEscolar` int NOT NULL AUTO_INCREMENT,
  `descripcionAnio` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estadoAnio` int NOT NULL,
  `cuotaInicial` decimal(10, 2) NOT NULL,
  `matriculaInicial` decimal(10, 2) NULL DEFAULT NULL,
  `pensionInicial` decimal(10, 2) NULL DEFAULT NULL,
  `matriculaPrimaria` decimal(10, 2) NULL DEFAULT NULL,
  `pensionPrimaria` decimal(10, 2) NULL DEFAULT NULL,
  `matriculaSecundaria` decimal(10, 2) NULL DEFAULT NULL,
  `pensionSecundaria` decimal(10, 2) NULL DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAnioEscolar`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of anio_escolar
-- ----------------------------
INSERT INTO `anio_escolar` VALUES (1, 'Año 2024', 1, 480.00, 150.00, 200.00, 160.00, 250.00, 175.00, 260.00, '2024-02-03 11:03:37', '2024-02-03 11:03:37', 1, 1);
INSERT INTO `anio_escolar` VALUES (2, 'Año 2023', 2, 460.00, 150.00, 200.00, 160.00, 250.00, 175.00, 260.00, '2023-02-03 11:03:37', '2023-02-03 11:03:37', 1, 1);

-- ----------------------------
-- Table structure for anio_postulante
-- ----------------------------
DROP TABLE IF EXISTS `anio_postulante`;
CREATE TABLE `anio_postulante`  (
  `idAnioPostulante` int NOT NULL AUTO_INCREMENT,
  `idAnioEscolar` int NOT NULL,
  `idPostulante` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAnioPostulante`) USING BTREE,
  INDEX `fk_anio_postulante`(`idAnioEscolar`) USING BTREE,
  INDEX `fk_postulante_anio`(`idPostulante`) USING BTREE,
  CONSTRAINT `fk_anio_postulante` FOREIGN KEY (`idAnioEscolar`) REFERENCES `anio_escolar` (`idAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_postulante_anio` FOREIGN KEY (`idPostulante`) REFERENCES `postulante` (`idPostulante`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of anio_postulante
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of apoderado
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of apoderado_alumno
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of area
-- ----------------------------

-- ----------------------------
-- Table structure for asistencia
-- ----------------------------
DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE `asistencia`  (
  `idAsistencia` int NOT NULL AUTO_INCREMENT,
  `idAlumnoAnioEscolar` int NOT NULL,
  `fechaAsistencia` date NOT NULL,
  `estadoAsistencia` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idAsistencia`) USING BTREE,
  INDEX `fk_horario_asistencia`(`idAlumnoAnioEscolar`) USING BTREE,
  CONSTRAINT `fk_asistencia_alumno_anio_escolar` FOREIGN KEY (`idAlumnoAnioEscolar`) REFERENCES `alumno_anio_escolar` (`idAlumnoAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of asistencia
-- ----------------------------

-- ----------------------------
-- Table structure for bimestre
-- ----------------------------
DROP TABLE IF EXISTS `bimestre`;
CREATE TABLE `bimestre`  (
  `idBimestre` int NOT NULL AUTO_INCREMENT,
  `idCursoGrado` int NOT NULL,
  `descripcionBimestre` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estadoBimestre` bit(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idBimestre`) USING BTREE,
  INDEX `idCursoGrado`(`idCursoGrado`) USING BTREE,
  CONSTRAINT `fk_bimestre_curso_grado` FOREIGN KEY (`idCursoGrado`) REFERENCES `curso_grado` (`idCursoGrado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 95 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bimestre
-- ----------------------------

-- ----------------------------
-- Table structure for competencias
-- ----------------------------
DROP TABLE IF EXISTS `competencias`;
CREATE TABLE `competencias`  (
  `idCompetencia` int NOT NULL AUTO_INCREMENT,
  `idUnidad` int NOT NULL,
  `descripcionCompetencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `capacidadesCompetencia` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `estandarCompetencia` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idCompetencia`) USING BTREE,
  INDEX `fk_competencia_unidad`(`idUnidad`) USING BTREE,
  CONSTRAINT `fk_competencia_unidad` FOREIGN KEY (`idUnidad`) REFERENCES `unidad` (`idUnidad`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of competencias
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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of comunicacion_pago
-- ----------------------------

-- ----------------------------
-- Table structure for criterios_competencia
-- ----------------------------
DROP TABLE IF EXISTS `criterios_competencia`;
CREATE TABLE `criterios_competencia`  (
  `idCriterioCompetencia` int NOT NULL AUTO_INCREMENT,
  `descripcionCriterio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idCompetencia` int NOT NULL,
  `idTecnicaEvaluacion` int NOT NULL,
  `idInstrumento` int NOT NULL,
  `fechaCreacion` date NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idCriterioCompetencia`) USING BTREE,
  INDEX `fk_competencia_criterio`(`idCompetencia`) USING BTREE,
  INDEX `idTecnicaEvaluacion`(`idTecnicaEvaluacion`) USING BTREE,
  INDEX `fk_criterio_instrumento`(`idInstrumento`) USING BTREE,
  CONSTRAINT `fk_competencia_criterio` FOREIGN KEY (`idCompetencia`) REFERENCES `competencias` (`idCompetencia`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_criterio_instrumento` FOREIGN KEY (`idInstrumento`) REFERENCES `instrumento` (`idInstrumento`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_criterio_tecnica_evaluacion` FOREIGN KEY (`idTecnicaEvaluacion`) REFERENCES `tecnica_evaluacion` (`idTecnicaEvaluacion`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of criterios_competencia
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 398 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  `estadoCurso` int NULL DEFAULT NULL,
  PRIMARY KEY (`idCurso`) USING BTREE,
  INDEX `fk_curso_area`(`idArea`) USING BTREE,
  CONSTRAINT `fk_curso_area` FOREIGN KEY (`idArea`) REFERENCES `area` (`idArea`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of curso
-- ----------------------------

-- ----------------------------
-- Table structure for curso_grado
-- ----------------------------
DROP TABLE IF EXISTS `curso_grado`;
CREATE TABLE `curso_grado`  (
  `idCursoGrado` int NOT NULL AUTO_INCREMENT,
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
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of curso_grado
-- ----------------------------

-- ----------------------------
-- Table structure for cursogrado_personal
-- ----------------------------
DROP TABLE IF EXISTS `cursogrado_personal`;
CREATE TABLE `cursogrado_personal`  (
  `idCursogradoPersonal` int NOT NULL AUTO_INCREMENT,
  `idCursoGrado` int NOT NULL,
  `idPersonal` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idCursogradoPersonal`) USING BTREE,
  INDEX `fk_personal_id`(`idPersonal`) USING BTREE,
  INDEX `fk_cursogrado_id`(`idCursoGrado`) USING BTREE,
  CONSTRAINT `fk_cursogrado_id` FOREIGN KEY (`idCursoGrado`) REFERENCES `curso_grado` (`idCursoGrado`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_personal_id` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`idPersonal`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cursogrado_personal
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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
-- Table structure for instrumento
-- ----------------------------
DROP TABLE IF EXISTS `instrumento`;
CREATE TABLE `instrumento`  (
  `idInstrumento` int NOT NULL AUTO_INCREMENT,
  `idTecnicaEvaluacion` int NOT NULL,
  `descripcionInstrumento` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codInstrumento` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaCreacion` date NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idInstrumento`) USING BTREE,
  INDEX `fk_tecnica_instrumento`(`idTecnicaEvaluacion`) USING BTREE,
  CONSTRAINT `fk_tecnica_instrumento` FOREIGN KEY (`idTecnicaEvaluacion`) REFERENCES `tecnica_evaluacion` (`idTecnicaEvaluacion`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instrumento
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
-- Table structure for nota
-- ----------------------------
DROP TABLE IF EXISTS `nota`;
CREATE TABLE `nota`  (
  `idNota` int NOT NULL AUTO_INCREMENT,
  `idAlumnoAnioEscolar` int NOT NULL,
  `idCursoGrado` int NOT NULL,
  `idCursoGradoPersonal` int NOT NULL,
  `idTipoNota` int NOT NULL,
  `nota` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idNota`) USING BTREE,
  INDEX `fk_alumno_anio_escolar`(`idAlumnoAnioEscolar`) USING BTREE,
  INDEX `fk_curso_grado_nota`(`idCursoGrado`) USING BTREE,
  INDEX `fk_curso_grado_personal`(`idCursoGradoPersonal`) USING BTREE,
  CONSTRAINT `fk_alumno_anio_escolar` FOREIGN KEY (`idAlumnoAnioEscolar`) REFERENCES `alumno_anio_escolar` (`idAlumnoAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_curso_grado_nota` FOREIGN KEY (`idCursoGrado`) REFERENCES `curso_grado` (`idCursoGrado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_curso_grado_personal` FOREIGN KEY (`idCursoGradoPersonal`) REFERENCES `cursogrado_personal` (`idCursogradoPersonal`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 47 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nota
-- ----------------------------

-- ----------------------------
-- Table structure for nota_bimestre
-- ----------------------------
DROP TABLE IF EXISTS `nota_bimestre`;
CREATE TABLE `nota_bimestre`  (
  `idNotaBimestre` int NOT NULL AUTO_INCREMENT,
  `idBimestre` int NULL DEFAULT NULL,
  `idAlumnoAnioEscolar` int NULL DEFAULT NULL,
  `idCursoGradoPersonal` int NULL DEFAULT NULL,
  `notaBimestre` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idNotaBimestre`) USING BTREE,
  INDEX `fk_bimestre_unidad`(`idBimestre`) USING BTREE,
  INDEX `fk_bimestre_alumno_anio_escolar`(`idAlumnoAnioEscolar`) USING BTREE,
  INDEX `fk_curso_grado_personal_bimestre`(`idCursoGradoPersonal`) USING BTREE,
  CONSTRAINT `fk_bimestre_alumno_anio_escolar` FOREIGN KEY (`idAlumnoAnioEscolar`) REFERENCES `alumno_anio_escolar` (`idAlumnoAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_bimestre_nota_bimestre` FOREIGN KEY (`idBimestre`) REFERENCES `bimestre` (`idBimestre`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_curso_grado_personal_bimestre` FOREIGN KEY (`idCursoGradoPersonal`) REFERENCES `cursogrado_personal` (`idCursogradoPersonal`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 60 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nota_bimestre
-- ----------------------------

-- ----------------------------
-- Table structure for nota_competencia
-- ----------------------------
DROP TABLE IF EXISTS `nota_competencia`;
CREATE TABLE `nota_competencia`  (
  `idNotaCompetencia` int NOT NULL AUTO_INCREMENT,
  `idCompetencia` int NOT NULL,
  `idAlumnoAnioEscolar` int NOT NULL,
  `notaCompetencia` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idNotaCompetencia`) USING BTREE,
  INDEX `fk_notaunidad_competencia`(`idCompetencia`) USING BTREE,
  INDEX `fk_notacompetencia_alumno_anio_escolar`(`idAlumnoAnioEscolar`) USING BTREE,
  CONSTRAINT `fk_notacompetencia_alumno_anio_escolar` FOREIGN KEY (`idAlumnoAnioEscolar`) REFERENCES `alumno_anio_escolar` (`idAlumnoAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_notaunidad_competencia` FOREIGN KEY (`idCompetencia`) REFERENCES `competencias` (`idCompetencia`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nota_competencia
-- ----------------------------

-- ----------------------------
-- Table structure for nota_criterio
-- ----------------------------
DROP TABLE IF EXISTS `nota_criterio`;
CREATE TABLE `nota_criterio`  (
  `idNotaCriterio` int NOT NULL AUTO_INCREMENT,
  `idCriterioCompetencia` int NOT NULL,
  `idAlumnoAnioEscolar` int NOT NULL,
  `notaCriterio` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fechaCreacion` date NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idNotaCriterio`) USING BTREE,
  INDEX `fk_nota_criterio`(`idCriterioCompetencia`) USING BTREE,
  INDEX `fk_nota_criterio_alumno_anio_escolar`(`idAlumnoAnioEscolar`) USING BTREE,
  CONSTRAINT `fk_nota_criterio` FOREIGN KEY (`idCriterioCompetencia`) REFERENCES `criterios_competencia` (`idCriterioCompetencia`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_nota_criterio_alumno_anio_escolar` FOREIGN KEY (`idAlumnoAnioEscolar`) REFERENCES `alumno_anio_escolar` (`idAlumnoAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 200 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nota_criterio
-- ----------------------------

-- ----------------------------
-- Table structure for nota_unidad
-- ----------------------------
DROP TABLE IF EXISTS `nota_unidad`;
CREATE TABLE `nota_unidad`  (
  `idNotaUnidad` int NOT NULL AUTO_INCREMENT,
  `idUnidad` int NULL DEFAULT NULL,
  `idAlumnoAnioEscolar` int NULL DEFAULT NULL,
  `idCursoGradoPersonal` int NULL DEFAULT NULL,
  `notaUnidad` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idNotaUnidad`) USING BTREE,
  INDEX `fk_bimestre_unidad`(`idUnidad`) USING BTREE,
  INDEX `fk_bimestre_alumno_anio_escolar`(`idAlumnoAnioEscolar`) USING BTREE,
  INDEX `fk_curso_grado_personal_bimestre`(`idCursoGradoPersonal`) USING BTREE,
  CONSTRAINT `nota_unidad_ibfk_1` FOREIGN KEY (`idAlumnoAnioEscolar`) REFERENCES `alumno_anio_escolar` (`idAlumnoAnioEscolar`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `nota_unidad_ibfk_2` FOREIGN KEY (`idUnidad`) REFERENCES `unidad` (`idUnidad`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `nota_unidad_ibfk_3` FOREIGN KEY (`idCursoGradoPersonal`) REFERENCES `cursogrado_personal` (`idCursogradoPersonal`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 126 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nota_unidad
-- ----------------------------

-- ----------------------------
-- Table structure for pago
-- ----------------------------
DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago`  (
  `idPago` int NOT NULL AUTO_INCREMENT,
  `idTipoPago` int NOT NULL,
  `idCronogramaPago` int NULL DEFAULT NULL,
  `boletaElectronica` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
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
) ENGINE = InnoDB AUTO_INCREMENT = 93 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal
-- ----------------------------

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
  `fichaPostulante` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaFichaPost` date NULL DEFAULT NULL,
  `estadoFichaPostulante` int NULL DEFAULT NULL,
  `fechaEntrevista` date NULL DEFAULT NULL,
  `estadoEntrevista` int NULL DEFAULT NULL,
  `informePsicologico` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fechaInformePsicologico` date NULL DEFAULT NULL,
  `estadoInformePsicologico` int NULL DEFAULT NULL,
  `constanciaAdeudo` bit(1) NULL DEFAULT NULL,
  `fechaConstanciaAdeudo` date NULL DEFAULT NULL,
  `cartaAdmision` bit(1) NULL DEFAULT NULL,
  `fechaCartaAdmision` date NULL DEFAULT NULL,
  `pagoMatricula` int NULL DEFAULT NULL,
  `fechaPagoMatricula` date NULL DEFAULT NULL,
  `pagoCuotaIngreso` int NULL DEFAULT NULL,
  `fechaCuotaIngreso` date NULL DEFAULT NULL,
  `contrato` bit(1) NULL DEFAULT NULL,
  `fechaContrato` date NULL DEFAULT NULL,
  `documentoTraslado` bit(1) NULL DEFAULT NULL,
  `fechaDocumentoTraslado` date NULL DEFAULT NULL,
  `constanciaVacante` bit(1) NULL DEFAULT NULL,
  `fechaConstanciaVacante` date NULL DEFAULT NULL,
  `estadoPostulante` int NOT NULL,
  `fechaCreacion` datetime NULL DEFAULT NULL,
  `fechaActualizacion` datetime NULL DEFAULT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idPostulante`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 85 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of postulante
-- ----------------------------

-- ----------------------------
-- Table structure for tecnica_evaluacion
-- ----------------------------
DROP TABLE IF EXISTS `tecnica_evaluacion`;
CREATE TABLE `tecnica_evaluacion`  (
  `idTecnicaEvaluacion` int NOT NULL AUTO_INCREMENT,
  `descripcionTecnica` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codTecnica` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaCreacion` date NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idTecnicaEvaluacion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tecnica_evaluacion
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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_pago
-- ----------------------------
INSERT INTO `tipo_pago` VALUES (1, 'Pago Matrícula', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);
INSERT INTO `tipo_pago` VALUES (2, 'Pago Pensión', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);
INSERT INTO `tipo_pago` VALUES (3, 'Pago Cuota Inicial', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);

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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tipo_usuario
-- ----------------------------
INSERT INTO `tipo_usuario` VALUES (1, 'Administrador', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);
INSERT INTO `tipo_usuario` VALUES (2, 'Docente', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);
INSERT INTO `tipo_usuario` VALUES (3, 'Administrativo', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);
INSERT INTO `tipo_usuario` VALUES (4, 'Apoderado', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);
INSERT INTO `tipo_usuario` VALUES (5, 'Dirección', '2024-01-29 12:50:58', '2024-01-29 12:50:58', 1, 1);

-- ----------------------------
-- Table structure for unidad
-- ----------------------------
DROP TABLE IF EXISTS `unidad`;
CREATE TABLE `unidad`  (
  `idUnidad` int NOT NULL AUTO_INCREMENT,
  `idBimestre` int NULL DEFAULT NULL,
  `descripcionUnidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estadoUnidad` bit(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `usuarioCreacion` int NOT NULL,
  `usuarioActualizacion` int NOT NULL,
  PRIMARY KEY (`idUnidad`) USING BTREE,
  INDEX `fk_bimestre_unidad`(`idBimestre`) USING BTREE,
  INDEX `idUnidad`(`idUnidad`) USING BTREE,
  CONSTRAINT `fk_bimestre_unidad` FOREIGN KEY (`idBimestre`) REFERENCES `bimestre` (`idBimestre`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 134 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of unidad
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (1, 1, 'admin@gmail.com', '$argon2id$v=19$m=4096,t=2,p=2$Z1BDUWNSZ3k3V2FRRVZMaw$vpJjcYwGTsviUXQmGnKTCKjtzBrwVzNl0YmTGdrQQrI', 'David', 'Poblette', '98745632', 1, '2024-06-25 15:00:03', '2024-01-29 12:51:49', '2024-06-22 11:39:32', 1, 1);

SET FOREIGN_KEY_CHECKS = 1;
