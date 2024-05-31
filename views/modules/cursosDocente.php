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