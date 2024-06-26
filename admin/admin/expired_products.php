<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expired Products</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="ack.css">
</head>
<style>
    .dataTables_wrapper {
    margin-top: 20px !important; /* Adjust the value as needed */
}
.container-fluid {
        margin-top: 100px; /* Adjust the value as needed */
    }
    </style>
</html>

<?php
function getStatusColor($productName, $expiryDate)
{
    $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");

    // Check if the product is in the expired_list table
    $check_expired_query = "SELECT COUNT(*) as count FROM expired_list WHERE product_name = '$productName'";
    $check_expired_result = mysqli_query($connection, $check_expired_query);

    if ($check_expired_result) {
        $check_expired_row = mysqli_fetch_assoc($check_expired_result);

        if ($check_expired_row['count'] > 0) {
            // Product is in expired_list, set color to red
            return 'red';
        }
    }

    // Product is not in expired_list, continue with the original logic
    $currentDate = date('Y-m-d');
    $expiryDateObj = new DateTime($expiryDate);
    $currentDateObj = new DateTime($currentDate);

    if ($expiryDateObj < $currentDateObj) {
        // Expired (red)
        return 'red';
    } else {
        $daysDifference = $currentDateObj->diff($expiryDateObj)->days;

        if ($daysDifference <= 7) {
            // Expiring within a week (orange)
            return 'orange';
        } else {
            // Still valid (green)
            return 'green';
        }
    }
}


?>
<?php
session_start();
include('includes/header.php');
include('includes/navbar2.php');
include('notification_logic2.php');
?>

<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h1>Expired Products</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
                
                // Fetch data from the database
                $query = "SELECT expired_list.*, product_list.measurement 
                          FROM expired_list
                          JOIN product_list ON expired_list.product_name = product_list.prod_name";
                $result = mysqli_query($connection, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead style="background-color: #EB3223; color: white;">
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Product Name <button class="btn btn-link btn-sm" onclick="sortTable(1)"><i id="sortIcon" class="fas fa-sort" style="color: white;"></i></button></th>
                        <th>Description</th>
                        <th>Quantity</th>
                        
                        <th>Price</th>
                        <th>Expiry Date</th>
                        <th>Permanently Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['sku']; ?></td>
                                <td>
                                    <?php 
                                    echo $row['product_name']; 
                                    if(isset($row['measurement'])) {
                                        echo ' - <span style="font-size: 80%;">' . $row['measurement'] . '</span>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['descript']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                
                                <td><?php echo $row['price']; ?></td>
                                <td style='color: <?php echo getStatusColor($row['product_stock_name'], $row['expiry_date']); ?>;'> 
    <?php 
        $expiryDate = new DateTime($row['expiry_date']);

        // Add one day if the product is in the expired_list table
        if (getStatusColor($row['product_name'], $row['expiry_date']) == 'red') {
            $expiryDate->modify('+1 day');
        }

        $formattedDate = $expiryDate->format('Y-m-d');

        // Apply red color to the entire date text
        echo '<span style="color: red;">' . $formattedDate . '</span>';

        // Add Font Awesome icons based on expiration status
        if (getStatusColor($row['product_name'], $row['expiry_date']) == 'red') {
            echo ' <i class="fas fa-exclamation-circle" style="color: red;"></i>';
        } elseif (getStatusColor($row['product_name'], $row['expiry_date']) == 'orange') {
            echo ' <i class="fas fa-exclamation-triangle" style="color: orange;"></i>';
        } elseif (getStatusColor($row['product_name'], $row['expiry_date']) == 'green') {
            echo ' <i class="fas fa-check-circle" style="color: green;"></i>';
        }
    ?>
</td>


                                <td>
                                    <form action="code.php" method="POST">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="permanent_delete_expired_btn" class="btn btn-action" style="border: none; background: none;">
                                        <i class="fas fa-trash-alt" style="color: #FF0000;"></i>
                                    </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
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
