<?php
$ipConfirmacion = $_SESSION["idUsuario"];
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloNotaAlumnoDocente"></h2><br>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active" id="idNavegacionNotasAlumnosDocentes">Notas</li>
      </ol>
    </nav>
  </div>
  <?php
  $listaIdentificadores = ControllerDocentes::ctrGetIdentificadoresDocente($_SESSION["idUsuario"]);
  $listaIdentificadores = json_encode($listaIdentificadores);
  $tipoDocente = $_SESSION["tipoDocente"];
  ?>
  <section class="section dashboard">
    <div class="row gap-3" id="tablaNotasAlumnosDocentes">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <div id="datosAlumno" class="mt-2 mb-2">
                <h5 class="text-start mt-4 mb-4"><strong>Datos del Curso</strong></h5>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="idAlumnoInput" class="form-label"><strong>ID Curso:</strong></label>
                      <input type="text" id="idAlumnoInput" class="form-control" readonly
                        style="width: calc(100% - 100px);">
                    </div>
                    <div class="mb-3">
                      <label for="nombreAlumnoInput" class="form-label"><strong>Curso:</strong></label>
                      <input type="text" id="nombreAlumnoInput" class="form-control" readonly
                        style="width: calc(100% - 100px);">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="nivelAlumnoInput" class="form-label"><strong>Nivel:</strong></label>
                      <input type="text" id="nivelAlumnoInput" class="form-control" readonly
                        style="width: calc(100% - 100px);">
                    </div>
                    <div class="mb-3">
                      <label for="gradoAlumnoInput" class="form-label"><strong>Grado:</strong></label>
                      <input type="text" id="gradoAlumnoInput" class="form-control" readonly
                        style="width: calc(100% - 100px);">
                    </div>
                  </div>
                </div>
              </div>
              <hr style="border: 0; height: 2px; background: #ddd; margin: 2px 0;">
              <!-- Tabla de notas -->
              <div class="table-responsive">
                <table id="dataTableNotasAlumnosDocentes" class="display dataTableNotasAlumnosDocentes"
                  style="width: 100%">
                  <thead>
                    <!-- dataTableNotasAlumnosDocentes -->
                  </thead>
                  <tbody>
                    <!-- dataTableNotasAlumnosDocentes -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row gap-3" id="tablaCursosDocenteNotas">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <table id='dataTableCursosNotasAlumnosDocente' class='display dataTableCursosNotasAlumnosDocente'
                data-tipo-docente='<?php echo $tipoDocente ?>'
                data-identificadores='<?php echo $listaIdentificadores ?>' style="width: 100%">
                <thead>
                  <!-- dataTableAsistenciaAlumnosDocente -->
                </thead>
                <tbody>
                  <!--dataTableAsistenciaAlumnosDocente-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>