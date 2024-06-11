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
            <div class="card-body table-responsive">
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
      <div class="modal-body table-responsive">
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
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="container row g-3">
            <h3 style="font-weight: bold">Datos del Alumno</h3>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nombresAlumnoVisualizar" class="form-label" style="font-weight:bold" style="font-weight:bold">Nombres</label>
                <input type="text" class="form-control" id="nombresAlumnoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="apellidosAlumnoVisualizar" class="form-label" style="font-weight:bold">Apellido</label>
                <input type="text" class="form-control" id="apellidosAlumnoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="dniAlumnoVisualizar" class="form-label" style="font-weight:bold">DNI</label>
                <input type="text" class="form-control" id="dniAlumnoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="fechaNacimientoVisualizar" class="form-label" style="font-weight:bold">Fecha de nacimiento</label>
                <input type="text" class="form-control" id="fechaNacimientoVisualizar" readonly>
              </div>
              <div class="col-md-6">
                <label for="sexoAlumno" class="form-label" style="font-weight:bold">Dirección</label>
                <input type="text" class="form-control" id="sexoAlumno" readonly>
              </div>
              <div class="col-md-6">
                <label for="telefonoEmergencia" class="form-label" style="font-weight:bold">Teléfono</label>
                <input type="text" class="form-control" id="telefonoEmergencia" readonly>
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

<!-- Modal visualizar cronograma del alumno -->
<div class="modal fade" id="cronogramaAdmisionPago" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cronogramaAdmisionPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 770px;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="cronogramaAdmisionPagoLabel" style="padding-left: 150px; font-weight: bold;">
          Cronograma Pagos Alumno</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Genera 11 inputs para cada registro de Cronograma pago de estudiante -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>