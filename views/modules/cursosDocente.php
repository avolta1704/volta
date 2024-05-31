<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloCursosDocente"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Todos mis cursos</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTableCursosDocenteAdmin-->
              <table id="dataTableCursosDocente" class="display dataTableCursosDocente " style="width: 100%">
                <thead>
                  <!-- dataTableCursosDocenteAdmin -->
                </thead>
                <tbody>
                  <!--dataTableCursosDocenteAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal Listado de alumnos por curso -->

<div class="modal fade" id="modalListadoAlumnosCurso" tabindex="-1" aria-labelledby="modalListadoAlumnosCursoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalListadoAlumnosCursoLabel">Listado de alumnos por curso</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--  Titulo dataTableAlumnosPorCurso-->
        <table id="dataTableListadoAlumnosCurso" class="display dataTableListadoAlumnosCurso " style="width: 100%">
          <thead>
            <!-- dataTableAlumnosPorCurso -->
          </thead>
          <tbody>
            <!--dataTableAlumnosPorCurso-->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal visualizar datos del alumno -->

<div class="modal fade" id="modalVisualizarDatosAlumno" tabindex="-1" aria-labelledby="modalVisualizarDatosAlumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVisualizarDatosAlumnoLabel">Datos del alumno</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="container row g-3">
            <h3 style="font-weight: bold">Datos del Alumno</h3>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nombresAlumnoVisualizar" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombresAlumnoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="apellidosAlumnoVisualizar" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellidosAlumnoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="dniAlumnoVisualizar" class="form-label">DNI</label>
                <input type="text" class="form-control" id="dniAlumnoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="fechaNacimientoVisualizar" class="form-label">Fecha de nacimiento</label>
                <input type="text" class="form-control" id="fechaNacimientoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="direccionAlumnoVisualizar" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccionAlumnoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="telefonoAlumnoVisualizar" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefonoAlumnoVisualizar" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>