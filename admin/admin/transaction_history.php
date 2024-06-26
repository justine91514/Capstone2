<?php
function generateTransactionNo($date, $count) {
    // Separate the year, month, and day from the date
    $year = substr($date, 0, 2);
    $month = substr($date, 2, 2);
    $day = substr($date, 4, 2);

    // Get the current date
    $current_date = date('ymd');

    // Separate the current year, month, and day
    $current_year = substr($current_date, 0, 2);
    $current_month = substr($current_date, 2, 2);
    $current_day = substr($current_date, 4, 2);

    // If the current date is different from the provided date, reset the count to 1
    if ($current_date != $date) {
        $count = 1;
    }

    // Generate the transaction number with padded count
    return $year . $month . $day . str_pad($count, 3, '0', STR_PAD_LEFT); // Format: YYMMDDXXX
}
session_start();
include('includes/header.php');
include('includes/navbar2.php');
date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
</head>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" href="ack.css">
<style>
    .container-fluid {
        margin-top: 100px; /* Adjust the value as needed */
    }
    .dataTables_wrapper {
    margin-top: 20px !important; /* Adjust the value as needed */
}
    </style>
</html>
<div class="container-fluid">
    <div class="card shadow nb-4">
        <div class="card-header py-3">
        <h1>Transaction History</h1>
            <h6 class="m-0 font-weight-bold text-primary">
                
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                $connection = mysqli_connect("localhost","root","","dbpharmacy");
                $query = "SELECT transaction_id, date, CONCAT(DATE_FORMAT(time, '%h:%i:%s'), DATE_FORMAT(NOW(), '%p')) AS time_with_am_pm, transaction_no, mode_of_payment, ref_no, list_of_items, sub_total, total_amount, cashier_name FROM transaction_list";
                $query_run = mysqli_query($connection, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead style="background-color: #304B1B; color: white;">
                        <th> Transaction no. </th>
                        <th> Date </th>
                        <th> Time </th>
                        <th> Mode of Payment </th>
                        <th> Reference# </th>
                        <th> List of Items </th>
                        <th> Sub Total </th>
                        <th> Grand Total </th>
                        <th> Cashier Name </th>
                        <th> Reissue of Reciept </th>

                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query_run) > 0)
                        {
                            $previous_date = ''; // Initialize variable to store the previous date
                            $count = 1; // Initialize a counter for sequential transaction numbers
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                $current_date = date('ymd'); // Current date in YYMMDD format
                                $transaction_no = ''; // Initialize transaction number
                                
                                if ($current_date != $previous_date) {
                                    $count = 1; // Reset the counter for the new date
                                }
                                
                                // Format the transaction number: YYMMDDXXX
                                $transaction_no = date('ymd') . str_pad($count, 3, '0', STR_PAD_LEFT);
                                
                                $previous_date = $current_date; // Update previous date for the next iteration

                                ?>    
                                <tr>
                                    <td> <?php echo $row['transaction_no']; ?></td>
                                    <td> <?php echo $row['date']; ?></td>
                                    <td> <?php echo $row['time_with_am_pm']; ?></td>
                                    <td> <?php echo $row['mode_of_payment']; ?></td>
                                    <td> <?php echo $row['ref_no']; ?></td>
                                    <td> <?php echo $row['list_of_items']; ?></td>
                                    <td> <?php echo $row['sub_total']; ?></td>     
                                    <td> <?php echo $row['total_amount']; ?></td>  
                                    <td> <?php echo $row['cashier_name']; ?></td>     
                                    <td> 
                                        <form action="print_product.php" method="post">
                                            <input type="hidden" name= print_id>
                                            <button type="submit" name="print_btn" class="btn btn-action" style="border: none; background: none;">
                                            <i class="fas fa-print" style="color: #0000FF;"></i>
                                        </button>
                                        </form>
                                    </td>
                    </tr>
                                <?php
                                $count++; // Increment the counter for the next transaction
                            }
                        }
                        else{
                            echo "No record Found";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="index.php">Logout</a>
        </div>
    </div>
</div>
</div>


    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
    </script>
    </html>

    <script>
    var ascending = true;

    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("dataTable");
        switching = true;
        var icon = document.getElementById("sortIcon");
        if (ascending) {
            icon.classList.remove("fa-sort");
            icon.classList.add("fa-sort-up");
        } else {
            icon.classList.remove("fa-sort-up");
            icon.classList.add("fa-sort-down");
        }
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[columnIndex];
                y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
                if (ascending) {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
        ascending = !ascending;
    }
</script>
        <!-- DataTables JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "pageLength": 10, // Display 10 entries per page
            "searching": true,
            "ordering": false, // Disable ordering/sorting
            "info": true,
            "autoWidth": false,
            "language": {
                "paginate": {
                    "previous": "<i class='fas fa-arrow-left'></i>", // Use arrow-left icon for previous button
                    "next": "<i class='fas fa-arrow-right'></i>" // Use arrow-right icon for next button
                }
            },
            "pagingType": "simple" // Set the pagination type to simple
        });
    });
</script>
