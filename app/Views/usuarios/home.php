<?= view('/template/template_header') ?>

<div class="col-12 mt-5" style="padding: 0.5rem;">
    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Lista de Usuarios</h3>
                <a href="<?= base_url() ?>reportes/reservaciones" target="_blank" type="button" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Exportar Datos
                </a>
            </div>
            <div id="usuarios_tabulator"></div>
        </div>
    </div>
</div>

<?= view('/template/template_footer') ?>
<script>
    var tableUsuarios = new Tabulator("#usuarios_tabulator", {
        ajaxURL: base_url + "usuarios/getUsuarios",
        ajaxConfig: "POST",
        tooltips: true,
        layout: "fitColumns",
        height: "900px",
        responsiveLayout: "collapse",
        columns: [{
                title: "#",
                formatter: "rownum",
                hozAlign: "center",
                width: 50,
            },
            {
                title: "Nombre del usuario",
                field: "nombre_completo",
                hozAlign: "center",
                headerFilter: true,
            },
            {
                title: "Correo Electrónico",
                field: "email",
                hozAlign: "center",
                width: 300,
                headerFilter: true,
            },
            {
                title: "Nombre de usuario",
                field: "user",
                hozAlign: "center",
                width: 200,
                headerFilter: true,
            },
            {
                title: "Tipo de usuario",
                field: "tipo",
                hozAlign: "center",
                width: 200,
                headerFilter: true,
            },
        ],
    });
</script>
<!-- <script src="<?= base_url() ?>/public/js/reservaciones/reservaciones.js"></script> -->