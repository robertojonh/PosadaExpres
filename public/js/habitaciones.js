function nuevaHabitacion() {
  $("#modalNuevaHabitacion").modal("show");
}

function guardarHabitacion() {
  const numeroHabitacion = $("#numeroHabitacion").val();
  const numeroCamas = $("#numeroCamas").val();
  const precioNoche = $("#precioNoche").val();
  const observaciones = $("#observaciones").val();

  if (!numeroHabitacion || !numeroCamas || !precioNoche) {
    showNotification(
      "custom",
      "warning",
      "Datos incompletos",
      "Es necesario completar todos los campos"
    );
    return;
  }

  $.ajax({
    url: base_url + "habitaciones/guardarHabitacion",
    type: "POST",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({
      numeroHabitacion: numeroHabitacion,
      numeroCamas: numeroCamas,
      precioNoche: precioNoche,
      observaciones: observaciones,
    }),
    success: function (response) {
      if (response.status) {
        const habitacionId = response.habitacion_id;
        const nuevoCard = `
                <div class="col foto">
                    <div class="card shadow-sm h-100 border-success text-success" style="border-width: 2px;">
                        <div class="card-body position-relative">
                            <h5 class="card-title text-center">Habitación Número: ${numeroHabitacion}</h5>
                            <p class="text-center fw-bold">
                                Estado: Libre
                            </p>
                            <div class="dropdown position-absolute bottom-0 end-0 me-2 mb-2">
                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                    id="dropdownMenuButton${habitacionId}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-list-ul"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="dropdownMenuButton${habitacionId}">
                                    <li>
                                        <a class="dropdown-item text-secondary" style="cursor: pointer;"
                                            onclick="cambiarDisponibilidad(this, '${habitacionId}','libre')">
                                            Desocupada
                                        </a>
                                        <a class="dropdown-item text-secondary" style="cursor: pointer;"
                                            onclick="cambiarDisponibilidad(this, '${habitacionId}','no_disponible')">
                                            No disponible
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col foto" data-habitacion-id="${habitacionId}">
                                <textarea name="descripcion_img" placeholder="Escriba una breve descripción"
                                    class="form-control form-control-sm mb-3 border-1 rounded-2" rows="4"
                                    style="resize: none;" data-original-value="${observaciones}"
                                    onblur="cambiarDescripcion(this, '${habitacionId}')">${observaciones}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        $("#row").append(nuevoCard);
        showNotification("success");
        $("#modalNuevaHabitacion").modal("hide");
      }
    },
    error: function (error) {
      console.error("Error al guardar la habitación:", error);
    },
  });
}

function cambiarDisponibilidad(elemento, habitacion_id, estado) {
  $.ajax({
    url: base_url + "habitaciones/cambiarDisponibilidad",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      habitacion_id: habitacion_id,
      estado: estado,
    }),
    success: function (response) {
      if (response.status === "success") {
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
        switch (estado) {
          case "libre":
            card.classList.add("border-success", "text-success");
            estadoText.textContent = "Estado: Libre";
            break;
          case "no_disponible":
            card.classList.add("border-secondary", "text-secondary");
            estadoText.textContent = "Estado: No Disponible";
            break;
          case "ocupada":
            card.classList.add("border-danger", "text-danger");
            estadoText.textContent = "Estado: Ocupada";
            break;
          case "reservada":
            card.classList.add("border-warning", "text-warning");
            estadoText.textContent = "Estado: Reservada";
            break;
          default:
            estadoText.textContent = "Estado: Desconocido";
            break;
        }
      } else {
        alert("No se pudo cambiar la disponibilidad.");
      }
    },
    error: function (error) {
      console.error("Error al cambiar la disponibilidad:", error);
    },
  });
}

function cambiarDescripcion(elemento, habitacion_id) {
  var textarea = $(elemento);
  var originalValue = textarea.data("original-value");
  var currentValue = textarea.val();

  if (currentValue !== originalValue) {
    $.ajax({
      url: base_url + "habitaciones/cambiarObservacion",
      type: "POST",
      dataType: "JSON",
      contentType: "application/json",
      data: JSON.stringify({
        habitacion_id: habitacion_id,
        observacion: currentValue,
      }),
      success: function (response) {
        if (response.status === "success") {
          showNotification("success");
          textarea.data("original-value", currentValue);
        }
      },
      error: function (resp) {},
    });
  }
}

function borrarHabitacion(elemento, habitacion_id) {
  if (confirm("¿Estás seguro de que deseas borrar esta habitación?")) {
    $.ajax({
      url: base_url + "habitaciones/borrarHabitacion",
      type: "POST",
      dataType: "json",
      contentType: "application/json",
      data: JSON.stringify({ habitacion_id: habitacion_id }),
      success: function (response) {
        if (response.status === "success") {
          const card = elemento.closest(".col.foto");
          if (card) {
            card.remove();
          }
          showNotification("success_delete");
        } else {
        }
      },
      error: function (error) {},
    });
  }
}

function showNotification(type, status = null, titulo = null, mensaje = null) {
  let notificationConfig = {
    effect: "slide",
    speed: 300,
    customClass: "",
    customIcon: "",
    showIcon: true,
    showCloseButton: false,
    autoclose: true,
    autotimeout: 3000,
    notificationsGap: null,
    notificationsPadding: null,
    type: "outline",
    position: "right bottom",
    customWrapper: "",
  };
  switch (type) {
    case "success":
      notificationConfig.status = "success";
      notificationConfig.title = "Se ha guardado correctamente";
      notificationConfig.text = "Habitacion guardada correctamente";
      break;
    case "custom":
      notificationConfig.status = status;
      notificationConfig.title = titulo;
      notificationConfig.text = mensaje;
      notificationConfig.speed = 500;
      break;
    case "success_delete":
      notificationConfig.status = "success";
      notificationConfig.title = "Se ha borrado la habitacion";
      notificationConfig.text = "Habitacion borrada correctamente";
      break;
    default:
      console.error("Tipo de notificación no reconocida");
      return;
  }
  new Notify(notificationConfig);
}
