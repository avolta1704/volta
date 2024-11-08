<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloDocentes"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <!-- <li class="breadcrumb-item"><a href="usuarios">Usuarios</a></li> -->
        <li class="breadcrumb-item active">Todos los Docentes</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTableDocentes-->
              <table id="dataTableDocentes" class="display dataTableDocentes" style="width: 100%">
                <thead>
                  <!-- dataTableDocentes -->
                </thead>
                <tbody>
                  <!--dataTableDocentes-->
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal Cursos -->
<div class="modal fade" id="seleccionarCursosAsignados" data-bs-keyboard="false" tabindex="-1" aria-labelledby="seleccionarCursosAsignadosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 650px;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="seleccionarCursosAsignadosLabel">Selecciona el Grado y Curso a Asignar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="">
                <div class="mb-3 selectGrado" id="selectGrado">
                    
                </div>
                <div class="mb-3 selectCurso" id="selectCurso">
                    
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="codPersonal" id="codPersonal" name="codPersonal">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary d-flex gap-2" id="btnAsignarCurso"><i class="bi bi-book"></i> Asignar Curso</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Listar Cursos -->
<div class="modal fade" id="modalListarCursosDocente" tabindex="-1" aria-labelledby="modalListarCursosDocenteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalListarCursosDocenteLabel">Listado de Cursos Asignados al Docente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-lg-4">
          <div class="row mb-2">
          </div>
        </div>

        <!--  Titulo dataTableCursosPorGradoAdmin-->
        <div class="table-responsive">
          <table id="dataTableCursosPorGradoPersonal" class="display dataTableCursosPorGradoPersonal" style="width: 95%">
            <thead>
              <!-- dataTableCursosPorGradoAdmin -->
            </thead>
            <tbody>
              <!--dataTableCursosPorGradoAdmin-->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

</div>