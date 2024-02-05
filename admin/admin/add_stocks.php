<?php
session_start();
include('includes/header.php');
include('includes/navbar2.php');

$selectedBranch = isset($_GET['branch']) ? $_GET['branch'] : 'All';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks</title>
    <!-- Add the JavaScript script here -->
    <script>
        function changeTableFormat() {
            var selectedBranch = document.getElementById("branch").value;
            window.location.href = 'add_stocks.php?branch=' + selectedBranch;
        }
    </script>
</head>

<body>

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

    $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
    $query = "SELECT prod_name FROM product_list";
    $query_run = mysqli_query($connection, $query);
    $productNames = array();
    while ($row = mysqli_fetch_assoc($query_run)) {
        $productNames[] = $row['prod_name'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedProduct = $_POST['product_stock_name'];
    }
    $expired_products_query = "SELECT * FROM add_stock_list WHERE expiry_date < CURDATE()";
    $expired_products_result = mysqli_query($connection, $expired_products_query);

    while ($expired_product = mysqli_fetch_assoc($expired_products_result)) {
        // Move expired product to expired_list
        $move_to_expired_query = "INSERT INTO expired_list (product_name, quantity, stocks_available, price, expiry_date)
                             VALUES ('{$expired_product['product_stock_name']}', '{$expired_product['quantity']}', '{$expired_product['stocks_available']}', '{$expired_product['price']}', '{$expired_product['expiry_date']}')";
        mysqli_query($connection, $move_to_expired_query);

        // Delete expired product from add_stock_list
        $delete_expired_query = "DELETE FROM add_stock_list WHERE id = {$expired_product['id']}";
        mysqli_query($connection, $delete_expired_query);
    }

    // Update stocks_available separately for each branch or all branches
    $update_stocks_query = "UPDATE add_stock_list a
                        JOIN (
                            SELECT product_stock_name, branch, SUM(quantity) as total_quantity
                            FROM add_stock_list
                            GROUP BY product_stock_name, branch
                        ) t ON a.product_stock_name = t.product_stock_name AND a.branch = t.branch
                        SET a.stocks_available = t.total_quantity
                        WHERE ('$selectedBranch' = 'All' OR a.branch = '$selectedBranch')";
    mysqli_query($connection, $update_stocks_query);

    $expiring_soon_query = "SELECT COUNT(*) as expiring_soon_count FROM add_stock_list WHERE expiry_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY";
    $expiring_soon_result = mysqli_query($connection, $expiring_soon_query);
    $expiring_soon_count = 0;

    if ($expiring_soon_result) {
        $expiring_soon_row = mysqli_fetch_assoc($expiring_soon_result);
        $expiring_soon_count = $expiring_soon_row['expiring_soon_count'];
    }

    ?>

    <div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- ... Your existing modal code ... -->
    </div>

    <div class="container-fluid">
        <div class="card shadow nb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                        Add Stock
                    </button>
                    <label> Branch </label>
                    <select id="branch" name="branch" class="form-control" onchange="changeTableFormat()" required>
                        <option value="Cell Med" <?php echo ($selectedBranch === 'Cell Med') ? 'selected' : ''; ?>>Cell Med</option>
                        <option value="3G Med" <?php echo ($selectedBranch === '3G Med') ? 'selected' : ''; ?>>3G Med</option>
                        <option value="Boom Care" <?php echo ($selectedBranch === 'Boom Care') ? 'selected' : ''; ?>>Boom Care</option>
                    </select>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php
                    $query = "SELECT add_stock_list.*, product_list.measurement 
                              FROM add_stock_list
                              JOIN product_list ON add_stock_list.product_stock_name = product_list.prod_name
                              WHERE ('$selectedBranch' = 'All' OR add_stock_list.branch = '$selectedBranch')";
                    $query_run = mysqli_query($connection, $query);
                    ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <th> ID </th>
                            <th> Product Name </th>
                            <th> Quantity </th>
                            <th> Stocks Available </th>
                            <th> Price </th>
                            <th> Branch </th>
                            <th> Expiry Date </th>
                            <th> Edit </th>
                            <th> Move To Archive </th>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                            ?>
                                    <tr>
                                        <td> <?php echo $row['id']; ?></td>
                                        <td> <?php echo $row['product_stock_name']; ?> - <span style='font-size: 80%;'><?php echo $row['measurement']; ?></span></td>
                                        <td> <?php echo $row['quantity']; ?></td>
                                        <td> <?php echo $row['stocks_available']; ?></td>
                                        <td> <?php echo $row['price']; ?></td>
                                        <td> <?php echo $row['branch']; ?></td>
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
                                            <form action="edit_stock_product.php" method="post">
                                                <input type="hidden" name=edit_id value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="code.php" method="POST">
                                                <input type="hidden" name="move_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="move_to_archive_btn" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "No record Found";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Logout Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- ... Your existing logout modal code ... -->
        </div>
        <?php
        include('includes/scripts.php');
        include('includes/footer.php');
        ?>
    </body>

    </html>
