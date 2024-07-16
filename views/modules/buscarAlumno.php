<?php
$aniosEscolar = ControllerAnioEscolar::ctrGetTodosAniosEscolar();
?>
<main id="main" class="main" style="display: flex; justify-content: center; align-items: center;">
  <section class="section dashboard">
    <div class="row">
      <div class="container-fluid w-100">
        <form role="form" method="post" class="row g-3 m-2 formBusquedaAlumno"
          style="display: flex; justify-content: center; align-items: center;">
          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h2 style="font-weight: bold; text-align: center;">Buscar Alumno</h2><br>
            </div>
            <div class="container">
              <h3>Datos de Búsqueda</h3>

              <!-- Fila para el nuevo select de año escolar -->
              <div class="row g-3">
                <div class="form-group col-md-4">
                  <label for="selectAnioEscolarAlumnoBusqueda" class="form-label" style="font-weight: bold">Año
                    Escolar</label>
                  <select class="form-control input-lg busqueda" id="selectAnioEscolarAlumnoBusqueda"
                    aria-label="Seleccionar año escolar">
                    <?php
                    foreach ($aniosEscolar as $anio) {
                      $anioActivo = $anio["estadoAnio"] == 1 ? 'selected' : '';
                      echo "<option value='" . $anio['idAnioEscolar'] . "' " . $anioActivo . " >" . $anio['descripcionAnio'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <!-- Espacio entre las filas -->
              <br>

              <!-- Fila para los otros tres selects -->
              <div class="row g-3">
                <div class="form-group col-md-4">
                  <label for="apellAlBusq" class="form-label" style="font-weight: bold">Apellidos Alumno</label>
                  <select class="form-control input-lg busqueda" id="apellAlBusq" name="apellAlBusq">
                    <!-- Las opciones se llenarán dinámicamente con JavaScript -->
                  </select>
                </div>

                <div class="form-group col-md-4">
                  <label for="nivAlBusq" class="form-label" style="font-weight: bold">Nivel Alumno</label>
                  <select class="form-control input-lg busqueda" id="nivAlBusq" name="nivAlBusq">
                    <!-- Las opciones se llenarán dinámicamente con JavaScript -->
                  </select>
                </div>

                <div class="form-group col-md-4">
                  <label for="gradAlBusq" class="form-label" style="font-weight: bold">Grado Alumno</label>
                  <select class="form-control input-lg busqueda" id="gradAlBusq" name="gradAlBusq">
                    <!-- Las opciones se llenarán dinámicamente con JavaScript -->
                  </select>
                </div>
              </div>
            </div>

            <div class="container row g-3 justify-content-center align-items-center">
              <h3 class="mt-5">Búsqueda</h3>
              <div class="container row g-3">
                <div class="col-md-4">
                  <label for="nombreBusqueda" class="form-label" style="font-weight: bold">Nombre</label>
                  <input type="text" class="form-control" id="nombreBusqueda" name="nombreBusqueda" readonly>
                </div>
                <div class="col-md-4">
                  <label for="apellidoBusqueda" class="form-label" style="font-weight: bold">Apellido</label>
                  <input type="text" class="form-control" id="apellidoBusqueda" name="apellidoBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="dniBusqueda" class="form-label" style="font-weight: bold">DNI</label>
                  <input type="text" class="form-control" id="dniBusqueda" name="dniBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="CodCajaBusqueda" class="form-label" style="font-weight: bold">Código Caja</label>
                  <input type="text" class="form-control" id="CodCajaBusqueda" name="CodCajaBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="gradoBusqueda" class="form-label" style="font-weight: bold">Grado</label>
                  <input type="text" class="form-control" id="gradoBusqueda" name="gradoBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="nivelBusqueda" class="form-label" style="font-weight: bold">Nivel</label>
                  <input type="text" class="form-control" id="nivelBusqueda" name="nivelBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="generoBusqueda" class="form-label" style="font-weight: bold">Género</label>
                  <input type="text" class="form-control" id="generoBusqueda" name="generoBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="nacimientoBusqueda" class="form-label" style="font-weight: bold">Fecha Nacimiento</label>
                  <input type="date" class="form-control" id="nacimientoBusqueda" name="nacimientoBusqueda" readonly>
                </div>
                <div class="col-md-1">
                  <label for="nacimientoBusqueda" class="form-label" style="font-weight: bold">Edad</label>
                  <input type="text" class="form-control" id="edadBusqueda" name="edadBusqueda" readonly>
                </div>
                <div class="col-md-3">
                  <label for="seguroBusqueda" class="form-label" style="font-weight: bold">Seguro Salud</label>
                  <input type="text" class="form-control" id="seguroBusqueda" name="seguroBusqueda" readonly>
                </div>
                <div class="col-md-4">
                  <label for="enfermedadBusqueda" class="form-label" style="font-weight: bold">Enfermedades</label>
                  <input type="text" class="form-control" id="enfermedadBusqueda" name="enfermedadBusqueda" readonly>
                </div>
                <div class="col-md-4">
                  <label for="ieProceBusqueda" class="form-label" style="font-weight: bold">IEE de Procedencia</label>
                  <input type="text" class="form-control" id="ieProceBusqueda" name="ieProceBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="estadoAlBusqueda" class="form-label" style="font-weight: bold">Estado</label>
                  <input type="text" class="form-control" id="estadoAlBusquedaNA" name="estadoAlBusquedaNA" readonly>
                </div>
                <div class="col-md-2">
                  <label for="ingVoltaBusqueda" class="form-label" style="font-weight: bold">Fecha de Ingreso</label>
                  <input type="date" class="form-control" id="ingVoltaBusqueda" name="ingVoltaBusqueda" readonly>
                </div>
                <div class="col-md-4">
                  <label for="direccionBusqueda" class="form-label" style="font-weight: bold">Dirección</label>
                  <input type="text" class="form-control" id="direccionBusqueda" name="direccionBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="distritoBusqueda" class="form-label" style="font-weight: bold">Distrito</label>
                  <input type="text" class="form-control" id="distritoBusqueda" name="distritoBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="numeroEmergBusqueda" class="form-label" style="font-weight: bold">Número de
                    Emergencia</label>
                  <input type="text" class="form-control" id="numeroEmergBusqueda" name="numeroEmergBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="siagieBusqueda" class="form-label" style="font-weight: bold">Estado Siagie</label>
                  <input type="text" class="form-control" id="siagieBusqueda" name="siagieBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="estadoAlBusqueda" class="form-label" style="font-weight: bold">Estado Matrícula</label>
                  <input type="text" class="form-control" id="estadoAlBusqueda" name="estadoAlBusqueda" readonly>
                </div>
                <div class="col-md-4">
                  <label for="apoderado1Busqueda" class="form-label" style="font-weight: bold">Apoderado 1</label>
                  <input type="text" class="form-control" id="apoderado1Busqueda" name="apoderado1Busqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="dni1ApoBusqueda" class="form-label" style="font-weight: bold">DNI Apoderado 1</label>
                  <input type="text" class="form-control" id="dni1ApoBusqueda" name="numero1ApoBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="numero1ApoBusqueda" class="form-label" style="font-weight: bold">Número Celular 1</label>
                  <input type="text" class="form-control" id="numero1ApoBusqueda" name="numero1ApoBusqueda" readonly>
                </div>
                <div class="col-md-1">
                  <label for="convive1Busqueda" class="form-label" style="font-weight: bold">Convive</label>
                  <input type="text" class="form-control" id="convive1Busqueda" name="conviveBusqueda" readonly>
                </div>
                <div class="col-md-3">
                  <label for="emailApoBusqueda" class="form-label" style="font-weight: bold">Email Apoderado 1</label>
                  <input type="text" class="form-control" id="email1ApoBusqueda" name="emailApoBusqueda" readonly>
                </div>
                <div class="col-md-4">
                  <label for="apoderado2Busqueda" class="form-label" style="font-weight: bold">Apoderado 2</label>
                  <input type="text" class="form-control" id="apoderado2Busqueda" name="apoderado2Busqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="dni2ApoBusqueda" class="form-label" style="font-weight: bold">DNI Apoderado 2</label>
                  <input type="text" class="form-control" id="dni2ApoBusqueda" name="numero1ApoBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="numero2ApoBusqueda" class="form-label" style="font-weight: bold">Número Celular 2</label>
                  <input type="text" class="form-control" id="numero2ApoBusqueda" name="numero2ApoBusqueda" readonly>
                </div>
                <div class="col-md-1">
                  <label for="convive2ApoBusqueda" class="form-label" style="font-weight: bold">Convive</label>
                  <input type="text" class="form-control" id="convive2ApoBusqueda" name="conviveBusqueda" readonly>
                </div>
                <div class="col-md-3">
                  <label for="email2ApoBusqueda" class="form-label" style="font-weight: bold">Email Apoderado 2</label>
                  <input type="text" class="form-control" id="email2ApoBusqueda" name="emailApoBusqueda" readonly>
                </div>
                <div class="col-md-2">
                  <label for="montoPagoMatriculaL" class="form-label" style="font-weight: bold">Monto Matrícula</label>
                  <input type="text" class="form-control" id="montoPagoMatricula" name="montoPagoMatricula" readonly>
                </div>
                <div class="col-md-2">
                  <label for="numeroComprobanteMatriculaL" class="form-label" style="font-weight: bold">Recibo
                    Matrícula</label>
                  <input type="text" class="form-control" id="numeroComprobanteMatricula"
                    name="numeroComprobanteMatricula" readonly>
                </div>
                <div class="col-md-2">
                  <label for="montoPagoCuotaL" class="form-label" style="font-weight: bold">Cuota de Ingreso</label>
                  <input type="text" class="form-control" id="cuotaBusqueda" name="montoPagoCuota" readonly>
                </div>
                <div class="col-md-2">
                  <label for="numeroComprobanteCuotaL" class="form-label" style="font-weight: bold">Recibo C.
                    Ingreso</label>
                  <input type="text" class="form-control" id="comprobanteCuotaBusqueda" name="numeroComprobanteCuota"
                    readonly>
                </div>
                <div class="col-md-2">
                  <label for="montoPagoPensionL" class="form-label" style="font-weight: bold">Monto Pensión</label>
                  <input type="text" class="form-control" id="pensionBusqueda" name="montoPagoPension" readonly>
                </div>
              </div>
            </div>

            <div class="container row g-3 justify-content-center align-items-center">
              <h3 class="mt-5">Estado de Pagos</h3>
              <div class="container" id="contenedorPrincipalDiv">
                <!-- Aquí se agregará el contenedor adicional -->
                <div id="contenedorPrincipal"></div> <br>
              </div>
            </div>

            <div class="container row g-3 justify-content-center align-items-center">
              <h3 class="mt-5">Cronograma Pagos y Comunicados</h3><br>
              <div class="container" id="comunicadosCronograma">

                <!-- pestaña para los comunicados y cronograma de pago -->
                <ul class="nav nav-tabs" id="myTabComunicadosCronograma" role="tablist">
                  <!-- Agrega más elementos de lista aquí para los otros meses -->
                </ul>


                <div class="tab-content" id="myTabContentComunicadosCronogramaContenido">
                  <div class="tab-pane fade show active" id="matricula" role="tabpanel" aria-labelledby="matricula-tab">
                    <br>
                    <!-- Contenido de la pestaña Matricula -->
                  </div>
                </div>
              </div>
            </div>
          </span>
          <div class="container row g-3 p-3 justify-content-between">

          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<!-- modal detalle Pago -->
<div class="modal modalDetallePagoBuscar" id="modalDetallePagoBuscar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Aquí van tus campos de entrada -->
        <label for="nombresDetalle">Nombres:</label>
        <input type="text" class="form-control mb-3" id="nombresDetalleBuscar" name="nombresDetalle" disabled>

        <label for="apellidosDetalle">Apellidos: </label>
        <input type="text" class="form-control mb-3" id="apellidosDetalleBuscar" name="apellidosDetalle" disabled>

        <label for="gradoDetalle">Grado:</label>
        <input type="text" class="form-control mb-3" id="gradoDetalleBuscar" name="gradoDetalle" disabled>

        <label for="nivelDertalle">Nivel:</label>
        <input type="text" class="form-control mb-3" id="nivelDertalleBuscar" name="nivelDertalle" disabled>

        <label for="codigoCajaDetalle">Codigo:</label>
        <input type="text" class="form-control mb-3" id="codigoCajaDetalleBuscar" name="codigoCajaDetalle" disabled>

        <label for="mesDetalle">Mes:</label>
        <input type="text" class="form-control mb-3" id="mesDetalleBuscar" name="mesDetalle" disabled>

        <label for="LimitePagoDetalle">Fecha Limite Pago:</label>
        <input type="text" class="form-control mb-3" id="LimitePagoDetalleBuscar" name="LimitePagoDetalle" disabled>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>