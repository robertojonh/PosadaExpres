<?= view('/template/template_header') ?>

<div class="col-12 mt-5" style="padding: 0.5rem;">
    <div class="card">
        <div class="card-body">
            <div class="text-center mb-3">
                <h3>Lista de las Reservaciones</h3>
            </div>
            <div id="reservaciones_tabulator"></div>
        </div>
    </div>
</div>

<?= view('/template/template_footer') ?>
<script src="<?= base_url() ?>/public/js/reservaciones/reservaciones.js"></script>