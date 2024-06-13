<?php
class FunctionBuscarAlumno
{
  //  Estados para los alumnos
  public static function getEstadoAlumnoBuscar($estadoAlumno)
  {
    if (empty($estadoAlumno)) {
      return $estadoAlumno;
    }

    switch ($estadoAlumno) {
      case 1:
        return "Anulado";
      case 2:
        return "Matriculado";
      case 3:
        return "Trasladado";
      case 4:
        return "Retirado";
      default:
        return "Sin Estado";
    }
  }
  public static function getEstadoNuevoAntigup($estadoNA)
  {
    if (empty($estadoNA)) {
      return $estadoNA;
    } else if ($estadoNA == 1) {
      $estado = "Nuevo";
    } else if ($estadoNA == 2) {
      $estado = "Antiguo";
    } else {
      $estado = "Sin Estado";
    }
    return $estado;
  }
  public static function getEstadosBuscarSiagiue($estadoSiagiue)
  {
    if (empty($estadoSiagiue)) {
      return $estadoSiagiue;
    }
    if ($estadoSiagiue == 1) {
      $estadoSia = "Activo";
    }
    if ($estadoSiagiue == 2) {
      $estadoSia = "Inactivo";
    }
    if ($estadoSiagiue == 3) {
      $estadoSia = "En revisión";
    }
    return $estadoSia;
  }

  //boton visualizar usuario
  public static function getBtnBuscarAlumno($codPago)
  {
    $botones = '
      <div class="btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownBuscarAlumno" aria-expanded="false">
          <i class="bi bi-pencil-square"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropDownBuscarAlumno">
          <button type="button" class="dropdown-item btnVisualizarPago" codPago="' . ($codPago) . '" data-bs-toggle="modal" data-bs-target="#modalDetallePagoBuscar"' . ($codPago === null ? ' disabled' : '') . '>Visualizar</button>
        </ul>
      </div>
      ';
    return $botones;
  }

}
