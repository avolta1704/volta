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
  static public function ctrCrearActualizarAsistenciaAlumnos($idCurso, $idGrado, $idPersonal, $data)
  {
    // Primero obtener todos las asistencias de los alumnos del curso y grado seleccionado
    $tabla = "asistencia";
    $hoy = date("Y-m-d");
    $asistenciaAlumnos = ModelAsistenciaAlumnos::mdlMostrarAsistenciaAlumnosPorFecha($tabla, $idCurso, $idGrado, $idPersonal, $hoy);

    // Recorrer todos los alumnos del curso
    try {
      // Start transaction
      // TransactionManager::mdlIniciarTransaccion();

      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      // acceder a la variable de sesión
      $idUsuario = $_SESSION["idUsuario"];

      foreach ($data as $alumno) {
        $idAlumno = $alumno["idAlumno"];
        if (in_array($idAlumno, array_column($asistenciaAlumnos, 'idAlumno'))) {
          $estado = $alumno["estadoAsistencia"];
          $fechaAsistencia = date("Y-m-d");
          $data = [
            "idAlumnoAnioEscolar" => $alumno["idAlumnoAnioEscolar"],
            "fechaAsistencia" => $fechaAsistencia,
            "estadoAsistencia" => $estado,
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioActualizacion" => $idUsuario
          ];
          $respuesta = ModelAsistenciaAlumnos::mdlActualizarAsistenciaAlumno($data);
          if ($respuesta != "ok") {
            // Rollback transaction
            // TransactionManager::mdlCancelarTransaccion();
            return $respuesta;
          }
        } else {
          $fechaAsistencia = date("Y-m-d");
          $data = [
            "idAlumnoAnioEscolar" => $alumno["idAlumnoAnioEscolar"],
            "fechaAsistencia" => $fechaAsistencia,
            "estadoAsistencia" => $alumno["estadoAsistencia"],
            "fechaCreacion" => date("Y-m-d H:i:s"),
            "usuarioCreacion" => $idUsuario,
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioActualizacion" => $idUsuario
          ];
          $respuesta = ModelAsistenciaAlumnos::mdlCrearAsistenciaAlumno($data);
          if ($respuesta != "ok") {
            // Rollback transaction
            // TransactionManager::mdlCancelarTransaccion();
            return $respuesta;
          }
        }
      }

      // Commit transaction
      // TransactionManager::mdlFinalizarTransaccion();

      return "ok";
    } catch (Exception $e) {
      // Rollback transaction
      TransactionManager::mdlCancelarTransaccion();
      return "Error: " . $e->getMessage() . " - " . $e;
    }
  }
}
