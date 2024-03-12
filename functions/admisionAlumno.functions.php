<?php
class FunctionAdmisionAlumnos
{
    //  Estados para  tipoAdmision
    public static function getEstadoTipoAdmision($tipoAdmision)
    {
        $tipoAdmision = intval($tipoAdmision);
        //  Estado tipoAdmision 1 = ordinario 2 = Extraordinario & 3 = Proceso
        if ($tipoAdmision == 1) {
            $tipo = '<span class="badge rounded-pill bg-secondary">Ordinario</span>';
        }
        if ($tipoAdmision == 2) {
            $tipo = '<span class="badge rounded-pill bg-secondary">Extra Ordinario</span>';
        }
        if ($tipoAdmision == "") {
            $tipo = '<span class="badge rounded-pill bg-secondary">Proceso</span>';
        }
        return $tipo;
    }
    //  Estados para estadoAdmisionAlumno
    public static function getEstadoAdmisionAlumno($estadoAdmisionAlumno)
    {
        //  Estado estadoAdmisionAlumno 1 = registtrado  2 = Programado  & 3 = Pagado 4 = Anulado 
        if ($estadoAdmisionAlumno == 1) {
            $estado = '<span class="badge rounded-pill bg-warning">Registrado</span>';
        }
        if ($estadoAdmisionAlumno == 2) {
            $estado = '<span class="badge rounded-pill bg-primary">Programado</span>';
        }
        if ($estadoAdmisionAlumno == 3) {
            $estado = '<span class="badge rounded-pill bg-succes">Pagado</span>';
        }
        if ($estadoAdmisionAlumno == 4) {
            $estado = '<span class="badge rounded-pill bg-danger">Anulado</span>';
        }
        return $estado;
    }
    //  Estados para los alumnos
    public static function getEstadoAlumno($estadoAlumno)
    {
        //  Estado de los alumnos 1 = Activo 2 = Inactivo & 3 = en revisión estraordinaria 
        if ($estadoAlumno == 1) {
            $estado = '<span class="badge rounded-pill bg-primary">Activo</span>';
        }
        if ($estadoAlumno == 2) {
            $estado = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
        }
        if ($estadoAlumno == 3) {
            $estado = '<span class="badge rounded-pill bg-warning">En revisión</span>';
        }
        return $estado;
    }
    //  Estados para estadoSiagie
    public static function getEstadoSiagie($estadoSiagie)
    {
        //  Estado de los alumnos 1 = Activo 2 = Inactivo & 3 = Proceso 
        if ($estadoSiagie == 1) {
            $estado = '<span class="badge rounded-pill bg-success">Activo</span>';
        }
        if ($estadoSiagie == 2) {
            $estado = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
        }
        if ($estadoSiagie == "") {
            $estado = '<span class="badge rounded-pill bg-warning">Proceso</span>';
        }
        return $estado;
    }
    //  Estados para estadoAlumno
    public static function getEstadoMatricula($estadoMatricula)
    {
        //  Estado de los alumnos 1 = Registrado 2 = Matriculado & 3 = sin Registro 
        if ($estadoMatricula == 1) {
            $estado = '<span class="badge rounded-pill bg-warning">Registrado</span>';
        }
        if ($estadoMatricula == 2) {
            $estado = '<span class="badge rounded-pill bg-success">Matriculado</span>';
        }
        if ($estadoMatricula == "") {
            $estado = '<span class="badge rounded-pill bg-primary">Sin Registro</span>';
        }
        return $estado;
    }

    //  Botones para la vista de alumnosAdmision
    public static function getBotonesAdmisionAlumnos($codAdmisionAlumno, $estadoAdmisionAlumno)
    {
        if ($estadoAdmisionAlumno == 1) {
            $botones = '
        <button type="button" class="btn btn-info btnVisualizarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-trash"></i></button>
      ';
        }
        if ($estadoAdmisionAlumno == 2) {
            $botones = '
        <button type="button" class="btn btn-info btnVisualizarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '" disabled><i class="bi bi-trash"></i></button>
      ';
        }
        if ($estadoAdmisionAlumno == 3) {
            $botones = '
        <button type="button" class="btn btn-info btnVisualizarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '" disabled><i class="bi bi-trash"></i></button>
      ';
        }
        if ($estadoAdmisionAlumno == 4) {
            $botones = '
        <button type="button" class="btn btn-info btnVisualizarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarAlumno" codAdmisionAlumno="' . ($codAdmisionAlumno) . '" disabled><i class="bi bi-trash"></i></button>
      ';
        }
        return $botones;
    }
}
