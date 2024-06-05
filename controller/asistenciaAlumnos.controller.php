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
    }
    return $respuesta;
  }

  /**
   * Mostrar la asistencia de los alumnos del dia actual para tomar asistencia
   * 
   * @param int $idCurso identificador del curso
   * @param int $idGrado identificador del grado
   * @param int $idPersonal identificador del personal
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos   
   */
  static public function ctrMostrarAsistenciaAlumnosTomarAsistencia($idCurso, $idGrado, $idPersonal)
  {
    $tabla = "asistencia";
    $respuesta = ModelAsistenciaAlumnos::mdlMostrarAsistenciaAlumnos($tabla, $idCurso, $idGrado, $idPersonal);
    // si no hay registros en la tabla asistencia
    if (!$respuesta) {
      return [];
    }

    // agregar el  campo estado y el campo de las acciones
    foreach ($respuesta as &$alumno) {
      $alumno["acciones"] = FunctionsAsistenciaAlumnos::getDropdownEstadoAsistencia($alumno["idAlumno"], $alumno["idCurso"], $alumno["idGrado"], $alumno["idPersonal"], $alumno["estadoAsistencia"]);
    }
    return $respuesta;
  }

  /**
   * Crear o Actualizar la asistencia de los alumnos
   * 
   * @param array $data array con la informacion de la asistencia de los alumnos
   * @return string $respuesta  respuesta de la creacion o actualizacion de la asistencia de los alumnos o error en caso de que no se haya podido realizar la operacion
   */
  static public function ctrCrearActualizarAsistenciaAlumnos($data)
  {
    // Primero obtener todos los alumnos del curso
    $alumnos = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnosTomarAsistencia($data["idCurso"], $data["idGrado"], $data["idPersonal"]);
    // Luego recorrer los alumnos y crear o actualizar la asistencia
    foreach ($alumnos as $alumno) {
      // vemos si este alumno viene en el arreglo de la asistencia
      $alumnoEncontrado = false;
      foreach ($data["alumnos"] as $alumnoAsistencia) {
        if ($alumno["idAlumno"] == $alumnoAsistencia["idAlumno"]) {
          $alumnoEncontrado = true;
          break;
        }
      }

      // si el alumno no fue encontrado en el arreglo de la asistencia, entonces se debe crear la asistencia
      if (!$alumnoEncontrado) {
        $respuesta = ModelAsistenciaAlumnos::mdlCrearAsistenciaAlumno($data["idCurso"], $data["idGrado"], $data["idPersonal"], $alumno["idAlumno"], $data["fecha"], $data["estado"]);
        if (!$respuesta) {
          return "error";
        }
      }
    }

    // Luego recorrer los alumnos y actualizar la asistencia
    foreach ($data["alumnos"] as $alumnoAsistencia) {
      $respuesta = ModelAsistenciaAlumnos::mdlActualizarAsistenciaAlumno($data["idCurso"], $data["idGrado"], $data["idPersonal"], $alumnoAsistencia["idAlumno"], $data["fecha"], $alumnoAsistencia["estado"]);
      if (!$respuesta) {
        return "error";
      }
    }
    return "ok";
  }
}
