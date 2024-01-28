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
                                 archive_list.product_name, 
                                 archive_list.expiry_date, 
                                 archive_list.quantity, 
                                 archive_list.stocks_available, 
                                 archive_list.price, 
                                 product_list.measurement
                          FROM archive_list
                          JOIN product_list ON archive_list.product_name = product_list.prod_name";

                $query_run = mysqli_query($connection, $query);
                ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Expiry Date</th>
                        <th>Quantity</th>
                        <th>Stocks Available</th>
                        <th>Price</th>
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
                                    <td>
                                        <?php echo $row['product_name']; ?> -
                                        <span style='font-size: 80%;'>
                                            <?php echo $row['measurement']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $row['expiry_date']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['stocks_available']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td>
                                        <form action="code.php" method="POST">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="permanent_delete_btn" class="btn btn-danger">DELETE</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="code.php" method="POST">
                                            <input type="hidden" name="move_id" value="<?php echo $row['id']; ?>">
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

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
