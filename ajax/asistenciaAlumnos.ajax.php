<?php

require_once "../controller/asistenciaAlumnos.controller.php";
require_once "../model/asistenciaAlumnos.model.php";
require_once "../functions/asistenciaAlumnos.functions.php";
require_once "../model/transactionManager.model.php";
require_once "../controller/alumnos.controller.php";
require_once "../model/alumnos.model.php";
require_once "../functions/admisionAlumno.functions.php";
require_once "../controller/notas.controller.php";
require_once "../model/notas.model.php";

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

  /**
   * Crear o Actualizar la asistencia de los alumnos a partir de un archivo Excel
   * 
   * @param string $data objeto con la informacion de la asistencia de los alumnos
   * @param array $data array con la informacion de la asistencia de los alumnos
   * @return string $respuesta  respuesta de la creacion o actualizacion de la asistencia de los alumnos o error en caso de que no se haya podido realizar la operacion
   */
  public function ajaxCrearActualizarAsistenciaAlumnosExcel($data, $asistenciaAlumnosExcel)
  {
    // Decodificar los datos JSON
    $data = json_decode($data, true);
    $asistenciaAlumnosExcel = json_decode($asistenciaAlumnosExcel, true);

    // Estructurar los datos de asistencia
    $asistenciasEstructuradas = $this->estructurarDataAsistencia($asistenciaAlumnosExcel);

    // Obtener todos los alumnos del curso
    $alumnos = ControllerAlumnos::ctrGetAlumnosCurso(
      $data["idCurso"],
      $data["idGrado"],
      $data["idPersonal"]
    );

    // Obtener todas las asistencias registradas para los alumnos del curso
    $asistenciasRegistradasAlumno = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnosTomarAsistenciaExcel(
      $data["idCurso"],
      $data["idGrado"],
      $data["idPersonal"]
    );

    // Convertir las asistencias a registrar a un array asociativo para facilitar la búsqueda
    $asistenciaAlumnosAssoc = [];
    foreach ($asistenciasEstructuradas as $asistencia) {
      $asistenciaAlumnosAssoc[$asistencia['idAlumnoAnioEscolar']][$asistencia['fechaAsistencia']] = $asistencia['estadoAsistencia'];
    }

    // Convertir las asistencias registradas a un array asociativo para facilitar la búsqueda
    $asistenciasRegistradasAssoc = [];
    foreach ($asistenciasRegistradasAlumno as $asistencia) {
      $asistenciasRegistradasAssoc[$asistencia['idAlumnoAnioEscolar']][$asistencia['fechaAsistencia']] = $asistencia['estadoAsistencia'];
    }

    // Arreglo para almacenar los datos de asistencia de los alumnos
    $asistenciaParaActualizar = [];

    // Recorrer todos los alumnos del curso
    foreach ($alumnos as $alumno) {
      $idAlumno = $alumno["idAlumno"];
      $idAlumnoAnioEscolar = $alumno["idAlumnoAnioEscolar"];

      // Verificar las asistencias para cada fecha
      if (isset($asistenciaAlumnosAssoc[$idAlumnoAnioEscolar])) {
        foreach ($asistenciaAlumnosAssoc[$idAlumnoAnioEscolar] as $fechaAsistencia => $nuevoEstadoAsistencia) {
          $existingEstadoAsistencia = isset($asistenciasRegistradasAssoc[$idAlumnoAnioEscolar][$fechaAsistencia]) ? $asistenciasRegistradasAssoc[$idAlumnoAnioEscolar][$fechaAsistencia] : null;

          // Determinar si actualizar o crear una nueva asistencia
          if ($existingEstadoAsistencia !== null) {
            if ($nuevoEstadoAsistencia != $existingEstadoAsistencia) {
              // Actualizar si el estado ha cambiado
              $asistenciaParaActualizar[] = [
                'idAlumno' => $idAlumno,
                'idAlumnoAnioEscolar' => $idAlumnoAnioEscolar,
                'estadoAsistencia' => $nuevoEstadoAsistencia,
                'fechaAsistencia' => $fechaAsistencia
              ];
            }
          } else {
            // Crear nueva asistencia si no existe
            $asistenciaParaActualizar[] = [
              'idAlumno' => $idAlumno,
              'idAlumnoAnioEscolar' => $idAlumnoAnioEscolar,
              'estadoAsistencia' => $nuevoEstadoAsistencia,
              'fechaAsistencia' => $fechaAsistencia
            ];
          }
        }
      }
    }

    // Llamar a la función del controlador para crear o actualizar las asistencias
    $respuesta = ControllerAsistenciaAlumnos::ctrCrearActualizarAsistenciaAlumnosExcel($data["idCurso"], $data["idGrado"], $data["idPersonal"], $asistenciaParaActualizar);

    // Devolver la respuesta
    echo json_encode($respuesta);
  }

  /**
   * Estructurar la data para tenga el estilo de alumno por cada mes y su asistencia
   * 
   * @param array $data array con la informacion de la asistencia de los alumnos
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos   
   */
  public function estructurarDataAsistencia($alumnos)
  {
    $separatedByDate = [];

    foreach ($alumnos as $alumno) {
      $dataAlumno = ControllerAlumnos::ctrGetAlumnoByIdAnioEscolar($alumno['IUU']);

      // si hubo un error al obtener los datos del alumno, se cancelo todo
      if (!$dataAlumno) {
        return false;
      }

      $idAlumno = $dataAlumno['idAlumno'];
      $idAlumnoAnioEscolar = $dataAlumno['idAlumnoAnioEscolar'];

      foreach ($alumno as $key => $value) {
        if (DateTime::createFromFormat('d/m/Y', $key) !== false) {
          // convertir la fecha a formato Y-m-d
          $fechaAsistencia = DateTime::createFromFormat('d/m/Y', $key)->format('Y-m-d');
          $estadoAsistencia = $value;

          $separatedByDate[] = [
            'idAlumno' => $idAlumno,
            'idAlumnoAnioEscolar' => $idAlumnoAnioEscolar,
            'estadoAsistencia' => $estadoAsistencia,
            'fechaAsistencia' => $fechaAsistencia
          ];
        }
      }
    }
    return $separatedByDate;
  }

  /**
   * Cancela la subida de los datos de la asistencia del excel, eliminar los datos que se registraron
   * 
   * @param string $data objeto con la informacion de la asistencia de los alumnos
   * @param array $data array con la informacion de la asistencia de los alumnos
   * @return string $respuesta  respuesta de la cancelación de la subida de la asistencia de los alumnos o error en caso de que no se haya podido realizar la operacion
   */
  public function ajaxCancelarAsistenciaAlumnosExcel($data, $asistenciaAlumnosExcel)
  {
    // Decodificar los datos JSON
    $data = json_decode($data, true);
    $asistenciaAlumnos = json_decode($asistenciaAlumnosExcel, true);
    $asistenciaAlumnosExcel = $this->estructurarDataAsistencia($asistenciaAlumnos);


    // Obtener todos los alumnos del curso
    $alumnos = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnosTomarAsistencia(
      $data["idCurso"],
      $data["idGrado"],
      $data["idPersonal"]
    );

    // Convertir las asistencias a registrar a un array asociativo para facilitar la búsqueda
    $asistenciaAlumnosAssoc = [];
    foreach ($asistenciaAlumnosExcel as $asistencia) {
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
        $fechaAsistencia = $asistenciaAlumnosAssoc[$idAlumno]['fechaAsistencia']; // Obtener la fecha de asistencia correspondiente

        if (
          $existingAsistencia !== null
        ) {
          // Si ya tiene asistencia registrada
          if ($nuevoEstadoAsistencia != $existingAsistencia) {
            // Si el nuevo estado es diferente al existente, actualizar
            $asistencia[] = [
              'idAlumno' => $idAlumno,
              'idAlumnoAnioEscolar' => $alumno['idAlumnoAnioEscolar'],
              'estadoAsistencia' => $nuevoEstadoAsistencia,
              'fechaAsistencia' => $fechaAsistencia // Agregar la fecha de asistencia al arreglo
            ];
          }
        } else {
          // Si no hay asistencia registrada, añadir nueva asistencia con el nuevo estado
          $asistencia[] = [
            'idAlumno' => $idAlumno,
            'idAlumnoAnioEscolar' => $alumno['idAlumnoAnioEscolar'],
            'estadoAsistencia' => $nuevoEstadoAsistencia,
            'fechaAsistencia' => $fechaAsistencia // Agregar la fecha de asistencia al arreglo
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
            'estadoAsistencia' => $estadoAsistencia,
            'fechaAsistencia' =>  $asistenciaAlumnosAssoc[$idAlumno]['fechaAsistencia'] // Agregar la fecha de asistencia al arreglo
          ];
        }
      }
    }

    // Llamar a la función del controlador para eliminar las asistencias
    $respuesta = ControllerAsistenciaAlumnos::ctrCancelarAsistenciaAlumnosExcel($asistencia);

    // Devolver la respuesta
    echo json_encode($respuesta);
  }
  public $idUsuarioAsistenciaApoderado;
  public function ajaxObtenerAsistenciaApoderadoAlumnos()
  {
    $idUsuarioAsistenciaApoderado = $this->idUsuarioAsistenciaApoderado;
    $respuesta = ControllerAsistenciaAlumnos::ctrObtenerAsistenciaApoderadoAlumnos($idUsuarioAsistenciaApoderado);
    echo json_encode($respuesta);
  }
  public $idCursoAsistenciaAlumnosDocente;
  public $idGradoAsistenciaAlumnosDocente;
  public $idPersonalAsistenciaAlumnosDocente;
  public function ajaxObtenerAsistenciaAlumnoDocente(){
    $idCursoAsistenciaAlumnosDocente = $this->idCursoAsistenciaAlumnosDocente;
    $idGradoAsistenciaAlumnosDocente = $this->idGradoAsistenciaAlumnosDocente;
    $idPersonalAsistenciaAlumnosDocente = $this->idPersonalAsistenciaAlumnosDocente;
    $respuesta = ControllerAsistenciaAlumnos::ctrObtenerAsistenciaAlumnoDocente($idCursoAsistenciaAlumnosDocente, $idGradoAsistenciaAlumnosDocente, $idPersonalAsistenciaAlumnosDocente);
    echo json_encode($respuesta);
  }

  /**
   * Obtener la asistencia de los alumnos de un grado segun fecha inicio y final
   * 
   * @param string $data identificador del grado
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos   
   */
  public function ajaxObtenerAsistenciaAlumnosGradoFechas($data)
  {
    $data = json_decode($data, true);
    $idGrado = $data["idGrado"];
    $fechaInicio = $data["fechaInicial"];
    $fechaFinal = $data["fechaFinal"];

    $respuesta = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnosPorGradoFecha($idGrado, $fechaInicio, $fechaFinal);
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

if (isset($_POST["guardarAsistenciaAlumnosExcel"]) && isset($_POST["asistenciaAlumnosExcel"])) {
  $crearActualizarAsistenciaAlumnos = new AsistenciaAlumnosAjax();
  $crearActualizarAsistenciaAlumnos->ajaxCrearActualizarAsistenciaAlumnosExcel($_POST["guardarAsistenciaAlumnosExcel"], $_POST["asistenciaAlumnosExcel"]);
}

if (isset($_POST["deleteAsistenciaAlumnosExcel"]) && isset($_POST["asistenciaAlumnosExcel"])) {
  $cancelarAsistenciaAlumnos = new AsistenciaAlumnosAjax();
  $cancelarAsistenciaAlumnos->ajaxCancelarAsistenciaAlumnosExcel($_POST["deleteAsistenciaAlumnosExcel"], $_POST["asistenciaAlumnosExcel"]);
}
if (isset($_POST["idUsuarioAsistenciaApoderado"])) {
  $alumnosAsistenciaApoderado = new AsistenciaAlumnosAjax();
  $alumnosAsistenciaApoderado->idUsuarioAsistenciaApoderado = $_POST["idUsuarioAsistenciaApoderado"];
  $alumnosAsistenciaApoderado->ajaxObtenerAsistenciaApoderadoAlumnos();
}
if (isset($_POST["gradoAsistencia"])) {
  $asistenciaAlumnosPorGrado = new AsistenciaAlumnosAjax();
  $asistenciaAlumnosPorGrado->ajaxObtenerAsistenciaAlumnosGradoFechas($_POST["gradoAsistencia"]);
}
