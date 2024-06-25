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

<!-- Modal Listar Cursos -->
<div class="modal fade" id="modalNotasAlumnoApoderado" tabindex="-1" aria-labelledby="modalCompetenciaUnidadLabel"
  aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;"> <!-- Ajusta el ancho aquí -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNotasAlumnoApoderadoLabel">Registro de Notas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--  Titulo dataTableNotasPorAlumnoApoderado-->
        <div class="table-responsive">
          <table id="dataTableNotasPorAlumnoApoderado" class="display dataTableNotasPorAlumnoApoderado"
            style="width: 100%">
            <thead>
              <tr>
                <th rowspan="2">CURSOS</th>
                <th rowspan="2">COMPETENCIAS</th>
                <th colspan="2">I BIMESTRE</th>
                <th colspan="2">II BIMESTRE</th>
                <th colspan="2">III BIMESTRE</th>
                <th colspan="2">IV BIMESTRE</th>
              </tr>
              <tr>
                <th>I UNIDAD</th>
                <th>II UNIDAD</th>
                <th>III UNIDAD</th>
                <th>IV UNIDAD</th>
                <th>V UNIDAD</th>
                <th>VI UNIDAD</th>
                <th>VII UNIDAD</th>
                <th>VIII UNIDAD</th>
              </tr>
            </thead>
            <tbody>
              <!--dataTableNotasPorAlumnoApoderado-->
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