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
            <div class="container row g-3 justify-content-center align-items-center">
              <h3>Datos de Busqueda</h3>
              <!-- datos para filtrar datos de busqueda -->
              <div class="form-group col-md-4">
                <label for="apellAlBusq" class="form-label" style="font-weight: bold"> Apellidos Alumno </label>
                <select class="form-control input-lg busqueda" id="apellAlBusq" name="apellAlBusq">
                  <!-- Las opciones se llenarán dinámicamente con JavaScript -->
                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="nivAlBusq" class="form-label" style="font-weight: bold">Nivel Alumno</label>
                <select class="form-control input-lg busqueda" id="nivAlBusq" name="nivAlBusq">

                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="gradAlBusq" class="form-label" style="font-weight: bold">Grado Alumno</label>
                <select class="form-control input-lg busqueda" id="gradAlBusq" name="gradAlBusq">

                </select>
              </div>
            </div><br>
            <!--resultado de la busqueda -->
            <h3>Búsqueda</h3>
            <div class="container row g-3">
              <div class="col-md-4">
                <label for="nombreBusqueda" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombreBusqueda" name="nombreBusqueda" readonly>
              </div>
              <div class="col-md-4">
                <label for="apellidoBusqueda" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellidoBusqueda" name="apellidoBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="dniBusqueda" class="form-label">Dni</label>
                <input type="text" class="form-control" id="dniBusqueda" name="dniBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="CodCajaBusqueda" class="form-label">Codigo Caja</label>
                <input type="text" class="form-control" id="CodCajaBusqueda" name="CodCajaBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="gradoBusqueda" class="form-label">Grado</label>
                <input type="text" class="form-control" id="gradoBusqueda" name="gradoBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="nivelBusqueda" class="form-label">Nivel</label>
                <input type="text" class="form-control" id="nivelBusqueda" name="nivelBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="generoBusqueda" class="form-label">Genero</label>
                <input type="text" class="form-control" id="generoBusqueda" name="generoBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="nacimientoBusqueda" class="form-label">Fecha Nacimiento</label>
                <input type="date" class="form-control" id="nacimientoBusqueda" name="nacimientoBusqueda" readonly>
              </div>
              <div class="col-md-4">
                <label for="seguroBusqueda" class="form-label">Seguro Salud</label>
                <input type="text" class="form-control" id="seguroBusqueda" name="seguroBusqueda" readonly>
              </div>
              <div class="col-md-4">
                <label for="enfermedadBusqueda" class="form-label">Enfermedades</label>
                <input type="text" class="form-control" id="enfermedadBusqueda" name="enfermedadBusqueda" readonly>
              </div>
              <div class="col-md-4">
                <label for="ieProceBusqueda" class="form-label">IEE de Procedencia</label>
                <input type="text" class="form-control" id="ieProceBusqueda" name="ieProceBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="estadoAlBusqueda" class="form-label">Estado Alumno</label>
                <input type="text" class="form-control" id="estadoAlBusqueda" name="estadoAlBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="ingVoltaBusqueda" class="form-label">Ingreso a Volta</label>
                <input type="date" class="form-control" id="ingVoltaBusqueda" name="ingVoltaBusqueda" readonly>
              </div>
              <div class="col-md-4">
                <label for="direccionBusqueda" class="form-label">Direccion</label>
                <input type="text" class="form-control" id="direccionBusqueda" name="direccionBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="distritoBusqueda" class="form-label">Distrito</label>
                <input type="text" class="form-control" id="distritoBusqueda" name="distritoBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="numeroEmergBusqueda" class="form-label">Numero de Emergencia</label>
                <input type="text" class="form-control" id="numeroEmergBusqueda" name="numeroEmergBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="siagieBusqueda" class="form-label">Estado Siagie</label>
                <input type="text" class="form-control" id="siagieBusqueda" name="siagieBusqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="matriculaBusqueda" class="form-label">Estado Matricula</label>
                <input type="text" class="form-control" id="matriculaBusqueda" name="matriculaBusqueda" readonly>
              </div>
              <div class="col-md-4">
                <label for="apoderado1Busqueda" class="form-label">Apoderado</label>
                <input type="text" class="form-control" id="apoderado1Busqueda" name="apoderado1Busqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="numero1ApoBusqueda" class="form-label">Numero Celular 1</label>
                <input type="text" class="form-control" id="numero1ApoBusqueda" name="numero1ApoBusqueda" readonly>
              </div>
              <div class="col-md-4">
                <label for="apoderado2Busqueda" class="form-label">Apoderado</label>
                <input type="text" class="form-control" id="apoderado2Busqueda" name="apoderado2Busqueda" readonly>
              </div>
              <div class="col-md-2">
                <label for="numero2ApoBusqueda" class="form-label">Numero Celular 2</label>
                <input type="text" class="form-control" id="numero2ApoBusqueda" name="numero2ApoBusqueda" readonly>
              </div>
            </div><br>

            <h3 >Cronograma Pagos y Comunicados</h3><br>
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

          </span>
          <div class="container row g-3 p-3 justify-content-between">
      
          </div>
        </form>
      </div>
    </div>
  </section>
</main>