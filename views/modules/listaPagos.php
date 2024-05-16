<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloPagos"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Todos los Pagos</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">

      <div class="col-lg-2">
        <span style="margin: 0 10px;"></span>
        <div class="row mb-2">
          <button type="button" class="btn btn-primary btnAgregarNuevoPago" id="btnAgregarNuevoPago"><i class="bi bi-cash-coin"></i>  Registrar
            Pago</button>
        </div>
      </div>
      <div style="width: 20px;"></div>
      <div class="col-lg-2">
        <span style="margin: 0 10px;"></span>
        <div class="row mb-2">
          <button type="button" class="btn btn-warning btnCargarArchivosExcel" id="btnCargarArchivosExcel">
            <i class="bi bi-file-earmark-arrow-up"></i> Cargar Excel Registro Pagos
          </button>
          <!-- Input oculto para subir archivos xlsx -->
          <input type="file" id="inputExcel" style="display: none;" accept=".xlsx, .xls">
        </div>
      </div>
      <div style="width: 20px;"></div>
      <div class="col-lg-2">
        <span style="margin: 0 10px;"></span>
        <div class="row mb-2">
          <button type="button" class="btn btn-info btnCargarArchivosExcelReporte" id="btnCargarArchivosExcelReporte">
            <i class="bi bi-file-earmark-arrow-up"></i> Cargar Excel Pagos Diarios
          </button>
          <!-- Input oculto para subir archivos xlsx -->
          <input type="file" id="inputExcelReporte" style="display: none;" accept=".xlsx, .xls">
        </div>
      </div>

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTablePagosAdmin-->
              <table id="dataTablePagos" class="display dataTablePagos" style="width: 98%">
                <thead>
                  <!-- dataTablePagosAdmin -->
                </thead>
                <tbody>
                  <!--dataTablePagosAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<!-- modal detalle Pago -->
<div class="modal modalDetallePago" id="modalDetallePago" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Aquí van tus campos de entrada -->
        <label for="nombresDetalle">Nombres:</label>
        <input type="text" class="form-control mb-3" id="nombresDetalle" name="nombresDetalle" disabled>

        <label for="apellidosDetalle">Apellidos: </label>
        <input type="text" class="form-control mb-3" id="apellidosDetalle" name="apellidosDetalle" disabled>

        <label for="gradoDetalle">Grado:</label>
        <input type="text" class="form-control mb-3" id="gradoDetalle" name="gradoDetalle" disabled>

        <label for="nivelDertalle">Nivel:</label>
        <input type="text" class="form-control mb-3" id="nivelDertalle" name="nivelDertalle" disabled>

        <label for="codigoCajaDetalle">Codigo:</label>
        <input type="text" class="form-control mb-3" id="codigoCajaDetalle" name="codigoCajaDetalle" disabled>

        <label for="mesDetalle">Mes:</label>
        <input type="text" class="form-control mb-3" id="mesDetalle" name="mesDetalle" disabled>

        <label for="LimitePagoDetalle">Fecha Limite Pago:</label>
        <input type="text" class="form-control mb-3" id="LimitePagoDetalle" name="LimitePagoDetalle" disabled>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
