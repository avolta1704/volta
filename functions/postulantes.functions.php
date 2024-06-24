<?php
class FunctionPostulantes
{

  //  Estados de los postulantes
  public static function getEstadoPostulantes($stateValue)
  {
    //  Estado de los postulantes 1 = Registrado & 2 = En revisión & 3 = Admitido & 4 = Desistido & 5 = Error
    if ($stateValue == 1) {
      $estado = '<span class="badge rounded-pill bg-primary">Registrado</span>';
    }else
    if ($stateValue == 2) {
      $estado = '<span class="badge rounded-pill bg-warning">En revisión</span>';
    }else
    if ($stateValue == 3) {
      $estado = '<span class="badge rounded-pill bg-success">Matriculado</span>';
    }else
    if ($stateValue == 4) {
      $estado = '<span class="badge rounded-pill bg-danger">Desestimado</span>';
    }else{
      $estado = '<span class="badge rounded-pill bg-secondary">Otro</span>';
    }
    return $estado;
  }
  //  Estados de marticula del postulante
  public static function getEstadoMatricula($stateMatricula)
  {
    //  si el estado del postulante contiene valor 0 o null se muestra como no pagado si contiene valor tiene un pago registrado en el campo pagoMatricula
    if (empty($stateMatricula) || $stateMatricula == 0 || $stateMatricula == null) {
      $matricula = '<span class="badge rounded-pill bg-warning">No Pagado</span>';
    } else {
      $matricula = '<span class="badge rounded-pill bg-primary">Pagado</span>';
    }
    return $matricula;
  }


  //  Botones para los postulantes
  public static function getBotonesPostulante($codPostulante, $estadoPostulante, $pagoMatricula)
  {
    $isDisabled = $estadoPostulante == 3 || $estadoPostulante == 4 || $estadoPostulante == 5 ? ' disabled' : '';
    $idDisabled =  $estadoPostulante == 3 ? ' disabled' : '';
    $isPagoMatricula = $estadoPostulante == 3 || $estadoPostulante == 4 || $estadoPostulante == 5 || strtolower($pagoMatricula) == "pagado" ? ' disabled' : '';
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
      <li><button type="button" class="dropdown-item btnAnadirPago" codPostulante="' . ($codPostulante) . '"' . $isPagoMatricula . '>Añadir pago</button></li>
      <li><button type="button" class="dropdown-item btnEliminarPostulante" codPostulante="' . ($codPostulante) . '"' . $idDisabled . '>Eliminar</button></li>

    ';

    $botones .= '
    </ul>
    </div>
    ';
    return $botones;
  }

  //  Creación del checklist para los postulantes
  public static function renderCheckList($codPostulante, $label, $checkName, $dateName, $estado, $fecha, $mostrarBotones)
  {
    $buttonId = ($label == 'Ficha Postulante') ? 'btnUpdateFichaPostulante' : (($label == 'Informe Psicológico') ? 'btnUpdateInformePsicologico' : 'a');
    $buttonIdDownload = ($label == 'Ficha Postulante') ? 'btnDownloadFichaPostulante' : (($label == 'Informe Psicológico') ? 'btnDownloadInformePsicologico' : 'a');
    $inputId = ($label == 'Ficha Postulante') ? 'fileInput' : (($label == 'Informe Psicológico') ? 'fileInput1' : 'a');
    $spanid = ($label == 'Ficha Postulante') ? 'fileName' : (($label == 'Informe Psicológico') ? 'fileName1' : 'a');
    $isChecked = $estado == "1" ? 'checked' : '';
    $dateValue = $estado == "1" ? $fecha : '';
    $buttons = $mostrarBotones ? "
        <div class='col-sm-2 buttonsChecklist'>
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
            <input type='date' name='$dateName' id='$dateName' class='form-control $dateName' value='$fecha'>
        </div>
        $buttons
    </div>
    ";
  }

  // Selec tipo pago  edit
  public static function getTipoPagoEdit($idTipoPago)
  {
    if ($idTipoPago == 1) {
      $tipo = 'Matrícula';
    }
    if ($idTipoPago == 2) {
      $tipo = 'Pensión';
    }
    if ($idTipoPago == 3) {
      $tipo = 'Otro';
    }
    return $tipo;
  }

  //  Unir apellidos y nombres para la tabla psotulantesReportes
  public static function getUnirNombreApellidoPostulantes($nombre, $apellido)
  {
    return $apellido . ' ' . $nombre;
  }
  //separa el texto de nivel para el datatable de PostulantesReportesAnio
  public static function separarTextoNivelPostulante($nivelPostulante)
  {
    //Secundaria 3er Año
    //Inicial
    //Primaria
    //Secundaria
    $nivelPostulante = explode(" ", $nivelPostulante);
    $nivel = $nivelPostulante[0]; // Obtiene el texto antes del primer espacio
    return $nivel;
  }
  //separa el texto de grado para el datatable de PostulantesReportesAnio
  public static function separarTextoGradoPostulante($gradoPostulante)
  {
    //Secundaria 3er Año
    // 3er Año
    // 3er Año
    // 3er Año
    $gradoPostulante = explode(" ", $gradoPostulante);
    $grado = implode(" ", array_slice($gradoPostulante, 1)); // Obtiene todo el texto después del primer espacio
    return $grado;
  }
  //  Unir apellidos y nombres para el xls de psotulantesReportes
  public static function getUnirNombreApellidoPostulantesXls($nombre, $apellido)
  {
    return $apellido . ', ' . $nombre;
  }
  //  Unir identificador y fecha anño postulacion psotulantesReportes
  public static function getUnirIdentificadorFechaPostulacionAnio($codPostulante, $fechaPostulacion)
  {
    $fechaAnio = self::separarTextofechaDelPostulante($fechaPostulacion);
    return $codPostulante . '-' . $fechaAnio;
  }
  //separar el año de la fecha postulacion para el codigo del exel
  public static function separarTextofechaDelPostulante($fechaPostulacion)
  {
    $fechaPostulacion = explode("-", $fechaPostulacion);
    $fechaAnio = $fechaPostulacion[0]; // Obtiene el texto antes del primer -
    return $fechaAnio;
  }
}
