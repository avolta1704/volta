<?php
class FunctionComunicado
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
    public static function getBotonesPagoAlumnos($codAdAlumCronograma, $codAlumno, $estadoAlumno)
    {
      $botones = '
      <div class="btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPostulantes" aria-expanded="false">
          <i class="bi bi-pencil-square"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
          <li><button type="button" class="dropdown-item btnVisualizarAdmisionAlumno" codAdAlumCronograma="' . $codAdAlumCronograma . '" data-bs-toggle="modal"  data-bs-target="#cronogramaAdmisionPago">Ver Cronograma</button></li>
          <li><button type="button" class="dropdown-item btnComunicadoPago" codAdAlumCronograma="' . $codAdAlumCronograma . '" codAlumno="' . $codAlumno . '">Ver Comunicados</button></li>
        </ul>
      </div>
      ';
      return $botones;
    }
    /* estado comunicado Cronograma texto  */
    public static function getEstadoComunicadoCrono($estadoAlumno)
    {
        if ($estadoAlumno == 1) {
            $estado = 'Pendiente';
        }
        if ($estadoAlumno == 2) {
            $estado = 'Cancelado';
        }
        if ($estadoAlumno == 3) {
            $estado = 'Anulado';
        }
        return $estado;
    }

}
