<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloAnio"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item">Seguimiento</li>
        <li class="breadcrumb-item active">Año Lectivo</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary btnAgregarCurso gap-2 justify-content-center d-flex" data-bs-target="#modalAgregarAnio" data-bs-toggle="modal">
            <i class="bi bi-plus-circle"></i> Agregar Año Escolar</button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTable Años lectivos-->
              <table id="dataTableAnios" class="display dataTableAnios " style="width: 100%">
                <thead>
                  <!-- dataTable Años lectivos -->
                </thead>
                <tbody>
                  <!--dataTable Años lectivos-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>