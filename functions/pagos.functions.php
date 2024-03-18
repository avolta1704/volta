<?php
class FunctionPagos
{
    //  Estados Cronograma de Pago Vista adminsion
    public static function getEstadoCronogramaPago($estadoCronogramaPago)
    {
        //  Estado de los alumnos 1 = En Revisión 2 = Activo & 3 = Inactivo 
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
