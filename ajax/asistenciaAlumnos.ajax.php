<?php

require_once "../controller/asistenciaAlumnos.controller.php";
require_once "../model/asistenciaAlumnos.model.php";
require_once "../functions/asistenciaAlumnos.functions.php";

class AsistenciaAlumnosAjax
{
  /**
   * Mostrar la asistencia de los alumnos del dia actual
   * 
   */
  public function ajaxMostrarAsistenciaAlumnos($data)
  {

    $data = json_decode($data, true);
    $idCurso = $data["idCurso"];
    $idGrado = $data["idGrado"];
    $idPersonal = $data["idPersonal"];

    $respuesta = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnos($idCurso, $idGrado, $idPersonal);
    echo json_encode($respuesta);
  }

  /**
   *  Mostrar la asistencia de los alumnos del dia actual para tomar asistencia
   * 
   * @param int $idCurso identificador del curso
   * @param int $idGrado identificador del grado
   * @param int $idPersonal identificador del personal
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos   
   */

  public function ajaxMostrarAsistenciaAlumnosTomarAsistencia($data)
  {
    $data = json_decode($data, true);
    $idCurso = $data["idCurso"];
    $idGrado = $data["idGrado"];
    $idPersonal = $data["idPersonal"];

    $respuesta = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnosTomarAsistencia($idCurso, $idGrado, $idPersonal);
    echo json_encode($respuesta);
  }

  /**
   * Crear o Actualizar la asistencia de los alumnos
   * 
   * @param string $data objeto con la informacion de la asistencia de los alumnos
   * @param array $data array con la informacion de la asistencia de los alumnos
   * @return string $respuesta  respuesta de la creacion o actualizacion de la asistencia de los alumnos o error en caso de que no se haya podido realizar la operacion
   */
  public function ajaxCrearActualizarAsistenciaAlumnos($data, $asistenciaAlumnos)
  {
    // Primero obtener todos los alumnos del curso
    $data = json_decode($data, true);
    $asistenciaAlumnos = json_decode($asistenciaAlumnos, true);

    $alumnos = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnosTomarAsistencia($data["idCurso"], $data["idGrado"], $data["idPersonal"]);

    // Arreglo para almacenar los datos de asistencia de los alumnos
    $asistencia = [];

    // Recorrer todos los alumnos del curso
    foreach ($alumnos as $alumno) {
      $idAlumno = $alumno["idAlumno"];
      if (in_array($idAlumno, array_column($asistenciaAlumnos, 'idAlumno'))) {
        $estado = $asistenciaAlumnos[array_search($idAlumno, array_column($asistenciaAlumnos, 'idAlumno'))]['estadoAsistencia'];
      } else {
        $estado = 'A';
      }

      $asistencia[] = array(
        'idAlumno' => $idAlumno,
        'estadoAsistencia' => $estado
      );
    }

    // Utilizar el arreglo de asistencia en la creación o actualización de la asistencia de los alumnos
    $respuesta = ControllerAsistenciaAlumnos::ctrCrearActualizarAsistenciaAlumnos($asistencia);
    echo json_encode($respuesta);
  }
}

if (isset($_POST["todosLosAlumnosAsistenciaCurso"])) {
  $mostrarAsistenciaAlumnos = new AsistenciaAlumnosAjax();
  $mostrarAsistenciaAlumnos->ajaxMostrarAsistenciaAlumnos($_POST["todosLosAlumnosAsistenciaCurso"]);
}

if (isset($_POST["todosLosAlumnosAsistenciaCursoTomarAsistencia"])) {
  $mostrarAsistenciaAlumnos = new AsistenciaAlumnosAjax();
  $mostrarAsistenciaAlumnos->ajaxMostrarAsistenciaAlumnosTomarAsistencia($_POST["todosLosAlumnosAsistenciaCursoTomarAsistencia"]);
}

if (isset($_POST["guardarAsistenciaAlumnos"]) && isset($_POST["asistenciaAlumnos"])) {
  $crearActualizarAsistenciaAlumnos = new AsistenciaAlumnosAjax();
  $crearActualizarAsistenciaAlumnos->ajaxCrearActualizarAsistenciaAlumnos($_POST["guardarAsistenciaAlumnos"], $_POST["asistenciaAlumnos"]);
}
