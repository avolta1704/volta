<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloCursosDocente"></h2>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active" id="idNavegacionNombreCursos">Todos mis Alumnos</li>
      </ol>
    </nav>
  </div>

  <?php
  $listaIdentificadores = ControllerDocentes::ctrGetIdentificadoresDocente($_SESSION["idUsuario"]);
  $listaIdentificadores = json_encode($listaIdentificadores);
  $tipoDocente = $_SESSION["tipoDocente"];
  ?>
  <section class="section dashboard">
    <div class="row gap-3">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
              <div class="card-body">
                <table id='dataTableAlumnosDocente' class='display dataTableAlumnosDocente'
                  data-tipo-docente='<?php echo $tipoDocente ?>'
                  data-identificadores='<?php echo $listaIdentificadores ?>' style="width: 100%">
                  <thead>
                    <!-- datatTableAlumnosDocente -->
                  </thead>
                  <tbody>
                    <!--datatTableAlumnosDocente-->
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>