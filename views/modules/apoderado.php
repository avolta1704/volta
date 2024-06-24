<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloApoderado"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <!-- <li class="breadcrumb-item"><a href="usuarios">Usuarios</a></li> -->
        <li class="breadcrumb-item active">Todos los Apoderados</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">

      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTableApoderado-->
              <table id="dataTableApoderado" class="display dataTableApoderado" style="width: 100%">
                <thead>
                  <!-- dataTableApoderado -->
                </thead>
                <tbody>
                  <!--dataTableApoderado-->
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<!-- Modal Crear Usuario Apoderado -->
<div class="modal fade" id="agregarUsuarioApoderado" tabindex="-1" role="dialog"
  aria-labelledby="agregarUsuarioApoderado" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Usuario Apoderado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form">
          <!-- Correo Electrónico -->
          <div class="form-group">
            <label for="usuarioCorreoApoderado" class="col-form-label" style="font-weight: bold">Correo Electrónico:</label>
            <input type="email" class="form-control" id="usuarioCorreoApoderado" name="usuarioCorreoApoderado" disabled>
          </div>

          <!-- Nombre -->
          <div class="form-group">
            <label for="nombreUsuarioApoderado" class="col-form-label" style="font-weight: bold">Nombre:</label>
            <input type="text" class="form-control" id="nombreUsuarioApoderado" name="nombreUsuarioApoderado" disabled>
          </div>

          <!-- Apellido -->
          <div class="form-group">
            <label for="apellidoUsuarioApoderado" class="col-form-label" style="font-weight: bold">Apellido:</label>
            <input type="text" class="form-control" id="apellidoUsuarioApoderado" name="apellidoUsuarioApoderado" disabled>
          </div>

          <!-- DNI -->
          <div class="form-group">
            <label for="dniUsuarioApoderado" class="col-form-label" style="font-weight: bold">DNI:</label>
            <input type="text" class="form-control" id="dniUsuarioApoderado" name="dniUsuarioApoderado" disabled>
          </div>

          <!-- Contraseña -->
          <div class="form-group">
            <label for="passwordUsuarioApoderado" class="col-form-label" style="font-weight: bold">Contraseña:</label>
            <input type="password" class="form-control" id="passwordUsuarioApoderado" name="passwordUsuarioApoderado" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnCrearUsuarioApoderadoMdl">Crear Apoderado</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>