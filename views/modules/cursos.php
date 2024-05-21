<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloCursos"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Todos los Cursos</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary btnAgregarCurso gap-2 justify-content-center d-flex" id="btnAgregarCurso">
            <i class="bi bi-plus-circle"></i> Agregar
            Nuevo Curso
          </button>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-warning btnAgregarCurso d-flex justify-content-center gap-2" id="btnAgregarCurso">
            <i class="bi bi-bookmarks"></i>
            Mostrar áreas
          </button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTableCursosAdmin-->
              <table id="dataTableCursos" class="display dataTableCursos" style="width: 100%">
                <thead>
                  <!-- dataTableCursosAdmin -->
                </thead>
                <tbody>
                  <!--dataTableCursosAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>