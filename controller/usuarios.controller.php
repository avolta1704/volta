<?php
date_default_timezone_set('America/Lima');

class ControllerUsuarios
{
  //creacion de sesion
  public static function ctrIniciarSesion()
  {
    if (isset($_POST["inputCorreo"]) && $_POST["inputCorreo"] != "" && $_POST["inputCorreo"] != null && $_POST["inputPassword"] != "" && $_POST["inputPassword"] != null) {

      //  Verificamos si son los datos correctos y si el usuarios está activo o no
      $verificar = self::ctrVerificarUsuario($_POST["inputCorreo"], $_POST["inputPassword"]);

      if ($verificar != false) {
        $tabla = "usuario";
        $dataUsuario = ModelUsuarios::mdlObtenerDatosSesion($tabla, $_POST["inputCorreo"]);
        $_SESSION["login"] = "ok";
        $_SESSION["idUsuario"] = $dataUsuario["idUsuario"];
        $_SESSION["correoUsuario"] = $dataUsuario["correoUsuario"];
        $_SESSION["nombreCompleto"] = $dataUsuario["nombreUsuario"] . ' ' . $dataUsuario["apellidoUsuario"];
        $_SESSION["tipoUsuario"] = $dataUsuario["idTipoUsuario"];

        //  Si el usuario es de tipo docente, se debe obtener el tipo de docente por medio de la tabla personal y tipo de personal
        if ($dataUsuario["idTipoUsuario"] == 2) {
          $TipoDocente = ControllerPersonal::ctrGetTipoDocente($dataUsuario["idUsuario"]);
          $_SESSION["tipoDocente"] = $TipoDocente["idTipoPersonal"];
          $_SESSION["descripcionDocente"] = $TipoDocente["descripcionTipo"];
        }
        // Save last login
        $ultimaConexion = date("Y-m-d\TH:i:sP");
        // Update last login
        $updateConnection = ModelUsuarios::mdlActualizarSesion($tabla, $ultimaConexion, $dataUsuario["idUsuario"]);
        if ($updateConnection == "ok") {
          echo '<script>
            window.location = "inicio";
          </script>';
        }
      } else {
        echo '<br><div class="alert alert-danger" role="alert">Las credenciales ingresadas no son correctas</div>';
      }
    }
  }

  //  Verificar usuario
  public static function ctrVerificarUsuario($email, $password)
  {
    $tabla = "usuario";
    $userData = ModelUsuarios::mdlObtenerDataUsuario($tabla, $email);
    if ($userData == null) {
      return false;
    }
    $verificar = password_verify($password, $userData["password"]);

    //  Primero verificamos si los datos ingresados son correctos, en el caso que si sea se verificará si el usuario está activo o no
    if ($verificar == true) {
      $verificarActivo = self::ctrVerificarEstado($email);
      if ($verificarActivo == "activo") {
        return true;
      } else {
        return false;
      }
    } else {
      $verificar = false;
    }
    return $verificar;
  }

  //  Verificar estado del usuario
  public static function ctrVerificarEstado($email)
  {
    $tabla = "usuario";
    $estadoUsuario = ModelUsuarios::mdlObtenerEstadoUsuarioCorreo($tabla, $email);
    if ($estadoUsuario["estadoUsuario"] == "1") {
      return "activo";
    } else {
      return "inactivo";
    }
  }

