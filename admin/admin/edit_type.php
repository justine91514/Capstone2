<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');
?>


    <div class="container-fluid">
    <!-- DataTables Example -->
        <div class="card shadow nb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Product Type</h6>
            </div>
            <div class="card-body">
            <?php

$connection = mysqli_connect("localhost", "root", "", "dbdaluyon");
if (isset($_POST['edit_btn'])) {
    $id = $_POST['edit_id'];

    $query = "SELECT * FROM product_type_list WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    foreach ($query_run as $row) {
        ?>
        <form action="code.php" method="POST"> <!-- Moved the form tag opening here -->

            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label> Product Type </label>
                <input type="text" name="edit_type" value="<?php echo $row['type_name'] ?>" class="form-control" placeholder="Enter Type" required />
            </div>
            <a href="add_category.php" class="btn btn-danger"> CANCEL</a>
            <!-- updatecategorybtn is in the code.php -->
            <button type="submit" name="updatetypebtn" class="btn btn-primary"> Update </button>
        </form> 
<?php
    }
}
?> 

            </div>
            </div>
        </div>
    </div>

<?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>