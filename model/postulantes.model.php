<?php
require_once "connection.php";

class ModelPostulantes
{
  //  Obtener todos los postulantes
  public static function mdlGetAllPostulantes($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT postulante.idPostulante, postulante.nombrePostulante, postulante.apellidoPostulante, postulante.dniPostulante, postulante.fechaPostulacion, postulante.pagoMatricula ,
    CASE 
        WHEN postulante.gradoPostulacion = 1 THEN 'Inicial 3 Años'
        WHEN postulante.gradoPostulacion = 2 THEN 'Inicial 4 Años'
        WHEN postulante.gradoPostulacion = 3 THEN 'Inicial 5 Años'
        WHEN postulante.gradoPostulacion = 4 THEN 'Primaria 1er Grado'
        WHEN postulante.gradoPostulacion = 5 THEN 'Primaria 2do Grado'
        WHEN postulante.gradoPostulacion = 6 THEN 'Primaria 3er Grado'
        WHEN postulante.gradoPostulacion = 7 THEN 'Primaria 4to Grado'
        WHEN postulante.gradoPostulacion = 8 THEN 'Primaria 5to Grado'
        WHEN postulante.gradoPostulacion = 9 THEN 'Primaria 6to Grado'
        WHEN postulante.gradoPostulacion = 10 THEN 'Secundaria 1er Año'
        WHEN postulante.gradoPostulacion = 11 THEN 'Secundaria 2do Año'
        WHEN postulante.gradoPostulacion = 12 THEN 'Secundaria 3er Año'
        WHEN postulante.gradoPostulacion = 13 THEN 'Secundaria 4to Año'
        WHEN postulante.gradoPostulacion = 14 THEN 'Secundaria 5to Año'
        ELSE 'Sin Grado'
    END AS descripcionGrado,
    postulante.estadoPostulante 
    FROM $tabla 
    ORDER BY postulante.idPostulante DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Crear postulante
  public static function mdlCrearPostulante($tabla, $datosPostulante)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (nombrePostulante, apellidoPostulante, sexoPostulante, dniPostulante, gradoPostulacion, fechaPostulacion, fechaNacimiento, lugarNacimiento, domicilioPostulante, colegioProcedencia, dificultadPostulante, dificultadObservacion, tipoAtencionPostulante, tratamientoPostulante, listaApoderados, estadoPostulante, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:nombrePostulante, :apellidoPostulante, :sexoPostulante, :dniPostulante, :gradoPostulacion, :fechaPostulacion, :fechaNacimiento, :lugarNacimiento, :domicilioPostulante, :colegioProcedencia, :dificultadPostulante, :dificultadObservacion, :tipoAtencionPostulante, :tratamientoPostulante, :listaApoderados, :estadoPostulante, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $statement->bindParam(":nombrePostulante", $datosPostulante["nombrePostulante"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoPostulante", $datosPostulante["apellidoPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":sexoPostulante", $datosPostulante["sexoPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":dniPostulante", $datosPostulante["dniPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":gradoPostulacion", $datosPostulante["gradoPostulacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaPostulacion", $datosPostulante["fechaPostulacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $datosPostulante["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":lugarNacimiento", $datosPostulante["lugarNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":domicilioPostulante", $datosPostulante["domicilioPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":colegioProcedencia", $datosPostulante["colegioProcedencia"], PDO::PARAM_STR);
    $statement->bindParam(":dificultadPostulante", $datosPostulante["dificultadPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":dificultadObservacion", $datosPostulante["dificultadObservacion"], PDO::PARAM_STR);
    $statement->bindParam(":tipoAtencionPostulante", $datosPostulante["tipoAtencionPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":tratamientoPostulante", $datosPostulante["tratamientoPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":listaApoderados", $datosPostulante["listaApoderados"], PDO::PARAM_STR);
    $statement->bindParam(":estadoPostulante", $datosPostulante["estadoPostulante"], PDO::PARAM_INT);
    $statement->bindParam(":fechaCreacion", $datosPostulante["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $datosPostulante["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $datosPostulante["usuarioCreacion"], PDO::PARAM_INT);
    $statement->bindParam(":usuarioActualizacion", $datosPostulante["usuarioActualizacion"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Eliminar postulante
  public static function mdlBorrarPostulante($tabla, $codPostulante)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $tabla WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener postulante por id
  public static function mdlGetPostulanteById($tabla, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT
    postulante.nombrePostulante, 
    postulante.apellidoPostulante, 
    grado.idGrado, 
    grado.descripcionGrado, 
    nivel.idNivel, 
    nivel.descripcionNivel, 
    postulante.sexoPostulante, 
    postulante.dniPostulante, 
    postulante.fechaNacimiento, 
    postulante.lugarNacimiento, 
    postulante.gradoPostulacion, 
    postulante.domicilioPostulante, 
    postulante.colegioProcedencia, 
    postulante.dificultadPostulante, 
    postulante.dificultadObservacion, 
    postulante.tipoAtencionPostulante, 
    postulante.tratamientoPostulante, 
    postulante.fechaPostulacion,
    postulante.listaApoderados
  FROM
    $tabla
    INNER JOIN
    grado
    ON 
      postulante.gradoPostulacion = grado.idGrado
    INNER JOIN
    nivel
    ON 
      grado.idNivel = nivel.idNivel
  WHERE
    idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Editar postulante
  public static function mdlEditarPostulante($tabla, $datosPostulante)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombrePostulante = :nombrePostulante, apellidoPostulante = :apellidoPostulante, sexoPostulante = :sexoPostulante, dniPostulante = :dniPostulante, gradoPostulacion = :gradoPostulacion, fechaPostulacion = :fechaPostulacion, fechaNacimiento = :fechaNacimiento, lugarNacimiento = :lugarNacimiento, domicilioPostulante = :domicilioPostulante, colegioProcedencia = :colegioProcedencia, dificultadPostulante = :dificultadPostulante, dificultadObservacion = :dificultadObservacion, tipoAtencionPostulante = :tipoAtencionPostulante, tratamientoPostulante = :tratamientoPostulante, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idPostulante = :idPostulante");
    $statement->bindParam(":nombrePostulante", $datosPostulante["nombrePostulante"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoPostulante", $datosPostulante["apellidoPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":sexoPostulante", $datosPostulante["sexoPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":dniPostulante", $datosPostulante["dniPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":gradoPostulacion", $datosPostulante["gradoPostulacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaPostulacion", $datosPostulante["fechaPostulacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $datosPostulante["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":lugarNacimiento", $datosPostulante["lugarNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":domicilioPostulante", $datosPostulante["domicilioPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":colegioProcedencia", $datosPostulante["colegioProcedencia"], PDO::PARAM_STR);
    $statement->bindParam(":dificultadPostulante", $datosPostulante["dificultadPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":dificultadObservacion", $datosPostulante["dificultadObservacion"], PDO::PARAM_STR);
    $statement->bindParam(":tipoAtencionPostulante", $datosPostulante["tipoAtencionPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":tratamientoPostulante", $datosPostulante["tratamientoPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $datosPostulante["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $datosPostulante["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idPostulante", $datosPostulante["idPostulante"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener estado del postulante
  public static function mdlObtenerEstadoPostulante($tabla, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT estadoPostulante FROM $tabla WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Actualizar el estado de un postulante, en el caso que este como presentado se cambia a en revisión
  public static function mdlActualizarEstadoPostulante($tabla, $dataPostulanteEdit)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoPostulante = :estadoPostulante,fechaActualizacion = :fechaActualizacion, usuarioActualizacion=:usuarioActualizacion WHERE idPostulante = :idPostulante");
    $statement->bindParam(":estadoPostulante", $dataPostulanteEdit["estadoPostulante"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $dataPostulanteEdit["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataPostulanteEdit["usuarioActualizacion"], PDO::PARAM_INT);
    $statement->bindParam(":idPostulante", $dataPostulanteEdit["idPostulante"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Obtener el último postulante creado extraordinario
  public static function mdlObtenerUltimoPostulanteCreado($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT MAX(idPostulante) AS idPostulante FROM $tabla");
    $statement->execute();
    return $statement->fetchColumn();
  }

  //  Obtener data de un postulante
  public static function mdlGetDatosPostulanteEditar($table, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT
      nombrePostulante, 
      apellidoPostulante, 
      dniPostulante, 
      fechaNacimiento, 
      gradoPostulacion 
      FROM $table WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Obtener lista de apoderados de un postulante por el código del postulante
  public static function mdlGetListaApoderados($table, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT listaApoderados FROM $table WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll();
  }

  //  Obtener todos los postulantes para la busqueda
  public static function mdlGetPostulantesBusqueda($table)
  {
    $statement = Connection::conn()->prepare("SELECT idPostulante, nombrePostulante, apellidoPostulante FROM $table WHERE estadoPostulante = 1 ORDER BY idPostulante DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Buscar postulante por identificador
  public static function mdlBuscarPostulanteById($table, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT
    postulante.sexoPostulante, 
    postulante.dniPostulante, 
    postulante.gradoPostulacion, 
    postulante.fechaPostulacion, 
    postulante.fechaNacimiento, 
    postulante.lugarNacimiento, 
    postulante.domicilioPostulante, 
    postulante.colegioProcedencia, 
    postulante.dificultadPostulante, 
    postulante.dificultadObservacion, 
    postulante.tipoAtencionPostulante, 
    postulante.tratamientoPostulante,
    postulante.listaApoderados
    FROM $table WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Obtiene los datos de un postulante por su código.
   *
   * @param int $codPostulante El código del postulante.
   * @return array|false Los datos del postulante o false si no se encuentra.
   */
  public static function mdlGetDataPostulanteById($codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT * FROM postulante WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Obtener la data del checklist
  public static function mdlGetChecklistPostulante($table, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT fichaPostulante, fechaFichaPost, estadoFichaPostulante, fechaEntrevista, estadoEntrevista, informePsicologico, fechaInformePsicologico, estadoInformePsicologico, constanciaAdeudo, fechaConstanciaAdeudo, cartaAdmision, fechaCartaAdmision, pagoMatricula, fechaPagoMatricula, contrato, fechaContrato, constanciaVacante, fechaConstanciaVacante FROM $table WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Actualiza el pago de matrícula de un postulante en la base de datos.
   *
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @param array $datosPostulante Los datos del postulante a actualizar.
   * @return string Retorna "ok" si la actualización fue exitosa, o "error" en caso contrario.
   */
  public static function mdlEditarPagoPostulante($tabla, $datosPostulante)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET pagoMatricula = :pagoMatricula, fechaPagoMatricula = :fechaPagoMatricula , fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idPostulante = :idPostulante");
    $statement->bindParam(":pagoMatricula", $datosPostulante["pagoMatricula"], PDO::PARAM_STR);
    $statement->bindParam(":fechaPagoMatricula", $datosPostulante["fechaPagoMatricula"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $datosPostulante["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $datosPostulante["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idPostulante", $datosPostulante["idPostulante"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Actualizar el checklist del postulante con todas las modificaciones

  public static function mdlActualizarChecklist($table, $actualizarChecklist)
  {
    $statement = Connection::conn()->prepare("
      UPDATE $table
      SET estadoFichaPostulante = :estadoFichaPostulante,
        fechaFichaPost = :fechaFichaPost,
        estadoEntrevista = :estadoEntrevista,
        fechaEntrevista = :fechaEntrevista,
        estadoInformePsicologico = :estadoInformePsicologico,
        fechaInformePsicologico = :fechaInformePsicologico,
        constanciaAdeudo = :constanciaAdeudo,
        fechaConstanciaAdeudo = :fechaConstanciaAdeudo,
        cartaAdmision = :cartaAdmision,
        fechaCartaAdmision = :fechaCartaAdmision,
        contrato = :contrato,
        fechaContrato = :fechaContrato,
        constanciaVacante = :constanciaVacante,
        fechaConstanciaVacante = :fechaConstanciaVacante,
        pagoMatricula = :pagoMatricula,
        fechaPagoMatricula = :fechaPagoMatricula,
        fechaActualizacion = :fechaActualizacion,
        usuarioActualizacion = :usuarioActualizacion
      WHERE idPostulante = :idPostulante
    ");
    $statement->bindParam(":idPostulante", $actualizarChecklist["idPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":estadoFichaPostulante", $actualizarChecklist["estadoFichaPostulante"], PDO::PARAM_STR);
    $statement->bindParam(":fechaFichaPost", $actualizarChecklist["fechaFichaPost"], PDO::PARAM_STR);
    $statement->bindParam(":fechaEntrevista", $actualizarChecklist["fechaEntrevista"], PDO::PARAM_STR);
    $statement->bindParam(":estadoEntrevista", $actualizarChecklist["estadoEntrevista"], PDO::PARAM_STR);
    $statement->bindParam(":fechaInformePsicologico", $actualizarChecklist["fechaInformePsicologico"], PDO::PARAM_STR);
    $statement->bindParam(":estadoInformePsicologico", $actualizarChecklist["estadoInformePsicologico"], PDO::PARAM_STR);
    $statement->bindParam(":constanciaAdeudo", $actualizarChecklist["constanciaAdeudo"], PDO::PARAM_STR);
    $statement->bindParam(":fechaConstanciaAdeudo", $actualizarChecklist["fechaConstanciaAdeudo"], PDO::PARAM_STR);
    $statement->bindParam(":cartaAdmision", $actualizarChecklist["cartaAdmision"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCartaAdmision", $actualizarChecklist["fechaCartaAdmision"], PDO::PARAM_STR);
    $statement->bindParam(":contrato", $actualizarChecklist["contrato"], PDO::PARAM_STR);
    $statement->bindParam(":fechaContrato", $actualizarChecklist["fechaContrato"], PDO::PARAM_STR);
    $statement->bindParam(":constanciaVacante", $actualizarChecklist["constanciaVacante"], PDO::PARAM_STR);
    $statement->bindParam(":fechaConstanciaVacante", $actualizarChecklist["fechaConstanciaVacante"], PDO::PARAM_STR);
    $statement->bindParam(":pagoMatricula", $actualizarChecklist["pagoMatricula"], PDO::PARAM_STR);
    $statement->bindParam(":fechaPagoMatricula", $actualizarChecklist["fechaPagoMatricula"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $actualizarChecklist["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $actualizarChecklist["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Comprueba si un postulante ha realizado el pago de la matrícula.
   *
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @param int $codPostulante El código del postulante.
   * @return string Retorna "ok" si el postulante ha realizado el pago de la matrícula, o "error" en caso contrario.
   */
  public static function mdlIsPostulantePagoMatricula($tabla, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT pagoMatricula FROM $tabla WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->fetchColumn() != null) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtiene el pago de matrícula de un postulante.
   *
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @param int $codPostulante El código del postulante.
   * @return array|false El pago de matrícula del postulante o false si no se encuentra.
   */
  public static function mdlGetPagoMatriculaPostulante($tabla, $codPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT pagoMatricula, idPostulante FROM $tabla WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $codPostulante, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
}
