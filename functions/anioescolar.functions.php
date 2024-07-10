<?php
class FunctionAnioEscolar
{
  //  Botones para listar los botones del año escolar
  public static function getButtonsAnioEscolar($idAnio, $estadoAnio)
  {
    $descripcion = $estadoAnio == 1 ? "Desactivar" : "Activar";
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPagos" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownAniosEscolar">
        <div>
          <button type="button" class="dropdown-item btnVisualizarAnio" codAnio="' . ($idAnio) . '" data-bs-toggle="modal" data-bs-target="#modalVisualizarAnio">Visualizar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEditarAnio" codAnio="' . ($idAnio) . '" data-bs-toggle="modal" data-bs-target="#modalEditarAnio">Editar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnActualizarEstado" codAnio="' . ($idAnio) . '" codEstado="' . ($estadoAnio) . '">' . $descripcion . '</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEliminarAnio" codAnio="' . ($idAnio) . '">Eliminar</button>
        </div>
      </ul>
    </div>
    ';
    return $botones;
  }

  //  Obtener los estados para el año escolar
  public static function getEstadoAnioEscolar($estadoAnio)
  {
    if ($estadoAnio == 1) {
      $estado = '<span class="badge bg-success">Activo</span>';
    }
    if ($estadoAnio == 2) {
      $estado = '<span class="badge bg-danger">Inactivo</span>';
    }
    return $estado;
  }

  public static function getButtonsGradoCerrarAnioEscolar($idGrado)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownCerrarAnioEscolarGrados" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownCerrarAnioEscolarGrados">
        <div>
          <button type="button" class="dropdown-item btnAsignarAlumnosNuevoAnio" idGrado="' . ($idGrado) . '" data-bs-toggle="modal" data-bs-target="#modalCerrarAnioAlumnos">Alumnos</button>
        </div>
      </ul>
    </div>
    ';
    return $botones;
  }
  public static function getSelectAlumnoCerrarAnioEscolar($idAlumno, $idAnioEscolar, $idGrado, $estadoFinal)
  {
      $select = "<select class='form-control selectAlumnoCerrarAnio' name='opcionAlumnoCerrarAnio' id='nota' idAlumno='$idAlumno' idAnioEscolar='$idAnioEscolar' idGrado='$idGrado'>";
      $select .= "<option value='null'>Seleccione</option>";
      $select .= "<option value='1' " . ($estadoFinal == "1" ? "selected" : "") . ">Aprobado</option>";
      $select .= "<option value='2' " . ($estadoFinal == "2" ? "selected" : "") . ">Reprobado</option>";
      $select .= "<option value='3' " . ($estadoFinal == "3" ? "selected" : "") . ">Traslado</option>";
      $select .= "</select>";
  
      return $select;
  }
}
