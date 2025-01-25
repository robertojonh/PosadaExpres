<?= view('template/template_header') ?>

<div class="col-12 mt-5" style="padding: 0.5rem;">
    <div class="card">
        <div class="card-body">
            <div class="text-center mb-3">
                <h3>Habitaciones reservadas</h3>
            </div>
            <button class="btn btn-outline-primary" onclick="modalHabitacion('agregar')">
                <i class="fas fa-2x fa-solid fa-square-plus"></i> Hacer una reservación
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

<?= view('template/template_footer') ?>