<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <!-- INICIO -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="inicio">
        <i class="bi bi-grid"></i>
        <span>Inicio</span>
      </a>
    </li>

    <!-- ALUMNOS -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#allAlumnos" data-bs-toggle="collapse" href="#">
        <i class="bi bi-people-fill"></i><span>Alumnos</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="allAlumnos" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="listaAlumnosDocentes">
            <i class="bi bi-circle"></i><span>Mis alumnos</span>
          </a>
        </li>
        <li>
          <a href="asistencia">
            <i class="bi bi-circle"></i><span>Asistencia</span>
          </a>
        </li>
        <li>
          <a href="notas">
            <i class="bi bi-circle"></i><span>Notas</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- CURSOS -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#allCursos" data-bs-toggle="collapse" href="#">
        <i class="bi bi-book"></i><span>Mis Cursos</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="allCursos" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="cursosDocente">
            <i class="bi bi-circle"></i><span>Todos mis cursos</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- REPORTES -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#allReportes" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Reportes</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="allReportes" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="reporteNotas">
            <i class="bi bi-circle"></i><span>Reporte de Notas</span>
          </a>
        </li>
        <li>
          <a href="reporteAsistencias">
            <i class="bi bi-circle"></i><span>Reporte de Asistencia</span>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>