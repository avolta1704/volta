<?php
class FunctionApoderado
{
  //  Tipo de Apoderado
/*   public static function getTipoApoderado($tipoApoderadoLogin)
  {
    if ($tipoApoderadoLogin == "Apoderado") {
      $tipoApoderado = '<span class="badge rounded-pill bg-success">Apoderado</span>';
    }
    if ($tipoApoderadoLogin == "Madre") {
      $tipoApoderado = '<span class="badge rounded-pill bg-success">Madre</span>';
    }
    if ($tipoApoderadoLogin == "Padre") {
      $tipoApoderado = '<span class="badge rounded-pill bg-success">Padre</span>';
    }
    return $tipoApoderado;
  } */
  //  Estados del Apoderado 
  public static function getEstadoApoderado($stateValue)
  {
    //  Estado de los usuarios 1 = Activo & 2 = Desactivado
    if ($stateValue == 1) {
      $estado = '<span class="badge rounded-pill bg-success">Activo</span>';
    }
    if ($stateValue == 2) {
      $estado = '<span class="badge rounded-pill bg-danger">Desactivado</span>';
    }
    if ($stateValue > 3) {
      $estado = '<span class="badge rounded-pill bg-warning">Sin Estado</span>';
    }
    return $estado;
  }
  //botones de Apoderado
  public static function getBtnApoderado($codApoderado)
  {
    $botones = '
        <button type="button" class="btn btn-warning btnEditarApoderado" codApoderado="' . ($codApoderado) . '"><i class="bi bi-pencil"></i></button>
      ';

    return $botones;
  }

  //  Radios de convivencia en vista de editar postulante
  public static function getRadioConvivencia($convivencia, $tipoApoderado)
  {
    if ($convivencia == "Si") {
      $radioConvivencia = '
      <label for="cbxSiConvive" style="font-weight: 600;"><input type="radio" id="cbxSiConvive" value="Si" name="editarConvive' . $tipoApoderado . '" checked>Si</label>
      <label for="cbxNoConvive" style="font-weight: 600;"><input type="radio" id="cbxNoConvive" value="No" name="editarConvive' . $tipoApoderado . '">No</label>
      ';
    } else {
      $radioConvivencia = '
      <label for="cbxSiConvive" style="font-weight: 600;"><input type="radio" id="cbxSiConvive" value="Si" name="editarConvive' . $tipoApoderado . '" >Si</label>
      <label for="cbxNoConvive" style="font-weight: 600;"><input type="radio" id="cbxNoConvive" value="No" name="editarConvive' . $tipoApoderado . '" checked>No</label>
      ';
    }
    return $radioConvivencia;
  }

  //  Radios para dificultad del postulante
  public static function getRadioDificultad($dificultadPostulante)
  {
    if ($dificultadPostulante == "Dificultad") {
      $radioDificultad = '
        <label for="cbxDificultad" style="font-weight: 600;"><input type="radio" id="cbxDificultad" value="Dificultad" name="editarDificultad">Dificultad de aprendizaje/lenguaje</label>
        <label for="cbxImpedimento" style="font-weight: 600;"><input type="radio" id="cbxImpedimento" value="Impedimento" name="editarDificultad">Impedimento físico/motoras</label>
        <label for="cbxEnfermedad" style="font-weight: 600;"><input type="radio" id="cbxEnfermedad" value="Enfermedad" name="editarDificultad">Enfermedad Crónica</label>
        <label for="cbxNinguno" style="font-weight: 600;"><input type="radio" id="cbxNinguno" value="Ninguna" name="editarDificultad">Ninguna</label>
      ';
    }
    if ($dificultadPostulante == "Impedimento") {
      $radioDificultad = '
        <label for="cbxDificultad" style="font-weight: 600;"><input type="radio" id="cbxDificultad" value="Dificultad" name="editarDificultad">Dificultad de aprendizaje/lenguaje</label>
        <label for="cbxImpedimento" style="font-weight: 600;"><input type="radio" id="cbxImpedimento" value="Impedimento" name="editarDificultad" checked>Impedimento físico/motoras</label>
        <label for="cbxEnfermedad" style="font-weight: 600;"><input type="radio" id="cbxEnfermedad" value="Enfermedad" name="editarDificultad">Enfermedad Crónica</label>
        <label for="cbxNinguno" style="font-weight: 600;"><input type="radio" id="cbxNinguno" value="Ninguna" name="editarDificultad">Ninguna</label>
      ';
    }
    if ($dificultadPostulante == "Enfermedad") {
      $radioDificultad = '
        <label for="cbxDificultad" style="font-weight: 600;"><input type="radio" id="cbxDificultad" value="Dificultad" name="editarDificultad">Dificultad de aprendizaje/lenguaje</label>
        <label for="cbxImpedimento" style="font-weight: 600;"><input type="radio" id="cbxImpedimento" value="Impedimento" name="editarDificultad">Impedimento físico/motoras</label>
        <label for="cbxEnfermedad" style="font-weight: 600;"><input type="radio" id="cbxEnfermedad" value="Enfermedad" name="editarDificultad" checked>Enfermedad Crónica</label>
        <label for="cbxNinguno" style="font-weight: 600;"><input type="radio" id="cbxNinguno" value="Ninguna" name="editarDificultad">Ninguna</label>
      ';
    }
    if ($dificultadPostulante == "Ninguna") {
      $radioDificultad = '
        <label for="cbxDificultad" style="font-weight: 600;"><input type="radio" id="cbxDificultad" value="Dificultad" name="editarDificultad">Dificultad de aprendizaje/lenguaje</label>
        <label for="cbxImpedimento" style="font-weight: 600;"><input type="radio" id="cbxImpedimento" value="Impedimento" name="editarDificultad">Impedimento físico/motoras</label>
        <label for="cbxEnfermedad" style="font-weight: 600;"><input type="radio" id="cbxEnfermedad" value="Enfermedad" name="editarDificultad">Enfermedad Crónica</label>
        <label for="cbxNinguno" style="font-weight: 600;"><input type="radio" id="cbxNinguno" value="Ninguna" name="editarDificultad" checked>Ninguna</label>
      ';
    }
    return $radioDificultad;
  }
}
