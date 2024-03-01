<?php
class FunctionPostulantes
{

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
        if ($stateValue > 5) {
            $estado = '<span class="badge rounded-pill bg-secondary">Sin Estado</span>';
        }
        return $estado;
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
}
