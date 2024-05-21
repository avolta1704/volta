<main id="main" class="main">

  <div class="pagetitle">
    <h1>Editar Alumno</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Editar Alumno</li>
      </ol>
    </nav>
    <?php
    $codAlumno = $_GET["codAlumnoEditar"];
    $datosAlumno = ControllerAlumnos::ctrGetDatosAlumnoEditar($codAlumno);
    ?>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>

      <div class="container-fluid">
        <form role="form" method="post" class="row g-3 m-2">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Personal</h3>

              <div class="form-group col-md-6">
                <label for="editarNombreAlumno" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="editarNombreAlumno" name="editarNombreAlumno" value="<?php echo $datosAlumno["nombresAlumno"] ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="editarApellidoAlumno" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="editarApellidoAlumno" name="editarApellidoAlumno" value="<?php echo $datosAlumno["apellidosAlumno"] ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="editarCodigoCaja" class="form-label" style="font-weight: bold">Código Caja Arequipa: </label>
                <input type="text" class="form-control" id="editarCodigoCaja" name="editarCodigoCaja" value="<?php echo $datosAlumno["codAlumnoCaja"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarDniAlumno" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="editarDniAlumno" name="editarDniAlumno" value="<?php echo $datosAlumno["dniAlumno"] ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechaNacimiento" class="form-label" style="font-weight: bold">Fecha Nacimiento: </label>
                <input type="date" class="form-control" id="editarFechaNacimiento" name="editarFechaNacimiento" value="<?php echo $datosAlumno["fechaNacimiento"] ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="editarSexoAlumno" class="col-form-label">Sexo:</label>
                <select class="form-control" name="editarSexoAlumno" id="editarSexoAlumno">
                  <option value="<?php echo $datosAlumno["sexoAlumno"] ?>"><?php echo $datosAlumno["sexoAlumno"] ?></option>
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDireccionAlumno" class="form-label" style="font-weight: bold">Dirección: </label>
                <input type="text" class="form-control" id="editarDireccionAlumno" name="editarDireccionAlumno" value="<?php echo $datosAlumno["direccionAlumno"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarDistritoAlumno" class="form-label" style="font-weight: bold">Distrito: </label>
                <input type="text" class="form-control" id="editarDistritoAlumno" name="editarDistritoAlumno" value="<?php echo $datosAlumno["distritoAlumno"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarIEPProcedencia" class="form-label" style="font-weight: bold">IEP Procedencia: </label>
                <input type="text" class="form-control" id="editarIEPProcedencia" name="editarIEPProcedencia" value="<?php echo $datosAlumno["IEPProcedencia"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarSeguroSalud" class="form-label" style="font-weight: bold">Seguro Salud: </label>
                <input type="text" class="form-control" id="editarSeguroSalud" name="editarSeguroSalud" value="<?php echo $datosAlumno["seguroSalud"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechaIngreso" class="form-label" style="font-weight: bold">Fecha de Ingreso: </label>
                <input type="date" class="form-control" id="editarFechaIngreso" name="editarFechaIngreso" value="<?php echo $datosAlumno["fechaIngresoVolta"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarNumeroEmergencia" class="form-label" style="font-weight: bold">Número Emergencia: </label>
                <input type="text" class="form-control" id="editarNumeroEmergencia" name="editarNumeroEmergencia" value="<?php echo $datosAlumno["numeroEmergencia"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarEnfermedades" class="form-label" style="font-weight: bold">Enfermedades: </label>
                <input type="text" class="form-control" id="editarEnfermedades" name="editarEnfermedades" value="<?php echo $datosAlumno["enfermedades"] ?>">
              </div>
            </div>
          </span>

          <div class="container row g-3 p-3 justify-content-between">
            <input type="hidden" class="codAlumno" name="codAlumno" id="codAlumno" value="<?php echo $codAlumno ?>">
            <?php
              if(isset($GET["tipo"])){
                echo '<button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarEditarAlumnoAdmision">Cerrar</button>';
              } else {
                echo '<button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarEditarAlumno">Cerrar</button>';
              }
            ?>
            <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary ">Editar Alumno</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
$editarAlumno = new ControllerAlumnos();
$editarAlumno->ctrEditarAlumno();
?>