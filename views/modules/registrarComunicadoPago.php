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
                        <label class="form-label" style="font-weight: bold">Apellidos: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["apellidosAlumno"] ?>"
                          placeholder="Apellido Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Nombres: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["nombresAlumno"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Codigo: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["codAlumnoCaja"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Dni: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["dniAlumno"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Grado: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["descripcionGrado"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Nivel: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["descripcionNivel"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Estado: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["estadoAlumno"] ?>"
                          placeholder="Nombre Alumno" disabled>
                      </div>

                    </div>
                  </div>

                  <div class="col-md-6">
                    <!-- Aquí van los datos del apoderado -->
                    <h3 style="text-align: center;">Datos del Apoderado</h3><br>
                    <div class="row">

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Apellidos:
                        </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["apellidoApoderado"] ?>"
                          placeholder="Apellido Apoderado" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Nombres: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["nombreApoderado"] ?>"
                          placeholder="Nombre Apoderado" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Tipo Apoderao: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["tipoApoderado"] ?>"
                          placeholder="Padre / Madre" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Telefono: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["numeroApoderado"] ?>"
                          placeholder="Numero Apoderado" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Correo: </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["correoApoderado"] ?>"
                          placeholder="Correo Apoderado" disabled>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" style="font-weight: bold">Convivencia Alumno:
                        </label>
                        <input type="text" class="form-control" value="<?php echo $datosAlumno["convivenciaAlumno"] ?>"
                          placeholder=" Si / No" disabled>
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
                  <?php
                  $codCronograma = $_GET["codAdAlumCronograma"];
                  $datosCronograma = ControllerComunicado::ctrGetCronogramaPagoComunicado($codCronograma);
                  
                  $meses = ['matricula', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                  ?>
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php
                    foreach ($meses as $index => $mes) {
                      $active = $index === 0 ? ' active' : '';
                      echo '<li class="nav-item" role="presentation">';
                      echo '<a class="nav-link' . $active . '" id="' . $mes . '-tab" data-bs-toggle="tab" href="#' . $mes . '" role="tab" aria-controls="' . $mes . '" aria-selected="true">' . ucfirst($mes) . '</a>';
                      echo '</li>';
                    }
                    ?>
                  </ul>
                  <br>
                  <div class="tab-content" id="myTabContent" style="border-bottom: 1px solid #000;">
                    <?php
                    foreach ($meses as $index => $mes) {
                      $active = $index === 0 ? ' show active' : '';
                      echo '<div class="tab-pane fade' . $active . '" id="' . $mes . '" role="tabpanel" aria-labelledby="' . $mes . '-tab">';
                      echo '<div class="row">';
                      if (isset($datosCronograma[$index])) {
                        $idCronogramaPago = '';
                        foreach ($datosCronograma[$index] as $identificador => $valor) {
                          if ($identificador == 'idCronogramaPago') {
                            $idCronogramaPago = $valor;
                            continue;
                          }
                          echo '<div class="col-md-2">';
                          echo '<label class="form-label" style="font-weight: bold">' . ucfirst($identificador) . ': </label>';
                          echo '<input type="text" class="form-control" value="' . $valor . '" placeholder="Apellido Alumno" disabled>';
                          echo '</div>';
                        }
                        echo '<div class="col-md-2" style="margin-top: 31px;">';
                        echo '<button class="btn btn-warning btnCronoCumunicado" data-bs-toggle="modal" data-bs-target="#comunicadoModal" value="' . $idCronogramaPago . '">Registrar Comunicado</button>';
                        echo '</div>';
                      }
                      echo '</div>'; // Cierre del div de la fila
                      echo '<br>';
                      echo '<h3 style=" font-weight: bold; text-align: center;">Informes de Comunicado</h3>';
                      echo '<br>';
                      if (isset($datosCronograma[$index]['comunicado'])) {
                        foreach ($datosCronograma[$index]['comunicado'] as $comunicado) {
                          echo '<div class="mb-3 row">';
                          echo '<h3 style="font-weight: bold; text-align: center; border-top: 1px solid #000; padding-top: 10px;">Comunicado</h3>';
                          echo '<div class="col">';
                          echo '<label for="exampleFormControlInput1" class="form-label">Asunto</label>';
                          echo '<input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Asunto" value="' . $comunicado['tituloComunicacion'] . '">';
                          echo '</div>';
                          echo '<div class="col-md-2">';
                          echo '<label for="exampleFormControlInput2" class="form-label">Fecha</label>';
                          echo '<input type="text" class="form-control" id="exampleFormControlInput2" placeholder="Fecha Comunicado" value="' . $comunicado['fechaComunicacion'] . '">';
                          echo '</div>';
                          echo '<div class="col-auto">';
                          echo '<label class="form-label">&nbsp;</label>';
                          echo '<div>';
                          echo '<button class="btn btn-primary" data-id="' . $comunicado['idComunicacionPago'] . '">Editar</button>';
                          echo '<button class="btn btn-danger" data-id="' . $comunicado['idComunicacionPago'] . '">Borrar</button>';
                          echo '</div>';
                          echo '</div>';
                          echo '<div class="mb-3">';
                          echo '<label for="exampleFormControlTextarea1" class="form-label">Comunicado</label>';
                          echo '<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Contenido del comunicado">' . $comunicado['detalleComunicacion'] . '</textarea>';
                          echo '</div>';
                          echo '</div>'; // Cierre del div de la fila
                        }
                      }
                      echo '</div>'; // Cierre del div de la pestaña
                    }
                    ?>
                    <br>
                  </div>
                  <br>
                </div>
            </div>

      </div>
      </span>

      <div class="container row g-3 p-3 justify-content-between">
        <button type="button"
          class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarRegistroPago">Cerrar</button>

      </div>
      </form>
    </div>
    </div>
  </section>
</main>

<!-- registrar modal comunicado -->
<div class="modal" id="comunicadoModal" tabindex="-1">

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Comunicado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="col-md-4">
          <label for="exampleFormControlInput2" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="exampleFormControlInput2" placeholder="Fecha Comunicado">
        </div>
        <div class="col">
          <label for="exampleFormControlInput1" class="form-label">Asunto</label>
          <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Asunto">
        </div>



        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">Comunicado</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"
            placeholder="Contenido del comunicado"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>