function actualizarTablaEstados() {
  let totalHabitaciones = 0;
  let totalOcupadas = 0;
  let totalLibres = 0;
  let totalReservadas = 0;
  let totalEsperaHuesped = 0;

  const tarjetas = document.querySelectorAll("#row .card");
  tarjetas.forEach((tarjeta) => {
    totalHabitaciones++;
    if (tarjeta.classList.contains("border-success")) {
      totalLibres++;
    } else if (tarjeta.classList.contains("border-danger")) {
      totalOcupadas++;
    } else if (tarjeta.classList.contains("border-warning")) {
      totalReservadas++;
    } else if (tarjeta.classList.contains("border-primary")) {
      totalEsperaHuesped++;
    }
  });
  const calcularPorcentaje = (cantidad) => totalHabitaciones > 0 ? (cantidad / totalHabitaciones) * 100 : 0;
  let porcentajeOcupadas = calcularPorcentaje(totalOcupadas);
  let porcentajeLibres = calcularPorcentaje(totalLibres);
  let porcentajeReservadas = calcularPorcentaje(totalReservadas);
  let porcentajeEsperaHuesped = calcularPorcentaje(totalEsperaHuesped);
  document.getElementById("totalHabitaciones").textContent = totalHabitaciones;
  document.getElementById("totalOcupadas").textContent = `${totalOcupadas} (${porcentajeOcupadas.toFixed(1)}%)`;
  document.getElementById("totalLibres").textContent = `${totalLibres} (${porcentajeLibres.toFixed(1)}%)`;
  document.getElementById("totalReservadas").textContent = `${totalReservadas} (${porcentajeReservadas.toFixed(1)}%)`;
  document.getElementById("totalEsperaHuesped").textContent = `${totalEsperaHuesped} (${porcentajeEsperaHuesped.toFixed(1)}%)`;
  document.getElementById("barOcupadas").style.width = `${porcentajeOcupadas}%`;
  document.getElementById("barLibres").style.width = `${porcentajeLibres}%`;
  document.getElementById("barReservadas").style.width = `${porcentajeReservadas}%`;
  document.getElementById("barEsperaHuesped").style.width = `${porcentajeEsperaHuesped}%`;
}

actualizarTablaEstados();

function rentar(element, habitacion_id) {
  const guardarRentaBtn = document.getElementById("guardarRenta");
  guardarRentaBtn.onclick = () => guardarRenta(habitacion_id, element);
  const precioHabitacionTexto = element
    .closest(".card")
    .querySelector(".precio-habitacion").textContent;
  const precioHabitacion = parseFloat(
    precioHabitacionTexto
      .replace("Precio por Noche: $", "")
      .replace(",", "")
      .trim()
  );
  document.getElementById("precioHabitacionModal").value = precioHabitacion;
  const numHabitacion = element
    .closest(".card")
    .querySelector(".card-title")
    .textContent.split(": ")[1];
  document.getElementById("numHabitacion").textContent = numHabitacion;
  const modal = new bootstrap.Modal(document.getElementById("modalRentar"));
  modal.show();
  document.getElementById("tipoRenta").value = "horas";
  cambiarTipoRenta();
}

function cambiarTipoRenta() {
  const tipoRenta = document.getElementById("tipoRenta").value;
  const informacionHuesped = document.getElementById("informacionHuesped");
  const fechaFinContainer = document.getElementById("fechaFinContainer");
  if (tipoRenta === "noche") {
    informacionHuesped.classList.remove("d-none");
    fechaFinContainer.classList.add("d-none");
    document
      .getElementById("numNoches")
      .addEventListener("input", calcularTotal);
  } else {
    informacionHuesped.classList.add("d-none");
    fechaFinContainer.classList.remove("d-none");
    document
      .getElementById("fechaFinContainer")
      .addEventListener("change", calcularTotal);
  }
}

