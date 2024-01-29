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
                    <thead>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Stocks Available</th>
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
                                <td>
                                    <?php 
                                    echo $row['product_name']; 
                                    if(isset($row['measurement'])) {
                                        echo ' - <span style="font-size: 80%;">' . $row['measurement'] . '</span>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['stocks_available']; ?></td>
                                <td><?php echo $row['price']; ?></td>
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
                                        <button type="submit" name="permanent_delete_expired_btn" class="btn btn-danger">DELETE</button>
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

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
