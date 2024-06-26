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
                    $query = "SELECT * FROM product_list WHERE id='$id'";
                    $query_run = mysqli_query($connection, $query);

                    foreach ($query_run as $row) {
            ?>
                        <form action="code.php" method="POST">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
                            <div class="form-group">
                                <label> Product Name </label>
                                <input type="text" name="prod_name" value="<?php echo $row['prod_name'] ?>" class="form-control" placeholder="Enter Category" required />
                            </div>
                            <div class="form-group">
                                <label> Category Name</label>
                                <select name="categories" class="form-control" required>
                                    <option value="" disabled>Select Category</option>
                                    <?php
                                        $category_query = "SELECT * FROM category_list";
                                        $category_result = mysqli_query($connection, $category_query);

                                        while ($category_row = mysqli_fetch_assoc($category_result)) {
                                            echo '<option value="' . $category_row['category_name'] . '" ' . (($row['categories'] == $category_row['category_name']) ? 'selected' : '') . '>' . $category_row['category_name'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label> Type Name</label>
                                <select name="type" class="form-control" required>
                                    <option value="" disabled>Select Type</option>
                                    <?php
                                        $type_query = "SELECT * FROM product_type_list";
                                        $type_result = mysqli_query($connection, $type_query);

                                        while ($type_row = mysqli_fetch_assoc($type_result)) {
                                            echo '<option value="' . $type_row['type_name'] . '" ' . (($row['type'] == $type_row['type_name']) ? 'selected' : '') . '>' . $type_row['type_name'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> Unit Name </label>
                                <select name="unit" class="form-control" required>
                                    <option value="" disabled>Select Type</option>
                                    <?php
                                        $type_query = "SELECT * FROM unit_list";
                                        $type_result = mysqli_query($connection, $type_query);

                                        while ($type_row = mysqli_fetch_assoc($type_result)) {
                                            echo '<option value="' . $type_row['unit_name'] . '" ' . (($row['unit'] == $type_row['unit_name']) ? 'selected' : '') . '>' . $type_row['unit_name'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> Measurement </label>
                                <input type="text" name="measurement" value="<?php echo $row['measurement'] ?>" class="form-control" placeholder="Enter Category" required />
                            </div>
                            <div class="form-group">
                                <label> Prescription </label>
                                <input type="checkbox" name="prescription" <?php echo ($row['prescription'] == 'yes') ? 'checked' : ''; ?>>
                            </div>
                            <a href="product.php" class="btn btn-danger"> CANCEL</a>
                            <button type="submit" name="updateproductbtn" class="btn btn-primary"> Update </button>
                        </form> 
            <?php
                    }
                }
            ?> 
        </div>
    </div>
</div>

<?php
    include('includes/scripts.php');
    include('includes/footer.php');
?>
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