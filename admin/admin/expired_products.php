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
                $query = "SELECT * FROM expired_list"; 
                $result = mysqli_query($connection, $query);
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
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
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
