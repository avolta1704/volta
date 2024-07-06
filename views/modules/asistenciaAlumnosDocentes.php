<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloAsistenciaAlumnosDocente"></h2>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active" id="idNavegacionNombreAsistencia">Asistencia</li>
      </ol>
    </nav>
  </div>

  <?php
  $listaIdentificadores = ControllerDocentes::ctrGetIdentificadoresDocente($_SESSION["idUsuario"]);
  $listaIdentificadores = json_encode($listaIdentificadores);
  $tipoDocente = $_SESSION["tipoDocente"];
  $labelText = ($tipoDocente == 1 || $tipoDocente == 2) ? "Grado:" : "Curso:";
  ?>
  <section class="section dashboard">
    <div class="row" id="alumnosAsistenciaContainer">
      <div class="col-12">
        <div class="row">
          <!-- Sección de filtros -->
          <div class="col-8">
            <div class="card">
              <!-- Header de la tarjeta con margen inferior para espacio -->
              <div class="card-header" style="margin-bottom: 8px;">
                Filtros
              </div>
              <!-- Body de la tarjeta con padding reducido -->
              <div class="card-body" style="padding: 10px;">
                <div class="d-flex flex-column" style="align-items: center; gap: 11px;">
                  <div class="mb-2" style="width: 100%;">
                    <form>
                      <label style="margin-bottom: 5px;"
                        id="labelAlumnoAsistenciaDocenteCursoGrado"><?php echo $labelText; ?></label>
                      <input type="text" id="labelCursoGradoAsistencia" readonly
                        style="border: 1px solid #ced4da; padding: 0.375rem 0.5rem; border-radius: 0.25rem; pointer-events: none; user-select: none; width: 100%; appearance: none; -webkit-appearance: none; -moz-appearance: none; font-size: 0.845rem;">
                    </form>
                  </div>
                </div>
                <div class="d-flex flex-column" style="align-items: center; gap: 11px;">
                  <div class="mb-2" style="width: 100%;"> <!-- Reducción del margen aquí -->
                    <label for="selectMes" style="margin-bottom: 5px;">Meses:</label>
                    <!-- Añadir margen inferior aquí -->
                    <select id="selectMesDocenteAsistencia" class="form-select form-select-sm"
                      style="width: 100%;margin-bottom: 5px;">
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
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Leyenda de códigos de asistencia -->
          <div class="col-4">
            <div class="card">
              <div class="card-header" style="margin-bottom: 17px;">
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

      <div class="col-lg-12">
        <!-- Sección de la tabla -->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header" style="margin-bottom: 25px;">
              Registro de Asistencia
            </div>
            <div class="card-body table-responsive">
              <!-- Contenedor de la tabla de asistencia -->
              <div id="asistenciaAlumnoDocenteContainer" data-tipo-docente='<?php echo $tipoDocente ?>'
                data-identificadores='<?php echo $listaIdentificadores ?>'></div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="row gap-3" id="tablaCursosDocenteAsistencia">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <table id='dataTableAsistenciaAlumnosDocente' class='display dataTableAlumnosDocente'
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