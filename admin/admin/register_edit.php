<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile</title>
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
                <h6 class="m-0 font-weight-bold text-primary">Edit User Profile
                </h6>
            </div>
            <div class="card-body">
            <?php

$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
if (isset($_POST['edit_btn'])) {
    $id = $_POST['edit_id'];

    $query = "SELECT * FROM register WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    foreach ($query_run as $row) {
        ?>
        <form action="code.php" method="POST"> <!-- Moved the form tag opening here -->

            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label> First Name </label>
                <input type="text" name="edit_firstname" value="<?php echo $row['first_name'] ?>" class="form-control" placeholder="Enter Firstname" required />
            </div>
            <div class="form-group">
                <label> Middle Name </label>
                <input type="text" name="edit_mid_name" value="<?php echo $row['mid_name'] ?>" class="form-control" placeholder="Enter Middle Name" required />
            </div>
            <div class="form-group">
                <label> Last Name </label>
                <input type="text" name="edit_lastname" value="<?php echo $row['last_name'] ?>" class="form-control" placeholder="Enter Lastname" required />
            </div>
            <div class="form-group">
                <label> Email </label>
                <input type="email" name="edit_email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Enter Email" required />
            </div>
            <div class="form-group">
                <label> Password </label>
                <input type="password" name="edit_password" value="<?php echo $row['password'] ?>" class="form-control" placeholder="Enter Password" required />
            </div>
            <div class="form-group">
                <label> Branch </label>
                <select name="branch" class="form-control" required>
                    <option value="" disabled selected>Select Branch</option>
                    <option value="Cell Med">Cell Med</option>
                    <option value="3G Med">3G Med</option>
                    <option value="Boom Care">Boom Care</option>
                </select>
            </div>
            <div class="form-group">
                <label> Usertype </label>
                <input type="usertype" name="update_usertype" value="<?php echo $row['usertype'] ?>" class="form-control" readonly required />
            </div>


            <a href="register.php" class="btn btn-danger"> CANCEL</a>
            <button type="submit" name="updatebtn" class="btn btn-primary"> Update </button>
        </form> <!-- Moved the form tag closing here -->
<?php
    }
}
?> 

            </div>
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