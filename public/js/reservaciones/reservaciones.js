var tableReservaciones = new Tabulator("#reservaciones_tabulator", {
    ajaxURL: base_url + "reservaciones/getReservaciones",
    ajaxConfig: "POST",
    tooltips: true,
    layout: "fitColumns",
    responsiveLayout: "collapse",
    columns: [
        {
            title: "#",
            formatter: "rownum",
            hozAlign: "center",
            width: 50,
        },
        {
            title: "Habitación",
            field: "num",
            hozAlign: "center",
            width: 200,
            headerFilter: true,
        },
        {
            title: "Estado de Reservacion",
            field: "estatus_reservacion",
            hozAlign: "center",
            formatter: function (cell, formatterParams, onRendered) {
                const row = cell.getValue();
                if (row == 'activo') {
                    return "Reservada";
                }
                return "Terminó Reservacion";
            },
            width: 200,
            headerFilter: true,
        },
        {
            title: "Precio",
            field: "precio",
            hozAlign: "center",
            width: 100,
            headerFilter: true,
        },
        {
            title: "Nombre del huesped",
            field: "nombre_huesped",
            hozAlign: "center",
            width: 300,
            headerFilter: true,
        },
        {
            title: "Fecha de Entrada",
            field: "fecha_inicio",
            hozAlign: "center",
            width: 200,
            headerFilter: true,
            formatter: function (cell, formatterParams, onRendered) {
                const rawDate = cell.getValue();
                return rawDate ? formatoFechaJS(rawDate, 3) : "";
            },
        },
        {
            title: "Fecha de Salida",
            field: "fecha_fin",
            hozAlign: "center",
            width: 200,
            headerFilter: true,
            formatter: function (cell, formatterParams, onRendered) {
                const rawDate = cell.getValue();
                return rawDate ? formatoFechaJS(rawDate, 3) : "";
            },
        },
        {
            title: "Fecha de Creación",
            field: "fecha",
            hozAlign: "center",
            width: 300,
            headerFilter: true,
            formatter: function (cell, formatterParams, onRendered) {
                const rawDate = cell.getValue();
                return rawDate ? formatoFechaJS(rawDate, 10) : "";
            }
        }

    ],
});