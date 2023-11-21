<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Inicio de Sesión | Posada Express </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico" />
    <link href="<?php echo base_url(); ?>Recursos/layouts/vertical-light-menu/css/light/loader.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>Recursos/layouts/vertical-light-menu/css/dark/loader.css" rel="stylesheet"
        type="text/css" />
    <script src="<?php echo base_url(); ?>Recursos/layouts/vertical-light-menu/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo base_url(); ?>Recursos/src/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo base_url(); ?>Recursos/layouts/vertical-light-menu/css/light/plugins.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>Recursos/src/assets/css/light/authentication/auth-boxed.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo base_url(); ?>Recursos/layouts/vertical-light-menu/css/dark/plugins.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>Recursos/src/assets/css/dark/authentication/auth-boxed.css" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

</head>

<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    <h2>Inicio de Sesión</h2>
                                    <p>Ingresa el nombre de usuario y contraseña</p>

                                </div>
                                <form class="row g-3" action="<?php echo base_url('/acceder') ?>" method="POST">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Nombre de Usuario</label>
                                            <input type="text" name="username" class="form-control" id="username">
                                            <?php if (session('errors.username')): ?>
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                                    <?= session('errors.username') ?>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label">Contraseña</label>
                                            <input type="password" name="password" class="form-control" id="password">
                                            <?php if (session('errors.password')): ?>
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                                    <?= session('errors.password') ?>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input me-3" type="checkbox" id="form-check-default">
                                            <label class="form-check-label" for="form-check-default">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    </div> -->

                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button class="btn btn-secondary w-100">Iniciar Sesión</button>
                                        </div>
                                        <?php if (session('msg')): ?>
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                <?= session('msg') ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo base_url(); ?>Recursos/src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


</body>

</html>