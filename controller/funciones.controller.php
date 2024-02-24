<?php

class ControllerFunciones
{
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
    if ($stateValue > 2) {
      $estado = '<span class="badge rounded-pill bg-secondary">Sin Estado</span>';
    }

    return $estado;
  }

  //  Estados de los postulantes
  public static function getEstadoPostulantes($stateValue)
  {
    //  Estado de los postulantes 1 = Registrado & 2 = En revisión & 3 = Aceptado & 4 = Rechazado
    if ($stateValue == 1) {
      $estado = '<span class="badge rounded-pill bg-primary">Registrado</span>';
    }
    if ($stateValue == 2) {
      $estado = '<span class="badge rounded-pill bg-warning">En revisión</span>';
    }
    if ($stateValue == 3) {
      $estado = '<span class="badge rounded-pill bg-success">Aprobado</span>';
    }
    if ($stateValue == 4) {
      $estado = '<span class="badge rounded-pill bg-danger">Rechazado</span>';
    }
    if ($stateValue > 4) {
      $estado = '<span class="badge rounded-pill bg-secondary">Sin Estado</span>';
    }
    return $estado;
  }

  //  Mensaje de alerta por acción
  public static function mostrarAlerta($tipo, $titulo, $mensaje, $ruta)
  {
    $alert =
      '<script>
            Swal.fire({
              icon: "' . $tipo . '",
              title: "' . $titulo . '",
              text: "' . $mensaje . '",
            }).then(function(result){
              if(result.value){
                window.location = "' . $ruta . '";
              }
            });
          </script>';
    return $alert;
  }

  //  Botones para los postulantes
  public static function getBotonesPostulante($codPostulante, $estadoPostulante)
  {
    if ($estadoPostulante == 1) {
      $botones = '
        <button type="button" class="btn btn-warning btnEditarPostulante" codPostulante="' . ($codPostulante) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-success btnActualizarPostulante" data-bs-toggle="modal" data-bs-target="#actualizarEstado" codPostulante="' . ($codPostulante) . '" codEstado="' . $estadoPostulante . '"><i class="bi bi-check2-circle"></i></button>
        <button type="button" class="btn btn-danger btnEliminarPostulante" codPostulante="' . ($codPostulante) . '"><i class="bi bi-trash"></i></button>
      ';
    }
    if ($estadoPostulante == 2) {
      $botones = '
        <button type="button" class="btn btn-warning btnEditarPostulante" codPostulante="' . ($codPostulante) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-success btnActualizarPostulante" data-bs-toggle="modal" data-bs-target="#actualizarEstado" codPostulante="' . ($codPostulante) . '" codEstado="' . $estadoPostulante . '"><i class="bi bi-check2-circle"></i></button>
        <button type="button" class="btn btn-danger btnEliminarPostulante" codPostulante="' . ($codPostulante) . '" disabled><i class="bi bi-trash"></i></button>
      ';
    }
    if ($estadoPostulante == 3) {
      $botones = '
        <button type="button" class="btn btn-warning btnEditarPostulante" codPostulante="' . ($codPostulante) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-success btnActualizarPostulante" data-bs-toggle="modal" data-bs-target="#actualizarEstado" codPostulante="' . ($codPostulante) . '" codEstado="' . $estadoPostulante . '"><i class="bi bi-check2-circle"></i></button>
        <button type="button" class="btn btn-danger btnEliminarPostulante" codPostulante="' . ($codPostulante) . '" disabled><i class="bi bi-trash"></i></button>
      ';
    }
    if ($estadoPostulante == 4) {
      $botones = '
        <button type="button" class="btn btn-warning btnEditarPostulante" codPostulante="' . ($codPostulante) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-success btnActualizarPostulante" data-bs-toggle="modal" data-bs-target="#actualizarEstado" codPostulante="' . ($codPostulante) . '" codEstado="' . $estadoPostulante . '"><i class="bi bi-check2-circle"></i></button>
        <button type="button" class="btn btn-danger btnEliminarPostulante" codPostulante="' . ($codPostulante) . '" disabled><i class="bi bi-trash"></i></button>
      ';
    }
    return $botones;
  }

  //  Estados para los alumnos
  public static function getEstadosAlumnos($estadoAlumno)
  {
    //  Estado de los alumnos 1 = Activo & 2 = Inactivo & 3 = En Revisión
    if ($estadoAlumno == 1) {
      $estado = '<span class="badge rounded-pill bg-primary">Activo</span>';
    }
    if ($estadoAlumno == 2) {
      $estado = '<span class="badge rounded-pill bg-warning">Inactivo</span>';
    }
    if ($estadoAlumno == 3) {
      $estado = '<span class="badge rounded-pill bg-warning">En revisión</span>';
    }
    return $estado;
  }

  //  Botones para la vista de listar alumnos
  public static function getBotonesAlumnos($codAlumno, $estadoAlumno)
  {
    if ($estadoAlumno == 1) {
      $botones = '
        <button type="button" class="btn btn-info btnVisualizarAlumno" codAlumno="' . ($codAlumno) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarAlumno" codAlumno="' . ($codAlumno) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarAlumno" codAlumno="' . ($codAlumno) . '"><i class="bi bi-trash"></i></button>
      ';
    }
    if ($estadoAlumno == 2) {
      $botones = '
        <button type="button" class="btn btn-info btnVisualizarAlumno" codAlumno="' . ($codAlumno) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarAlumno" codAlumno="' . ($codAlumno) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarAlumno" codAlumno="' . ($codAlumno) . '" disabled><i class="bi bi-trash"></i></button>
      ';
    }
    if ($estadoAlumno == 3) {
      $botones = '
        <button type="button" class="btn btn-info btnVisualizarAlumno" codAlumno="' . ($codAlumno) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarAlumno" codAlumno="' . ($codAlumno) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarAlumno" codAlumno="' . ($codAlumno) . '" disabled><i class="bi bi-trash"></i></button>
      ';
    }
    return $botones;
  }
}
