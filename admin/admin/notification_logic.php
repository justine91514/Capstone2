<?php
$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");

// Query to get the expiring soon count
$expiring_soon_query = "SELECT COUNT(*) as expiring_soon_count FROM add_stock_list WHERE expiry_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY";
$expiring_soon_result = mysqli_query($connection, $expiring_soon_query);
$expiring_soon_count = 0;

if ($expiring_soon_result) {
    $expiring_soon_row = mysqli_fetch_assoc($expiring_soon_result);
    $expiring_soon_count = $expiring_soon_row['expiring_soon_count'];
}
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const expiringSoonCount = <?php echo $expiring_soon_count; ?>;
    const expiringSoonLink = document.getElementById('expiringSoonLink');
    const expiringSoonMessage = document.getElementById('expiringSoonMessage');
    
    if (expiringSoonLink && expiringSoonMessage) {
        expiringSoonLink.addEventListener('click', function () {
            // Redirect to add_stocks.php when the "Expiring Soon" link is clicked
            window.location.href = expiringSoonCount > 0 ? 'add_stocks.php' : '#';
        });

        // Update the expiring soon message
        expiringSoonMessage.innerHTML = expiringSoonCount > 0
            ? `There are (${expiringSoonCount}) product(s) that will expire soon`
            : 'NONE';
    }

    // Update the notification badge count in the header
    const badgeCounter = document.getElementById('expiringSoonCount');
    if (badgeCounter) {
        badgeCounter.innerHTML = expiringSoonCount > 0 ? expiringSoonCount : '';
    }
});
</script>

