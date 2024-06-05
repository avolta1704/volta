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

  public static function ctrCerrarUnidad($idUnidadCerrar, $idBimestreCerrar)
  {
    $tabla = "unidad";
    $sumatoriaNotaCompetencia = 0;
    $i = 0;
    $todoslosDatosparaSubirNota = ModelUnidad::mdlObtenerTodoslosDatosparaAsignarNota($tabla, $idUnidadCerrar);
    foreach ($todoslosDatosparaSubirNota as $datos) {
      $idNotaUnidad = $datos["idNotaUnidad"];
      $notaCompetencia = $datos["notaCompetencia"];
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
      $sumatoriaNotaCompetencia = $sumatoriaNotaCompetencia + $notaNumerica;
      $i = $i + 1;
    }
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
    $tablanotaunidad = "nota_unidad";
    $respuestanotaunidad = ModelUnidad::mdlInsertarNotaUnidad($tablanotaunidad, $idNotaUnidad, $notaUnidad);
    if($respuestanotaunidad =="ok"){
      $dataUnidad = ModelUnidad::mdlCerrarUnidad($tabla, $idUnidadCerrar);
      return $dataUnidad;
    }


  }
}

