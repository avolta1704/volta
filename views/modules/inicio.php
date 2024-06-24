<main id="main" class="main">

  <div class="pagetitle">
    <h1>Inicio</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
      </ol>
    </nav>
  </div>
  <?php
  //  Obtener el tipo de usuario para gestionar el menú
  $tipoUsuario = $_SESSION["tipoUsuario"];
  $ipConfirmacion = $_SESSION["idUsuario"];
  if ($tipoUsuario == 4) {
    $idsAlumnos = $_SESSION["idAlumnos"];
  }





  /**
   * 1 = Administrador
   * 2 = Docente
   * 3 = Administrativo
   * 4 = Apoderado
   * 5 = Directivo
   */

  if ($tipoUsuario == 1) {
    include "inicio/inicio-administrativo.php";
  }
  if ($tipoUsuario == 2) {
    include "inicio/inicio-docente.php";
  }
  if ($tipoUsuario == 3) {
    include "inicio/inicio-administrativo.php";
  }
  if ($tipoUsuario == 4) {
    include "inicio/inicio-apoderado.php";
  }
  if ($tipoUsuario == 5) {
    include "inicio/inicio-directivo.php";
  }
  ?>
  <!-- Datos del usuario para JavaScript -->
  <div id="datos" data-ip-confirmacion="<?= htmlspecialchars($ipConfirmacion); ?>"
    data-tipo-usuario="<?= htmlspecialchars($tipoUsuario); ?>" <?php if ($tipoUsuario == 4 && !empty($idsAlumnos)): ?>
      data-primer-id-alumno="<?= htmlspecialchars($idsAlumnos[0]["idAlumno"]); ?>" <?php endif; ?> style="display: none;">
  </div>


</main>