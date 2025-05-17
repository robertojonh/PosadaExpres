function formatoFechaJS(fecha, option) {
    if (!fecha || fecha === "0000-00-00") return "";

    const mesesMin = ["", "ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC"];
    const mesesCompleto = ["", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];

    const fechaObj = new Date(fecha);
    const dia = fechaObj.getDate().toString().padStart(2, "0");
    const mes = (fechaObj.getMonth() + 1).toString().padStart(2, "0");
    const anio = fechaObj.getFullYear();
    const hora = fechaObj.getHours().toString().padStart(2, "0");
    const minutos = fechaObj.getMinutes().toString().padStart(2, "0");

    let resultado = "";

    switch (option) {
        case 1:
            resultado = `${dia}-${mesesMin[parseInt(mes)]}-${anio.toString().slice(-2)}`;
            break;
        case 2:
            resultado = `${dia} DE ${mesesCompleto[parseInt(mes)]}`;
            break;
        case 3:
            resultado = `${dia} DE ${mesesCompleto[parseInt(mes)]} DEL ${anio}`;
            break;
        case 4:
            resultado = `${dia}-${mesesMin[parseInt(mes)]}`;
            break;
        case 5:
            resultado = `${dia}-${mesesMin[parseInt(mes)].toLowerCase()}-${anio}`;
            break;
        case 6:
            resultado = `${dia}`;
            break;
        case 7:
            resultado = `${dia}-${mesesMin[parseInt(mes)]}-${anio}`;
            break;
        case 8:
            resultado = `${dia}-${mesesMin[parseInt(mes)].toLowerCase()}-${anio}`;
            break;
        case 9:
            resultado = `${dia}-${mesesMin[parseInt(mes)]}-${anio} ${hora}:${minutos}`;
            break;
        case 10:
            resultado = `${dia} DE ${mesesCompleto[parseInt(mes)]} DEL ${anio} A LAS ${hora}:${minutos} HRS`;
            break;
        default:
            resultado = fechaObj.toISOString().split("T")[0];
            break;
    }

    return resultado;
}

function calcularFechaFin(fechaInicio, noches) {
    const fecha = new Date(fechaInicio);
    fecha.setDate(fecha.getDate() + noches);
    fecha.setHours(12, 0, 0, 0);
    return fecha.toISOString();
}