<?php
require_once "connection.php";

class ModelTecnicaseInstrumentos
{
  /**
   * Crear una nueva técnica e instrumento
   *
   * @param string $tabla
   * @param array $data
   * @return bool
   */
  public static function mdlCrearTecnicaeInstrumentos($tabla, $data)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla(codTecnica, descripcionTecnica, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:codTecnica, :descripcionTecnica, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $stmt->bindParam(":codTecnica", $data["codTecnica"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcionTecnica", $data["descripcionTecnica"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaCreacion", $data["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $data["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $data["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $data["usuarioActualizacion"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Obtener el último id de la técnica
   *
   * @param string $tabla
   * @return int
   */
  public static function mdlObtenerUltimoIdTecnica($tabla)
  {
    $stmt = Connection::conn()->prepare("SELECT MAX(idTecnicaEvaluacion) AS idTecnica FROM $tabla");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_COLUMN);
  }

  /**
   * Crear un nuevo instrumento
   *
   * @param string $tabla
   * @param array $data
   * @return bool
   */
  public static function mdlCrearInstrumento($tabla, $data)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla(idTecnicaEvaluacion, descripcionInstrumento, codInstrumento, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idTecnicaEvaluacion, :descripcionInstrumento, :codInstrumento, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $stmt->bindParam(":idTecnicaEvaluacion", $data["idTecnicaEvaluacion"], PDO::PARAM_INT);
    $stmt->bindParam(":descripcionInstrumento", $data["descripcionInstrumento"], PDO::PARAM_STR);
    $stmt->bindParam(":codInstrumento", $data["codInstrumento"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaCreacion", $data["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $data["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $data["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $data["usuarioActualizacion"], PDO::PARAM_INT);


    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  /*
    * Obtener todas las técnicas
    *
    * @param string $tabla
    * @return array
    */
  public static function mdlGetTodasLasTecnicas($tabla)
  {
    $stmt = Connection::conn()->prepare("SELECT idTecnicaEvaluacion, descripcionTecnica, codTecnica FROM $tabla");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Visualizar una técnica
   *
   * @param string $tabla
   * @param string $codTecnicaVisualizar
   * @return array
   */
  public static function mdlVisualizarTecnica($tabla, $codTecnicaVisualizar)
  {
    $stmt = Connection::conn()->prepare("SELECT descripcionTecnica, codTecnica FROM $tabla WHERE idTecnicaEvaluacion = :idTecnicaEvaluacion");
    $stmt->bindParam(":idTecnicaEvaluacion", $codTecnicaVisualizar, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /** 
    * Obtener la lista de instrumentos por técnica
    *
    * @param string $tabla
    * @param int  $codTecnica
    * @return array
    */
  public static function mdlObtenerInstrumentos($tabla, $codTecnica)
  {
    $stmt = Connection::conn()->prepare("SELECT idInstrumento, descripcionInstrumento, codInstrumento FROM $tabla WHERE idTecnicaEvaluacion = :idTecnicaEvaluacion");
    $stmt->bindParam(":idTecnicaEvaluacion", $codTecnica, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Eliminar un instrumento
   * 
   * @param string $tabla
   * @param int $codInstrumentoEliminar
   * @return bool
   */
  public static function mdlEliminarInstrumento($tabla, $codInstrumentoEliminar)
  {
    $stmt = Connection::conn()->prepare("DELETE FROM $tabla WHERE idInstrumento = :idInstrumento");
    $stmt->bindParam(":idInstrumento", $codInstrumentoEliminar, PDO::PARAM_INT);
    //  Verifico si se puede e
    try {
      if ($stmt->execute()) {
        return true;
      }
    } catch (Exception $e){
      return false;
    }
  }
}
