<?php

date_default_timezone_set('America/Lima');

require_once "controller/template.controller.php";

//  Functions
require_once "functions/funciones.controller.php";
require_once "functions/alumnos.functions.php";
require_once "functions/usuarios.functions.php";
require_once "functions/postulantes.functions.php";
require_once "functions/personal.functions.php";
require_once "functions/perfil.functions.php";
require_once "functions/apoderado.functions.php";
require_once "functions/pagos.functions.php";
require_once "functions/comunicado.functions.php";
require_once "functions/buscarAlumno.functions.php";
require_once "functions/reportesPensiones.functions.php";
require_once "functions/reportesComunicados.functions.php";
require_once "functions/cursos.functions.php";
require_once "functions/areas.functions.php";
require_once "functions/asignarCursos.functions.php";
require_once "functions/docentes.functions.php";
require_once "functions/anioescolar.functions.php";
require_once "functions/cursosDocente.functions.php";
require_once "functions/unidad.functions.php";
require_once "functions/asistenciaAlumnos.functions.php";
require_once "functions/competencia.functions.php";
require_once "functions/criterios.functions.php";
require_once "functions/notas.functions.php";
require_once "functions/tecnicaseInstrumentos.functions.php";

//  Controllers
require_once "controller/usuarios.controller.php";
require_once "controller/alumnos.controller.php";
require_once "controller/apoderado.controller.php";
require_once "controller/nivelGrado.controller.php";
require_once "controller/gradoAlumno.controller.php";
require_once "controller/postulantes.controller.php";
require_once "controller/anioescolar.controller.php";
require_once "controller/personal.controller.php";
require_once "controller/perfil.controller.php";
require_once "controller/admisionalumno.controller.php";
require_once "controller/admision.controller.php";
require_once "controller/pagos.controller.php";
require_once "controller/comunicado.controller.php";
require_once "controller/buscarAlumno.controller.php";
require_once "controller/anioAdmision.controller.php";
require_once "controller/apoderadoAlumno.controller.php";
require_once "controller/reportesPensiones.controller.php";
require_once "controller/reportesComunicados.controller.php";
require_once "controller/cursos.controller.php";
require_once "controller/areas.controller.php";
require_once "controller/docentes.controller.php";
require_once "controller/anioPostulacion.controller.php";
require_once "controller/alumnoAnioEscolar.controller.php";
require_once "controller/anioCursoGrado.controller.php";
require_once "controller/bimestre.controller.php";
require_once "controller/unidad.controller.php";
require_once "controller/asistenciaAlumnos.controller.php";
require_once "controller/competencia.controller.php";
require_once "controller/criterios.controller.php";
require_once "controller/notas.controller.php";
require_once "controller/inicio.controller.php";
require_once "controller/tecnicaseInstrumentos.controller.php";


//  Models
require_once "model/usuarios.model.php";
require_once "model/alumnos.model.php";
require_once "model/apoderado.model.php";
require_once "model/nivelGrado.model.php";
require_once "model/gradoAlumno.model.php";
require_once "model/postulantes.model.php";
require_once "model/anioescolar.model.php";
require_once "model/personal.model.php";
require_once "model/perfil.model.php";
require_once "model/admisionalumno.model.php";
require_once "model/admision.model.php";
require_once "model/pagos.model.php";
require_once "model/comunicado.model.php";
require_once "model/buscarAlumno.model.php";
require_once "model/anioAdmision.model.php";
require_once "model/apoderadoAlumno.model.php";
require_once "model/reportesPensiones.model.php";
require_once "model/reportesComunicados.model.php";
require_once "model/cursos.model.php";
require_once "model/areas.model.php";
require_once "model/docentes.model.php";
require_once "model/anioPostulante.model.php";
require_once "model/alumnoAnioEscolar.model.php";
require_once "model/anioCursoGrado.model.php";
require_once "model/bimestre.model.php";
require_once "model/unidad.model.php";
require_once "model/asistenciaAlumnos.model.php";
require_once "model/transactionManager.model.php";
require_once "model/competencia.model.php";
require_once "model/criterios.model.php";
require_once "model/notas.model.php";
require_once "model/inicio.model.php";
require_once "model/tecnicaseInstrumentos.model.php";


$template = new ControllerTemplate();
$template->ctrTemplate();
