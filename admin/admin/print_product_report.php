<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Report</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="stylecode.css">
    <style>
.dataTables_wrapper {
    margin-top: 25px !important; /* Adjust the value as needed */
}

.container-fluid {
        margin-top: 50px; /* Adjust the value as needed */
    }
</style>
</head>
<body>

<?php
session_start();
include('includes/header.php');
include('includes/navbar2.php');
include("dbconfig.php");

// Your PHP code for database queries and other functionality goes here
?>

<div class="container-fluid">
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h1>Product Report</h1>
        </div>
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-primary">
            <button type="button" class="btn btn-primary" onclick="generatePrintableReport()" style="background-color: #259E9E; border: none; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
    <i class="fas fa-print fa-lg"></i> <span style="font-weight: bold; text-transform: uppercase;">Print Table</span>
</button>
            </h6>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead style="background-color: #259E9E; color: white;">
    <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Type</th>
        <th>Measurement</th>
        <th>Stocks Available</th>
        <th>Prescription</th>
        <th>Has Discount</th>
    </tr>
</thead>
<tbody>
    <?php
    $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
    $query = "SELECT * FROM product_list";
    $query_run = mysqli_query($connection, $query);
    if(mysqli_num_rows($query_run) > 0) {
        while($row = mysqli_fetch_assoc($query_run)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['prod_name'] . "</td>";
            echo "<td>" . $row['categories'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['measurement'] . "</td>";
            echo "<td>" . $row['stocks_available'] . "</td>";
            echo "<td>" . ($row['prescription'] == 1 ? 'Yes' : 'No') . "</td>";
            echo "<td>" . ($row['discounted'] == 1 ? 'Yes' : 'No') . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }
    ?>
</tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals and other HTML elements -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>


<!-- DataTables JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
        "lengthChange": true,
        "pageLength": 10, // Display 10 entries per page
        "searching": true,
        "ordering": true, // Enable ordering/sorting
        "info": true,
        "autoWidth": false,
        "language": {
            "paginate": {
                "previous": "<i class='fas fa-arrow-left'></i>", // Use arrow-left icon for previous button
                "next": "<i class='fas fa-arrow-right'></i>" // Use arrow-right icon for next button
            }
        },
        "pagingType": "simple", // Set the pagination type to simple
        "order": [[0, "desc"]] // Sort by the first column (ID) in descending order
        });
    });

function generatePrintableReport() {
    window.location.href = 'printable_product_report.php';
}

</script>

</body>
</html>
