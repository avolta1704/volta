<?php
class FunctionPagos
{
  //  Estados Cronograma de Pago Vista adminsion
  public static function getEstadoCronogramaPago($estadoCronogramaPago)
  {
    //  Estado de los alumnos 1 = Pendiente 2 = Cancelado & 3 = Anulado 
    if ($estadoCronogramaPago == 1) {
      $estado = '<span class="badge rounded-pill bg-warning">Pendiente</span>';
    }
    if ($estadoCronogramaPago == 2) {
      $estado = '<span class="badge rounded-pill bg-success">Cancelado</span>';
    }
    if ($estadoCronogramaPago == 3) {
      $estado = '<span class="badge rounded-pill bg-danger">Anulado</span>';
    }
    return $estado;
  }


    //  Botones para la vista de listar alumnos
    public static function getBotonesPagos($codPago, $estadoCronograma)
    {
      $botones = '
      <div class="btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPagos" aria-expanded="false">
          <i class="bi bi-pencil-square"></i>
        </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
      '; 
      if ($estadoCronograma == 1) {
        $botones .= '
        <div>
          <button type="button" class="dropdown-item btnVisualizarPago" codPago="' . ($codPago) . '" data-bs-toggle="modal" data-bs-target="#modalDetallePago">Visualizar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEditarPago" codPago="' . ($codPago) . '">Editar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEliminarPago" codPago="' . ($codPago) . '">Eliminar</button>
        </div>
        ';
      }
      if ($estadoCronograma == 2) {
        $botones .= '
        <div>
          <button type="button" class="dropdown-item btnVisualizarPago" codPago="' . ($codPago) . '" data-bs-toggle="modal" data-bs-target="#modalDetallePago">Visualizar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEditarPago" codPago="' . ($codPago) . '">Editar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEliminarPago" codPago="' . ($codPago) . '">Eliminar</button>
        </div>
        ';
      }
      if ($estadoCronograma == 3) {
        $botones .= '
        <div>
          <button type="button" class="dropdown-item btnVisualizarPago" codPago="' . ($codPago) . '" data-bs-toggle="modal" data-bs-target="#modalDetallePago">Visualizar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEditarPago" codPago="' . ($codPago) . '">Editar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEliminarPago" codPago="' . ($codPago) . '">Eliminar</button>
        </div>
        ';
      }     
      

    return $botones;
  }
  //  Nivel para el alumno
  public static function getNivelAlumno($nivelAlumno)
  {
    //  Estado de los usuarios 1 = Activo & 2 = Desactivado
    if ($nivelAlumno == 1) {
      $nivel = 'Inical';
    }
    if ($nivelAlumno == 2) {
      $nivel = 'Primaria';
    }
    if ($nivelAlumno == 3) {
      $nivel = 'Secundaria';
    }
    return $nivel;
  }

  //agreagar el simbolo se sol para el campo cantidad 
  public static function getCantidadPago($cantidadPago)
  {
    // Asegúrate de que $cantidadPago es un número antes de concatenar
    if (is_numeric($cantidadPago)) {
      $montoSol = 'S/. ' . $cantidadPago;
      return $montoSol;
    } else {
      return "Sin Valor";
    }
  }
  //  Nivel para el alumno
  public static function getTipoPago($nivelAlumno)
  {
    //  Estado de los usuarios 1 = Activo & 2 = Desactivado
    if ($nivelAlumno == 1) {
      $nivel = 'Matrícula';
    }
    if ($nivelAlumno == 2) {
      $nivel = 'Pensión';
    }
    if ($nivelAlumno == 3) {
      $nivel = 'Otro';
    }
    return $nivel;
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
  // Selec estado pago  edit
  public static function getEstadoPagoEdit($estadoPagoEdit)
  {
    if ($estadoPagoEdit == 1) {
      $estado = 'Registrado';
    }
    if ($estadoPagoEdit == 2) {
      $estado = 'Cancelado';
    }
    if ($estadoPagoEdit == 3) {
      $estado = 'Anulado';
    }
    return $estado;
  }

  // Select Mes Cronograma Pago
  public static function getMesEdit($mesPagoCrono)
  {
    // Crear un objeto DateTime a partir del valor de fecha recibido
    $date = new DateTime($mesPagoCrono);
    // Crear un array con los nombres de los meses en español
    $meses = array(
      1 => 'Enero',
      2 => 'Febrero',
      3 => 'Marzo',
      4 => 'Abril',
      5 => 'Mayo',
      6 => 'Junio',
      7 => 'Julio',
      8 => 'Agosto',
      9 => 'Septiembre',
      10 => 'Octubre',
      11 => 'Noviembre',
      12 => 'Diciembre'
    );
    // Obtener el número del mes
    $numeroMes = $date->format('n');
    // Obtener el nombre del mes en español
    $mesPago = $meses[$numeroMes];
    return $mesPago;
  }
}
