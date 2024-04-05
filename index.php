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
require_once "controller/admisionAlumno.controller.php";
require_once "controller/admision.controller.php";
require_once "controller/pagos.controller.php";
require_once "controller/comunicado.controller.php";
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
require_once "model/admisionAlumno.model.php";
require_once "model/admision.model.php";
require_once "model/pagos.model.php";
require_once "model/comunicado.model.php";

$template = new ControllerTemplate();
$template -> ctrTemplate();