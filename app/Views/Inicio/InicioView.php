<?= view('/template/template_header') ?>
<style>
    .info-card {
        padding: 0rem 0.5rem;
        padding-bottom: 10px;
    }

    .info-card h6 {
        font-size: 28px;
        color: #635A5A;
        font-weight: 700;
        margin: 0;
        padding: 0;
    }

    .table_status_docs {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table_status_docs th,
    .table_status_docs td {
        padding: 8px;
        text-align: center;
        border-bottom: 1px solid #000;
    }

    .table_status_docs th {
        color: #fff;
    }
</style>
<div class="col-12 mt-5" style="padding: 0.5rem;">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered text-center table_status_docs">
                        <thead class="table-dark">
                            <tr>
                                <th class="bg-success text-white">Total de habitaciones</th>
                                <th class="bg-danger text-white">Ocupadas</th>
                                <th class="bg-primary text-white">Libres</th>
                                <th class="bg-warning text-dark">Reservadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h6 id="totalHabitaciones"></h6>
                                </td>
                                <td>
                                    <h6 id="totalOcupadas"></h6>
                                </td>
                                <td>
                                    <h6 id="totalLibres"></h6>
                                </td>
                                <td>
                                    <h6 id="totalReservadas"></h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center">
                <h3>Lista de habitaciones</h3>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-3" style="padding-top: 2rem;" id="row">
                <?php foreach ($habitaciones as $habitacion):
                    $estadoClase = '';
                    switch ($habitacion->estado) {
                        case 'libre':
                            $estadoClase = 'border-success text-success';
                            break;
                        case 'ocupada':
                            $estadoClase = 'border-danger text-danger';
                            break;
                        case 'reservada':
                            $estadoClase = 'border-warning text-warning';
                            break;
                        case 'no_disponible':
                            $estadoClase = 'border-secondary text-secondary';
                            break;
                        default:
                            $estadoClase = 'border-secondary text-secondary';
                            break;
                    }
                    ?>
                    <div class="col">
                        <div class="card shadow-sm h-100 <?= $estadoClase ?>" style="border-width: 2px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center mb-3">Habitación Número: <?= $habitacion->num ?></h5>
                                <p class="text-center fw-bold">Estado: <?= ucfirst($habitacion->estado) ?></p>
                                <div class="infoRenta" id="infoRenta">
                                    <?php if ($habitacion->estado == "ocupada" && isset($habitacion->renta_id)): ?>
                                        <button class="btn btn-outline-primary btn-sm mb-3" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#rentaInfo<?= $habitacion->habitacion_id ?>" aria-expanded="false"
                                            aria-controls="rentaInfo<?= $habitacion->habitacion_id ?>">
                                            Ver Detalles de Renta
                                        </button>
                                        <div class="collapse" id="rentaInfo<?= $habitacion->habitacion_id ?>">
                                            <div class="bg-light p-3 rounded border">
                                                <?php if ($habitacion->tipo == 1): ?>
                                                    <p><strong>Tipo:</strong> <span class="text-primary">Por Horas</span></p>
                                                    <p><strong>Inicio:</strong> <?= formato_fecha($habitacion->fecha_inicio, 10) ?>
                                                    </p>
                                                    <p><strong>Fin:</strong> <?= formato_fecha($habitacion->fecha_fin, 10) ?></p>
                                                <?php elseif ($habitacion->tipo == 2): ?>
                                                    <p><strong>Tipo:</strong> <span class="text-primary">Por Noche</span></p>
                                                    <p><strong>Huésped:</strong> <?= $habitacion->nombre_huesped ?></p>
                                                    <p><strong>Teléfono:</strong> <?= $habitacion->num_telefono ?></p>
                                                    <p><strong>Noches:</strong> <?= $habitacion->num_noches ?></p>
                                                    <p><strong>Inicio:</strong> <?= formato_fecha($habitacion->fecha_inicio, 10) ?>
                                                    </p>
                                                <?php endif; ?>
                                                <p><strong>Observaciones:</strong> <?= $habitacion->observaciones ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-3">
                                    <?php for ($i = 1; $i <= $habitacion->num_camas; $i++): ?>
                                        <i class="fas fa-2x fa-solid fa-bed me-2"></i>
                                    <?php endfor; ?>
                                </div>
                                <p id="precioHabitacion" class="text-center fw-bold text-secondary precio-habitacion">
                                    Precio por Noche: $<?= number_format($habitacion->precio, 2) ?>
                                </p>
                                <div class="dropdown mt-auto">
                                    <button class="btn btn-outline-secondary btn-sm w-100" type="button"
                                        id="dropdownMenuButton<?= $habitacion->habitacion_id ?>" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list-ul me-1"></i> Opciones
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdownMenuButton<?= $habitacion->habitacion_id ?>">
                                        <?php if ($habitacion->estado == "libre"): ?>
                                            <li>
                                                <a class="dropdown-item" style="cursor: pointer;"
                                                    onclick="rentar(this, '<?= $habitacion->habitacion_id ?>')">
                                                    Rentar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" style="cursor: pointer;"
                                                    onclick="reservar(this, '<?= $habitacion->habitacion_id ?>')">
                                                    Reservar
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($habitacion->estado == "ocupada"): ?>
                                            <li>
                                                <a class="dropdown-item" style="cursor: pointer;"
                                                    onclick="desocupar(this, '<?= $habitacion->habitacion_id ?>')">
                                                    Liberar
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-xl fade" id="modalRentar" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Rentar Habitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="text" class="form-control" id="total" readonly>
                </div>
                <div class="mb-3">
                    <label for="tipoRenta" class="form-label">Tipo de Renta</label>
                    <select class="form-select" id="tipoRenta" onchange="cambiarTipoRenta()">
                        <option value="horas">Por horas</option>
                        <option value="noche">Por noche</option>
                    </select>
                </div>
                <input type="text" id="precioHabitacionModal" hidden>
                <div class="mb-3">
                    <label class="form-label">Número de Habitación</label>
                    <p id="numHabitacion" class="form-control-plaintext fw-bold"></p>
                </div>
                <div id="informacionHuesped" class="d-none">
                    <h6 class="fw-bold mt-3">Información del Huésped</h6>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="nombreHuesped" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreHuesped" placeholder="Juan Pérez">
                        </div>
                        <div class="col-md-6">
                            <label for="telefonoHuesped" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefonoHuesped" placeholder="555-555-5555">
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-md-6">
                            <label for="correoHuesped" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correoHuesped" placeholder="email@ejemplo.com">
                        </div>
                        <div class="col-md-6">
                            <label for="numNoches" class="form-label">Noches</label>
                            <input type="number" class="form-control" id="numNoches" placeholder="2" min="1">
                        </div>
                    </div>
                </div>
                <div class="row g-2 mt-3">
                    <div class="col-md-6">
                        <label for="fechaInicio" class="form-label">Fecha y Hora de Inicio</label>
                        <input type="datetime-local" class="form-control" id="fechaInicio">
                    </div>
                    <div class="col-md-6 d-none" id="fechaFinContainer">
                        <label for="fechaFin" class="form-label">Fecha y Hora de Fin</label>
                        <input type="datetime-local" class="form-control" id="fechaFin">
                    </div>
                </div>
                <div class="mt-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea class="form-control" id="observaciones" rows="2"
                        placeholder="Notas adicionales..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarRenta"
                    onclick="guardarRenta()">Guardar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal modal-xl fade" id="modalReservacion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Reservación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 text-center">
                    <label class="form-label text-uppercase fw-bold text-secondary">Número de Habitación</label>
                    <p id="numHabitacionR" class="display-6 fw-bold text-primary">101</p>
                </div>
                <div class="mb-4 text-center">
                    <label class="form-label text-uppercase fw-bold text-secondary">Precio Total</label>
                    <p id="totalReservacionR" class="display-5 fw-bold text-success">$150.00</p>
                </div>
                <input type="text" id="precioHabitacionR" hidden>
                <div id="informacionHuesped">
                    <h6 class="fw-bold text-uppercase text-secondary border-bottom pb-2 mb-3">Información del Huésped
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombreHuespedR" class="form-label">Nombre del huésped</label>
                            <input type="text" class="form-control" id="nombreHuespedR" placeholder="Juan Pérez">
                        </div>
                        <div class="col-md-6">
                            <label for="telefonoHuespedR" class="form-label">Teléfono de contacto</label>
                            <input type="text" class="form-control" id="telefonoHuespedR" placeholder="555-555-5555">
                        </div>
                        <div class="col-md-6">
                            <label for="correoHuespedR" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correoHuespedR" placeholder="email@ejemplo.com">
                        </div>
                        <div class="col-md-6">
                            <label for="numNochesR" class="form-label">Noches</label>
                            <input type="number" class="form-control" id="numNochesR" value="1" placeholder="2" min="1">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaInicioR" class="form-label">Fecha de Entrada</label>
                            <input type="date" class="form-control" id="fechaInicioR">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaFinR" class="form-label">Fecha de Salida</label>
                            <input type="date" class="form-control" id="fechaFinR">
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="observacionesR" class="form-label">Observaciones</label>
                    <textarea class="form-control" id="observacionesR" rows="3"
                        placeholder="Habitación de solo reservación"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarReservacion"
                    onclick="guardarReservacion()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?= view('/template/template_footer') ?>
<script src="<?= base_url() ?>/public/js/inicio.js"></script>