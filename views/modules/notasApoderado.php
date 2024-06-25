<?php
$ipConfirmacion = $_SESSION["idUsuario"];
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloNotaAlumno"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Notas </li>
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
          <div class="card py-4">
            <div class="card-header">
            </div>
            <script>
              var ipConfirmacion = "<?php echo $ipConfirmacion; ?>";
            </script>
            <div class="card-body table-responsive">
              <!--  Titulo dataTableNotasAlumnoApoderado-->
              <table id="dataTableNotasAlumnoApoderado" class="display dataTableNotasAlumnoApoderado"
                style="width: 100%">
                <thead>
                  <!-- dataTableNotasAlumnoApoderado -->
                </thead>
                <tbody>
                  <!--dataTableNotasAlumnoApoderado-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>