<?php
$ipConfirmacion = $_SESSION["idUsuario"];
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloNotaAlumnoDocente"></h2><br>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Notas </li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">
        <div class="card py-4">
          <script>
            var ipConfirmacion = "<?php echo $ipConfirmacion; ?>";
          </script>
          <div class="card-body table-responsive">
            <!-- Contenedor para los datos del alumno -->
            <div id="datosAlumno" style="margin-bottom: 15px;">
              <div class="row">
                <div class="col-md-6">
                  <p style="margin: 0;"><strong>ID Curso:</strong> <span id="idAlumno"></span></p>
                  <p style="margin: 0;"><strong>Curso:</strong> <span id="nombreAlumno"></span></p>
                </div>
                <div class="col-md-6">
                  <p style="margin: 0;"><strong>Nivel:</strong> <span id="nivelAlumno"></span></p>
                  <p style="margin: 0;"><strong>Grado:</strong> <span id="gradoAlumno"></span></p>
                </div>
              </div>
            </div>
            <hr style="border: 0; height: 2px; background: #ddd; margin: 15px 0;">
            <!-- Tabla de notas -->
            <div class="table-responsive">
              <table id="dataTableNotasPorAlumnoApoderado" class="display dataTableNotasPorAlumnoApoderado"
                style="width: 100%">
                <thead>
                  <!-- dataTableNotasPorAlumnoApoderado -->
                </thead>
                <tbody>
                  <!-- dataTableNotasPorAlumnoApoderado -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>