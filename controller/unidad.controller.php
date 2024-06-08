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
  // Funcionalidad para cerrar la unidad
  public static function ctrCerrarUnidad($idUnidadCerrar, $idBimestreCerrar, $idCursoCerrar, $idGradoCerrar)
  {
    $tablaalumnoanioescolar = "alumno_anio_escolar";
    // Obtener todos los alumnos de un curso y grado específicos
    $todoslosAlumnosdelCurso = ModelAlumnoAnioEscolar::mdlObtnerTodosLosAlumnosDeUnGradoCurso($tablaalumnoanioescolar, $idCursoCerrar, $idGradoCerrar);
    // Iterar sobre cada alumno del curso
    foreach ($todoslosAlumnosdelCurso as $alumno) {
      $idAlumnoAnioEscolar = $alumno['idAlumnoAnioEscolar'];
      $tabla = "unidad";
      // Obtener todos los datos necesarios para asignar la nota de la unidad
      $todoslosDatosparaSubirNota = ModelUnidad::mdlObtenerTodoslosDatosparaAsignarNota($tabla, $idUnidadCerrar, $idAlumnoAnioEscolar);
      // Obtener el ID de la nota de la unidad
      $idNotaUnidad = $todoslosDatosparaSubirNota[0]["idNotaUnidad"];
      $tiponotaCompetencia = "notaCompetencia";
      // Calcular la nota de la unidad para el alumno
      $notaUnidad = calcularNotaUnidad($todoslosDatosparaSubirNota, $tiponotaCompetencia);
      $tablanotaunidad = "nota_unidad";
      // Insertar la nota calculada en la tabla correspondiente
      $respuestanotaunidad = ModelUnidad::mdlInsertarNotaUnidad($tablanotaunidad, $idNotaUnidad, $notaUnidad, $idAlumnoAnioEscolar);
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
              $todasLasNotas = ModelBimestre::mdlObtenerTodaslasNotasdeUnidad($idBimestreCerrar, $idAlumnoAnioEscolar);
              $tipodeNotaUnidad = "notaUnidad";
              // Calcular el promedio de las notas
              $promedioNotas = calcularNotaUnidad($todasLasNotas, $tipodeNotaUnidad);
              // Subir el promedio de notas del bimestre
              ModelBimestre::mdlSubirNotaPromedioBimestreUnidad($idBimestreCerrar, $promedioNotas, $idAlumnoAnioEscolar);
            } else {
              // Activar la siguiente unidad
              ModelUnidad::mdlActivarUnidad($todosLosBimestresYUnidades[$index + 1]['idUnidad'], 1);
              $unidadActivada = true;
              break;
            }
          }
        } elseif ($bimestreActualEncontrado && !$unidadActivada && $activarSiguienteBimestre) {
          ModelBimestre::mdlActualizarEstadoBimestreCerrarUnidad($idBimestreCerrar,0);
          // Activar el siguiente bimestre y su unidad
          ModelBimestre::mdlActualizarEstadoBimestreCerrarUnidad($bu['idBimestre'], 1);
          ModelUnidad::mdlActivarUnidad($bu['idUnidad'], 1);
          break;
        }
      }
    }

    // Verificar si la inserción de la nota de unidad fue exitosa
    if ($respuestanotaunidad == "ok") {
      // Cerrar la unidad y retornar el resultado
      $dataUnidad = ModelUnidad::mdlCerrarUnidad($tabla, $idUnidadCerrar);
      return $dataUnidad;
    }
  }
}
//Funcion para calcular el promedio de las notas
function calcularNotaUnidad($todoslosDatosparaSubirNota, $tipodenota)
{
  $sumatoriaNotaCompetencia = 0;
  $i = 0;

  foreach ($todoslosDatosparaSubirNota as $datos) {
    $notaCompetencia = $datos[$tipodenota];
    // Asignar un valor numérico a cada nota de competencia
    switch ($notaCompetencia) {
      case 'AD':
        $notaNumerica = 20;
        break;
      case 'A':
        $notaNumerica = 15;
        break;
      case 'B':
        $notaNumerica = 10;
        break;
      case 'C':
        $notaNumerica = 5;
        break;
      default:
        $notaNumerica = 0;
        break;
    }
    $sumatoriaNotaCompetencia += $notaNumerica;
    $i++;
  }

  if ($i > 0) { // Asegurar que no haya división por cero
    $promedio = $sumatoriaNotaCompetencia / $i; // Promedio numérico
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

