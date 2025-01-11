<?= view('/template/template_header') ?>

<div class="col-12 mt-5" style="padding: 0.5rem;">
    <div class="card">
        <div class="card-body">
            <button class="btn btn-outline-primary" onclick="modalHabitacion('agregar')">
                <i class="fas fa-2x fa-solid fa-square-plus"></i> Agregar Habitación
            </button>
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
                    <div class="col foto">
                        <div class="card shadow-sm h-100 <?= $estadoClase ?>" style="border-width: 2px;">
                            <div class="card-body position-relative">
                                <h5 class="card-title text-center">Habitación Número: <?= $habitacion->num ?></h5>
                                <p class="text-center fw-bold">
                                    Estado: <?= ucfirst($habitacion->estado) ?>
                                </p>
                                <p class="text-center">Precio por Noche: $<?= number_format($habitacion->precio, 2) ?>
                                </p>
                                <p class="text-center">Número de camas: <?= $habitacion->num_camas ?>
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
                                                onclick="modalHabitacion('modificar', '<?= $habitacion->habitacion_id ?>',this)">
                                                Editar
                                            </a>
                                            <a class="dropdown-item text-secondary" style="cursor: pointer;"
                                                onclick="cambiarDisponibilidad(this, '<?= $habitacion->habitacion_id ?>','libre')">
                                                Desocupada
                                            </a>
                                            <a class="dropdown-item text-secondary" style="cursor: pointer;"
                                                onclick="cambiarDisponibilidad(this, '<?= $habitacion->habitacion_id ?>','no_disponible')">
                                                No disponible
                                            </a>
                                            <a class="dropdown-item text-danger" style="cursor: pointer;"
                                                onclick="borrarHabitacion(this, '<?= $habitacion->habitacion_id ?>','no_disponible')">
                                                Borrar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col foto" data-habitacion-id="<?= $habitacion->habitacion_id ?>">
                                    <textarea name="descripcion_img" placeholder="Escriba una breve descripción"
                                        class="form-control form-control-sm mb-3 border-1 rounded-2" rows="4"
                                        style="resize: none;" data-original-value="<?= $habitacion->observaciones ?>"
                                        onblur="cambiarDescripcion(this,'<?= $habitacion->habitacion_id ?>')"><?= $habitacion->observaciones ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<div class="modal modal-xl fade" id="modalHabitacion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Nueva Habitación</h5>
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
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <input type="text" class="form-control" id="observaciones"
                        placeholder="Habitación de solo reservación">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modalHabitacionGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>


<?= view('/template/template_footer') ?>
<script src="<?= base_url() ?>/public/js/habitaciones.js"></script>