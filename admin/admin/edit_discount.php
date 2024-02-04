<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
</html>
<?php 
session_start();
include('includes/header.php');
include('includes/navbar2.php');
?>


    <div class="container-fluid">
    <!-- DataTables Example -->
        <div class="card shadow nb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Discount</h6>
            </div>
            <div class="card-body">
            <?php

$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
if (isset($_POST['edit_btn'])) {
    $id = $_POST['edit_id'];

    $query = "SELECT * FROM discount_list WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    foreach ($query_run as $row) {
        ?>
        <form action="code.php" method="POST"> <!-- Moved the form tag opening here -->

            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label> Discount Name </label>
                <input type="text" name="edit_discount" value="<?php echo $row['discount_name'] ?>" class="form-control" placeholder="Enter Category" required />
            </div>

            <div class="form-group">
                <label> Value% </label>
                <input type="text" name="edit_value" value="<?php echo $row['value'] ?>" class="form-control" placeholder="Enter Value" required />
            </div>

            

            <a href="add_discount.php" class="btn btn-danger"> CANCEL</a>
            <!-- updatecategorybtn is in the code.php -->
            <button type="submit" name="updatediscountbtn" class="btn btn-primary"> Update </button>
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