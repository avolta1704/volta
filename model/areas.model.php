<?php
require_once "connection.php";

class ModelAreas
{
  /**
   * Obtiene todas las áreas.
   * 
   * @return array Todas las áreas.
   */
  public static function mdlGetAllAreas()
  {
    $table = "area";
    $stmt = Connection::conn()->prepare("SELECT idArea, descripcionArea FROM $table");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Agrega un área.
   * 
   * @param string $tabla El nombre de la tabla.
   * @param array $dataRegistrarAreaModal Los datos del área a registrar.
   */
  public static function mdlAddArea($tabla, $dataRegistrarAreaModal)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $tabla(descripcionArea, fechaCreacion, usuarioCreacion, fechaActualizacion, usuarioActualizacion) VALUES (:descripcionArea, :fechaCreacion, :usuarioCreacion, :fechaActualizacion, :usuarioActualizacion)");
    $stmt->bindParam(":descripcionArea", $dataRegistrarAreaModal["descripcionArea"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaCreacion", $dataRegistrarAreaModal["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $dataRegistrarAreaModal["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaActualizacion", $dataRegistrarAreaModal["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioActualizacion", $dataRegistrarAreaModal["usuarioActualizacion"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Elimina un área.
   * 
   * @param string $tabla El nombre de la tabla.
   * @param int $idArea El ID del área a eliminar.
   */
  public static function mdlEliminarArea($tabla, $idArea)
  {
    $stmt = Connection::conn()->prepare("DELETE FROM $tabla WHERE idArea = :idArea");
    $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtiene un área.
   * 
   * @param int $idArea El ID del área a obtener.
   */
  public static function mdlGetArea($idArea)
  {
    $table = "area";
    $stmt = Connection::conn()->prepare("SELECT idArea, descripcionArea FROM $table WHERE idArea = :idArea");
    $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
  }

  /**
   * Edita un área.
   * 
   * @param string $tabla El nombre de la tabla.
   * @param array $dataEditarAreaModal Los datos del área a editar.
   * @return string La respuesta de la edición.
   */
  public static function mdlEditarArea($tabla, $dataEditarAreaModal)
  {
    $stmt = Connection::conn()->prepare("UPDATE $tabla SET descripcionArea = :descripcionArea, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idArea = :idArea");
    $stmt->bindParam(":descripcionArea", $dataEditarAreaModal["descripcionArea"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $dataEditarAreaModal["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioActualizacion", $dataEditarAreaModal["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":idArea", $dataEditarAreaModal["idArea"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
