<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="need.css">
</head>
</html>
<style>
        /* Modal styles */
        .modal-content {
        background-color: #f8f9fc; /* Background color */
        border-radius: 10px; /* Rounded corners */
    }

    .modal-header {
        border-bottom: none; /* Remove border at the bottom of the header */
        padding: 15px 20px; /* Add padding */
        background-color: #EB3223; /* Header background color */
        color: #fff; /* Header text color */
        border-radius: 10px 10px 0 0; /* Rounded corners only at the top */
    }

    .modal-body {
        padding: 20px; /* Add padding */
    }

    .modal-footer {
        border-top: none; /* Remove border at the top of the footer */
        padding: 15px 20px; /* Add padding */
        background-color: #f8f9fc; /* Footer background color */
        border-radius: 0 0 10px 10px; /* Rounded corners only at the bottom */
    }

    /* Close button style */
    .modal-header .close {
        display: none;
    }

    .modal-body label {
        color: #304B1B;
        font-weight: bold;
    }
    
    </style>
<?php
function getStatusColor($expiryDate)
{
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
?>

<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h1>Archive</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");

                // Update stocks_available based on the sum of quantities for each product
                $update_query = "UPDATE archive_list a
                                 JOIN (
                                     SELECT product_name, SUM(quantity) as total_quantity
                                     FROM archive_list
                                     GROUP BY product_name
                                 ) t ON a.product_name = t.product_name
                                 SET a.stocks_available = t.total_quantity";
                mysqli_query($connection, $update_query);

                // Fetch updated data
                $query = "SELECT archive_list.id, 
                                 archive_list.sku,   
                                 archive_list.product_name,
                                 archive_list.descript, 
                                 archive_list.expiry_date, 
                                 archive_list.quantity, 
                                 archive_list.stocks_available, 
                                 archive_list.price, 
                                 archive_list.branch, 
                                 product_list.measurement
                          FROM archive_list
                          JOIN product_list ON archive_list.product_name = product_list.prod_name";

                $query_run = mysqli_query($connection, $query);
                ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        
                        <th>Price</th>
                        <th>Branch</th>
                        <th>Expiry Date</th>
                        <th>Permanently Delete</th>
                        <th>Restore Data</th>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['sku']; ?></td>
                                    <td>
                                        <?php echo $row['product_name']; ?> -
                                        <span style='font-size: 80%;'>
                                            <?php echo $row['measurement']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $row['descript']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['branch']; ?></td>
                                    <td style='color: <?php echo getStatusColor($row['expiry_date']); ?>;'> 
                                        <?php 
                                            echo $row['expiry_date']; 
                                            // Add Font Awesome icons based on expiration status
                                            if (getStatusColor($row['expiry_date']) == 'red') {
                                                echo ' <i class="fas fa-exclamation-circle" style="color: red;"></i>';
                                            } elseif (getStatusColor($row['expiry_date']) == 'orange') {
                                                echo ' <i class="fas fa-exclamation-triangle" style="color: orange;"></i>';
                                            } elseif (getStatusColor($row['expiry_date']) == 'green') {
                                                echo ' <i class="fas fa-check-circle" style="color: green;"></i>';
                                            }
                                        ?>
                                    </td>     
                                    <td>
                                        <form action="code.php" method="POST">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="permanent_delete_btn" class="btn btn-danger">DELETE</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="code.php" method="POST">
                                            <input type="hidden" name="restore_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="restore_btn" class="btn btn-danger">Restore</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='8'>No records found</td></tr>";
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
    
