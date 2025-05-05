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
    const hoy = new Date().toISOString().split('T')[0];
</script>
</body>

</html>