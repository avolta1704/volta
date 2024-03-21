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
        if ($estadoCronograma == 1) {
            $botones = '
        <button type="button" class="btn btn-info btnVisualizarPago" codPago="' . ($codPago) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarPago" codPago="' . ($codPago) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarPago" codPago="' . ($codPago) . '"><i class="bi bi-trash"></i></button>
      ';
        }
        if ($estadoCronograma == 2) {
            $botones = '
        <button type="button" class="btn btn-info btnVisualizarPago" codPago="' . ($codPago) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarPago" codPago="' . ($codPago) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarPago" codPago="' . ($codPago) . '" ><i class="bi bi-trash"></i></button>
      ';
        }
        if ($estadoCronograma == 3) {
            $botones = '
        <button type="button" class="btn btn-info btnVisualizarPago" codPago="' . ($codPago) . '"><i class="bi bi-search"></i></button>
        <button type="button" class="btn btn-warning btnEditarPago" codPago="' . ($codPago) . '"><i class="bi bi-pencil"></i></button>
        <button type="button" class="btn btn-danger btnEliminarPago" codPago="' . ($codPago) . '" ><i class="bi bi-trash"></i></button>
      ';
        }
        return $botones;
    }

    // vista de pagos buscar alumno por el dni funcion para idNivel para descripcionGrado
    public static function getNivelAlumnoGrado($nivelAlumno)
    {
        //  Estado de los alumnos 1 = Inicial 2 = Primaria  3 = Secuandaria 
        if ($nivelAlumno == 1) {
            $nivel = 'Inicial';
        }
        if ($nivelAlumno == 2) {
            $nivel = 'Primaria';
        }
        if ($nivelAlumno == 3) {
            $nivel = 'Secuandaria';
        }
        return $nivel;
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
            $nivel = 'Matricula';
        }
        if ($nivelAlumno == 2) {
            $nivel = 'Pencion';
        }
        if ($nivelAlumno == 3) {
            $nivel = 'Otro';
        }

        return $nivel;
    }
}
