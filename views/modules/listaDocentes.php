<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloDocentes"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <!-- <li class="breadcrumb-item"><a href="usuarios">Usuarios</a></li> -->
        <li class="breadcrumb-item active">Todos los Docentes</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarUsuario">Agregar
            Docente</button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTableDocentes-->
              <table id="dataTableDocentes" class="display dataTableDocentes" style="width: 100%">
                <thead>
                  <!-- dataTableDocentes -->
                </thead>
                <tbody>
                  <!--dataTableDocentes-->
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<!-- Modal Cursos -->
<div class="modal fade" id="seleccionarCursosAsignados" data-bs-keyboard="false" tabindex="-1" aria-labelledby="seleccionarCursosAsignadosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 650px;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="seleccionarCursosAsignadosLabel">Selecciona el Grado y Curso a Asignar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="selectGrado" class="form-label">Selecciona el Grado:</label>
                    <select class="form-select" id="selectGrado" data-placeholder="Elegir grado">
                        <option value="">Selecciona un grado...</option>
                        <?php
                        $listaPostulantes = ControllerDocentes::ctrGetCursoGrado();
                        $listaDocentes = ControllerDocentes::ctrGetAllDocentes();
                        
                        foreach ($listaDocentes as $docente) {
                            foreach ($listaPostulantes as $postulante) {
                                if ($docente["descripcionTipo"] === "Docente Inicial" && $postulante["descripcionNivel"] === "Inicial") {
                                    echo "<option value='" . $postulante["descripcionGrado"] . "' data-nivel='Inicial'>" . $postulante["descripcionGrado"] . "</option>";
                                } elseif ($docente["descripcionTipo"] === "Docente Primaria" && $postulante["descripcionNivel"] === "Primaria") {
                                    echo "<option value='" . $postulante["descripcionGrado"] . "' data-nivel='Primaria'>" . $postulante["descripcionGrado"] . "</option>";
                                } elseif ($docente["descripcionTipo"] === "Docente Secundaria" && $postulante["descripcionNivel"] === "Secundaria") {
                                    echo "<option value='" . $postulante["descripcionGrado"] . "' data-nivel='Secundaria'>" . $postulante["descripcionGrado"] . "</option>";
                                } elseif ($docente["descripcionTipo"] === "Docente General" && ($postulante["descripcionNivel"] === "Primaria" || $postulante["descripcionNivel"] === "Secundaria")) {
                                    echo "<option value='" . $postulante["descripcionGrado"] . "' data-nivel='" . $postulante["descripcionNivel"] . "'>" . $postulante["descripcionGrado"] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3" id="selectCursoContainer" style="display: none;">
                    <label for="selectCurso" class="form-label">Selecciona el Curso:</label>
                    <select class="form-select" id="selectCurso" data-placeholder="Elegir curso">
                        <option value="">Selecciona un curso...</option>
                        <?php
                        $listaCursos = ControllerDocentes::ctrGetCurso();
                        foreach ($listaCursos as $curso) {
                            echo "<option value='" . $curso["descripcionCurso"] . "' data-grado='" . $curso["descripcionGrado"] . "' style='display:none;'>" . $curso["descripcionCurso"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary d-flex gap-2" id="btnAsignarCurso"><i class="bi bi-file-earmark-excel"></i> Asignar Curso</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('selectGrado').addEventListener('change', function() {
        var gradoSeleccionado = this.value;
        var selectCursoContainer = document.getElementById('selectCursoContainer');
        var gradoNivel = this.options[this.selectedIndex].getAttribute('data-nivel');
        var selectCurso = document.getElementById('selectCurso');
        
        // Limpiar la selección del segundo select si no se ha seleccionado un grado
        if (gradoSeleccionado === '') {
            selectCursoContainer.style.display = 'none';
            selectCurso.value = '';
            return;
        }

        // Mostrar el segundo select solo para Docente Secundaria y Docente General
        var tipoDocente = "<?php echo $listaDocentes[0]['descripcionTipo']; ?>";
        if (tipoDocente === "Docente Secundaria" || tipoDocente === "Docente General") {
            selectCursoContainer.style.display = '';
        } else {
            selectCursoContainer.style.display = 'none';
            selectCurso.value = '';
        }

        // Mostrar solo los cursos que corresponden al grado seleccionado
        for (var i = 0; i < selectCurso.options.length; i++) {
            var option = selectCurso.options[i];
            if (option.getAttribute('data-grado') === gradoSeleccionado) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    });
</script>
</div>