function calcularTotal() {
  const tipoRenta = document.getElementById("tipoRenta").value;
  const numNoches = parseInt(
    document.getElementById("numNoches").value || 0,
    10
  );
  const fechaInicio = document.getElementById("fechaInicio").value;
  const fechaFin = document.getElementById("fechaFin").value;

  var precioHabitacion = document.getElementById("precioHabitacionModal").value;
  let total = 0;

  if (tipoRenta === "noche" && numNoches > 0) {
    total = precioHabitacion * numNoches;
  } else if (tipoRenta === "horas" && fechaInicio && fechaFin) {
    const precioPorHora = 70;
    const horas =
      (new Date(fechaFin) - new Date(fechaInicio)) / (1000 * 60 * 60);
    total = precioPorHora * Math.ceil(horas);
  }
  document.getElementById("totalRenta").innerHTML = `$${total.toFixed(2)}`;
}

function guardarRenta(habitacion_id, elemento) {
  const tipoRenta = document.getElementById("tipoRenta").value;
  const numHabitacion = document.getElementById("numHabitacion").textContent;
  const nombreHuesped = document.getElementById("nombreHuesped").value || null;
  const correoHuesped = document.getElementById("correoHuesped").value || null;
  const telefonoHuesped =
    document.getElementById("telefonoHuesped").value || null;
  const numNoches = document.getElementById("numNoches").value || null;
  const fechaInicio = document.getElementById("fechaInicio").value;
  const fechaFin = document.getElementById("fechaFin").value || null;
  const observaciones = document.getElementById("observaciones").value;
  const total = parseFloat(
    document.getElementById("totalRenta").textContent.replace("$", "").trim()
  );

  if (!fechaInicio || (!fechaFin && tipoRenta === "horas")) {
    generalNotify('personalizada', 'warning', 'Campos necesarios', 'Es necesario completar todos los campos');
    return;
  }
  const renta = {
    habitacion_id,
    tipoRenta,
    numHabitacion,
    nombreHuesped,
    correoHuesped,
    telefonoHuesped,
    numNoches,
    fechaInicio,
    fechaFin,
    observaciones,
    total,
  };

  $.ajax({
    url: base_url + "rentas/rentarHabitacion",
    type: "POST",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({ data: renta }),
    success: function (response) {
      if (response.status === "success") {
        var estado = "ocupada";
        data_response = response.data;
        renta.renta_id = data_response.renta_id;
        cambiarEstadoHabitacion(elemento, estado, habitacion_id, renta);
        actualizarTablaEstados();
        $("#modalRentar").modal("hide");
        generalNotify('personalizada', 'success', 'Se ha rentado', 'La habitación ha sido rentada correctamente');
      } else {
        generalNotify('general-error');
      }
    },
    error: function (error) { },
  });
}

function desocupar(elemento, habitacion_id, tipo, tipo_id) {
  var estado = "libre";
  $.ajax({
    url: base_url + "habitaciones/cambiarDisponibilidad",
    type: "POST",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({
      habitacion_id: habitacion_id,
      estado: estado,
      tipo: tipo,
      tipo_id: tipo_id
    }),
    success: function (response) {
      if (response.status === "success") {
        cambiarEstadoHabitacion(elemento, estado, habitacion_id);
        actualizarTablaEstados();
        $("#modalRentar").modal("hide");
        if (tipo == "rentas") {
          generalNotify('personalizada', 'success', 'Se ha desocupado', 'La habitación ha sido desocupada correctamente');
        }
      } else {
        generalNotify('error-general');
      }
    },
    error: function (error) { },
  });
}

