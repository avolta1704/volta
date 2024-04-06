<main id="main" class="main">


  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>

      <div class="container-fluid">
        <form role="form" method="post" class="row g-3 m-2 formPagoAlumno">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h2 style="font-weight: bold; text-align: center;">Registro Comunicado</h2><br>
              <!--  div para ver el perfil de alumno y apoderados  dividido por la mitad con sus respectivos campos de datos basicos-->
              <div class="container" style="border-bottom: 1px solid #000;">
                <div class="row">

                  <div class="col-md-6" style="border-right: 1px solid #000;">
                    <!-- Aquí van los datos del alumno -->
                    <h3 style="text-align: center;">Datos del Alumno</h3><br>
                    <!-- datos del alumno del pago -->
                    <?php
                    $codAlumno = $_GET["codAlumno"];
                    $datosAlumno = ControllerComunicado::ctrGetDatosAlumnoComunicado($codAlumno);
                    ?>
                    <div class="row">

                      <div class="col-md-4">
                        <label for="apellidoAlumnoPago" class="form-label" style="font-weight: bold">Apellidos: </label>
                        <input type="text" class="form-control" 
                        value="<?php echo $datosAlumno["apellidosAlumno"] ?>" placeholder="Apellido Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreAlumnoPago" class="form-label" style="font-weight: bold">Nombres: </label>
                        <input type="text" class="form-control"  value="<?php echo $datosAlumno["nombresAlumno"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreAlumnoPago" class="form-label" style="font-weight: bold">Codigo: </label>
                        <input type="text" class="form-control"  value="<?php echo $datosAlumno["codAlumnoCaja"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreAlumnoPago" class="form-label" style="font-weight: bold">Dni: </label>
                        <input type="text" class="form-control"  value="<?php echo $datosAlumno["dniAlumno"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreAlumnoPago" class="form-label" style="font-weight: bold">Grado: </label>
                        <input type="text" class="form-control"  value="<?php echo $datosAlumno["descripcionGrado"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreAlumnoPago" class="form-label" style="font-weight: bold">Nivel: </label>
                        <input type="text" class="form-control"  value="<?php echo $datosAlumno["descripcionNivel"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreAlumnoPago" class="form-label" style="font-weight: bold">Estado: </label>
                        <input type="text" class="form-control"  value="<?php echo $datosAlumno["estadoAlumno"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                    </div>
                  </div>

                  <div class="col-md-6">
                    <!-- Aquí van los datos del apoderado -->
                    <h3 style="text-align: center;">Datos del Apoderado</h3><br>
                    <div class="row">

                      <div class="col-md-4">
                        <label for="apellidoApoderadoPago" class="form-label" style="font-weight: bold">Apellidos:
                        </label>
                        <input type="text" class="form-control" 
                        value="<?php echo $datosAlumno["apellidoApoderado"] ?>" placeholder="Apellido Apoderado" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreApoderadoPago" class="form-label" style="font-weight: bold">Nombres: </label>
                        <input type="text" class="form-control" 
                        value="<?php echo $datosAlumno["nombreApoderado"] ?>" placeholder="Nombre Apoderado" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreApoderadoPago" class="form-label" style="font-weight: bold">Tipo Apoderao: </label>
                        <input type="text" class="form-control" 
                        value="<?php echo $datosAlumno["tipoApoderado"] ?>" placeholder="Padre / Madre" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreApoderadoPago" class="form-label" style="font-weight: bold">Telefono: </label>
                        <input type="text" class="form-control" 
                        value="<?php echo $datosAlumno["numeroApoderado"] ?>" placeholder="Numero Apoderado" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreApoderadoPago" class="form-label" style="font-weight: bold">Correo: </label>
                        <input type="text" class="form-control" 
                        value="<?php echo $datosAlumno["correoApoderado"] ?>" placeholder="Correo Apoderado" disabled>
                      </div>

                      <div class="col-md-4">
                        <label for="nombreApoderadoPago" class="form-label" style="font-weight: bold">Convivencia Alumno:
                        </label>
                        <input type="text" class="form-control" 
                        value="<?php echo $datosAlumno["convivenciaAlumno"] ?>" placeholder=" Si / No" disabled>
                      </div>


                      <!-- Agrega los campos de datos del apoderado aquí -->
                    </div>
                  </div>
                </div>
                <br>
              </div>
            </div>



            <div style="display: flex; justify-content: center;">
              <div class="container" style="margin-top: 20px;">
                <!-- cronograma de pagos alumno -->
                <?php
                $codCronograma = $_GET["codAdAlumCronograma"];
                $datosCronograma = ControllerComunicado::ctrGetCronogramaPagoComunicado($codCronograma);
                ?>
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="matricula-tab" data-bs-toggle="tab" href="#matricula" role="tab"
                      aria-controls="matricula" aria-selected="true">Matricula</a>
                  </li>

                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="marzo-tab" data-bs-toggle="tab" href="#marzo" role="tab"
                      aria-controls="marzo" aria-selected="true">Marzo</a>
                  </li>

                  <li class="nav-item" role="presentation">
                    <a class="nav-link " id="abril-tab" data-bs-toggle="tab" href="#abril" role="tab"
                      aria-controls="abril" aria-selected="true">Abril</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link " id="mayo-tab" data-bs-toggle="tab" href="#mayo" role="tab" aria-controls="mayo"
                      aria-selected="true">Mayo</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link " id="junio-tab" data-bs-toggle="tab" href="#junio" role="tab"
                      aria-controls="junio" aria-selected="true">Junio</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link " id="julio-tab" data-bs-toggle="tab" href="#julio" role="tab"
                      aria-controls="julio" aria-selected="true">Julio</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link " id="agosto-tab" data-bs-toggle="tab" href="#agosto" role="tab"
                      aria-controls="agosto" aria-selected="true">Agosto</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link " id="septiembre-tab" data-bs-toggle="tab" href="#septiembre" role="tab"
                      aria-controls="septiembre" aria-selected="true">Septiembre</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link " id="octubre-tab" data-bs-toggle="tab" href="#octubre" role="tab"
                      aria-controls="octubre" aria-selected="true">Octubre</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link " id="noviembre-tab" data-bs-toggle="tab" href="#noviembre" role="tab"
                      aria-controls="noviembre" aria-selected="true">Noviembre</a>
                  </li>

                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="diciembre-tab" data-bs-toggle="tab" href="#diciembre" role="tab"
                      aria-controls="diciembre" aria-selected="false">Diciembre</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                  <div class="tab-pane fade show active" id="matricula" role="tabpanel" aria-labelledby="matricula-tab">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">First</th>
                          <th scope="col">Last</th>
                          <th scope="col">Handle</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Mark</td>
                          <td>Otto</td>
                          <td>@mdo</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="tab-pane fade" id="marzo" role="tabpanel" aria-labelledby="marzo-tab">
                    <table class="table">
                   
                  </div>
                  <div class="tab-pane fade  " id="abril" role="tabpanel" aria-labelledby="abril-tab">
                    <table class="table">
                     
                    </table>
                  </div>
                  <div class="tab-pane fade  " id="mayo" role="tabpanel" aria-labelledby="mayo-tab">
                    <!-- Contenido de la pestaña Marzo -->
                  </div>
                  <div class="tab-pane fade  " id="junio" role="tabpanel" aria-labelledby="junio-tab">
                    <!-- Contenido de la pestaña Marzo -->
                  </div>
                  <div class="tab-pane fade  " id="julio" role="tabpanel" aria-labelledby="julio-tab">
                    <!-- Contenido de la pestaña Marzo -->
                  </div>
                  <div class="tab-pane fade  " id="agosto" role="tabpanel" aria-labelledby="agosto-tab">
                    <!-- Contenido de la pestaña Marzo -->
                  </div>
                  <div class="tab-pane fade  " id="septiembre" role="tabpanel" aria-labelledby="septiembre-tab">
                    <!-- Contenido de la pestaña Marzo -->
                  </div>
                  <div class="tab-pane fade  " id="octubre" role="tabpanel" aria-labelledby="octubre-tab">
                    <!-- Contenido de la pestaña Marzo -->
                  </div>
                  <div class="tab-pane fade  " id="noviembre" role="tabpanel" aria-labelledby="noviembre-tab">
                    <!-- Contenido de la pestaña Marzo -->
                  </div>

                  <div class="tab-pane fade" id="diciembre" role="tabpanel" aria-labelledby="diciembre-tab">
                    <!-- Contenido de la pestaña Diciembre -->
                  </div>
                </div>
              </div>
            </div>


      </div>
      </span>

      <div class="container row g-3 p-3 justify-content-between">
        <button type="button"
          class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarRegistroPago">Cerrar</button>
        <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary ">Registrar Pago</button>
      </div>
      </form>
    </div>
    </div>
  </section>
</main>
