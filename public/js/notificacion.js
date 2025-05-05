function generalNotify(type, status = null, title = null, text = null) {
    let notificationConfig = {
        effect: "slide",
        speed: 300,
        customClass: "",
        customIcon: "",
        showIcon: true,
        showCloseButton: false,
        autoclose: true,
        autotimeout: 5000,
        notificationsGap: null,
        notificationsPadding: null,
        type: "outline",
        position: "right bottom",
        customWrapper: "",
    };

    switch (type) {
        case "personalizada":
            notificationConfig.status = status;
            notificationConfig.title = title;
            notificationConfig.text = text;
            break;
        case "error-general":
            notificationConfig.autoclose = false;
            notificationConfig.showCloseButton = true;
            notificationConfig.status = "error";
            notificationConfig.title = "Ha ocurrido un problema";
            notificationConfig.text = "Ha ocurrido un error, por favor intentelo de nuevo o comuniquese con soporte.";
            break;
        default:
            return;
    }

    new Notify(notificationConfig);
}