<?php
require_once "connection.php";

class ModelPagos
{
  // Obtener todos los alumnos
  public static function mdlGetAllPagos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT 
    idPago, 
    idTipoPago,
    idCronogramaPago, 
    fechaPago, 
    cantidadPago, 
    metodoPago
    FROM $tabla");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}