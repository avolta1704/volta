<main id="main" class="main">
  <?php
  $todoslosAlumnosporGrado = ModelInicio::mdlObtenertodoslosAlumnosporGrandos();
  $grados = [];
  $alumnos = [];

  foreach ($todoslosAlumnosporGrado as $fila) {
    $grados[] = $fila['descripcionGrado'];
    $alumnos[] = $fila['Alumnos'];
  }
  // Convertir arrays a formato JSON para usarlos en JavaScript
  $gradosJson = json_encode($grados);
  $alumnosJson = json_encode($alumnos);
  $pensionesPendientes = ModelInicio::mdlObtenertodaslasPensionesPendientes();
  $meses = [];
  $pagosPorMes = [];
  $porcentajePorMes = []; // Array para almacenar los porcentajes
  $totalPensiones = 0; // Variable para almacenar el total de pensiones
  
  foreach ($pensionesPendientes as $fila) {
    $mes = $fila['mesPago'];
    $meses[] = $mes;
    $pagosPorMes[$mes][] = $fila['pagos_vencidos'];
    // Calcular el porcentaje de pensiones vencidas para este mes y almacenarlo en el array
    $porcentaje = $fila['porcentaje_vencidas'];
    $porcentajePorMes[$mes] = $porcentaje;
    // Sumar al total de pensiones
    $totalPensiones = $fila['total_pensiones'];
  }

  // Convertir arrays a formato JSON para usarlos en JavaScript
  $mesesJson = json_encode(array_unique($meses));
  $pagosPorMesJson = json_encode($pagosPorMes);
  $porcentajePorMesJson = json_encode($porcentajePorMes);
  $totalPensionesJson = json_encode($totalPensiones);

  $todoslosAlumnosporAnio = ModelInicio::mdlObtenerTodoslosAlumnosporAnio();
  // Creación de arrays y llenado
  $descripcionesAnio = [];
  $estadosAnio = [];
  $totalesAlumnos = [];

  foreach ($todoslosAlumnosporAnio as $fila) {
    $descripcionesAnio[] = $fila['descripcionAnio'];
    $estadosAnio[] = $fila['estadoAnio'];
    $totalesAlumnos[] = $fila['total_alumno'];
  }

  // Conversión a JSON
  $descripcionesAnioJson = json_encode($descripcionesAnio);
  $estadosAnioJson = json_encode($estadosAnio);
  $totalesAlumnosJson = json_encode($totalesAlumnos);

  ?>

  <div class="pagetitle">
    <h1>Inicio</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtrar por</h6>
                  </li>
                  <?php foreach (array_unique($meses) as $mes): ?>
                    <li><a class="dropdown-item" href="#" onclick="filtrarPagos('<?php echo $mes; ?>')"><?php echo $mes; ?></a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Pagos Vencidos <span id="filtroSeleccionado"></span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-x"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="totalPagosVencidos">0</h6>
                    <span class="text-success small pt-1 fw-bold" id="porcentajeVencidas">12%</span>
                    <span class="text-muted small pt-2 ps-1">de <?php echo $totalPensionesJson; ?></span>
                  </div>
                </div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    const pagosPorMes = <?php echo $pagosPorMesJson; ?>;
                    const porcentajePorMes = <?php echo $porcentajePorMesJson; ?>;
                    const meses = <?php echo $mesesJson; ?>;

                    // Función para actualizar el total de pagos vencidos y porcentaje de pensiones vencidas
                    window.updatePagosVencidos = function (mes) {
                      const totalPagosVencidos = pagosPorMes[mes].reduce((sum, current) => sum + current, 0);
                      const porcentajeVencidas = Math.round(parseFloat(porcentajePorMes[mes]) * 100) / 100;

                      document.getElementById('filtroSeleccionado').textContent = "| " + mes;
                      document.getElementById('totalPagosVencidos').textContent = totalPagosVencidos;
                      document.getElementById('porcentajeVencidas').textContent = porcentajeVencidas + '%';
                    }

                    // Inicializar con el primer mes
                    if (meses.length > 0) {
                      updatePagosVencidos(meses[0]);
                    }
                  });

                  // Para el primer card
                  function filtrarPagos(mes) {
                    updatePagosVencidos(mes);
                  }
                </script>
              </div>
            </div>
          </div>

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>
                  <?php foreach ($descripcionesAnio as $descripcion): ?>
                    <li><a class="dropdown-item" href="#"
                        onclick="filtrarAlumnos('<?php echo $descripcion; ?>')"><?php echo $descripcion; ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Alumnos <span class="filtro-seleccionado">|
                    <?php echo $descripcionesAnio[0]; ?></span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-up"></i>
                  </div>
                  <div class="ps-3">
                    <h6 class="total-alumnos"><?php echo number_format($totalesAlumnos[0]); ?></h6>
                  </div>
                </div>
              </div>

              <script>
                // JavaScript para actualizar el título y el total de alumnos
                document.addEventListener("DOMContentLoaded", () => {
                  const descripcionesAnio = <?php echo json_encode($descripcionesAnio); ?>;
                  const totalesAlumnos = <?php echo json_encode($totalesAlumnos); ?>;

                  // Función para actualizar el título y el total de alumnos
                  window.actualizarDatos = function (indice) {
                    const filtroSeleccionado = document.querySelector('.filtro-seleccionado');
                    const totalAlumnos = document.querySelector('.total-alumnos');

                    filtroSeleccionado.textContent = "| " + descripcionesAnio[indice];
                    totalAlumnos.textContent = totalesAlumnos[indice].toLocaleString() + " Matriculados"; // Formatear como número
                  }

                  // Inicializar con el primer conjunto de datos
                  actualizarDatos(0);
                });

                // Función para filtrar por año
                function filtrarAlumnos(descripcionAnio) {
                  const descripcionesAnio = <?php echo json_encode($descripcionesAnio); ?>;
                  const indice = descripcionesAnio.indexOf(descripcionAnio);
                  if (indice !== -1) {
                    actualizarDatos(indice);
                  }
                }
              </script>

            </div>
          </div>

          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoy</a></li>
                  <li><a class="dropdown-item" href="#">Este Mes</a></li>
                  <li><a class="dropdown-item" href="#">Este Año</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Noticias <span>| Hoy</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>1244</h6>
                    <span class="text-danger small pt-1 fw-bold">12%</span> <span
                      class="text-muted small pt-2 ps-1">decrease</span>

                  </div>
                </div>

              </div>
            </div>

          </div>

          <!-- Reports -->
          <div class="col-12">
            <div class="card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoy</a></li>
                  <li><a class="dropdown-item" href="#">Este Mes</a></li>
                  <li><a class="dropdown-item" href="#">Este Año</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Alumnos <span>/Grado</span></h5>

                <!-- Line Chart -->
                <div id="reportsChart"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    // Datos obtenidos desde PHP
                    const grados = <?php echo $gradosJson; ?>;
                    const alumnos = <?php echo $alumnosJson; ?>;

                    new ApexCharts(document.querySelector("#reportsChart"), {
                      series: [{
                        name: 'Alumnos',
                        data: alumnos,
                      }],
                      chart: {
                        height: 350,
                        type: 'bar',  // Usamos un gráfico de barras para este tipo de datos
                        toolbar: {
                          show: false
                        },
                      },
                      plotOptions: {
                        bar: {
                          horizontal: false,
                          columnWidth: '55%',
                          endingShape: 'rounded'
                        },
                      },
                      dataLabels: {
                        enabled: false
                      },
                      stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                      },
                      xaxis: {
                        categories: grados,
                      },
                      fill: {
                        opacity: 1
                      },
                      tooltip: {
                        y: {
                          formatter: function (val) {
                            return val + " alumnos"
                          }
                        }
                      }
                    }).render();
                  });
                </script>
              </div>

            </div>
          </div>

          <!-- Recent Sales -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoy</a></li>
                  <li><a class="dropdown-item" href="#">Este Mes</a></li>
                  <li><a class="dropdown-item" href="#">Este Año</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Noticias<span>| Hoy</span></h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Customer</th>
                      <th scope="col">Product</th>
                      <th scope="col">Price</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><a href="#">#2457</a></th>
                      <td>Brandon Jacob</td>
                      <td><a href="#" class="text-primary">At praesentium minu</a></td>
                      <td>$64</td>
                      <td><span class="badge bg-success">Approved</span></td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2147</a></th>
                      <td>Bridie Kessler</td>
                      <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                      <td>$47</td>
                      <td><span class="badge bg-warning">Pending</span></td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2049</a></th>
                      <td>Ashleigh Langosh</td>
                      <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                      <td>$147</td>
                      <td><span class="badge bg-success">Approved</span></td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2644</a></th>
                      <td>Angus Grady</td>
                      <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                      <td>$67</td>
                      <td><span class="badge bg-danger">Rejected</span></td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2644</a></th>
                      <td>Raheem Lehner</td>
                      <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                      <td>$165</td>
                      <td><span class="badge bg-success">Approved</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

</main>