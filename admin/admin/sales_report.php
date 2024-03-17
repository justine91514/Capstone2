<?php
session_start();
include('includes/header.php');
include('includes/navbar2.php');

// Initialize variables
$total_earnings = 0;
$earnings_by_date = [];

// Check if the form is submitted and dates are set
if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
    // Get the selected dates
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    
    // Establish connection to the database
    $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");

    // Get all dates within the selected range
    $current_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));
    
    while ($current_date <= $end_date) {
        // Query to get earnings for each date
        $query = "SELECT SUM(total_amount) AS earnings FROM transaction_list WHERE date = '$current_date'";
        $query_run = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($query_run);
        $earnings = $row['earnings'] ?? 0;
        
        // Store earnings for each date
        $earnings_by_date[$current_date] = $earnings;
        
        // Increment total earnings
        $total_earnings += $earnings;
        
        // Move to the next date
        $current_date = date('Y-m-d', strtotime($current_date . ' + 1 day'));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks</title>
</head>
<body>

<div class="container-fluid">
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Compute Earnings</h6>
        </div>
        <div class="card-body">
            <form method="GET">
                <label for="start_date">From:</label>
                <input type="date" id="start_date" name="start_date">
                <label for="end_date">To:</label>
                <input type="date" id="end_date" name="end_date">
                <input type="submit" value="Compute">
            </form>
            
            <!-- Display total earnings and earnings by date in a table format -->
            <?php if(isset($total_earnings)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($earnings_by_date as $date => $earnings) { ?>
                            <tr>
                                <td><?php echo $date; ?></td>
                                <td>$<?php echo $earnings; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Total</td>
                            <td>$<?php echo $total_earnings; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php } ?>
            
            <!-- Your table goes here -->
        </div>
    </div>
</div>

</body>
</html>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
