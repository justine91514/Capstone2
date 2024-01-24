<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');
?>


    <div class="container-fluid">
    <!-- DataTables Example -->
        <div class="card shadow nb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">EDIT Admin Profile
                    
                </h6>
            </div>
            <div class="card-body">
            <?php

$connection = mysqli_connect("localhost", "root", "", "dbdaluyon");
if (isset($_POST['edit_btn'])) {
    $id = $_POST['edit_id'];

    $query = "SELECT * FROM register WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    foreach ($query_run as $row) {
        ?>
        <form action="code.php" method="POST"> <!-- Moved the form tag opening here -->

            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label> Firstname </label>
                <input type="text" name="edit_firstname" value="<?php echo $row['first_name'] ?>" class="form-control" placeholder="Enter Firstname" required />
            </div>
            <div class="form-group">
                <label> Lastname </label>
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
                <label> Usertype </label>
                <select name="update_usertype" class="form-control">
                    <option value= "admin">Admin</option>
                    <option value= "pharmacy_assistant">Pharmacy Assistant</option>
                </select>
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

<?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>