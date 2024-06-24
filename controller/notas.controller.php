<?php
class ControllerNotas
{
  /**
   * Controlador para obtener todas las notas de los alumnos
   * 
   * @param int $idCurso id del curso
   * @param int $idGrado id del grado
   * @param int $idPersonal id del personal
   * @param int $idUnidad id de la unidad
   * @param int $idBimestre id del bimestre
   * @return array con todas las notas de los alumnos
   */
  public static function ctrTodasLasNotasUnidadDeAlumnos($idCurso, $idGrado, $idPersonal, $idUnidad, $idBimestre)
  {

    // obtenemos todos los alumnos de un grado, un curso y un docente 
    $alumnos = ControllerAlumnos::ctrGetAlumnosCurso($idCurso, $idGrado, $idPersonal);

    // verificamos que haya alumnos
    if (count($alumnos) == 0) {
      return [];
    }

    // obtenemos todos las competencias con sus criterios de dicha unidad

    $competencias = ControllerCompetencia::ctrObtenerCompetenciaCriterios($idUnidad);

    // verificamos que haya competencias
    if (count($competencias) == 0) {
      return [];
    }

    // verificamos que cada competencia tenga al menos un criterio
    $todosTienenCriterios = self::ctrValidarNotasCompetencias($competencias);

    if ($todosTienenCriterios === 'sin criterios') {
      return 'sin criterios';
    }

    $agruparCompetenciasPorCriterios = self::ctrAgruparCompetenciasPorCriterios($competencias);

    // alumnos para agregar las notas
    $alumnosConNotas = [];

    // recorremos todos los alumnos y buscamos si tiene notas de los criterios segun las competencias
    foreach ($alumnos as $alumno) {
      $idAlumnoAnioEscolar = $alumno['idAlumnoAnioEscolar'];

      // inicializamos el arreglo de notas
      $alumnosConNotas[$idAlumnoAnioEscolar] = [
        'idAlumnoAnioEscolar' => $idAlumnoAnioEscolar,
        'nombresAlumno' => $alumno['nombresAlumno'],
        'apellidosAlumno' => $alumno['apellidosAlumno'],
        'notas' => []
      ];

      // recorremos las competencias agrupadas para verificar si los criterios tienen notas
      foreach ($agruparCompetenciasPorCriterios as $idCompetencia => $criterios) {
        $notas = [];

        // recorremos los criterios
        foreach ($criterios as $idCriterio) {
          $nota = ModelNotas::mdlObtenerNotaAlumnoCriterio($idAlumnoAnioEscolar, $idCriterio, $idCompetencia, $idUnidad, $idBimestre);

          // si no hay nota, agregamos un null pero si hay nota agregamos la nota y el id del criterio
          if (count($nota) == 0) {
            $notas[$idCriterio] = null;
          } else {
            $notas[$idCriterio] = $nota[0];
          }
        }

        // agregamos las notas al arreglo de notas
        $alumnosConNotas[$idAlumnoAnioEscolar]['notas'][$idCompetencia] = $notas;
      }
    }

    // Obtenemos todos las competencias con sus criterios de la unidad
    $competencias = ModelCompetencia::mdlObtenerCompetenciaCriteriosPorIdUnidad($idUnidad, $idBimestre);

    // Verificamos que cada competencia tenga al menos un criterio
    $todosTienenCriterios = self::ctrValidarNotasCompetencias($competencias);

    if ($todosTienenCriterios === 'sin criterios') {
      return 'sin criterios';
    }

    // Agrupar los criterios por competencia
    $agruparCompetenciasPorCriteriosDatos = self::ctrAgruparCompetenciasPorCriteriosConDatos($competencias);

    // devolver el arreglo de alumnos con notas y el arreglo de competencias con criterios

    return [
      'alumnosConNotas' => $alumnosConNotas,
      'competencias' => $agruparCompetenciasPorCriteriosDatos
    ];
  }

