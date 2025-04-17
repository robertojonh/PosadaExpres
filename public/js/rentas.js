var tableRentas = new Tabulator("#rentas_tabulator", {
  ajaxURL: base_url + "rentas/getRentas",
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
      title: "Numero de Habitación",
      field: "num",
      hozAlign: "center",
      width: 200,
      headerFilter: true,
    },
    {
      title: "Tipo",
      field: "tipo",
      hozAlign: "center",
      formatter: function (cell, formatterParams, onRendered) {
        const row = cell.getValue();
        if (row == 1) {
          return "Por horas";
        }
        return "Por noche";
      },
      width: 100,
      headerFilter: true,
    },
    {
      title: "Nombre del huesped",
      field: "nombre_huesped",
      hozAlign: "center",
      formatter: "textarea",
      width: 200,
      headerFilter: true,
    },
    {
      title: "Noches",
      field: "num_noches",
      hozAlign: "center",
      width: 100,
      headerFilter: true,
    },
    {
      title: "Fecha de Entrada",
      field: "fecha_inicio",
      hozAlign: "center",
      width: 300,
      headerFilter: true,
      formatter: function (cell, formatterParams, onRendered) {
        const rawDate = cell.getValue();
        return rawDate ? formatoFechaJS(rawDate, 10) : "";
      },
    },
    {
      title: "Fecha de Salida",
      field: "fecha_fin",
      hozAlign: "center",
      width: 300,
      /* headerFilter: "datetime", */
      headerFilter: true,
      formatter: function (cell, formatterParams, onRendered) {
        const rawDate = cell.getValue();
        return rawDate ? formatoFechaJS(rawDate, 10) : "";
      },
    },
    {
      title: "Fecha de renta",
      field: "fecha",
      hozAlign: "center",
      width: 300,
      headerFilter: true,
      formatter: function (cell, formatterParams, onRendered) {
        const rawDate = cell.getValue();
        return rawDate ? formatoFechaJS(rawDate, 10) : "";
      },
    },
    {
      title: "Total",
      field: "total",
      hozAlign: "center",
      width: 75,
      headerFilter: true,
      formatter: "money",
      formatterParams: {
        decimal: ".",
        thousand: ",",
        symbol: "$",
        negativeSign: true,
        precision: 2,
      },
      topCalc: "sum",
      /* topCalcParams: {
        decimal: ".",
        thousand: ",",
        symbol: "$",
        negativeSign: true,
        precision: 2,
      }, */
    },
    {
      title: "Observaciones",
      field: "observaciones",
      formatter: "textarea",
      headerFilter: true,
    },
  ],
});
