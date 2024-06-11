<?php
$idCurso = $_GET["idCurso"];
$idGrado = $_GET["idGrado"];
$idPersonal = $_GET["idPersonal"];

$nombreCurso = ControllerCursos::ctrGetCurso($idCurso)["descripcionCurso"];
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4">Asistencia de los Alumnos para el curso <?php echo $nombreCurso ?> | <?php echo date("d-m-Y") ?></h2>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="cursosDocente">Cursos Asignados</a></li>
        <li class="breadcrumb-item active">Todos los Alumnos</li>
      </ol>
    </nav>
  </div>
  <!-- Botones para tomar asistencia, descargar template y subir excel asistencia -->
  <div class="row gap-3 mb-2">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex gap-4">
            <button type="button" class="btn btn-primary gap-2 d-flex" id="btnTomarAsistencia" data-bs-toggle="modal" data-bs-target="#modalTomarAsistencia" idCurso="<?php echo $idCurso ?>" idGrado="<?php echo $idGrado ?>" idPersonal="<?php echo $idPersonal ?>"> <i class="bi bi-clipboard-check-fill"></i>Tomar Asistencia</button>
            <button type="button" class="btn btn-warning d-flex gap-2" data-bs-toggle="modal" data-bs-target="#modalSubirExcelAsistencia" idCurso="<?php echo $idCurso ?>" idGrado="<?php echo $idGrado ?>" idPersonal="<?php echo $idPersonal ?>"><i class="bi bi-file-earmark-arrow-up-fill"></i>Subir Excel</button>
            <button type="button" class="btn btn-success d-flex gap-2" id="btnDescargarTemplateAsistencia" idCurso="<?php echo $idCurso ?>" idGrado="<?php echo $idGrado ?>" idPersonal="<?php echo $idPersonal ?>"> <i class="bi bi-file-earmark-arrow-down-fill"></i>Descargar Template</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTableCursosDocenteAdmin-->
              <table id="dataTableAsistenciaAlumnos" class="display dataTableAsistenciaAlumnos " style="width: 100%">
                <thead>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>

<!-- Modal para tomar asistencia -->
<div class="modal fade" id="modalTomarAsistencia" tabindex="-1" aria-labelledby="modalTomarAsistenciaLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTomarAsistenciaLabel">Tomar Asistencia</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body
      ">
        <div class="row gap-3">
          <div class="col-lg-12">
            <div class="row">
              <div class="card">
                <div class="card-body table-responsive">
                  <!--  Titulo dataTableCursosDocenteAdmin-->
                  <table id="dataTableTomarAsistencia" class="display dataTableTomarAsistencia " style="width: 100%">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex gap-4">
              <button type="button" class="btn btn-primary" id="btnGuardarAsistencia" idCurso="<?php echo $idCurso ?>" idGrado="<?php echo $idGrado ?>" idPersonal="<?php echo $idPersonal ?>">Guardar Asistencia</button>
              <button type="button" class="btn btn-secondary" id="btnCancelarAsistencia" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal para subir ahi un archivo, y un mensaje para dar aviso sobre la data que debe tener tu excel -->
<div class="modal fade" id="modalSubirExcelAsistencia" tabindex="-1" aria-labelledby="modalSubirExcelAsistenciaLabel" aria-hidden="true" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSubirExcelAsistenciaLabel">Subir Excel de Asistencia</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row gap-3">
          <div class="col-lg-12">
            <div class="row">
              <div class="card">
                <div class="card-body">
                  <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">¡Atención!</h4>
                    <p>La asistencia debe tener el siguiente formato</p>
                    <ul>
                      <li>A : ASISTIÓ</li>
                      <li>F : FALTÓ </li>
                      <li>T : INASISTENCIA INJUSTIFICADA </li>
                      <li>J : FALTA JUSTIFICADA </li>
                      <li>U : TARDANZA JUSTIFICADA </li>
                    </ul>
                    <hr>
                  </div>
                  <div class="alert alert-success" role="alert">Descarga el template para subir la asistencia de los alumnos.</div>
                  <div class="alert alert-info" role="alert">Dejar en blanco los días que no se registrarán o ya están registrados en el sistema.</div>
                  <div>
                    <div class="mb-3">
                      <label for="formFile" class="form-label fw-bold">Seleccione el archivo de asistencia</label>
                      <input class="form-control" type="file" id="excelAsistencia" accept=".xlsx,.xls" required>
                    </div>
                  </div>
                  <div class="d-flex gap-4">
                    <button type="button" class="btn btn-primary" id="btnSubirExcelAsistencia">Subir Excel</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>