<?php
$ipConfirmacion = $_SESSION["idUsuario"];
$alumnos = ModelNotas::mdlObtenerAlumnosApoderado("usuario", $ipConfirmacion);
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h2 class="mt-4">Asistencia Alumno</h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Asistencia </li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-8">
        <div class="row">
          <!-- Sección de filtros -->
          <div class="col-12">
            <div class="card">
              <!-- Header de la tarjeta con margen inferior para espacio -->
              <div class="card-header" style="margin-bottom: 8px;">
                Filtros
              </div>
              <!-- Body de la tarjeta con padding reducido -->
              <div class="card-body" style="padding: 10px;">
                <div class="d-flex flex-column" style="align-items: center; gap: 11px;">
                  <div class="mb-2" style="width: 100%;">
                    <label for="selectAlumno">Alumno:</label>
                    <select id="selectAlumno" class="form-select form-select-sm" style="width: 100%;">
                      <option value="0">Ninguna Opción</option>
                      <?php foreach ($alumnos as $alumno): ?>
                        <option value="<?php echo $alumno['idAlumno']; ?>">
                          <?php echo $alumno['nombre_completo']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mb-2" style="width: 100%;"> <!-- Reducción del margen aquí -->
                    <label for="selectMes">Meses:</label>
                    <select id="selectMes" class="form-select form-select-sm" style="width: 100%;">
                      <option value="1">Ninguna Opción</option>
                      <option value="3">Marzo</option>
                      <option value="4">Abril</option>
                      <option value="5">Mayo</option>
                      <option value="6">Junio</option>
                      <option value="7">Julio</option>
                      <option value="8">Agosto</option>
                      <option value="9">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                      <option value="13">Total Anual</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Leyenda de códigos de asistencia -->
          <div class="col-12">
            <div class="card">
              <div class="card-header" style="margin-bottom: 8px;">
                Leyenda de Asistencia
              </div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li><strong style="color: green;">A:</strong> ASISTIÓ</li>
                  <li><strong style="color: red;">F:</strong> FALTÓ</li>
                  <li><strong style="color: orange;">T:</strong> INASISTENCIA INJUSTIFICADA</li>
                  <li><strong style="color: blue;">J:</strong> FALTA JUSTIFICADA</li>
                  <li><strong style="color: purple;">U:</strong> TARDANZA JUSTIFICADA</li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-4">
        <div class="">
          <!-- Revenue Card -->
          <div class="col-xxl-12 col-xl-8">

            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Asistencia <span class="filtro-seleccionado-asistencia-mes"></span></h5>

                <canvas id="asistenciaApoderadoChart" style="max-width: 400px; max-height: 375px;"></canvas>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-12">
        <!-- Sección de la tabla -->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header" style="margin-bottom: 25px;">
              Registro de Asistencia
            </div>
            <div class="card-body table-responsive">
              <!-- Contenedor de la tabla de asistencia -->
              <div id="asistenciaContainer"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<script>
  var ipConfirmacion = "<?php echo $ipConfirmacion; ?>";
</script>