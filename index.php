<?php

date_default_timezone_set('America/Lima');

//  Controllers
require_once "controller/template.controller.php";
require_once "controller/funciones.controller.php";

require_once "controller/usuarios.controller.php";
require_once "controller/alumnos.controller.php";
require_once "controller/apoderado.controller.php";
require_once "controller/nivelGrado.controller.php";
require_once "controller/gradoAlumno.controller.php";
require_once "controller/postulantes.controller.php";

//  Models
require_once "model/usuarios.model.php";
require_once "model/alumnos.model.php";
require_once "model/apoderado.model.php";
require_once "model/nivelGrado.model.php";
require_once "model/gradoAlumno.model.php";
require_once "model/postulantes.model.php";

$template = new ControllerTemplate();
$template -> ctrTemplate();