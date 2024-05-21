<?php
class ControllerAreas
{
  /**
   * Obtiene todas las áreas.
   * 
   * @return array Todas las áreas.
   */
  static public function ctrGetAllAreas()
  {
    $response = ModelAreas::mdlGetAllAreas();
    return $response;
  }

  /**
   * Agrega un área.
   * 
   * @param array $dataRegistrarAreaModal Los datos del área a registrar.
   */
  static public function ctrAddArea($dataRegistrarAreaModal)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $tabla = "area";
    $idUsuario = $_SESSION['idUsuario'];
    $dataRegistrarAreaModal = array(
      "descripcionArea" => $dataRegistrarAreaModal["descripcionArea"],
      "usuarioCreacion" => $idUsuario,
      "fechaCreacion" => date('Y-m-d H:i:s'),
      "usuarioActualizacion" => $idUsuario,
      "fechaActualizacion" => date('Y-m-d H:i:s'),
    );

    $response = ModelAreas::mdlAddArea($tabla, $dataRegistrarAreaModal);
    if ($response == "ok") {
      return "ok";
    } else {
      return $response;
    }
  }

  /**
   * Elimina un área.
   * 
   * @param int $idArea El ID del área a eliminar.
   */
  public static function ctrEliminarArea($idArea)
  {
    $tabla = "area";

    $existeArea = ModelCursos::mdlExistAreaEnCurso($idArea);
    if ($existeArea == "ok") {
      return "error";
    }

    $response = ModelAreas::mdlEliminarArea($tabla, $idArea);
    if ($response == "ok") {
      return "ok";
    } else {
      return $response;
    }
  }

  /**
   * Obtiene un área.
   * 
   * @param int $idArea El ID del área a obtener.
   */
  public static function ctrGetArea($idArea)
  {
    $response = ModelAreas::mdlGetArea($idArea);
    return $response;
  }

  /**
   * Edita un área.
   * 
   * @param array $dataEditarAreaModal Los datos del área a editar.
   * @return string La respuesta de la edición.
   */
  public static function ctrEditarArea($dataEditarAreaModal)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $tabla = "area";
    $idUsuario = $_SESSION['idUsuario'];
    $dataEditarAreaModal = array(
      "idArea" => $dataEditarAreaModal["idArea"],
      "descripcionArea" => $dataEditarAreaModal["descripcionArea"],
      "usuarioActualizacion" => $idUsuario,
      "fechaActualizacion" => date('Y-m-d H:i:s'),
    );

    $response = ModelAreas::mdlEditarArea($tabla, $dataEditarAreaModal);
    if ($response == "ok") {
      return "ok";
    } else {
      return $response;
    }
  }
}
