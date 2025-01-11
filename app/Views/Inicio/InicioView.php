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
                    <table border="1" class="table table_status_docs" style="table-layout: fixed;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="background-color:rgb(142, 187, 65); color:#fff;">Total de habitaciones</th>
                                <th style="background-color:rgb(0, 64, 184); color:#fff;">Ocupadas</th>
                                <th style="background-color:rgb(0, 197, 36); color:#fff;">Libres</th>
                                <th style="background-color: #3A5A40; color:#fff;">Reservadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="info-card" style="text-align: center;">
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

            <!-- Listado de las habitaciones -->
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
                            <div class="card-body">
                                <h5 class="card-title text-center">Habitación Número: <?= $habitacion->num ?></h5>
                                <p class="text-center fw-bold">
                                    Estado: <?= ucfirst($habitacion->estado) ?>
                                </p>
                                <div class="d-flex justify-content-center align-items-center">
                                    <?php for ($i = 1; $i <= $habitacion->num_camas; $i++): ?>
                                        <i class="fas fa-2x fa-solid fa-bed me-2"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-center">Precio por Noche: $<?= number_format($habitacion->precio, 2) ?>
                                </p>

                                <div class="dropdown position-absolute bottom-0 end-0 me-2 mb-2">
                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                        id="dropdownMenuButton<?= $habitacion->habitacion_id ?>" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdownMenuButton<?= $habitacion->habitacion_id ?>">
                                        <li>
                                            <a class="dropdown-item text-secondary" style="cursor: pointer;"
                                                onclick="rentar(this, '<?= $habitacion->habitacion_id ?>','libre')">
                                                Rentar
                                            </a>
                                            <a class="dropdown-item text-secondary" style="cursor: pointer;"
                                                onclick="reservar(this, '<?= $habitacion->habitacion_id ?>','libre')">
                                                Reservar
                                            </a>
                                        </li>
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
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Rentar habitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="numeroHabitacion" class="form-label">Nombre del huesped</label>
                    <input type="number" class="form-control" id="numeroHabitacion" placeholder="Ejemplo: 21">
                </div>
                <div class="mb-3">
                    <label for="numeroHabitacion" class="form-label">Número de habitación</label>
                    <input type="number" class="form-control" id="numeroHabitacion" placeholder="Ejemplo: 21">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="guardarHabitacion()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-xl fade" id="modalReservacion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Reservacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="numeroHabitacion" class="form-label">Número de habitación</label>
                    <input type="number" class="form-control" id="numeroHabitacion" placeholder="Ejemplo: 21">
                </div>
                <div class="mb-3">
                    <label for="numeroCamas" class="form-label">Número de Camas</label>
                    <input type="number" class="form-control" id="numeroCamas" placeholder="Ejemplo: 2">
                </div>
                <div class="mb-3">
                    <label for="precioNoche" class="form-label">Precio por Noche</label>
                    <input type="text" class="form-control" id="precioNoche" placeholder="Ejemplo: 1500.00">
                </div>
                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observacion</label>
                    <input type="text" class="form-control" id="observaciones"
                        placeholder="Habitacion de solo reservacion">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="guardarHabitacion()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?= view('/template/template_footer') ?>
<script>
    function rentar() {

        $('#modalRentar').modal('show');
    }
</script>
<script src="<?= base_url() ?>/public/js/inicio.js"></script>