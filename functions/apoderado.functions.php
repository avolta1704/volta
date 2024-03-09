<?php
class FunctionApoderado
{
    //  Tipo de Apoderado
    public static function getTipoApoderado($tipoApoderadoLogin)
    {
        if ($tipoApoderadoLogin == 1) {
            $tipoApoderado = '<span class="badge rounded-pill bg-success">Apoderado</span>';
        }
        if ($tipoApoderadoLogin == 2) {
            $tipoApoderado = '<span class="badge rounded-pill bg-success">Madre</span>';
        }
        if ($tipoApoderadoLogin == 3) {
            $tipoApoderado = '<span class="badge rounded-pill bg-success">Padre</span>';
        }
        return $tipoApoderado;
    }
    //  Estados del Apoderado 
    public static function getEstadoApoderado($stateValue)
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
    //botones de Apoderado
    public static function getBtnApoderado($codApoderado)
    {
        $botones = '
        <button type="button" class="btn btn-warning btnEditarApoderado" codApoderado="' . ($codApoderado) . '"><i class="bi bi-pencil"></i></button>
      ';
   
        return $botones;
    }

}