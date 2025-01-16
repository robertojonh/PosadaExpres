<script src="<?= base_url() ?>/public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/public/jquery/js/jquery.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="<?= base_url() ?>/public/tabulator/js/tabulator.min.js"></script>
<script src="<?= base_url() ?>/public/font-awesome/js/all.min.js"></script>
<script>
    const pusher = new Pusher("a88403b3e52c3753b043", {
        cluster: "us2",
        encrypted: true,
    });
    var user_id = "<?= auth_id() ?>";
    var base_url = "<?= base_url() ?>";
    function formatDate(dateString, format) {
        const date = new Date(dateString);
        if (isNaN(date)) return "Fecha inválida";

        const day = String(date.getDate()).padStart(2, "0");
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, "0");
        const minutes = String(date.getMinutes()).padStart(2, "0");

        switch (format) {
            case 1:
                return `${day}/${month}/${year}`;
            case 2:
                return `${month}-${day}-${year}`;
            case 3:
                return `${year}/${month}/${day}`;
            case 4:
                return `${day}/${month}/${year} a las ${hours}:${minutes}`;
            default:
                return date.toLocaleDateString();
        }
    }
</script>
</body>

</html>