  /**
   * Controlador para crear o actualizar una nota
   * 
   * @param int $idAlumnoAnioEscolar id del alumno año escolar
   * @param int $idCriterioCompetencia id del criterio de competencia
   * @param int $idNotaCriterio id de la nota del criterio
   * @param string $nota nota del criterio
   */
  public static function ctrCrearActualizarNota($idAlumnoAnioEscolar, $idCriterioCompetencia, $idNotaCriterio, $nota)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    // verificamos si la nota ya existe
    $notaExistente = ModelNotas::mdlObtenerNotaAlumnoCriterioPorId($idNotaCriterio);
    // si la nota existe, actualizamos la nota
    if (count($notaExistente) > 0) {

      // si la nota diferente a "AD", "A", "B" o "C" eliminamos la nota
      if ($nota !== "AD" && $nota !== "A" && $nota !== "B" && $nota !== "C") {
        $respuesta = ModelNotas::mdlEliminarNota($idNotaCriterio);
      } else {
        $dataNotaActualizar = array(
          'nota' => $nota,
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $idUsuario,
        );
        // actualizamos la nota
        $respuesta = ModelNotas::mdlActualizarNota($idNotaCriterio, $dataNotaActualizar);
      }
    } else {
      $dataNotaCrear = array(
        'nota' => $nota,
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $idUsuario,
      );
      // si la nota no existe, creamos la nota
      $respuesta = ModelNotas::mdlCrearNota($idAlumnoAnioEscolar, $idCriterioCompetencia, $dataNotaCrear);
    }

