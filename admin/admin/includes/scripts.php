<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Other scripts you have in your scripts.php file -->
<!-- Core plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages -->
<script src="js/sb-admin-2.min.js"></script>
<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>
<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>

<!-- Add these links to include Bootstrap DateTimePicker CSS and JS files -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>



<script>
// Update the notification badge count in the header
document.addEventListener('DOMContentLoaded', function () {
    const expiringSoonCount = <?php echo $expiring_soon_count + $expiring_soon_buffer_count; ?>;
    const expiredCount = <?php echo $expired_count; ?>; // Add this line for expired products
    const badgeCounter = document.querySelector('.badge-counter');

    if (badgeCounter) {
        const totalCount = expiringSoonCount + expiredCount;
        badgeCounter.innerHTML = totalCount > 0 ? totalCount : '';
    }
});
</script>











