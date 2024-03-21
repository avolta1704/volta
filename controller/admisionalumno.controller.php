<?php
date_default_timezone_set('America/Lima');

class ControllerAdmisionAlumno
{
  //todos los registros de admision
  public static function ctrGetAdmisionAlumnos()
  {
    $tabla = "admision_alumno";
    $listaAdmisionAlumnos = ModelAdmisionAlumno::mdlGetAdmisionAlumnos($tabla);
    return $listaAdmisionAlumnos;
  }
  //  crear postulante alumno extraordinario
  public static function ctrCrearAlumnoExtraordinaria()
  {
    if (isset($_POST["nombresAlumno"]) && isset($_POST["apellidosAlumno"])) {
      // Crear postulante extraordinario con estado 3
      $tabla = "postulante";
      $datosPostulante = array(
        "nombrePostulante" => $_POST["nombresAlumno"],
        "apellidoPostulante" => $_POST["apellidosAlumno"],
        "dniPostulante" => $_POST["dniAlumno"],
        "fechaPostulacion" => $_POST["fechaIngreso"],
        "fechaNacimiento" => $_POST["fechaNacimiento"],
        "gradoPostulacion" => $_POST["gradoAlumno"],
        "estadoPostulante" => 3,
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelPostulantes::mdlCrearPostulante($tabla, $datosPostulante);
      // Crear alumno extraordinario
      if ($response == "ok") {
        $tabla = "alumno";
        $dataAlumno = array(
          "nombresAlumno" => $_POST["nombresAlumno"],
          "apellidosAlumno" => $_POST["apellidosAlumno"],
          "sexoAlumno" => $_POST["sexoAlumno"],
          "estadoSiagie" => 2,//Inactivo
          "estadoAlumno" => 3,//estado extraordinario -> Cambiar luego cuando se autorice el ingreso y se genere el cronograma de pagos
          "estadoMatricula" => 1,
          "dniAlumno" => $_POST["dniAlumno"],
          "fechaNacimiento" => $_POST["fechaNacimiento"],
          "direccionAlumno" => $_POST["direccionAlumno"],
          "distritoAlumno" => $_POST["distrito"],
          "IEPProcedencia" => $_POST["iepProcedencia"],
          "seguroSalud" => $_POST["seguroSalud"],
          "fechaIngresoVolta" => $_POST["fechaIngreso"],
          "numeroEmergencia" => $_POST["numeroEmergencia"],
          "enfermedades" => $_POST["enfermedadesAlumno"],
          "fechaCreacion" => date("Y-m-d\TH:i:sP"),
          "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
          "usuarioCreacion" => $_SESSION["idUsuario"],
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $response = ModelAlumnos::mdlCrearAlumno($tabla, $dataAlumno);
        if ($response == "ok") {
          // Obtener el último postulante creado extraordinario
          $ultimoPostulanteCreado = ControllerPostulantes::ctrObtenerUltimoPostulanteCreado();
          if ($ultimoPostulanteCreado) {
            // Obtener el último alumno creado extraordinario
            $ultimoAlumnoCreado = ControllerAlumnos::ctrObtenerUltimoAlumnoCreado();
            // Crear un array de datos de el id de último registro de postulante, alumno  y el grado del postulante del $_POST gradoAlumno
            if ($ultimoAlumnoCreado) {

              $alumnoExtraordinario = array(
                "idPostulante" => intval($ultimoPostulanteCreado),
                "idAlumno" => intval($ultimoAlumnoCreado),
                "idGrado" => intval($_POST["gradoAlumno"])
              );
              
              //funcion para agregar apoderado a alumno solo si listaApoderados contiene datos 
              if (isset($_POST["listaApoderados"]) && $_POST["listaApoderados"] != "") {
                $listaApoderados = json_decode($_POST["listaApoderados"], true);
                foreach ($listaApoderados as $value) {
                  $listaAlumnos = array(
                    "idAlumno" => $ultimoAlumnoCreado
                  );
                  $dataApoderado = array(
                    "numeroApoderado" => $value["numeroApoderado"],
                    "tipoApoderado" => $value["tipoApoderado"],
                    "correoApoderado" => $value["correoApoderado"],
                    "nombreApoderado" => $value["nombreApoderado"],
                    "apellidoApoderado" => $value["apellidoApoderado"],
                    "listaAlumnos" => json_encode($listaAlumnos),
                    "fechaCreacion" => date("Y-m-d\TH:i:sP"),
                    "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
                    "usuarioCreacion" => $_SESSION["idUsuario"],
                    "usuarioActualizacion" => $_SESSION["idUsuario"]
                  );
                  $nuevoApoderado = ControllerApoderados::ctrCrearApoderadoAlumno($dataApoderado);
                  $codApoderado = ControllerApoderados::ctrObtenerUltimoApoderado();
                  
                
                  $dataApoderadoAlumno = array(
                    "idAlumno" => $alumnoExtraordinario['idAlumno'],
                    "idApoderado" => $codApoderado["idApoderado"],
                    "fechaCreacion" => date("Y-m-d\TH:i:sP"),
                    "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
                    "usuarioCreacion" => $_SESSION["idUsuario"],
                    "usuarioActualizacion" => $_SESSION["idUsuario"]
                  );
                  $response = ControllerAlumnos::ctrAsignarAlumnoApoderado($dataApoderadoAlumno);
                }
              }
              // Crear un nuevo registro del alumno creado en la tabla alumno_grado extraordiario
              $alumnoGradoAsignado = ControllerGradoAlumno::ctrRegistrarGradoAlumnoAdmision($alumnoExtraordinario);
              if ($alumnoGradoAsignado == "ok") {
                // Tomar el año escolar "estadoAnio 1 = actual 2 = anteriores" para el registro de postulante en la tabla anio_escolar extraordiario
                $estadoAnio = 1;
                $anioEscolarActiva = ControllerAnioEscolar::ctrAnioEscolarActivoParaRegistroAlumno($estadoAnio);
                if ($anioEscolarActiva != false) {
                  // Tomar el año escolar activo para el registro de postulante en la tabla admision extraordiario
                  $codPostulante = $alumnoExtraordinario['idPostulante'];
                  $tipoAdmision = 2; // 1 = ordinario, 2 = extraordinario
                  $admisionAnioEscolar = ControllerAdmision::ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulante, $tipoAdmision);
                  if ($admisionAnioEscolar != false) {
                    // Crear un nuevo registro de alumno por la tabla postulante en la tabla admision_alumno extraordiario
                    $admisionAlumno = ControllerAdmision::ctrCrearAdmisionAlumno($admisionAnioEscolar, $alumnoExtraordinario);
                    if ($admisionAlumno != false) {
                      // Proceso completado exitosamente
                      $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Alumno Creado Correctamente", "listaAdmisionAlumnos");
                      echo $mensaje;
                      return "ok";
                    } else {
                      $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
                      echo $mensaje;
                      return "error";
                    }
                  } else {
                    $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
                    echo $mensaje;
                    return "error";
                  }
                } else {
                  $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
                  echo $mensaje;
                  return "error";
                }
              } else {
                $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
                echo $mensaje;
                return "error";
              }
            } else {
              $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
              echo $mensaje;
              return "error";
            }
          } else {
            $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
            echo $mensaje;
            return "error";
          }
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
          echo $mensaje;
          return "error";
        }
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Al Crear nuevo Alumno", "listaAdmisionAlumnos");
        echo $mensaje;
        return "error";
      }
    }
  }
  //ontener data de anio escolar
  public static function ctrOGetDataAnioEscolar()
  {
    $tabla = "anio_escolar";
    $dataAnioEscolar = ModelAdmisionAlumno::mdlGetDataAnioEscolar($tabla);
    return $dataAnioEscolar;
  }
  // Actualizar estado admision_alumno y crear registro en cronograma_pago
  public static function ctrActualizarestadoAdmisionAlumno($codAdmisionAlumno)
  {
    // Obtener el registro de anio_escolar
    $dataAnioEscolar = self::ctrOGetDataAnioEscolar();
    if ($dataAnioEscolar) {
      //sesión esté iniciada
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      // acceder a la variable de sesión
      $idUsuario = $_SESSION["idUsuario"];
      $tabla = "cronograma_pago";
      //crear solo una vez este array de datos por que es la matricula
      $dataCronoPagoMatricula = array(
        "idAdmisionAlumno" => $codAdmisionAlumno,
        "conceptoPago" => "Matricula",
        "montoPago" => $dataAnioEscolar["costoMatricula"],
        "fechaLimite" => date("Y-m-d", strtotime("+30 days")),//fecha 30 dias despues de la fecha de registro
        "estadoCronograma" => 1,//estado por defecto 1 = pendiente 2 = cancelado 3 = anulado
        "mesPago" => date("Y-m-d"),//fecha actual de registro
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
        "usuarioActualizacion" => $idUsuario
      );
      //crear 11 veces este array de datos por que es la Pension pero se tiene que crear desde marzo hasta diciembre
      $dataAllCronoPago = array();
      $dataAllCronoPago[] = $dataCronoPagoMatricula;
      for ($i = 3; $i <= 12; $i++) {
        $mesPago = date("Y") . '-' . sprintf("%02d", $i) . '-05';
        $fechaLimite = date("Y-m-d", strtotime($mesPago . "+30 days"));
        $dataCronoPagoPension = array(
          "idAdmisionAlumno" => $codAdmisionAlumno,
          "conceptoPago" => "Pension",
          "montoPago" => $dataAnioEscolar["costoPension"],
          "fechaLimite" => $fechaLimite,//fecha 30 dias despues de la fecha de mesPago solo en este array
          "estadoCronograma" => 1,//estado por defecto 1 = pendiente 2 = cancelado 3 = anulado
          "mesPago" => $mesPago,//este campo se tiene que cambiar por el mes correspondiente y tiene que ser  el 5 de cada  mes
          "fechaCreacion" => date("Y-m-d H:i:s"),
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioCreacion" => $idUsuario,
          "usuarioActualizacion" => $idUsuario
        );
        $dataAllCronoPago[] = $dataCronoPagoPension;
      }
      foreach ($dataAllCronoPago as $dataAdmisionCronoPago) {
        $response = ModelAdmisionAlumno::mdlCrearCronogramaPago($tabla, $dataAdmisionCronoPago);
        if ($response != "ok") {
          return "error";
        }
      }
      // Actualizar el campo en la tabla admision_alumno
      $table = "admision_alumno";
      $dataActualizarEstadoAdAlum = array(
        "idAdmisionAlumno" => $codAdmisionAlumno,
        "estadoAdmisionAlumno" => 2,//estado por defecto 1 = registrado 2 = establecido 3 = cancelado
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $idUsuario
      );
      $response = ModelAdmisionAlumno::mdlActualizarestadoAdmisionAlumno($table, $dataActualizarEstadoAdAlum);
      if ($response == "ok") {
        return "ok";
      } else {
        return "error";
      }
    } else {
      return "error";
    }
  }
 // ver calendario cronograma pago de la tabla  admision_alumno
  public static function ctrDataCronoPagoAdAlumEstado($codAdAlumCalendario)
  {
    $tabla = "cronograma_pago";
    $dataAdAlumCalendario = ModelAdmisionAlumno::mdlDataCronoPagoAdAlumEstado($tabla, $codAdAlumCalendario);
    return $dataAdAlumCalendario;
  }
}