    return $respuesta;
  }

  // Verificamos que todas las competencias tengan al menos un criterio
  public static function ctrValidarNotasCompetencias($competencias)
  {
    $competenciasVerificadas = [];

    // Recorremos el arreglo de competencias
    foreach ($competencias as $competencia) {
      $idCompetencia = $competencia['idCompetencia'];
      $idCriterioCompetencia = $competencia['idCriterioCompetencia'];

      // Inicializamos el arreglo si no existe
      if (!isset($competenciasVerificadas[$idCompetencia])) {
        $competenciasVerificadas[$idCompetencia] = [
          'conteo' => 0,
          'sinCriterios' => 0
        ];
      }

      // Contamos las repeticiones y verificamos los criterios
      $competenciasVerificadas[$idCompetencia]['conteo'] += 1;
      if ($idCriterioCompetencia === null) {
        $competenciasVerificadas[$idCompetencia]['sinCriterios'] += 1;
      }
    }

    // Verificamos si alguna competencia no tiene criterios
    foreach ($competenciasVerificadas as $idCompetencia => $datos) {
      if ($datos['sinCriterios'] === $datos['conteo']) {
        return 'sin criterios';
      }
    }


    return 'ok';
  }

  // Agrupamos criterios por competencia
  public static function ctrAgruparCompetenciasPorCriterios($competencias)
  {
    $agruparCompetenciasPorCriterios = [];

    // Recorremos el arreglo de competencias
    foreach ($competencias as $competencia) {
      $idCompetencia = $competencia['idCompetencia'];
      $idCriterioCompetencia = $competencia['idCriterioCompetencia'];

      // Inicializamos el arreglo si no existe
      if (!isset($agruparCompetenciasPorCriterios[$idCompetencia])) {
        $agruparCompetenciasPorCriterios[$idCompetencia] = [];
      }

      // Guardamos los criterios en el arreglo 
      $agruparCompetenciasPorCriterios[$idCompetencia][] = $idCriterioCompetencia;
    }

    return $agruparCompetenciasPorCriterios;
  }

  // Agrupar criterios por competencia osea solo los competencias y dentro los criterios con todos los datos
  public static function ctrAgruparCompetenciasPorCriteriosConDatos($competencias)
  {
    $agruparCompetenciasPorCriterios = [];

    // Recorremos el arreglo de competencias
    foreach ($competencias as $competencia) {
      $idCompetencia = $competencia['idCompetencia'];
      $idCriterioCompetencia = $competencia['idCriterioCompetencia'];

      // Inicializamos el arreglo si no existe
      if (!isset($agruparCompetenciasPorCriterios[$idCompetencia])) {
        $agruparCompetenciasPorCriterios[$idCompetencia] = [
          'idCompetencia' => $idCompetencia,
          'descripcionCompetencia' => $competencia['descripcionCompetencia'],
          'criterios' => []
        ];
      }

      // Guardamos los criterios en el arreglo
      $agruparCompetenciasPorCriterios[$idCompetencia]['criterios'][] = [
        'idCriterioCompetencia' => $idCriterioCompetencia,
        'descripcionCriterio' => $competencia['descripcionCriterio'],
      ];
    }

    return $agruparCompetenciasPorCriterios;
  }

  /**
   * Controlador para cerrar las notas de los criterios
   * 
   * @param array $data arreglo con los datos de las notas
   * @return string con la respuesta de la operacion "ok" o "error"
   */
  public static function ctrCerrarNotasCriterios($data)
  {

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];

    // Obtener el ids
    $idGrado = $data["idGrado"];
    $idCurso = $data["idCurso"];
    $idPersonal = $data["idPersonal"];
    $idBimestre = $data["idBimestre"];
    $idUnidad = $data["idUnidad"];

    // Obtener los alumnos
    $alumnos = ControllerAlumnos::ctrGetAlumnosCurso($idCurso, $idGrado, $idPersonal);

    // Verificar si hay alumnos
    if (count($alumnos) == 0) {
      return 'error';
    }

    // Obtener las competencias con sus criterios
    $competencias = ControllerCompetencia::ctrObtenerCompetenciaCriterios($idUnidad);

    // Verificar si hay competencias
    if (count($competencias) == 0) {
      return 'sin competencias';
    }

    // Verificar si todas las competencias tienen al menos un criterio
    $todosTienenCriterios = self::ctrValidarNotasCompetencias($competencias);

    if ($todosTienenCriterios === 'sin criterios') {
      return 'error';
    }

    // Agrupar las competencias por criterios
    $agruparCompetenciasPorCriterios = self::ctrAgruparCompetenciasPorCriterios($competencias);

    // Verificar si todos los alumnos tienen notas registradas en los criterios
    $todosTienenNotas = self::ctrValidarNotasAlumnos($alumnos, $agruparCompetenciasPorCriterios);

    if ($todosTienenNotas === 'sin notas') {
      return 'sin notas';
    }

    // Recorrer los alumnos y verificar si tienen notas de los criterios segun las competencias y sacamos promedios de cada competencias para cada alumno
    foreach ($alumnos as $alumno) {
      $idAlumnoAnioEscolar = $alumno['idAlumnoAnioEscolar'];

      // Inicializamos el arreglo de notas
      $notas = [];

      // Recorremos las competencias agrupadas para verificar si los criterios tienen notas
      foreach ($agruparCompetenciasPorCriterios as $idCompetencia => $criterios) {
        $promedio = 0;

        // Recorremos los criterios
        foreach ($criterios as $idCriterio) {
          $nota = ModelNotas::mdlObtenerNotaAlumnoCriterio($idAlumnoAnioEscolar, $idCriterio, $idCompetencia, $idUnidad, $idBimestre);

          // Si no hay nota, agregamos un null pero si hay nota agregamos la nota y el id del criterio
          if (count($nota) == 0) {
            $notas[$idCriterio] = null;
          } else {
            $notas[$idCriterio] = $nota[0];
          }
        }

        // Sacamos el promedio de la competencia
        $promedio = self::calcularPromedioCriterios($notas);

        // Verificamos si la notaCompetencia ya existe
        $notaExistente = ModelNotas::mdlObtenerNotaCompetenciaByIdAlumnoAnioEscolaryIdCompetencia($idAlumnoAnioEscolar, $idCompetencia);

        // Si la nota existe, actualizamos la nota
        if ($notaExistente !== "error") {

          $dataNotaCompetenciaActualizar = array(
            'notaCompetencia' => $promedio,
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioActualizacion" => $idUsuario,
          );

          // Actualizamos la nota
          $respuesta = ModelNotas::mdlActualizarNotaCompetencia($notaExistente[0]['idNotaCompetencia'], $dataNotaCompetenciaActualizar);
        } else {

          $dataNotaCompetenciaCrear = array(
            'notaCompetencia' => $promedio,
            "fechaCreacion" => date("Y-m-d H:i:s"),
            "usuarioCreacion" => $idUsuario,
            "fechaActualizacion" => date("Y-m-d H:i:s"),
            "usuarioActualizacion" => $idUsuario,
          );

          // Si la nota no existe, creamos la nota
          $respuesta = ModelNotas::mdlCrearNotaCompetencia($idAlumnoAnioEscolar, $idCompetencia, $dataNotaCompetenciaCrear);
        }
      }
    }
    return $respuesta;
  }

  // Calcular el promedio de la competencia
  public static function calcularPromedioCriterios($notas)
  {
    if (empty($notas)) {
      return 0; // Si no hay notas, retorna 0
    }

    $total = 0;
    $cantidadNotas = count($notas);

    foreach ($notas as $nota) {
      $total += self::convertirNotaANumerico($nota["notaCriterio"]);
    }

    $promedioNumerico = $total / $cantidadNotas;
    return self::convertirPromedioACategoria($promedioNumerico);
  }

  // Calcular el promedio de las notas competencias de una unidad
  public static function calcularPromedioCompetencias($notas)
  {
    if (empty($notas)) {
      return 0; // Si no hay notas, retorna 0
    }

    $total = 0;
    $cantidadNotas = count($notas);

    foreach ($notas as $nota) {
      $total += self::convertirNotaANumerico($nota["notaCompetencia"]);
    }

    $promedioNumerico = $total / $cantidadNotas;
    return self::convertirPromedioACategoria($promedioNumerico);
  }

  // Calcular el promedio de las notas unidad de un alumno
  public static function calcularPromedioUnidad($notas)
  {
    if (empty($notas)) {
      return 0; // Si no hay notas, retorna 0
    }

    $total = 0;
    $cantidadNotas = count($notas);

    foreach ($notas as $nota) {
      $total += self::convertirNotaANumerico($nota["notaUnidad"]);
    }

    $promedioNumerico = $total / $cantidadNotas;
    return self::convertirPromedioACategoria($promedioNumerico);
  }

  // Convertir la nota a un valor numérico
  public static function convertirNotaANumerico($nota)
  {
    switch ($nota) {
      case 'AD':
        return 19.5;
      case 'A':
        return 16;
      case 'B':
        return 12;
      case 'C':
        return 8.5;
      default:
        return 0; // Si la nota no es válida, asigna 0
    }
  }

  // convertir la nota promedio a la categoria que le corresponde
  public static function convertirPromedioACategoria($promedio)
  {
    if ($promedio >= 19 && $promedio <= 20) {
      return 'AD';
    } elseif ($promedio >= 15 && $promedio < 19) {
      return 'A';
    } elseif ($promedio >= 9 && $promedio < 15) {
      return 'B';
    } elseif ($promedio < 9) {
      return 'C';
    } else {
      return 'N/A'; // Si el promedio no encaja en ninguna categoría
    }
  }

  // Verificar si todos los alumnos tienen notas registradas en los criterios
  public static function ctrValidarNotasAlumnos($alumnos, $competencias)
  {
    // Recorremos los alumnos
    foreach ($alumnos as $alumno) {
      $idAlumnoAnioEscolar = $alumno['idAlumnoAnioEscolar'];

      // Recorremos las competencias agrupadas para verificar si los criterios tienen notas
      foreach ($competencias as $idCompetencia => $criterios) {
        // Recorremos los criterios
        foreach ($criterios as $idCriterio) {
          $nota = ModelNotas::mdlObtenerNotaAlumnoCriterio($idAlumnoAnioEscolar, $idCriterio, $idCompetencia);

          // Si no hay nota, agregamos un null pero si hay nota agregamos la nota y el id del criterio
          if (count($nota) == 0) {
            return 'sin notas';
          }
        }
      }
    }

    return 'ok';
  }
  public static function ctrObtenerAlumnosApoderado($idUsuario){
    $tabla= "usuario";
    $response = ModelNotas::mdlObtenerAlumnosApoderado($tabla, $idUsuario);
    return $response;
  }
}