function cambiarEstadoHabitacion(elemento, estado, habitacion_id, data) {
  const card = elemento.closest(".card");
  card.classList.remove(
    "border-success",
    "text-success",
    "border-danger",
    "text-danger",
    "border-warning",
    "text-warning"
  );
  const estadoText = card.querySelector("p");
  const dropdownMenu = $(elemento).closest(".dropdown").find(".dropdown-menu");
  const rentaInfoContainer = card.querySelector(".infoRenta");

  switch (estado) {
    case "libre":
      card.classList.add("border-success", "text-success");
      estadoText.textContent = "Estado: Libre";
      dropdownMenu.html(`
        <li>
          <a class="dropdown-item text-secondary" style="cursor: pointer;"
              onclick="rentar(this, '${habitacion_id}')">
              Rentar
          </a>
          <a class="dropdown-item text-secondary" style="cursor: pointer;"
              onclick="reservar(this, '${habitacion_id}')">
              Reservar
          </a>
        </li>`);
      rentaInfoContainer.innerHTML = "";
      break;
    case "no_disponible":
      card.classList.add("border-secondary", "text-secondary");
      estadoText.textContent = "Estado: No Disponible";
      rentaInfoContainer.innerHTML = "";
      break;
    case "ocupada":
      card.classList.add("border-danger", "text-danger");
      estadoText.textContent = "Estado: Ocupada";
      dropdownMenu.html(`
          <li>
            <a class="dropdown-item text-secondary" style="cursor: pointer;"
                onclick="desocupar(this, '${habitacion_id}','rentas','${data.renta_id}')">
                Liberar
            </a>
          </li>
        `);
      const rentaInfo = `
          <button class="btn btn-outline-primary btn-sm mb-3" type="button" data-bs-toggle="collapse"
            data-bs-target="#rentaInfo${habitacion_id}" aria-expanded="false"
            aria-controls="rentaInfo${habitacion_id}">
            Ver Detalles de Renta
          </button>
          <div class="collapse" id="rentaInfo${habitacion_id}">
            <div class="bg-light p-3 rounded border">
              <p><strong>Tipo:</strong> <span class="text-primary">${data.tipoRenta === 1 ? "Por Horas" : "Por Noche"
        }</span></p>

              ${data.tipoRenta === 1
          ? `
                  <p><strong>Fin:</strong> ${data.fechaInicio}</p>
                  `
          : `
                   <p><strong>Huésped:</strong> ${data.nombreHuesped}</p>
                  <p><strong>Teléfono:</strong> ${data.telefonoHuesped}</p>
                  <p><strong>Noches:</strong> ${data.numNoches}</p>
                  <p><strong>Fin:</strong> ${data.fechaInicio}</p>
                  `
        }
              <p><strong>Observaciones:</strong> ${data.observaciones || "Ninguna"
        }</p>
            </div>
          </div>`;
      rentaInfoContainer.innerHTML = rentaInfo;
      break;
    case "reservada":
      card.classList.add("border-warning", "text-warning");
      estadoText.textContent = "Estado: Reservada";
      dropdownMenu.html(`
        <li>
          <a class="dropdown-item text-secondary" style="cursor: pointer;"
              onclick="cancelarReservacion(this, '${habitacion_id}','reservaciones','${data.reservacion_id}')">
              Liberar
          </a>
        </li>
      `);
      const reservacionInfo = `
          <button class="btn btn-outline-primary btn-sm mb-3" type="button" data-bs-toggle="collapse"
            data-bs-target="#rentaInfo${habitacion_id}" aria-expanded="false"
            aria-controls="rentaInfo${habitacion_id}">
            Ver Detalles de Renta
          </button>
          <div class="collapse" id="rentaInfo${habitacion_id}">
            <div class="bg-light p-3 rounded border">
              <p><strong>Tipo:</strong> <span class="text-primary">${data.tipoRenta === 1 ? "Por Horas" : "Por Noche"
        }</span></p>

              ${data.tipoRenta === 1
          ? `
                  <p><strong>Fin:</strong> ${data.fechaInicio}</p>
                  `
          : `
                   <p><strong>Huésped:</strong> ${data.nombreHuesped}</p>
                  <p><strong>Teléfono:</strong> ${data.telefonoHuesped}</p>
                  <p><strong>Noches:</strong> ${data.numNoches}</p>
                  <p><strong>Fin:</strong> ${data.fechaInicio}</p>
                  `
        }
              <p><strong>Observaciones:</strong> ${data.observaciones || "Ninguna"
        }</p>
            </div>
          </div>`;
      rentaInfoContainer.innerHTML = reservacionInfo;
      break;
    default:
      estadoText.textContent = "Estado: Desconocido";
      rentaInfoContainer.innerHTML = "";
      break;
  }
}

