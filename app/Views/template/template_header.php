<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal - Posada Express</title>
    <link href="<?= base_url() ?>/public/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/public/tabulator/css/tabulator.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify/dist/simple-notify.css" />
    <script src="https://cdn.jsdelivr.net/npm/simple-notify/dist/simple-notify.min.js"></script>
</head>

<body>
    <!-- Inicio del NavBar -->
    <nav class="navbar navbar-dark bg-dark fixed-top mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url("/Inicio"); ?>">PE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Abrir menú de navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">PE</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Cerrar"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('home') !== false ? 'active' : '') ?> " aria-current="page"
                                href="<?= base_url() ?>home">Menú
                                Principal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('habitaciones') !== false ? 'active' : '') ?>"
                                href="<?= base_url() ?>habitaciones">Habitaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('rentas') !== false ? 'active' : '') ?>"
                                href="<?= base_url() ?>rentas">Informe de Rentas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('reservaciones') !== false ? 'active' : '') ?>"
                                href="<?= base_url() ?>reservaciones">Informe de Reservaciones</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Nombre de Usuario: <?= session('username'); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userDropdown">
                                <li><span class="dropdown-item">Correo Electrónico: <?= session('email'); ?></span></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= base_url("/Salir"); ?>">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Fin del NavBar -->