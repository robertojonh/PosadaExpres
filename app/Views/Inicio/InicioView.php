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
                                <p id="precioHabitacion" class="text-center precio-habitacion">
                                    Precio por Noche: $<?= number_format($habitacion->precio, 2) ?></p>
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
                                                onclick="rentar(this, '<?= $habitacion->habitacion_id ?>')">
                                                Rentar
                                            </a>
                                            <a class="dropdown-item text-secondary" style="cursor: pointer;"
                                                onclick="reservar(this, '<?= $habitacion->habitacion_id ?>')">
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

<!-- <div class="modal modal-xl fade" id="modalRentar" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
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
</div> -->

<!-- Modal Rentar -->
<div class="modal modal-xl fade" id="modalRentar" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Rentar Habitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tipo de Renta -->
                <div class="mb-3">
                    <label for="tipoRenta" class="form-label">Tipo de Renta</label>
                    <select class="form-select" id="tipoRenta" onchange="cambiarTipoRenta()">
                        <option value="horas">Por horas</option>
                        <option value="noche">Por noche</option>
                    </select>
                </div>
                <input type="text" name="" id="precioHabitacionModal" hidden>
                <!-- Número de Habitación -->
                <div class="mb-3">
                    <label class="form-label">Número de Habitación</label>
                    <p id="numHabitacion" class="form-control-plaintext fw-bold"></p>
                </div>

                <!-- Información del Huésped (solo para renta por noche) -->
                <div id="informacionHuesped" class="d-none">
                    <h6 class="fw-bold mt-3">Información del Huésped</h6>
                    <div class="mb-3">
                        <label for="nombreHuesped" class="form-label">Nombre del Huésped</label>
                        <input type="text" class="form-control" id="nombreHuesped" placeholder="Ejemplo: Juan Pérez">
                    </div>
                    <div class="mb-3">
                        <label for="numNoches" class="form-label">Número de Noches</label>
                        <input type="number" class="form-control" id="numNoches" placeholder="Ejemplo: 2" min="1">
                    </div>
                </div>

                <!-- Fechas y Horas -->
                <div class="mb-3">
                    <label for="fechaInicio" class="form-label">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" class="form-control" id="fechaInicio">
                </div>
                <div id="fechaFinContainer" class="mb-3 d-none">
                    <label for="fechaFin" class="form-label">Fecha y Hora de Fin</label>
                    <input type="datetime-local" class="form-control" id="fechaFin">
                </div>

                <!-- Observaciones -->
                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea class="form-control" id="observaciones" rows="3"
                        placeholder="Notas adicionales..."></textarea>
                </div>

                <!-- Total Calculado -->
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="text" class="form-control" id="total" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarRenta()">Guardar</button>
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
    function actualizarTablaEstados() {
        let totalHabitaciones = 0;
        let totalOcupadas = 0;
        let totalLibres = 0;
        let totalReservadas = 0;
        const tarjetas = document.querySelectorAll('#row .card');
        tarjetas.forEach((tarjeta) => {
            totalHabitaciones++;
            if (tarjeta.classList.contains('border-success')) {
                totalLibres++;
            } else if (tarjeta.classList.contains('border-danger')) {
                totalOcupadas++;
            } else if (tarjeta.classList.contains('border-warning')) {
                totalReservadas++;
            }
        });
        document.getElementById('totalHabitaciones').textContent = totalHabitaciones;
        document.getElementById('totalOcupadas').textContent = totalOcupadas;
        document.getElementById('totalLibres').textContent = totalLibres;
        document.getElementById('totalReservadas').textContent = totalReservadas;
    }
    document.addEventListener('DOMContentLoaded', actualizarTablaEstados);

    /* function rentar(element, habitacionId) {
        // Obtener el número de habitación desde el elemento this
        const numHabitacion = element.closest('.card').querySelector('.card-title').textContent.split(': ')[1];

        // Actualizar el modal con el número de habitación
        document.getElementById('numHabitacion').textContent = numHabitacion;

        // Abrir el modal
        const modal = new bootstrap.Modal(document.getElementById('modalRentar'));
        modal.show();
    } */


    /* function rentar(element, habitacionId) {
        const numHabitacion = element.closest('.card').querySelector('.card-title').textContent.split(': ')[1];
        document.getElementById('numHabitacion').textContent = numHabitacion;
        const modal = new bootstrap.Modal(document.getElementById('modalRentar'));
        modal.show();
        document.getElementById('tipoRenta').value = 'horas';
        cambiarTipoRenta();
        $('#modalRentar').modal('show');
    } */

    function rentar(element, habitacionId) {
        const precioHabitacionTexto = element.closest('.card').querySelector('.precio-habitacion').textContent;
        const precioHabitacion = parseFloat(precioHabitacionTexto.replace('Precio por Noche: $', '').replace(',', '').trim());
        console.log(precioHabitacion);
        document.getElementById('precioHabitacionModal').value = precioHabitacion;
        const numHabitacion = element.closest('.card').querySelector('.card-title').textContent.split(': ')[1];
        document.getElementById('numHabitacion').textContent = numHabitacion;
        const modal = new bootstrap.Modal(document.getElementById('modalRentar'));
        modal.show();
        document.getElementById('tipoRenta').value = 'horas';
        cambiarTipoRenta();
    }


    /* function cambiarTipoRenta() {
        const tipoRenta = document.getElementById('tipoRenta').value;
        const informacionHuesped = document.getElementById('informacionHuesped');
        const fechaFinContainer = document.getElementById('fechaFinContainer');

        if (tipoRenta === 'noche') {
            informacionHuesped.classList.remove('d-none');
            fechaFinContainer.classList.add('d-none'); // Fecha de fin no manual para noches
        } else {
            informacionHuesped.classList.add('d-none');
            fechaFinContainer.classList.remove('d-none'); // Fecha de fin manual para horas
        }
        calcularTotal();
    } */

    function cambiarTipoRenta() {
        const tipoRenta = document.getElementById('tipoRenta').value;
        const informacionHuesped = document.getElementById('informacionHuesped');
        const fechaFinContainer = document.getElementById('fechaFinContainer');
        if (tipoRenta === 'noche') {
            informacionHuesped.classList.remove('d-none');
            fechaFinContainer.classList.add('d-none');
            document.getElementById('numNoches').addEventListener('input', calcularTotal);
        } else {
            informacionHuesped.classList.add('d-none');
            fechaFinContainer.classList.remove('d-none');
            document.getElementById('fechaFinContainer').addEventListener('change', calcularTotal);
        }
        /* calcularTotal(); */
    }


    /* function calcularTotal() {
        const tipoRenta = document.getElementById('tipoRenta').value;
        const numNoches = parseInt(document.getElementById('numNoches').value || 0, 10);
        const fechaInicio = document.getElementById('fechaInicio').value;
        const fechaFin = document.getElementById('fechaFin').value;

        let total = 0;

        if (tipoRenta === 'noche' && numNoches > 0) {
            const precioPorNoche = 100; // Ejemplo: $100 por noche
            total = precioPorNoche * numNoches;
        } else if (tipoRenta === 'horas' && fechaInicio && fechaFin) {
            const precioPorHora = 10; // Ejemplo: $10 por hora
            const horas = (new Date(fechaFin) - new Date(fechaInicio)) / (1000 * 60 * 60);
            total = precioPorHora * Math.ceil(horas);
        }

        document.getElementById('total').value = `$${total.toFixed(2)}`;
    } */

    function calcularTotal() {
        const tipoRenta = document.getElementById('tipoRenta').value;
        const numNoches = parseInt(document.getElementById('numNoches').value || 0, 10);
        const fechaInicio = document.getElementById('fechaInicio').value;
        const fechaFin = document.getElementById('fechaFin').value;

        /* const precioHabitacion = parseFloat(document.getElementById('precioHabitacion').value || 0); */
        // Obtener el precio de la habitación desde el texto
        var precioHabitacion = document.getElementById('precioHabitacionModal').value;
        console.log(precioHabitacion);
        let total = 0;

        if (tipoRenta === 'noche' && numNoches > 0) {
            total = precioHabitacion * numNoches;
        } else if (tipoRenta === 'horas' && fechaInicio && fechaFin) {
            const precioPorHora = 10; // Ejemplo: $10 por hora
            const horas = (new Date(fechaFin) - new Date(fechaInicio)) / (1000 * 60 * 60);
            total = precioPorHora * Math.ceil(horas);
        }

        document.getElementById('total').value = `$${total.toFixed(2)}`;
    }


    function guardarRenta() {
        const tipoRenta = document.getElementById('tipoRenta').value;
        const numHabitacion = document.getElementById('numHabitacion').value;
        const nombreHuesped = document.getElementById('nombreHuesped').value || null;
        const numNoches = document.getElementById('numNoches').value || null;
        const fechaInicio = document.getElementById('fechaInicio').value;
        const fechaFin = document.getElementById('fechaFin').value || null;
        const observaciones = document.getElementById('observaciones').value;
        const total = parseFloat(document.getElementById('total').value.replace('$', ''));

        if (!numHabitacion || !fechaInicio || (!fechaFin && tipoRenta === 'horas')) {
            alert('Por favor, complete todos los campos requeridos.');
            return;
        }

        const renta = {
            tipoRenta,
            numHabitacion,
            nombreHuesped,
            numNoches,
            fechaInicio,
            fechaFin,
            observaciones,
            total,
        };

        console.log('Datos de la renta:', renta);

        // Cerrar modal
        $('#modalRentar').modal('hide');
    }

</script>
<script src="<?= base_url() ?>/public/js/inicio.js"></script>