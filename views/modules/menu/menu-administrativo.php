<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <!-- INICIO -->
    <li class="nav-item">
      <a class="nav-link" href="inicio">
        <i class="bi bi-grid"></i>
        <span>Inicio</span>
      </a>
    </li>

    <!-- PAGOS -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#allPagos" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person-lines-fill"></i><span>Pagos</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="allPagos" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="todosPagos">
            <i class="bi bi-circle"></i><span>Todos los Pagos</span>
          </a>
        </li>
        <li>
          <a href="buscarAlumno">
            <i class="bi bi-circle"></i><span>Buscar Alumno</span>
          </a>
        </li>
        <li>
          <a href="reportePagos">
            <i class="bi bi-circle"></i><span>Reporte de Pagos</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- ADMISION -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#allAdmision" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Admisión</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="allAdmision" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="listaPostulantes">
            <i class="bi bi-circle"></i><span>Postulaciones</span>
          </a>
        </li>
        <li>
          <a href="docPostulantes">
            <i class="bi bi-circle"></i><span>Documentación</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- ALUMNOS -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#allAlumnos" data-bs-toggle="collapse" href="#">
        <i class="bi bi-buildings"></i><span>Alumnos</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="allAlumnos" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="listaAlumnos">
            <i class="bi bi-circle"></i><span>Todos los Alumnos</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- USUARIOS -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#allUsuarios" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="allUsuarios" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="usuarios">
            <i class="bi bi-circle"></i><span>Todos los Usuarios</span>
          </a>
        </li>
        <li>
          <a href="apoderado">
            <i class="bi bi-circle"></i><span>Todos Los Apoderados</span>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>