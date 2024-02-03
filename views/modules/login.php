<body>
  <div class="fondo-login">
    <main>
      <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                  <a href="index.html" class="logo d-flex align-items-center w-auto">
                    <img src="assets/img/logo.png" alt="Logo Colegio Volta" class="imagenLogin">
                  </a>
                </div><!-- End Logo -->

                <div class="card mb-3">

                  <div class="card-body">

                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">Inicio de Sesión</h5>
                    </div>

                    <form class="row g-3 needs-validation" method="post">

                      <div class="col-12">
                        <label for="inputCorreo" class="form-label">Correo Electrónico</label>
                        <div class="input-group has-validation">
                          <span class="input-group-text" id="inputGroupPrepend">@</span>
                          <input type="email" name="inputCorreo" class="form-control" id="inputCorreo" required>
                          <div class="invalid-feedback">¡Ingresa tu correo!</div>
                        </div>
                      </div>

                      <div class="col-12">
                        <label for="inputPassword" class="form-label">Contraseña</label>
                        <input type="password" name="inputPassword" class="form-control" id="inputPassword" required>
                        <div class="invalid-feedback">¡Ingresa tu contraseña!</div>
                      </div>

                      <div class="col-12">
                        <button class="btn btn-success w-100" type="submit">Ingresar</button>
                      </div>
                      <?php
                      $login = new ControllerUsuarios();
                      $login->ctrIniciarSesion();
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
  </div>