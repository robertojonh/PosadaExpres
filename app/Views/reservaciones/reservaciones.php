<?= view('/template/template_header') ?>

<div class="col-12 mt-5" style="padding: 0.5rem;">
    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Lista de las Reservaciones</h3>
                <a href="<?= base_url('reservaciones/exportar') ?>" type="button" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Exportar Datos
                </a>
            </div>
            <div id="reservaciones_tabulator"></div>
        </div>
    </div>
</div>

<?= view('/template/template_footer') ?>
<script src="<?= base_url() ?>/public/js/reservaciones/reservaciones.js"></script>