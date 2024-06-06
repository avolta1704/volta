<?php

require_once "../controller/asistenciaAlumnos.controller.php";
require_once "../model/asistenciaAlumnos.model.php";
require_once "../functions/asistenciaAlumnos.functions.php";
require_once "../model/transactionManager.model.php";

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
    // Decodificar los datos JSON
    $data = json_decode($data, true);
    $asistenciaAlumnos = json_decode($asistenciaAlumnos, true);

    // Obtener todos los alumnos del curso
    $alumnos = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnosTomarAsistencia(
      $data["idCurso"],
      $data["idGrado"],
      $data["idPersonal"]
    );

    // Convertir las asistencias a registrar a un array asociativo para facilitar la búsqueda
    $asistenciaAlumnosAssoc = [];
    foreach ($asistenciaAlumnos as $asistencia) {
      $asistenciaAlumnosAssoc[$asistencia['idAlumno']] = $asistencia;
    }

    // Arreglo para almacenar los datos de asistencia de los alumnos
    $asistencia = [];

    // Recorrer todos los alumnos del curso
    foreach ($alumnos as $alumno) {
      $idAlumno = $alumno["idAlumno"];
      $estadoAsistencia = 'A'; // Por defecto, ausente

      // Verificar si el alumno ya tiene asistencia registrada
      $existingAsistencia = isset($alumno['estadoAsistencia']) ? $alumno['estadoAsistencia'] : null;

      // Verificar si el alumno está en asistenciaAlumnos y obtener su estado
      if (isset($asistenciaAlumnosAssoc[$idAlumno])) {
        $nuevoEstadoAsistencia = $asistenciaAlumnosAssoc[$idAlumno]['estadoAsistencia'];

        if (
          $existingAsistencia !== null
        ) {
          // Si ya tiene asistencia registrada
          if ($nuevoEstadoAsistencia != $existingAsistencia) {
            // Si el nuevo estado es diferente al existente, actualizar
            $asistencia[] = [
              'idAlumno' => $idAlumno,
              'idAlumnoAnioEscolar' => $alumno['idAlumnoAnioEscolar'],
              'estadoAsistencia' => $nuevoEstadoAsistencia
            ];
          }
        } else {
          // Si no hay asistencia registrada, añadir nueva asistencia con el nuevo estado
          $asistencia[] = [
            'idAlumno' => $idAlumno,
            'idAlumnoAnioEscolar' => $alumno['idAlumnoAnioEscolar'],
            'estadoAsistencia' => $nuevoEstadoAsistencia
          ];
        }
      } else {
        // Si el alumno no está en asistenciaAlumnos
        if (
          $existingAsistencia === null
        ) {
          // Si no hay asistencia registrada, añadir nueva asistencia con el estado por defecto
          $asistencia[] = [
            'idAlumno' => $idAlumno,
            'idAlumnoAnioEscolar' => $alumno['idAlumnoAnioEscolar'],
            'estadoAsistencia' => $estadoAsistencia
          ];
        }
        // Si hay asistencia registrada pero no hay un nuevo estado enviado, no hacer nada
      }
    }

    // Llamar a la función del controlador para crear o actualizar las asistencias
    $respuesta = ControllerAsistenciaAlumnos::ctrCrearActualizarAsistenciaAlumnos($data["idCurso"], $data["idGrado"], $data["idPersonal"], $asistencia);

    // Devolver la respuesta
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
