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
      <div class="col-lg-8">
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
                    <li><a class="dropdown-item" href="#" onclick="filtrar('<?php echo $mes; ?>')"><?php echo $mes; ?></a>
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
                    // Datos obtenidos desde PHP
                    const pagosPorMes = <?php echo $pagosPorMesJson; ?>;
                    const porcentajePorMes = <?php echo $porcentajePorMesJson; ?>;

                    // Función para actualizar el total de pagos vencidos y porcentaje de pensiones vencidas
                    window.updatePagosVencidos = function (mes) {
                      const totalPagosVencidos = pagosPorMes[mes].reduce((sum, current) => sum + current, 0);
                      const porcentajeVencidas = porcentajePorMes[mes]; // Sin multiplicar por 100
                      document.getElementById('totalPagosVencidos').textContent = totalPagosVencidos;
                      document.getElementById('porcentajeVencidas').textContent = porcentajeVencidas.toFixed(2) + '%'; // Formatea a dos decimales
                      document.getElementById('filtroSeleccionado').textContent = "| " + mes;
                    }

                    // Inicializar con el primer mes
                    updatePagosVencidos('<?php echo reset($meses); ?>');
                  });

                  // Función para filtrar
                  function filtrar(mes) {
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

                  <li><a class="dropdown-item" href="#">Hoy</a></li>
                  <li><a class="dropdown-item" href="#">Este Mes</a></li>
                  <li><a class="dropdown-item" href="#">Este Año</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Suscritos <span>| Hoy</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>$3,264</h6>
                    <span class="text-success small pt-1 fw-bold">8%</span> <span
                      class="text-muted small pt-2 ps-1">increase</span>

                  </div>
                </div>
              </div>

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

      <div class="col-lg-4">

        <div class="card">

          <div class="card-body">
            <h5 class="card-title">Recent Activity <span>| Today</span></h5>

            <div class="activity">

              <div class="activity-item d-flex">
                <div class="activite-label">32 min</div>
                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                <div class="activity-content">
                  Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                </div>
              </div>

              <div class="activity-item d-flex">
                <div class="activite-label">56 min</div>
                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                <div class="activity-content">
                  Voluptatem blanditiis blanditiis eveniet
                </div>
              </div>

              <div class="activity-item d-flex">
                <div class="activite-label">2 hrs</div>
                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                <div class="activity-content">
                  Voluptates corrupti molestias voluptatem
                </div>
              </div>

              <div class="activity-item d-flex">
                <div class="activite-label">1 day</div>
                <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                <div class="activity-content">
                  Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                </div>
              </div>

              <div class="activity-item d-flex">
                <div class="activite-label">2 days</div>
                <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                <div class="activity-content">
                  Est sit eum reiciendis exercitationem
                </div>
              </div>

              <div class="activity-item d-flex">
                <div class="activite-label">4 weeks</div>
                <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                <div class="activity-content">
                  Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                </div>
              </div>

            </div>

          </div>
        </div>

        <!-- News & Updates Traffic -->
        <div class="card">
          <div class="card-body pb-0">
            <h5 class="card-title">Noticias &amp; Eventos</h5>

            <div class="news">
              <div class="post-item clearfix">
                <img src="" alt="">
                <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
              </div>

              <div class="post-item clearfix">
                <img src="" alt="">
                <h4><a href="#">Quidem autem et impedit</a></h4>
                <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
              </div>

              <div class="post-item clearfix">
                <img src="" alt="">
                <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
              </div>

              <div class="post-item clearfix">
                <img src="" alt="">
                <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
              </div>

              <div class="post-item clearfix">
                <img src="" alt="">
                <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
              </div>

            </div>

          </div>
        </div>

      </div>

    </div>
  </section>

</main>