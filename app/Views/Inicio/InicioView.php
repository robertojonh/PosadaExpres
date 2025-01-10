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
                                <th style="background-color: #A3B18A; color:#fff;">Total de habitaciones</th>
                                <th style="background-color: #3A5A40; color:#fff;">Ocupadas</th>
                                <th style="background-color: #3A5A40; color:#fff;">Libres</th>
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


        </div>
    </div>
</div>

<?= view('/template/template_footer') ?>