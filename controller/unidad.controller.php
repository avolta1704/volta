<?php
date_default_timezone_set('America/Lima');

class ControllerUnidad
{
  // Obtener todas las unidades
  public static function ctrObtenerTodasLasUnidades($idBimestre)
  {
    $tabla = "unidad";
    $dataUnidad = ModelUnidad::mdlObtenerTodasLasUnidades($tabla, $idBimestre);
    return $dataUnidad;
  }
  /**
   * Cerrar una unidad y asignar las notas correspondientes
   * 
   * @param int $idUnidadCerrar id de la unidad a cerrar
   * @param int $idBimestreCerrar id del bimestre al que pertenece la unidad
   * @param array $idsAlumnos arreglo con los ids de los alumnos a los que se les asignará la nota
   * @param int $idCursoGradoPersonal id del curso y grado del personal
   * @return string $respuesta resultado de la operación
   */
  public static function ctrCerrarUnidad($idUnidadCerrar, $idBimestreCerrar, $idsAlumnos, $idCursoGradoPersonal)
  {

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];

    // Obtener las competentencias de la unidad
    $competenciasUnidad = ModelUnidad::mdlObtenerCompetenciasUnidad($idUnidadCerrar);

    if ($competenciasUnidad == "error") {
      return "error";
    }