function reservar(element, habitacion_id) {
  const guardarReservacionBtn = document.getElementById("guardarReservacion");
  guardarReservacionBtn.onclick = () =>
    guardarReservacion(habitacion_id, element);
  const precioHabitacionTexto = element
    .closest(".card")
    .querySelector(".precio-habitacion").textContent;
  const precioHabitacion = parseFloat(
    precioHabitacionTexto
      .replace("Precio por Noche: $", "")
      .replace(",", "")
      .trim()
  );
  document.getElementById("precioHabitacionR").value = precioHabitacion;
  const numHabitacion = element
    .closest(".card")
    .querySelector(".card-title")
    .textContent.split(": ")[1];
  document.getElementById("numHabitacionR").textContent = numHabitacion;
  calcularTotalReservacion();
  const modal = new bootstrap.Modal(
    document.getElementById("modalReservacion")
  );
  modal.show();
}

document
  .getElementById("numNochesR")
  .addEventListener("input", calcularTotalReservacion);

function calcularTotalReservacion() {
  var precioHabitacion = document.getElementById("precioHabitacionR").value;
  let total = 0;
  const numNoches = parseInt(
    document.getElementById("numNochesR").value || 0,
    10
  );
  total = precioHabitacion * numNoches;
  document.getElementById("totalReservacionR").innerHTML = `$${total.toFixed(
    2
  )}`;
}

function guardarReservacion(habitacion_id, elemento) {
  const numHabitacion = document.getElementById("numHabitacionR").textContent;
  const nombreHuesped = document.getElementById("nombreHuespedR").value || null;
  const correoHuesped = document.getElementById("correoHuespedR").value || null;
  const telefonoHuesped =
    document.getElementById("telefonoHuespedR").value || null;
  const numNoches = document.getElementById("numNochesR").value || null;
  const fechaInicio = document.getElementById("fechaInicioR").value;
  const fechaFin = document.getElementById("fechaFinR").value || null;
  const observaciones = document.getElementById("observacionesR").value;
  const total = parseFloat(
    document.getElementById("totalReservacionR").textContent.replace("$", "")
  );

  if (!fechaInicio || (!fechaFin && tipoRenta === "horas")) {
    generalNotify('personalizada', 'warning', 'Campos necesarios', 'Es necesario completar todos los campos');
    return;
  }
  const reservacion = {
    habitacion_id,
    numHabitacion,
    nombreHuesped,
    correoHuesped,
    telefonoHuesped,
    numNoches,
    fechaInicio,
    fechaFin,
    observaciones,
    total,
  };
  $.ajax({
    url: base_url + "reservaciones/reservar",
    type: "POST",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({ data: reservacion }),
    success: function (response) {
      if (response.status === "success") {
        var estado = "reservada";
        reservacion.reservacion_id = response.reservacion_id;
        cambiarEstadoHabitacion(elemento, estado, habitacion_id, reservacion);
        actualizarTablaEstados();
        $("#modalReservacion").modal("hide");
        generalNotify('personalizada', 'success', 'Reservación guardada', 'La reservación ha sido guardada correctamente');
      } else {
      }
    },
    error: function (error) { },
  });
}

function cancelarReservacion(elemento, habitacion_id, tipo, tipo_id) {
  let numHabitacion = $(elemento).closest(".card").find(".card-title").text().replace("Habitación Número: ", "").trim();
  $("#numHabitacionC").text(numHabitacion);
  $("#confirmarCancelacion")
    .data("habitacion", habitacion_id)
    .data("tipo", tipo)
    .data("tipo_id", tipo_id)
    .data("elemento", elemento);

  $("#modalCancelarReservacion").modal("show");
}

