<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloCursosDocente"></h2>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Todos mis Alumnos</li>
      </ol>
    </nav>
  </div>

  <?php
  $listaIdentificadores = ControllerDocentes::ctrGetIdentificadoresDocente($_SESSION["idUsuario"]);
  $listaIdentificadores = json_encode($listaIdentificadores);
  ?>
  <section class="section dashboard">
    <div class="row gap-3">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <script>
              var tipoDocente = "<?php echo $tipoDocente; ?>";
            </script>
            <?php
            $tipoDocente = $_SESSION['tipoDocente']; // O cualquier otra fuente de donde obtengas $tipoDocente
            // Mostrar dataTableAlumnosDocente si tipoDocente es 1 o 2
            if ($tipoDocente == 1 || $tipoDocente == 2) {
              ?>
              <div class="card-body">
                <table id='dataTableAlumnosDocente' class='display dataTableAlumnosDocente'
                  data-tipo-docente='<?php echo $tipoDocente ?>'
                  data-identificadores='<?php echo $listaIdentificadores ?>' style="width: 100%">
                  <thead>
                    <!-- datatTableAlumnosDocente -->
                  </thead>
                  <tbody>
                    <!--datatTableAlumnosDocente-->
                  </tbody>
                </table>
              </div>
              <?php
            } elseif ($tipoDocente == 3 || $tipoDocente == 4) { // Mostrar dataTableCursosDocente si tipoDocente es 3 o 4
              ?>
              <div class="card-body">
                <table id="dataTableCursosDocente" class="display dataTableCursosDocente " style="width: 100%">
                  <thead>
                    <!-- dataTableCursosDocenteAdmin -->
                  </thead>
                  <tbody>
                    <!--dataTableCursosDocenteAdmin-->
                  </tbody>
                </table>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>