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

$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
$query = "SELECT prod_name FROM product_list";
$query_run = mysqli_query($connection, $query);
$productNames = array();
while ($row = mysqli_fetch_assoc($query_run)) {
    $productNames[] = $row['prod_name'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedProduct = $_POST['buffer_stock_name'];
}
$expired_products_query = "SELECT * FROM buffer_stock_list WHERE expiry_date < CURDATE()";
$expired_products_result = mysqli_query($connection, $expired_products_query);

while ($expired_product = mysqli_fetch_assoc($expired_products_result)) {
    // Move expired product to expired_list
    $move_to_expired_query = "INSERT INTO expired_list (product_name, quantity, stocks_available, price, expiry_date)
                             VALUES ('{$expired_product['buffer_stock_name']}', '{$expired_product['quantity']}', '{$expired_product['buffer_stocks_available']}', '{$expired_product['price']}', '{$expired_product['expiry_date']}')";
    mysqli_query($connection, $move_to_expired_query);

    // Delete expired product from add_stock_list
    $delete_expired_query = "DELETE FROM buffer_stock_list WHERE id = {$expired_product['id']}";
    mysqli_query($connection, $delete_expired_query);
}
$update_stocks_query = "UPDATE buffer_stock_list a
                        JOIN (
                            SELECT buffer_stock_name, SUM(quantity) as total_quantity
                            FROM buffer_stock_list
                            GROUP BY buffer_stock_name
                        ) t ON a.buffer_stock_name = t.buffer_stock_name
                        SET a.buffer_stocks_available = t.total_quantity";
mysqli_query($connection, $update_stocks_query);
?>

<!-- Modal -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Buffer Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="code.php" method="POST">
    <div class="modal-body">
    <div class="form-group">
    <label>Product Name</label>
    <select name="buffer_stock_name" class="form-control" required>
        <?php
        foreach ($productNames as $productName) {
            $query = "SELECT * FROM product_list WHERE prod_name='$productName'";
            $query_run = mysqli_query($connection, $query);
            $productInfo = mysqli_fetch_assoc($query_run);
            $measurement = $productInfo['measurement'];
            $selected = ($selectedProduct == $productName) ? 'selected' : '';
            echo "<option value='$productName' data-measurement='$measurement' $selected>
                      $productName - <span style='font-size: 80%;'>$measurement</span>
                  </option>";
        }
        ?>
    </select>
</div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="text" name="quantity" class="form-control" placeholder="Enter Quantity" required />
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="text" name="price" class="form-control" placeholder="Enter Price" required />
        </div>
        <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control" placeholder="Select Expiry Date" required 
                            min="<?php echo date('Y-m-d'); ?>" />
                    </div>
    </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="add_buffer_stock_btn" class="btn btn-primary">Save</button>
        </div>
    </form>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- DataTables Example -->
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                    Add Buffer Stock
                </button>
            </h6>
        </div>
        <div class="card-body">

            <div class="table-responsive">

            <?php
                $connection = mysqli_connect("localhost","root","","dbpharmacy");

                $query = "SELECT buffer_stock_list.*, product_list.measurement 
              FROM buffer_stock_list
              JOIN product_list ON buffer_stock_list.buffer_stock_name = product_list.prod_name";
                $query_run = mysqli_query($connection, $query);
            ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th> ID </th>
                        <th> Product Name </th>
                        <th> Quantity </th>
                        <th> Buffer Stocks Available </th>
                        <th> Price </th>
                        <th> Expiry Date </th>
                        <th> Edit </th>
                        <th> Move to Archive </th>
                        <th> Move To Main </th>
                    </thead>
                    <tbody>
                    <?php
                    if(mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            ?>    
                        <tr>
                            <td> <?php echo $row['id']; ?></td>
                            <td> <?php echo $row['buffer_stock_name']; ?> - <span style='font-size: 80%;'><?php echo $row['measurement']; ?></span></td>
                            <td> <?php echo $row['quantity']; ?></td>
                            <td> <?php echo $row['buffer_stocks_available']; ?></td>
                            <td> <?php echo $row['price']; ?></td>
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
                                <form action="edit_buffer_stock_product.php" method="post">
                                    <input type="hidden" name= edit_id value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="edit_btn" class="btn btn-success">Edit</button>
                                </form>
                            </td>
                            <td> 
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="move_id" value="<?php echo $row['id'];?>">
                                <button type="submit" name="move_buffer_to_archive_btn" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            <td> 
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="move_id" value="<?php echo $row['id'];?>">
                                    <button type="submit" name="move_buffer_stock_btn" class="btn btn-danger">Move</button>
                                </form>
                            </td>
                        </tr>
                        <?php
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
            <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
    </div>
</div>
</div>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
