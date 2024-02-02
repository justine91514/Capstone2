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
    const expiringSoonCount = <?php echo $expiring_soon_count; ?>;
    const badgeCounter = document.querySelector('.badge-counter');

    if (badgeCounter) {
        badgeCounter.innerHTML = expiringSoonCount > 0 ? expiringSoonCount : '';
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Update the notification badge count in the header
    const expiringSoonCount = <?php echo $expiring_soon_count; ?>;
    const badgeCounter = document.querySelector('.badge-counter');

    if (badgeCounter) {
        badgeCounter.innerHTML = expiringSoonCount > 0 ? expiringSoonCount : '';
    }

    // Notify for each product expiring soon
    <?php
    $expiring_soon_result = mysqli_query($connection, $expiring_soon_query);
    while ($expiring_product = mysqli_fetch_assoc($expiring_soon_result)) {
        $expiring_date = date('F j, Y', strtotime($expiring_product['expiry_date']));
    ?>
        notifyExpiringProduct('<?php echo $expiring_date; ?>');
    <?php
    }
    ?>

    function notifyExpiringProduct(expiringDate) {
        // Add your logic here to show the notification
        console.log('Product expiring soon on ' + expiringDate);
        // Update the HTML content to display the expiring date dynamically
        const notificationContainer = document.getElementById('notification-container');
        
        if (notificationContainer) {
            const notificationElement = document.createElement('div');
            notificationElement.innerHTML = `
                <div>
                    <div class="small text-gray-500">${expiringDate}</div>
                    <span class="font-weight-bold">Expiring Soon:</span> Check medications with upcoming expiration dates.
                </div>
            `;
            notificationContainer.appendChild(notificationElement);
        }
    }

    // Display a message if no products are expiring soon
    if (expiringSoonCount === 0) {
        const notificationContainer = document.getElementById('notification-container');
        
        if (notificationContainer) {
            const notificationElement = document.createElement('div');
            notificationElement.innerHTML = `
                <div>
                    <span class="font-weight-bold">There are no expiring products in the inventory.</span>
                </div>
            `;
            notificationContainer.appendChild(notificationElement);
        }
    }
});
</script>

<script>
// Notify for each product expiring soon
document.addEventListener('DOMContentLoaded', function () {
    // ... (existing code)
});
</script>