  //  Agregar nuevo usuario
  public static function ctrGetAllUsuarios()
  {
    $tabla = "usuario";
    $listUsuarios = ModelUsuarios::mdlGetAllUsuarios($tabla);
    return $listUsuarios;
  }
  //  Obtener tipos de usuarios
  public static function ctrGetTipoUsuarios()
  {
    $tabla = "tipo_usuario";
    $listTipos = ModelUsuarios::mdlGetTipoUsuarios($tabla);
    return $listTipos;
  }
  //  Crear usuario y  personal dependiendo del tipo 1 = admin y 4 = apoderado ,otro valor = personal
  public static function ctrCrearUsuario()
  {
    if (isset($_POST["usuarioCorreo"]) && isset($_POST["passwordUsuario"])) {
      $tabla = "usuario";
      $password = password_hash($_POST["passwordUsuario"], PASSWORD_ARGON2ID, [
        'memory_cost' => 1 << 12,
        'time_cost' => 2,
        'threads' => 2
      ]);
      $dataUsuario = array(
        "correoUsuario" => $_POST["usuarioCorreo"],
        "password" => $password,
        "nombreUsuario" => $_POST["nombreUsuario"],
        "apellidoUsuario" => $_POST["apellidoUsuario"],
        "dniUsuario" => $_POST["dniUsuario"],
        "idTipoUsuario" => $_POST["tipoUsuario"],
        "estadoUsuario" => "1",
        "fechaCreacion" => date("Y-m-d\TH:i:sP"),
        "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelUsuarios::mdlCrearUsuario($tabla, $dataUsuario);
      if ($response == "ok") {
        //  Crear apoderado si es igual a 4
        if ($dataUsuario["idTipoUsuario"] == 4) {
          $ultimoIdUsuario = ControllerApoderados::ctrUltimoUsuarioCreado();
          $dataUsuario["idUsuario"] = $ultimoIdUsuario["idUsuario"];
          $response = ControllerApoderados::ctrCrearUsuarioApoderado($dataUsuario);
          //  Crear personal si es diferente de 1
        } elseif ($dataUsuario["idTipoUsuario"] != 1) {
          $ultimoIdUsuario = ControllerPersonal::ctrUltimoUsuarioCreado();
          $dataUsuario["idUsuario"] = $ultimoIdUsuario["idUsuario"];
          $response = ControllerPersonal::ctrCrearUsuarioPersonal($dataUsuario);
        } else {
          $response = "ok";
        }
        if ($response == "ok") {
          $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Usuario creado correctamente", "usuarios");
          echo $mensaje;
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al crear un nuevo usuario", "usuarios");
          echo $mensaje;
        }
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al crear un nuevo usuario", "usuarios");
        echo $mensaje;
      }
    }
  }
  //  Obtener datos para editar
  public static function ctrGetUsuarioEdit($codUsuario)
  {
    $tabla = "usuario";
    $dataUsuario = ModelUsuarios::mdlGetUsuarioEditar($tabla, $codUsuario);
    return $dataUsuario;
  }
  //  Editar usuario
  public static function ctrEditarUsuarioPersonal()
  {
    if (isset($_POST["correoEditar"]) && isset($_POST["tipoEditar"])) {
      if ($_POST["tipoEditar"] == 4) {
        $mensaje = ControllerFunciones::mostrarAlerta('error', 'Error, No se puede cambiar un Personal a Apoderado', 'NO SE PUEDE EDITAR AL APODERADO EN ESTE MODULO', 'usuarios');
        echo $mensaje;
        exit();
      }
      // Si el usuario se cambia de docente a administrativo entonces se debe cambiar el tipo de personal a administrativo
      if ($_POST["tipoEditar"] == 3) {
        $tablaTipoPersonal = "tipo_personal";

        $idTipoAdministrativo = ModelPersonal::mdlObtenerIdTipoPersonal($tablaTipoPersonal);

        $dataPersonal = array(
          "idUsuario" => $_POST["codUsuario"],
          "idTipoPersonal" => $idTipoAdministrativo["idTipoPersonal"],
          "correoPersonal" => $_POST["correoEditar"],
          "nombrePersonal" => $_POST["nombreEditar"],
          "apellidoPersonal" => $_POST["apellidoEditar"],
          "fechaCreacion" => date("Y-m-d\TH:i:sP"),
          "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
          "usuarioCreacion" => $_SESSION["idUsuario"],
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );

        $tabla = "personal";
        // buscamos si existe este personal 
        $personal = ModelPersonal::mdlGetPersonalByIdUsuario($tabla, $_POST["codUsuario"]);

        if ($personal) {
          $response = ModelPersonal::mdlEditarUsuarioPersonal($tabla, $dataPersonal);
        }

        if ($response == "ok") {
          $mensaje = ControllerFunciones::mostrarAlerta('success', 'Correcto', 'Usuario editado correctamente', 'usuarios');
          echo $mensaje;
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta('error', 'Error', 'Error al editar el usuario', 'usuarios');
          echo $mensaje;
        }
      }

      // Si el usuario se cambia de administrativo a docente entonces se debe agregar o actualizar el personal
      if ($_POST["tipoEditar"] == 2) {
        $tablaTipoPersonal = "tipo_personal";

        $idTipoDocente = ModelPersonal::mdlObtenerIdTipoDocente($tablaTipoPersonal);

        $dataPersonal = array(
          "idUsuario" => $_POST["codUsuario"],
          "idTipoPersonal" => $idTipoDocente["idTipoPersonal"],
          "correoPersonal" => $_POST["correoEditar"],
          "nombrePersonal" => $_POST["nombreEditar"],
          "apellidoPersonal" => $_POST["apellidoEditar"],
          "fechaCreacion" => date("Y-m-d\TH:i:sP"),
          "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
          "usuarioCreacion" => $_SESSION["idUsuario"],
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );

        $tabla = "personal";
        // buscamos si existe este personal 
        $personal = ModelPersonal::mdlGetPersonalByIdUsuario($tabla, $_POST["codUsuario"]);

        if ($personal) {
          $response = ModelPersonal::mdlEditarUsuarioPersonal($tabla, $dataPersonal);
        } else {
          $response = ModelPersonal::mdlCrearUsuarioPersonalApartirUsuario($tabla, $dataPersonal);
        }
      }
      $tabla = "usuario";
      $dataUsuario = array(
        "correoUsuario" => $_POST["correoEditar"],
        "nombreUsuario" => $_POST["nombreEditar"],
        "apellidoUsuario" => $_POST["apellidoEditar"],
        "dniUsuario" => $_POST["dniEditar"],
        "idTipoUsuario" => $_POST["tipoEditar"],
        "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
        "usuarioActualizacion" => $_SESSION["idUsuario"],
        "idUsuario" => $_POST["codUsuario"],
      );
      $response = ModelUsuarios::mdlEditarUsuarioPersonal($tabla, $dataUsuario);
      if ($response == "ok") {
        $tabla = "personal";

        switch ($_POST["tipoEditar"]) {
          case 1:
            $idTipoPersonal = 5;
            break;
          case 2:
            $idTipoPersonal = 4;
            break;
          case 3:
            $idTipoPersonal = 6;
            break;
          case 4:
            $idTipoPersonal = 7;
            break;
          case 5:
            $idTipoPersonal = 5;
            break;
          default:
            $idTipoPersonal = 0; // Valor por defecto si $_POST["tipoEditar"] no coincide con ningún caso
        }
        $dataUsuarioPersonal = array(
          "idUsuario" => $_POST["codUsuario"],
          "correoPersonal" => $_POST["correoEditar"],
          "idTipoPersonal" => $idTipoPersonal,
          "nombrePersonal" => $_POST["nombreEditar"],
          "apellidoPersonal" => $_POST["apellidoEditar"],
          "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
          "usuarioActualizacion" => $_SESSION["idUsuario"],
        );
        $actuPersonal = self::ctrActualizarDatosPersonal($tabla, $dataUsuarioPersonal);
        if ($actuPersonal == "ok") {
          $mensaje = ControllerFunciones::mostrarAlerta('success', 'Correcto', 'Usuario editado correctamente', 'usuarios');
          echo $mensaje;
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta('error', 'Error', 'Error al actualizar los datos personales', 'usuarios');
          echo $mensaje;
        }
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta('error', 'Error', 'Error al editar el usuario', 'usuarios');
        echo $mensaje;
      }
    }
  }
  //  Actualizar datos del personal
  public static function ctrActualizarDatosPersonal($tabla, $dataUsuarioPersonal)
  {
    $response = ControllerPersonal::ctrActualizarDatosPersonal($tabla, $dataUsuarioPersonal);
    return $response;
  }
  //  Actualizar datos del usuario
  public static function ctrActualizarDatoUsuario($tabla, $dataUsuario)
  {
    $response = ModelUsuarios::mdlActualizarDatosPersonal($tabla, $dataUsuario);
    return $response;
  }
  //  Actualizar estado del usuario
  public static function ctrActualizarEstado($codUsuario)
  {
    $tabla = "usuario";
    $estadoUsuario = ModelUsuarios::mdlObtenerEstadoUsuario($tabla, $codUsuario);
    if ($estadoUsuario["estadoUsuario"] == "1 ") {
      $nuevoEstado = ModelUsuarios::mdlActualizarEstado($tabla, $codUsuario, "2");
    } else {
      $nuevoEstado = ModelUsuarios::mdlActualizarEstado($tabla, $codUsuario, "1");
    }
    return $nuevoEstado;
  }

  //  Validar si el correo ya existe o no
  public static function ctrValidarCorreo($validarCorreo)
  {
    $tabla = "usuario";
    $response = ModelUsuarios::mdlValidarCorreo($tabla, $validarCorreo);
    return $response;
  }

  public static function ctrEliminarUsuario($codUsuario)
  {
    $verificar = self::ctrVerificarUsuarioBD($codUsuario);
    if ($verificar["existencia"] == true || $verificar["existencia"] == "1") {
      return "error";
    } else {
      $tabla = "usuario";
      $response = ModelUsuarios::mdlEliminarUsuario($tabla, $codUsuario);
      return $response;
    }
  }

  //  Verifica si el usuario está siendo usando en la base de datos. En caso que esté enviará 1 y no 0
  public static function ctrVerificarUsuarioBD($codUsuario)
  {
    $response = ModelUsuarios::mdlVerificarUsuario($codUsuario);
    return $response;
  }

  /**
   * Obtener el tipo de usuario
   * 
   * @param int $idUsuario id del usuario
   * @return string tipo de usuario 
   */
  public static function ctrGetTipoUsuario()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $idUsuario = $_SESSION["idUsuario"];
    $usuario = ControllerUsuarios::ctrGetUsuarioEdit($idUsuario);
    $idTipoUsuario = $usuario["idTipoUsuario"];
    $tabla = "tipo_usuario";
    $response = ModelUsuarios::mdlObtenerTipoUsuario($tabla, $idTipoUsuario);
    return $response;
  }

