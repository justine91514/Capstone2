<?php 
session_start();
include('includes/header.php');
include('includes/navbar2.php');
?>

<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
        </div>
        <div class="card-body">
            <?php
            $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");

            if (isset($_POST['edit_btn'])) {
                $id = $_POST['edit_id'];

                $query = "SELECT * FROM buffer_stock_list WHERE id='$id'";
                $query_run = mysqli_query($connection, $query);

                foreach ($query_run as $row) {
                    ?>
                    <form action="code.php" method="POST">

                        <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="buffer_stock_name" value="<?php echo $row['buffer_stock_name'] ?>" class="form-control" placeholder="Enter Category" readonly required />
                        </div>
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="date" name="expiry_date" value="<?php echo $row['expiry_date']; ?>" class="form-control" placeholder="Select Expiry Date" required />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="quantity" value="<?php echo $row['quantity'] ?>" class="form-control" placeholder="Enter Category" required />
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" value="<?php echo $row['price'] ?>" class="form-control" placeholder="Enter Category" required />
                        </div>

                        <a href="buffer_stock.php" class="btn btn-danger">CANCEL</a>
                        <button type="submit" name="update_buffer_stock_btn" class="btn btn-primary">Update</button>
                    </form>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
