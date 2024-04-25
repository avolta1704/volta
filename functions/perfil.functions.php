<?php
class FunctionPerfil
{
  //  Tipo de perfil Personal
  public static function getTipoPerfilPersonal($tipoPersonalLogin)
  {

    if ($tipoPersonalLogin == 1) {
      $tipoPersonal = '<span class="badge rounded-pill bg-success">Docente Inicial</span>';
    }
    if ($tipoPersonalLogin == 2) {
      $tipoPersonal = '<span class="badge rounded-pill bg-success">Docente Primaria</span>';
    }
    if ($tipoPersonalLogin == 3) {
      $tipoPersonal = '<span class="badge rounded-pill bg-success">Docente Secundaria</span>';
    }
    if ($tipoPersonalLogin == 4) {
      $tipoPersonal = '<span class="badge rounded-pill bg-success">Docente General</span>';
    }
    if ($tipoPersonalLogin > 5) {
      $tipoPersonal = '<span class="badge rounded-pill bg-success">Dirección</span>';
    }
    if ($tipoPersonalLogin > 6) {
      $tipoPersonal = '<span class="badge rounded-pill bg-success">Administrativo</span>';
    }

    return $tipoPersonal;
  }
  //  Tipo de perfil Usuario
  public static function getTipoPerfilUsuario($tipoUsuariolLogin)
  {

    if ($tipoUsuariolLogin == 1) {
      $tipoPersonal = '<span class="badge rounded-pill bg-success">Administrador</span>';
    }
    if ($tipoUsuariolLogin == 2) {
      $tipoPersonal = '<span class="badge rounded-pill bg-warning">Docente</span>';
    }
    if ($tipoUsuariolLogin == 3) {
      $tipoPersonal = '<span class="badge rounded-pill bg-info">Administrativo</span>';
    }
    if ($tipoUsuariolLogin == 4) {
      $tipoPersonal = '<span class="badge rounded-pill bg-danger">Apoderado</span>';
    }
    return $tipoPersonal;
  }
  //  Tipo de perfil Personal Texto
  public static function getTipoPerfilPersonalTxt($tipoPersonalLogin)
  {
    if ($tipoPersonalLogin == 1) {
      $tipoPersonal = 'Docente Inicial';
    }
    if ($tipoPersonalLogin == 2) {
      $tipoPersonal = 'Docente Primaria';
    }
    if ($tipoPersonalLogin == 3) {
      $tipoPersonal = 'Docente Secundaria';
    }
    if ($tipoPersonalLogin == 4) {
      $tipoPersonal = 'Docente General';
    }
    if ($tipoPersonalLogin > 5) {
      $tipoPersonal = 'Dirección';
    }
    if ($tipoPersonalLogin > 6) {
      $tipoPersonal = 'Administrativo';
    }

    return $tipoPersonal;
  }
  //  Tipo de perfil Usuario Texto
  public static function getTipoPerfilUsuarioTxt($tipoUsuariolLogin)
  {
    if ($tipoUsuariolLogin == 1) {
      $tipoPersonal = 'Administrador';
    }
    if ($tipoUsuariolLogin == 2) {
      $tipoPersonal = 'Docente';
    }
    if ($tipoUsuariolLogin == 3) {
      $tipoPersonal = 'Administrativo';
    }
    if ($tipoUsuariolLogin == 4) {
      $tipoPersonal = 'Apoderado.|    7';
    }
    return $tipoPersonal;
  }
  //  Estados del perfil
  public static function getEstadoPerfil($stateValue)
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

  //botones de perfil 
  public static function getBtnPerfil($codUsuario)
  {
    $buttons = '
        <button type="button" class="btn btn-warning btnActualizarUsuario" codUsuario="' . $codUsuario . '"title="Activar/Desactivar"><i class="bi bi-arrow-left-right"></i></button>
        ';
    return $buttons;
  }
}
