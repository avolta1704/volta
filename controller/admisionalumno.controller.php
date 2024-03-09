<?php
date_default_timezone_set('America/Lima');

class ControllerAdmisionAlumno
{
 //  Listar alumnos
 public static function ctrGetAdmisionAlumnos()
 {
   $tabla = "admision_alumno";
   $listaAdmisionAlumnos = ModelAdmisionAlumno::mdlGetAdmisionAlumnos($tabla);
   return $listaAdmisionAlumnos;
 }
}