    // Iterar sobre cada ID de alumno
    foreach ($idsAlumnos as $idAlumnoAnioEscolar) {

      // Obtener todas las notas de competencias del alumno
      $todasLasNotasCompetenciasAlumno = self::ctrObtenerNotasCompetenciasUnidad($idAlumnoAnioEscolar, $competenciasUnidad);

      // Verificar si hubo un error al obtener las notas
      if ($todasLasNotasCompetenciasAlumno == "error") {
        return "error";
      }

      // Calcular la nota de la unidad para el alumno
      $promedioNotaCompetencias = ControllerNotas::calcularPromedioCompetencias($todasLasNotasCompetenciasAlumno);

      // Insertar la nota calculada en la tabla correspondiente
      $tablaNotaUnidad = "nota_unidad";

      $notaUnidad = array(
        'notaUnidad' => $promedioNotaCompetencias,
        "idCursoGradoPersonal" => $idCursoGradoPersonal,
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $idUsuario,
      );

      //Obtener todas las unidades del bimestre
      $todasLasUnidades = ModelUnidad::mdlObtenerTodasLasUnidades("unidad", $idBimestreCerrar);

      // verificar si hay unidades
      if ($todasLasUnidades == "error") {
        return "error";
      }

      // Insertar la nota de la unidad      
      $respuestanotaunidad = ModelUnidad::mdlInsertarNotaUnidad($tablaNotaUnidad, $idUnidadCerrar, $idAlumnoAnioEscolar, $notaUnidad);

      // Verificar si la inserción de la nota de unidad fue exitosa
      if ($respuestanotaunidad != "ok") {
        return "error";
      }

      // Obtener el curso y grado del bimestre
      $idCursoGrado = ModelBimestre::mdlObtenerCursoGradoBimestre($idBimestreCerrar);
      // Obtener todos los bimestres y unidades con sus estados
      $todosLosBimestresYUnidades = ModelBimestre::mdlObtenerTodosLosBimestresyUnidadesEstados($idCursoGrado);
      // Variables para el manejo del estado de la unidad y el bimestre
      $unidadActivada = false;
      $bimestreActualEncontrado = false;
      $activarSiguienteBimestre = false;
      // Iterar sobre todos los bimestres y unidades
      foreach ($todosLosBimestresYUnidades as $index => $bu) {
        if ($bu['idBimestre'] == $idBimestreCerrar) {
          $bimestreActualEncontrado = true;
          if ($bu['idUnidad'] == $idUnidadCerrar) {
            // Verificar si es la última unidad del bimestre
            if ($index == count($todosLosBimestresYUnidades) - 1 || $todosLosBimestresYUnidades[$index + 1]['idBimestre'] != $idBimestreCerrar) {
              $activarSiguienteBimestre = true;
              // Obtener todas las notas de la unidad
              $todasLasNotas = self::ctrObtenerNotasUnidadesBimestre($todasLasUnidades, $idAlumnoAnioEscolar, $idCursoGradoPersonal);
              // Calcular el promedio de las notas
              $promedioNotasUnidad = ControllerNotas::calcularPromedioUnidad($todasLasNotas);

              $notaBimestre = array(
                'notaBimestre' => $promedioNotasUnidad,
                "idCursoGradoPersonal" => $idCursoGradoPersonal,
                "fechaCreacion" => date("Y-m-d H:i:s"),
                "usuarioCreacion" => $idUsuario,
                "fechaActualizacion" => date("Y-m-d H:i:s"),
                "usuarioActualizacion" => $idUsuario,
              );

              // Subir el promedio de notas del bimestre
              ModelBimestre::mdlSubirNotaPromedioBimestreUnidad($idBimestreCerrar, $notaBimestre, $idAlumnoAnioEscolar);
            } else {
              // Activar la siguiente unidad
              ModelUnidad::mdlActivarUnidad($todosLosBimestresYUnidades[$index + 1]['idUnidad'], 1);
              $unidadActivada = true;
              break;
            }
          }
        } elseif ($bimestreActualEncontrado && !$unidadActivada && $activarSiguienteBimestre) {
          ModelBimestre::mdlActualizarEstadoBimestreCerrarUnidad($idBimestreCerrar, 0);
          // Activar el siguiente bimestre y su unidad
          ModelBimestre::mdlActualizarEstadoBimestreCerrarUnidad($bu['idBimestre'], 1);
          ModelUnidad::mdlActivarUnidad($bu['idUnidad'], 1);
          break;
        }
      }
      // Verificar si la inserción de la nota de unidad fue exitosa
      if ($respuestanotaunidad != "ok") {
        return "error";
      }
    }
    // Cerrar la unidad y retornar el resultado
    return ModelUnidad::mdlCerrarUnidad("unidad", $idUnidadCerrar);
  }

  /**
   * Obtener una unidad por su id
   * 
   * @param int $idUnidad id de la unidad
   * @return array $dataUnidad datos de la unidad 
   */
  public static function ctrObtenerUnidadById($idUnidad)
  {
    $tabla = "unidad";
    $dataUnidad = ModelUnidad::mdlObtenerUnidadById($tabla, $idUnidad);
    return $dataUnidad;
  }

  /**
   * Obtener todas las notas de la competencias de una unidad y un alumno
   * 
   * @param int $idUnidad id de la unidad
   * @param int $idAlumnoAnioEscolar id del alumno
   * @return array $competencias arreglo con las notas de las competencias
   * @return string "error" si hubo un error
   */
  public static function ctrObtenerNotasCompetenciasUnidad($idAlumnoAnioEscolar, $competencias)
  {
    $tabla = "nota_competencia";

    $notasCompetenciasUnidad = [];
    // Recorrer todas las competencias    
    foreach ($competencias as $competencia) {
      $idCompetencia = $competencia['idCompetencia'];
      $notaCompetencia = ModelUnidad::mdlObtenerNotaCompetencia($tabla, $idAlumnoAnioEscolar, $idCompetencia);
      if ($notaCompetencia == "error") {
        return "error";
      }
      $notasCompetenciasUnidad[$notaCompetencia["idNotaCompetencia"]] = $notaCompetencia;
    }
    return $notasCompetenciasUnidad;
  }

  /**
   * Obtener las notas de la unidad de un alumno
   * 
   * @param array $unidades arreglo con las unidades
   * @param int $idAlumnoAnioEscolar id del alumno
   * @return array $notasUnidad datos de las notas de la unidad
   */
  public static function ctrObtenerNotasUnidadesBimestre($unidades, $idAlumnoAnioEscolar, $idCursoGradoPersonal)
  {
    $tabla = "nota_unidad";

    $notasUnidad = [];
    // Recorrer todas las unidades
    foreach ($unidades as $unidad) {
      $idUnidad = $unidad['idUnidad'];
      $notaUnidad = ModelUnidad::mdlObtenerNotaUnidad($tabla, $idUnidad, $idAlumnoAnioEscolar, $idCursoGradoPersonal);
      if ($notaUnidad == "error") {
        return "error";
      }
      $notasUnidad[$notaUnidad["idNotaUnidad"]] = $notaUnidad;
    }

    return $notasUnidad;
  }
}
//Funcion para calcular el promedio de las notas
function calcularNotaUnidad($todoslosDatosparaSubirNota, $tipodenota)
{
  $sumatoriaNotaCompetencia = 0;
  $notasNumericas = ['AD' => 20, 'A' => 15, 'B' => 10, 'C' => 5, 'default' => 0];

  foreach ($todoslosDatosparaSubirNota as $datos) {
    $notaCompetencia = $datos[$tipodenota];
    $notaNumerica = isset($notasNumericas[$notaCompetencia]) ? $notasNumericas[$notaCompetencia] : $notasNumericas['default'];
    $sumatoriaNotaCompetencia += $notaNumerica;
  }

  $numDatos = count($todoslosDatosparaSubirNota);
  if ($numDatos > 0) { // Asegurar que no haya división por cero
    $promedio = $sumatoriaNotaCompetencia / $numDatos; // Promedio numérico
    $notaUnidadNumerica = round($promedio); // Redondear el promedio a un número entero

    // Convertir el promedio numérico a una nota de competencia
    if ($notaUnidadNumerica < 9) {
      $notaUnidad = 'C';
    } else if ($notaUnidadNumerica < 15) {
      $notaUnidad = 'B';
    } else if ($notaUnidadNumerica < 19) {
      $notaUnidad = 'A';
    } else {
      $notaUnidad = 'AD';
    }
  } else {
    $notaUnidad = 'C'; // Valor por defecto si no hay datos
  }
  return $notaUnidad;
}
