<?php
class ControllerAsistenciaAlumnos
{
  /**
   * Mostrar la asistencia de los alumnos del dia actual
   * 
   * @param int $idCurso identificador del curso
   * @param int $idGrado identificador del grado
   * @param int $idPersonal identificador del personal
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos
   */
  static public function ctrMostrarAsistenciaAlumnos($idCurso, $idGrado, $idPersonal)
  {
    $tabla = "asistencia";
    $respuesta = ModelAsistenciaAlumnos::mdlMostrarAsistenciaAlumnos($tabla, $idCurso, $idGrado, $idPersonal);
    // si no hay registros en la tabla asistencia
    if (!$respuesta) {
      return [];
    }

    // agregar el  campo estado y el campo de las acciones
    foreach ($respuesta as &$alumno) {
      $alumno["estadoAsistencia"] = FunctionsAsistenciaAlumnos::getEstadoAsistencia($alumno["estadoAsistencia"]);
      $alumno["acciones"] = FunctionsAsistenciaAlumnos::getDropdownEstadoAsistencia($alumno["idAlumno"]);
    }
    return $respuesta;
  }
}
