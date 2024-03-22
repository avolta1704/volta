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
        <button type="button" class="btn btn-info btnVisualizarPago" codPago="' . ($codPago) . '" data-bs-toggle="modal" data-bs-target="#modalDetallePago"><i class="bi bi-search"></i></button>
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
    // Selec tipo pago  edit
    public static function getTipoPagoEdit($idTipoPago)
    {
        if ($idTipoPago == 1) {
            $tipo = 'Matricula';
        }
        if ($idTipoPago == 2) {
            $tipo = 'Pension';
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
    // Selec nivel alum pago  edit
    public static function getNivelEdit($nivelAlumEdit)
    {
        if ($nivelAlumEdit == 1) {
            $nivelEdit = 'Inical';
        }
        if ($nivelAlumEdit == 2) {
            $nivelEdit = 'Primaria';
        }
        if ($nivelAlumEdit == 3) {
            $nivelEdit = 'Secundaria';
        }
        return $nivelEdit;
    }
    // Selec Mes Cronograma Pago
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