$(document).on("click", "#confirmarCancelacion", function () {
  let habitacion_id = $(this).data("habitacion");
  let tipo = $(this).data("tipo");
  let tipo_id = $(this).data("tipo_id");
  let elemento = $(this).data("elemento");
  let motivo = $("#motivoCancelacion").val().trim();

  if (motivo === "") {
    generalNotify('personalizada', 'warning', 'Campos necesarios', 'Es necesario completar todos los campos');
    return;
  }

  $.ajax({
    url: base_url + "reservaciones/cancelacion",
    type: "POST",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({
      habitacion_id: habitacion_id,
      motivo: motivo,
      reservacion_id: tipo_id
    }),
    success: function (response) {
      if (response.status == "success") {
        desocupar(elemento, habitacion_id, tipo, tipo_id);
        $("#modalCancelarReservacion").modal("hide");
        generalNotify('personalizada', 'success', 'Reservación cancelada', 'La reservación ha sido cancelada sin problemas.');
      } else {
        alert("Hubo un error al cancelar la reservación.");
        generalNotify('personalizada', 'warning', 'Problema al cancelar', 'Ha ocurrido un problema al cancelar la reservacion, puedes interntarlo mas tarde.');
      }
    },
    error: function (error) {
      generalNotify('error-general');
    }
  });
});


function rentarReservacion(element, habitacion_id, reservacion_id) {
  const guardarRentaBtn = document.getElementById("guardarRenta");
  guardarRentaBtn.onclick = () => guardarRentaReservacion(habitacion_id, element, reservacion_id);
  const precioHabitacionTexto = element
    .closest(".card")
    .querySelector(".precio-habitacion").textContent;
  const precioHabitacion = parseFloat(
    precioHabitacionTexto
      .replace("Precio por Noche: $", "")
      .replace(",", "")
      .trim()
  );
  document.getElementById("precioHabitacionModal").value = precioHabitacion;
  const numHabitacion = element
    .closest(".card")
    .querySelector(".card-title")
    .textContent.split(": ")[1];
  document.getElementById("numHabitacion").textContent = numHabitacion;
  const modal = new bootstrap.Modal(document.getElementById("modalRentar"));
  modal.show();
  document.getElementById("tipoRenta").value = "horas";
  cambiarTipoRenta();
}

function guardarRentaReservacion(habitacion_id, elemento, reservacion_id) {
  const tipoRenta = document.getElementById("tipoRenta").value;
  const numHabitacion = document.getElementById("numHabitacion").textContent;
  const nombreHuesped = document.getElementById("nombreHuesped").value || null;
  const correoHuesped = document.getElementById("correoHuesped").value || null;
  const telefonoHuesped =
    document.getElementById("telefonoHuesped").value || null;
  const numNoches = document.getElementById("numNoches").value || null;
  const fechaInicio = document.getElementById("fechaInicio").value;
  const fechaFin = document.getElementById("fechaFin").value || null;
  const observaciones = document.getElementById("observaciones").value;
  const total = parseFloat(
    document.getElementById("totalRenta").textContent.replace("$", "").trim()
  );

  if (!fechaInicio || (!fechaFin && tipoRenta === "horas")) {
    generalNotify('personalizada', 'warning', 'Campos necesarios', 'Es necesario completar todos los campos');
    return;
  }
  const renta = {
    habitacion_id,
    tipoRenta,
    numHabitacion,
    nombreHuesped,
    correoHuesped,
    telefonoHuesped,
    numNoches,
    fechaInicio,
    fechaFin,
    observaciones,
    total,
    reservacion_id
  };

  console.log(renta);

  $.ajax({
    url: base_url + "rentas/rentarHabitacion",
    type: "POST",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({ data: renta }),
    success: function (response) {
      if (response.status === "success") {
        var estado = "ocupada";
        data_response = response.data;
        renta.renta_id = data_response.renta_id;
        cambiarEstadoHabitacion(elemento, estado, habitacion_id, renta);
        actualizarTablaEstados();
        $("#modalRentar").modal("hide");
        generalNotify('personalizada', 'success', 'Se ha rentado', 'La habitación ha sido rentada correctamente');
      } else {
        generalNotify('general-error');
      }
    },
    error: function (error) { },
  });
}