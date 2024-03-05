<?php
class FunctionPersonal
{
    //  Tipo de personal
    public static function getTipoPersonal($tipoPersonalLogin)
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
    //  Estados del personal 
    public static function getEstadoPersonal($stateValue)
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
    //botones de personal
    public static function getBtnPersonal($codUsuario)
    {
        $buttons = '
        <button type="button" class="btn btn-warning btnActualizarUsuario" codUsuario="' . $codUsuario . '"title="Activar/Desactivar"><i class="bi bi-arrow-left-right"></i></button>
        ';
        return $buttons;
    }

}