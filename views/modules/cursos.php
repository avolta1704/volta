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
          <button type="button" class="btn btn-primary btnAgregarCurso gap-2 justify-content-center d-flex" data-bs-target="#modalAgregarCurso" data-bs-toggle="modal">
            <i class="bi bi-plus-circle"></i> Agregar
            Nuevo Curso
          </button>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-warning  d-flex justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAreas">
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
              <table id="dataTableCursos" class="display dataTableCursos " style="width: 100%">
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

<?php
$areas = new ControllerAreas();
$todasLasAreas = $areas->ctrGetAllAreas();
?>

<!-- Modal crear curso -->
<div class="modal fade" id="modalAgregarCurso" tabindex="-1" aria-labelledby="modalAgregarCursoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarCursoLabel">Agregar Nuevo Curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formRegistrarCurso">
          <div class="mb-3">
            <label for="descripcionCurso" class="form-label">Descripción del Curso</label>
            <input type="text" class="form-control" id="descripcionCurso" name="descripcionCurso" required />
          </div>
          <div class="mb-3">
            <label for="areaCurso" class="form-label">Área del Curso</label>
            <select class="form-select" id="areaCurso" name="areaCurso" required>
              <option value="" selected>Seleccione una opción</option>
              <?php
              foreach ($todasLasAreas as $area) {
                echo "<option value='" . $area['idArea'] . "'>" . $area['descripcionArea'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnRegistrarCursoModal" id="btnRegistrarCursoModal" name="btnRegistrarCursoModal" btnRegistrarCursoModal=" ">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal todas las áreas -->
<div class="modal fade" id="modalAreas" tabindex="-1" aria-labelledby="modalAreasLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAreasLabel">Listado de las Áreas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="row p-2">
        <div class="col-lg-6 ml-2">
          <div class="row">
            <button type="button" class="btn btn-primary btnAgregarArea gap-2 justify-content-center d-flex" data-bs-toggle="modal" data-bs-target="#modalAgregarArea">
              <i class="bi bi-plus-circle"></i> Agregar
              Nueva Área
            </button>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <!--  Titulo dataTableCursosAdmin-->
        <table id="dataTableAreas" class="display dataTableAreas" style="width: 100%">
          <thead>
            <!-- dataTableCursosAdmin -->
          </thead>
          <tbody>
            <!--dataTableCursosAdmin-->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Area -->
<div class="modal fade" id="modalAgregarArea" tabindex="-1" aria-labelledby="modalAgregarAreaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarAreaLabel">Agregar Nueva Área</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formRegistrarArea">
          <div class="mb-3">
            <label for="descripcionArea" class="form-label">Descripción del Área</label>
            <input type="text" class="form-control" id="descripcionArea" name="descripcionArea" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnRegistrarAreaModal" id="btnRegistrarAreaModal" name="btnRegistrarAreaModal" btnRegistrarAreaModal=" ">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Area -->
<div class="modal fade" id="modalEditarArea" tabindex="-1" aria-labelledby="modalEditarAreaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarAreaLabel">Editar Área</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarArea">
          <div class="mb-3">
            <label for="descripcionArea" class="form-label
            ">Descripción del Área</label>
            <input type="text" class="form-control d-none" id="idAreaEditar" name="idAreaEditar">
            <input type="text" class="form-control" id="descripcionAreaEditar" name="descripcionAreaEditar" required descripcionArea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnEditarAreaModal" id="btnEditarAreaModal" name="btnEditarAreaModal" btnEditarAreaModal=" ">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>