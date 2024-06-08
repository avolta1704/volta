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

  public static function ctrCerrarUnidad($idUnidadCerrar, $idBimestreCerrar, $idCursoCerrar, $idGradoCerrar)
  {
    $tablaalumnoanioescolar = "alumno_anio_escolar";
    $todoslosAlumnosdelCurso = ModelAlumnoAnioEscolar::mdlObtnerTodosLosAlumnosDeUnGradoCurso($tablaalumnoanioescolar, $idCursoCerrar, $idGradoCerrar);


    foreach ($todoslosAlumnosdelCurso as $alumno) {
      $idAlumnoAnioEscolar = $alumno['idAlumnoAnioEscolar'];

      $tabla = "unidad";
      $todoslosDatosparaSubirNota = ModelUnidad::mdlObtenerTodoslosDatosparaAsignarNota($tabla, $idUnidadCerrar, $idAlumnoAnioEscolar);

      $idNotaUnidad = $todoslosDatosparaSubirNota[0]["idNotaUnidad"];

      $tiponotaCompetencia = "notaCompetencia";
      $notaUnidad = calcularNotaUnidad($todoslosDatosparaSubirNota, $tiponotaCompetencia);
      $tablanotaunidad = "nota_unidad";

      $respuestanotaunidad = ModelUnidad::mdlInsertarNotaUnidad($tablanotaunidad, $idNotaUnidad, $notaUnidad, $idAlumnoAnioEscolar);

      $idCursoGrado = ModelBimestre::mdlObtenerCursoGradoBimestre($idBimestreCerrar);
      $todosLosBimestresYUnidades = ModelBimestre::mdlObtenerTodosLosBimestresyUnidadesEstados($idCursoGrado);

      $unidadActivada = false;
      $bimestreActualEncontrado = false;
      $activarSiguienteBimestre = false;

      foreach ($todosLosBimestresYUnidades as $index => $bu) {
        if ($bu['idBimestre'] == $idBimestreCerrar) {
          $bimestreActualEncontrado = true;
          if ($bu['idUnidad'] == $idUnidadCerrar) {
            if ($index == count($todosLosBimestresYUnidades) - 1 || $todosLosBimestresYUnidades[$index + 1]['idBimestre'] != $idBimestreCerrar) {
              $activarSiguienteBimestre = true;
              $todasLasNotas = ModelBimestre::mdlObtenerTodaslasNotasdeUnidad($idBimestreCerrar, $idAlumnoAnioEscolar);

              $tipodeNotaUnidad = "notaUnidad";
              $promedioNotas = calcularNotaUnidad($todasLasNotas, $tipodeNotaUnidad);
              ModelBimestre::mdlSubirNotaPromedioBimestreUnidad($idBimestreCerrar, $promedioNotas, $idAlumnoAnioEscolar);
            } else {
              ModelUnidad::mdlActivarUnidad($todosLosBimestresYUnidades[$index + 1]['idUnidad'], 1);
              $unidadActivada = true;
              break;
            }
          }
        } elseif ($bimestreActualEncontrado && !$unidadActivada && $activarSiguienteBimestre) {
          ModelBimestre::mdlActualizarEstadoBimestreCerrarUnidad($bu['idBimestre'], 1);
          ModelUnidad::mdlActivarUnidad($bu['idUnidad'], 1);
          break;
        }
      }
    }

    if ($respuestanotaunidad == "ok") {
      $dataUnidad = ModelUnidad::mdlCerrarUnidad($tabla, $idUnidadCerrar);
      return $dataUnidad;
    }
  }
}

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

