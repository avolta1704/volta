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
  $tipoUsuario = $_SESSION["tipoUsuario"];

  /**
   * 1 = Administrador
   * 2 = Docente
   * 3 = Administrativo
   * 4 = Apoderado
   * 5 = Directivo
   */

  if ($tipoUsuario == 1) {
    include "menu/menu-administrador.php";
  }
  if ($tipoUsuario == 2) {
    include "modules/dashboard/dashboard-administrativo.php";
  }
  if ($tipoUsuario == 3) {
    include "menu/menu-administrativo.php";
  }
  if ($tipoUsuario == 4) {
    include "menu/menu-apoderado.php";
  }
  if ($tipoUsuario == 5) {
    include "menu/menu-direccion.php";
  }

  ?>
</main>