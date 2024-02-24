<main id="main" class="main">

  <div class="pagetitle">
    <h1>Todos los Alumnos</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="listaAlumnos">Alumnos</a></li>
        <li class="breadcrumb-item active">Todos los Alumnos</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary btnAgregarNuevoAlumno" id="btnAgregarNuevoAlumno">Admisión Extraordinaria</button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Todos los Alumno</h5>

              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Nivel</th>
                    <th scope="col">Grado</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $listAlumnos = ControllerAlumnos::ctrGetAlumnos();
                  foreach ($listAlumnos as $key => $value) {
                    $estado = ControllerFunciones::getEstadosAlumnos($value["estadoAlumno"]);
                    $botones = ControllerFunciones::getBotonesAlumnos ($value["idAlumno"], $value["estadoAlumno"]);
                    echo '
                    <tr>
                      <th scope="row">' . ($key + 1) . '</th>
                      <td>' . ($value["nombresAlumno"]) . '</td>
                      <td>' . ($value["apellidosAlumno"]) . '</td>
                      <td>' . ($value["sexoAlumno"]) . '</td>
                      <td>' . $estado . '</td>
                      <td>' . ($value["descripcionGrado"]) . '</td>
                      <td>' . ($value["descripcionNivel"]) . '</td>
                      <td>
                        ' . $botones . '
                      </td>
                    </tr>
                    ';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>