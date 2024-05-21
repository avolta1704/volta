<?php
class FunctionPostulantes
{

  //  Estados de los postulantes
  public static function getEstadoPostulantes($stateValue)
  {
    //  Estado de los postulantes 1 = Registrado & 2 = En revisión & 3 = Admitido & 4 = Desistido & 5 = Error
    if ($stateValue == 1) {
      $estado = '<span class="badge rounded-pill bg-primary">Registrado</span>';
    }
    if ($stateValue == 2) {
      $estado = '<span class="badge rounded-pill bg-warning">En revisión</span>';
    }
    if ($stateValue == 3) {
      $estado = '<span class="badge rounded-pill bg-success">Admitido</span>';
    }
    if ($stateValue == 4) {
      $estado = '<span class="badge rounded-pill bg-danger">Desistido</span>';
    }
    if ($stateValue == 5) {
      $estado = '<span class="badge rounded-pill bg-secondary">Error</span>';
    }
    return $estado;
  }


  //  Botones para los postulantes
  public static function getBotonesPostulante($codPostulante, $estadoPostulante, $pagoMatricula)
  {
    $isDisabled = $estadoPostulante == 3 || $estadoPostulante == 4 || $estadoPostulante == 5 ? ' disabled' : '';
    $isPagoMatricula = $estadoPostulante == 3 || $estadoPostulante == 4 || $estadoPostulante == 5 || $pagoMatricula != null ? ' disabled' : '';
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPostulantes" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
    <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
    ';

    $botones .= '
      <li><button type="button" class="dropdown-item btnVisualizarPostulante" codPostulante="' . ($codPostulante) . '">Visualizar</button></li>
      <li><button type="button" class="dropdown-item btnEditarPostulante" codPostulante="' . ($codPostulante) . '"' . $isDisabled . '>Editar</button></li>
      <li><button type="button" class="dropdown-item btnActualizarEstadoPostulante" data-bs-toggle="modal" data-bs-target="#actualizarEstado" codPostulante="' . ($codPostulante) . '" codEstado="' . $estadoPostulante . '"' . $isDisabled . '>Actualizar</button></li>
      <li><button type="button" class="dropdown-item btnEliminarPostulante" codPostulante="' . ($codPostulante) . '"' . $isDisabled . '>Eliminar</button></li>
      <li><button type="button" class="dropdown-item btnAnadirPago" codPostulante="' . ($codPostulante) . '"' . $isPagoMatricula . '>Añadir pago</button></li>
    ';

    $botones .= '
    </ul>
    </div>
    ';
    return $botones;
  }

  //  Creación del checklist para los postulantes
  public static function renderCheckList($codPostulante,$label, $checkName, $dateName, $estado, $fecha, $mostrarBotones)
  {
    $buttonId = ($label == 'Ficha Postulante') ? 'btnUpdateFichaPostulante' : (($label == 'Informe Psicológico') ? 'btnUpdateInformePsicologico' : 'a');
    $buttonIdDownload = ($label == 'Ficha Postulante') ? 'btnDownloadFichaPostulante' : (($label == 'Informe Psicológico') ? 'btnDownloadInformePsicologico' : 'a');
    $inputId = ($label == 'Ficha Postulante') ? 'fileInput' : (($label == 'Informe Psicológico') ? 'fileInput1' : 'a');
    $spanid = ($label == 'Ficha Postulante') ? 'fileName' : (($label == 'Informe Psicológico') ? 'fileName1' : 'a');
    $isChecked = $estado == "1" ? 'checked' : '';
    $dateValue = $estado == "1" ? $fecha : '';
    $buttons = $mostrarBotones ? "
        <div class='col-sm-2'>
            <button type='button' class='btn btn-success btnUpdateFichaPostulante' id='$buttonId' data-codpostulante='$codPostulante'><i class='bi bi-cloud-arrow-up-fill'></i></button>
            <button type='button' class='btn btn-warning' id='$buttonIdDownload' data-codpostulante='$codPostulante'><i class='bi bi-cloud-arrow-down-fill'></i></button>
            <!-- MANEJO DE IMAGENES -->
            <input type='file' id='$inputId' style='display:none;' />
            <span id='$spanid' style='display:block;'></span>
        </div>
    " : "";
    echo "
    <div class='form-group row'>
        <label for='$checkName' class='col-sm-3 col-form-label' style='font-weight: bold'>$label: </label>
        <div class='col-sm-2'>
            <div class='form-check form-switch'>
                <input class='form-check-input' type='checkbox' id='$checkName' name='$checkName' $isChecked>
                <label class='form-check-label' for='$checkName'>Presentado</label>
            </div>
        </div>
        <div class='col-sm-3'>
            <input type='date' name='$dateName' id='$dateName' class='form-control $dateName' value='$dateValue'>
        </div>
        $buttons
    </div>
    ";
  }
}
