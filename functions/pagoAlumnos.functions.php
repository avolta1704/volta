<?php
class FunctionPagoAlumnos
{

    //  Estados para los alumnos
    public static function getEstadoAlumno($estadoAlumno)
    {
        //  Estado de los alumnos 1 = Activo 2 = Inactivo & 3 = en revisión estraordinaria 
        if ($estadoAlumno == 1) {
            $estado = '<span class="badge rounded-pill bg-success">Activo</span>';
        }
        if ($estadoAlumno == 2) {
            $estado = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
        }
        if ($estadoAlumno == 3) {
            $estado = '<span class="badge rounded-pill bg-warning">En revisión</span>';
        }
        return $estado;
    }

    //  Botones para la vista de alumnosAdmision
    public static function getBotonesPagoAlumnos($codAdAlumCronograma, $estadoAlumno)
    {
        if ($estadoAlumno == 1) {
            $botones = '
        <button type="button" class="btn btn-info btnVisualizarAdmisionAlumno" codAdAlumCronograma="' . ($codAdAlumCronograma) . '" data-bs-toggle="modal" data-bs-target="#cronogramaAdmisionPago" ><i class="bi bi-calendar-week"></i></button>
        <button type="button" class="btn btn-warning btnComunicadoPago" codAdAlumCronograma="' . ($codAdAlumCronograma) . '"><i class="bi bi-envelope-paper"></i></button>
      ';
        }
        if ($estadoAlumno == 2) {
            $botones = '
             <button type="button" class="btn btn-info btnVisualizarAdmisionAlumno" codAdAlumCronograma="' . ($codAdAlumCronograma) . '" data-bs-toggle="modal" data-bs-target="#cronogramaAdmisionPago"><i class="bi bi-calendar-week"></i></button>
        <button type="button" class="btn btn-warning btnComunicadoPago" codAdAlumCronograma="' . ($codAdAlumCronograma) . '" ><i class="bi bi-envelope-paper"></i></button>
      ';
        }
        if ($estadoAlumno == 3) {
            $botones = '
             <button type="button" class="btn btn-info btnVisualizarAdmisionAlumno" codAdAlumCronograma="' . ($codAdAlumCronograma) . '" data-bs-toggle="modal" data-bs-target="#cronogramaAdmisionPago"><i class="bi bi-calendar-week"></i></button>
        <button type="button" class="btn btn-warning btnComunicadoPago" codAdAlumCronograma="' . ($codAdAlumCronograma) . '" ><i class="bi bi-envelope-paper"></i></button>
      ';
        }
        return $botones;
    }
}
