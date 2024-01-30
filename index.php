<?php

date_default_timezone_set('America/Lima');

//  Controllers
require_once "controller/template.controller.php";
require_once "controller/funciones.controller.php";
require_once "controller/usuarios.controller.php";

//  Models
require_once "model/usuarios.model.php";

$template = new ControllerTemplate();
$template -> ctrTemplate();