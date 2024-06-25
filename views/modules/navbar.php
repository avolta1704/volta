<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="inicio" class="d-flex align-items-center imageNavBar">
        <img class="move-right" src="assets/img/logo.png" alt="Logo Colegio Volta">
      </a>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!-- <button type="button" class="btn btn-warning btnModeDarck" id="btnModeDarck">Cambiar Tema</button> -->
        <span style="margin: 0 10px;"></span>

        <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">

      </li>
      <!-- varaibles para la solicitud de datos -->
      <?php
      $idTipoUsuario = $_SESSION["tipoUsuario"];
      $idUsuario = $_SESSION["idUsuario"];
      if ($idTipoUsuario == 4) {
        $idsAlumnos = $_SESSION["idAlumnos"];
      }

      ?>
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="assets/img/usuario.png" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2">
            <?php echo $_SESSION["nombreCompleto"]; ?>
          </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6><?php echo $_SESSION["nombreCompleto"]; ?></h6>
            <span><?php echo FunctionPerfil::getTipoPerfilUsuario($idTipoUsuario); ?> </span>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="perfil">
              <i class="bi bi-person"></i>
              <span>Mi Perfil</span>
            </a>
          </li>
          <!-- Inicio de inserción de opciones basadas en $idsAlumnos -->
          <?php if ($idTipoUsuario == 4 && !empty($idsAlumnos)): ?>
            
            <?php foreach ($idsAlumnos as &$idAlumno): ?>
              <?php
              // Obtener el nombre completo del alumno
              $nombreCompletoAlumno = ModelUsuarios::mdlObtenerNombreCompletoAlumno("alumno", $idAlumno["idAlumno"]);
              ?>
              <li>
                <a class="dropdown-item d-flex align-items-center alumno-item"
                  data-id-alumno="<?php echo $idAlumno["idAlumno"]; ?>">
                  <i class="bi bi-person-video2"></i>
                  <span><?php echo $nombreCompletoAlumno["nombre_completo"]; ?></span>
                </a>
              </li>
            <?php endforeach; ?>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>
          </ul>
        </li>
        <!-- varaibles para la solicitud de datos -->
        <?php
        $idTipoUsuario = $_SESSION["tipoUsuario"];
        $idUsuario = $_SESSION["idUsuario"];

        ?>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/usuario.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">
              <?php echo $_SESSION["nombreCompleto"]; ?>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION["nombreCompleto"]; ?></h6>
              <span><?php echo FunctionPerfil::getTipoPerfilUsuario($idTipoUsuario); ?> </span>
            </li>
          <?php endif; ?>
          <!-- Fin de inserción de opciones -->
          <li>
            <a class="dropdown-item d-flex align-items-center" href="cerrarSesion">
              <i class="bi bi-box-arrow-right"></i>
              <span>Cerrar Sesion</span>
            </a>
          </li>
        </ul>
      </li>

    </ul>
  </nav>


</header>