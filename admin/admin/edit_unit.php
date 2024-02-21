<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Unit</title>
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
                <h6 class="m-0 font-weight-bold text-primary">Edit Unit</h6>
            </div>
            <div class="card-body">
            <?php

$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
if (isset($_POST['edit_unit'])) {
    $id = $_POST['edit_id'];

    $query = "SELECT * FROM unit_list WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    foreach ($query_run as $row) {
        ?>
        <form action="code.php" method="POST"> <!-- Moved the form tag opening here -->

            <input type="hidden" name="edit_unit_btn" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label> Unit </label>
                <input type="text" name="edit_unit" value="<?php echo $row['unit_name'] ?>" class="form-control" placeholder="Enter Unit" required />
            </div>
            <a href="add_unit.php" class="btn btn-danger"> CANCEL</a>
            <!-- updateunitbtn is in the code.php -->
            <button type="submit" name="updateunitbtn" class="btn btn-primary"> Update </button>
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