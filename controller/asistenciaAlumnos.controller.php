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
   * Mostrar la asistencia de los alumnos para tomar asistencia
   * 
   * @param int $idCurso identificador del curso
   * @param int $idGrado identificador del grado
   * @param int $idPersonal identificador del personal
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos   
   */
  static public function ctrMostrarAsistenciaAlumnosTomarAsistenciaExcel($idCurso, $idGrado, $idPersonal)
  {
    $tabla = "asistencia";

    // mes actual del año actual
    $mesActual = date("Y-m");
    $respuesta = ModelAsistenciaAlumnos::mdlMostrarAsistenciaAlumnosRegistradosMes($tabla, $idCurso, $idGrado, $idPersonal, $mesActual);
    // si no hay registros en la tabla asistencia
    if (!$respuesta) {
      return [];
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
      TransactionManager::mdlIniciarTransaccion();

      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      // acceder a la variable de sesión
      $idUsuario = $_SESSION["idUsuario"];

      foreach ($data as $alumno) {
        $idAlumno = $alumno["idAlumno"];
        if (in_array($idAlumno, array_column($asistenciaAlumnos, 'idAlumno'))) {
          $estado = $alumno["estadoAsistencia"];
          $data = [
            "idAlumnoAnioEscolar" => $alumno["idAlumnoAnioEscolar"],
            "fechaAsistencia" => $hoy,
            "estadoAsistencia" => $estado,
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioActualizacion" => $idUsuario
          ];
          $respuesta = ModelAsistenciaAlumnos::mdlActualizarAsistenciaAlumno($data);
          if ($respuesta != "ok") {
            // Rollback transaction
            TransactionManager::mdlCancelarTransaccion();
            return $respuesta;
          }
        } else {
          $data = [
            "idAlumnoAnioEscolar" => $alumno["idAlumnoAnioEscolar"],
            "fechaAsistencia" => $hoy,
            "estadoAsistencia" => $alumno["estadoAsistencia"],
            "fechaCreacion" => date("Y-m-d H:i:s"),
            "usuarioCreacion" => $idUsuario,
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioActualizacion" => $idUsuario
          ];
          $respuesta = ModelAsistenciaAlumnos::mdlCrearAsistenciaAlumno($data);
          if ($respuesta != "ok") {
            // Rollback transaction
            TransactionManager::mdlCancelarTransaccion();
            return $respuesta;
          }
        }
      }

      // Commit transaction
      TransactionManager::mdlFinalizarTransaccion();

      return "ok";
    } catch (Exception $e) {
      // Rollback transaction
      TransactionManager::mdlCancelarTransaccion();
      return "Error: " . $e->getMessage() . " - " . $e;
    }
  }

  /**
   * Crear o Actualizar la asistencia de un alumno mediante un excel
   * 
   * @param array $data array con la informacion de la asistencia de los alumnos
   * @return string $respuesta  respuesta de la creacion o actualizacion de la asistencia de los alumnos o error en caso de que no se haya podido realizar la operacion
   */
  static public function ctrCrearActualizarAsistenciaAlumnosExcel($idCurso, $idGrado, $idPersonal, $data)
  {
    // Primero obtener todas las asistencias de los alumnos del curso y grado seleccionado para el mes específico
    $tabla = "asistencia";
    $mesActual = date("Y-m");
    $asistenciaAlumnos = ModelAsistenciaAlumnos::mdlMostrarAsistenciaAlumnosRegistradosMes($tabla, $idCurso, $idGrado, $idPersonal, $mesActual);

    // Convertir el array de asistencias registradas a un formato más fácil de manejar
    $asistenciaAlumnosAssoc = [];
    foreach ($asistenciaAlumnos as $asistencia) {
      $asistenciaAlumnosAssoc[$asistencia['idAlumnoAnioEscolar']][$asistencia['fechaAsistencia']] = $asistencia['estadoAsistencia'];
    }

    try {
      // Iniciar transacción
      TransactionManager::mdlIniciarTransaccion();

      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      // Acceder a la variable de sesión
      $idUsuario = $_SESSION["idUsuario"];

      foreach ($data as $asistenciaAlumno) {
        $idAlumnoAnioEscolar = $asistenciaAlumno["idAlumnoAnioEscolar"];
        $fechaAsistencia = $asistenciaAlumno["fechaAsistencia"];
        $nuevoEstadoAsistencia = $asistenciaAlumno["estadoAsistencia"];

        if (isset($asistenciaAlumnosAssoc[$idAlumnoAnioEscolar][$fechaAsistencia])) {
          // Si ya existe una asistencia registrada para este alumno y fecha
          $estadoRegistrado = $asistenciaAlumnosAssoc[$idAlumnoAnioEscolar][$fechaAsistencia];

          if ($nuevoEstadoAsistencia != $estadoRegistrado) {
            // Si el nuevo estado es diferente al existente, actualizar
            $dataUpdate = [
              "idAlumnoAnioEscolar" => $idAlumnoAnioEscolar,
              "fechaAsistencia" => $fechaAsistencia,
              "estadoAsistencia" => $nuevoEstadoAsistencia,
              "fechaActualizacion" => date("Y-m-d H:i:s"),
              "usuarioActualizacion" => $idUsuario
            ];
            $respuesta = ModelAsistenciaAlumnos::mdlActualizarAsistenciaAlumno($dataUpdate);
            if ($respuesta != "ok") {
              // Rollback transaction
              TransactionManager::mdlCancelarTransaccion();
              return $respuesta;
            }
          }
        } else {
          // Si no hay asistencia registrada, añadir nueva asistencia
          $dataInsert = [
            "idAlumnoAnioEscolar" => $idAlumnoAnioEscolar,
            "fechaAsistencia" => $fechaAsistencia,
            "estadoAsistencia" => $nuevoEstadoAsistencia,
            "fechaCreacion" => date("Y-m-d H:i:s"),
            "usuarioCreacion" => $idUsuario,
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioActualizacion" => $idUsuario
          ];
          $respuesta = ModelAsistenciaAlumnos::mdlCrearAsistenciaAlumno($dataInsert);
          if ($respuesta != "ok") {
            // Rollback transaction
            TransactionManager::mdlCancelarTransaccion();
            return $respuesta;
          }
        }
      }

      // Commit transaction
      TransactionManager::mdlFinalizarTransaccion();

      return "ok";
    } catch (Exception $e) {
      // Rollback transaction
      TransactionManager::mdlCancelarTransaccion();
      return "Error: " . $e->getMessage();
    }
  }

  /**
   * Cancelar la subida de datos de la asistencia por excel, eliminar los datos de la base de datos
   * 
   * @param array $data array con la informacion de la asistencia de los alumnos
   * @return string $respuesta  respuesta de la eliminacion de la asistencia de los alumnos o error en caso de que no se haya podido realizar la operacion
   */
  static public function ctrCancelarAsistenciaAlumnosExcel($data)
  {
    $tabla = "asistencia";

    // Recorrer todos los alumnos del curso
    try {
      // Start transaction
      TransactionManager::mdlIniciarTransaccion();

      foreach ($data as $alumno) {
        $idAlumnoAnioEscolar = $alumno["idAlumnoAnioEscolar"];
        $fechaAsistencia = $alumno["fechaAsistencia"];
        $respuesta = ModelAsistenciaAlumnos::mdlEliminarAsistenciaAlumno($tabla, $idAlumnoAnioEscolar, $fechaAsistencia);
        if ($respuesta != "ok") {
          // Rollback transaction
          TransactionManager::mdlCancelarTransaccion();
          return $respuesta;
        }
      }

      // Commit transaction
      TransactionManager::mdlFinalizarTransaccion();

      return "ok";
    } catch (Exception $e) {
      // Rollback transaction
      TransactionManager::mdlCancelarTransaccion();
      return "Error: " . $e->getMessage() . " - " . $e;
    }
    return $respuesta;
  }
}
