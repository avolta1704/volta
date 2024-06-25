<?php
class FunctionUsuario
{

  public static function getTipoUsuarioLogin($tipoUsuarioLogin)
  {

    if ($tipoUsuarioLogin == 1) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Administrador</span>';
    }
    if ($tipoUsuarioLogin == 2) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Docente</span>';
    }
    if ($tipoUsuarioLogin == 3) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Administrativo</span>';
    }
    if ($tipoUsuarioLogin == 4) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Apoderado</span>';
    }
    if ($tipoUsuarioLogin > 5) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Sin Tipo Usuario</span>';
    }

    return $TipoUsuario;
  }
  //  Estados de los usuarios
  public static function getEstadoUsuarios($stateValue)
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

  //botones usuarios
  public static function getBtnUsuarios($codUsuario)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPostulantes" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
        <button type="button" class="dropdown-item btn btnActualizarUsuario" codUsuario="' . $codUsuario . '">Activar</button>
        <button type="button" class="dropdown-item btn btnEditarUsuario" data-bs-toggle="modal" data-bs-target="#editarUsuario" codUsuario="' . $codUsuario . '">Editar</button>
        <button type="button" class="dropdown-item btn btnDeleteUsuario" codUsuario="' . $codUsuario . '">Eliminar</button>
      </ul>
    </div>
    ';
    return $botones;
  }
  // Estado de Pago Inicio Apoderado
  public static function getEstadoPagos($estadoPago){
    //  Estado de los pagos Apoderado 0 = Vencido & 1 = Pendiente
    if ($estadoPago == 0) {
      $estado = '<span class="badge rounded-pill bg-danger">Vencido</span>';
    }
    if ($estadoPago == 1) {
      $estado = '<span class="badge rounded-pill bg-warning">Pendiente</span>';
    }
    if ($estadoPago == 2) {
      $estado = '<span class="badge rounded-pill bg-success">Pagado</span>';
    }
    if ($estadoPago > 3) {
      $estado = '<span class="badge rounded-pill bg-warning">Sin Estado</span>';
    }

    return $estado;
  }
  // Notas Asignadas
  public static function getNotasAsignadas($notasAsignadas){
    //  Estado de los pagos Apoderado 0 = Vencido & 1 = Pendiente
    if ($notasAsignadas == "C") {
      $estado = '<span class="badge rounded-pill bg-danger">C</span>';
    }
    if ($notasAsignadas == "B") {
      $estado = '<span class="badge rounded-pill bg-warning">B</span>';
    }
    if ($notasAsignadas == "A") {
      $estado = '<span class="badge rounded-pill bg-success">A</span>';
    }
    if ($notasAsignadas == "AD") {
      $estado = '<span class="badge rounded-pill bg-success">AD</span>';
    }
    if ($notasAsignadas == null) {
      $estado = '<span class="badge rounded-pill bg-warning">Sin Nota</span>';
    }

    return $estado;
  }
}
