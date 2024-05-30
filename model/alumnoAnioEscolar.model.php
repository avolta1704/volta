<?php

require_once "connection.php";
 class ModelAlumnoAnioEscolar
 {
   //  Crear anio_admision
   static public function mdlCrearAlumnoAnioEscolar($tabla, $arrayAnio)
   {
     $stmt = Connection::conn()->prepare("INSERT INTO $tabla (idAnioEscolar, idAlumno, idGrado, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idAnioEscolar, :idAlumno, :idGrado, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
     $stmt->bindParam(":idAnioEscolar", $arrayAnio["idAnioEscolar"], PDO::PARAM_INT);
     $stmt->bindParam(":idAlumno", $arrayAnio["idAlumno"], PDO::PARAM_INT);
     $stmt->bindParam(":idGrado", $arrayAnio["idGrado"], PDO::PARAM_INT);
     $stmt->bindParam(":fechaCreacion", $arrayAnio["fechaCreacion"], PDO::PARAM_STR);
     $stmt->bindParam(":fechaActualizacion", $arrayAnio["fechaActualizacion"], PDO::PARAM_STR);
     $stmt->bindParam(":usuarioCreacion", $arrayAnio["usuarioCreacion"], PDO::PARAM_INT);
     $stmt->bindParam(":usuarioActualizacion", $arrayAnio["usuarioActualizacion"], PDO::PARAM_INT);
     if ($stmt->execute()) {
       return "ok";
     } else {
       return "error";
     }
   }
 }