  /**
   * Dar acceso a la vista actual
   * 
   * @return string script para redireccionar
   */
  public static function ctrTieneAcceso()
  {

    $tipoUsuario = self::ctrGetTipoUsuario();
    $usuario = strtolower($tipoUsuario["descripcionTipoUsuario"]);

    if ($usuario == "administrador") {
      // Dar acceso a todas las URLs
      return;
    } elseif ($usuario == "administrativo") {
      // Dar acceso a URLs específicas para administrativos
      $allowedUrls = array(
        "listaPostulantes",
        "buscarPostulante",
        "listaAdmisionAlumnos",
        "buscarAlumno",
        "listaPagos",
        "listaComunicadoPago",
        "reporteComunicaciones",
        "reportePagos",
        "reporteAdmisiones",

      );
    } elseif ($usuario == "dirección") {
      // Dar acceso a URLs específicas para directivos
      $allowedUrls = array(
        "listaAlumnos",
        "buscarAlumno",
        "buscarAlumno",
        "anioEscolar",
        "reporteAdmisiones",
        "reporteComunicaciones",
        "reportePagos",
        "personal",
        "usuarios",
        "apoderado",
        "cursos",
        "asignarCursos",
        "listaDocentes"
      );
    } elseif ($usuario == "docente") {
      // Dar acceso a URLs específicas para docentes
      $allowedUrls = array(
        "listaAlumnos",
        "cursosDocente",
      );
    } elseif ($usuario == "apoderado") {
      // Dar acceso a URLs específicas para apoderados
      $allowedUrls = array(
        ""
      );
    }


    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $currentUrl = basename($currentPath);
    print_r($allowedUrls);

    if ($currentUrl == "inicio") {
      return;
    }
    if (!in_array($currentUrl, $allowedUrls)) {
      return '<script>
        window.location = "inicio";
      </script>';
    }


  }
  public static function ctrCrearUsuarioApoderadoVista($datos)
  {
    $tabla = "usuario";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $contrasenaUsuarioApoderado = password_hash($datos["contrasenaUsuarioApoderado"], PASSWORD_ARGON2ID, [
      'memory_cost' => 1 << 12,
      'time_cost' => 2,
      'threads' => 2
    ]);

    $dataUsuario = array(
      "correoUsuario" => $datos["correoUsuarioApoderado"],
      "password" => $contrasenaUsuarioApoderado,
      "nombreUsuario" => $datos["nombreUsuarioApoderado"],
      "apellidoUsuario" => $datos["apellidoUsuarioApoderado"],
      "dniUsuario" => $datos["dniUsuarioApoderado"],
      "idTipoUsuario" => $datos["tipoUsuarioApoderado"],
      "estadoUsuario" => "1",
      "fechaCreacion" => date("Y-m-d\TH:i:sP"),
      "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelUsuarios::mdlCrearUsuarioApoderado($tabla, $dataUsuario);
    
    $idApoderado2 = ModelApoderados::mdlObtenerSegundoIdApoderado($datos["codApoderado"]);
    $respuestaCambiodeEstadoUsuarioCreado1= ModelApoderados::mdlCambiarEstadoCuentaCreada($datos["codApoderado"]);
    $respuestaCambiodeEstadoUsuarioCreado2= ModelApoderados::mdlCambiarEstadoCuentaCreada($idApoderado2);
    if($respuestaCambiodeEstadoUsuarioCreado1=="ok" && $respuestaCambiodeEstadoUsuarioCreado2=="ok"){
      $response = "ok";
    }
    return $response;
  }
}
