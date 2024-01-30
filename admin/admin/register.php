<?php 
session_start();
include('includes/header.php');
include('includes/navbar2.php');
?>

<!-- Modal -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="code.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label> First Name </label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter Firstname" required />
                    </div>
                    <div class="form-group">
                        <label> Middle Name </label>
                        <input type="text" name="mid_name" class="form-control" placeholder="Enter Middle Name" required />
                    </div>
                    <div class="form-group">
                        <label> Last Name </label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter Lastname" required />
                    </div>
                    <div class="form-group">
                        <label> Email </label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required />
                    </div>
                    <div class="form-group">
                        <label> Password </label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password" required />
                    </div>
                    <div class="form-group">
                        <label> Confirm Password </label>
                        <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required />
                    </div>
                    <input type="hidden" name="usertype" value="admin">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Admin Profile
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                    Add Admin Profile
                </button>
            </h6>
        </div>
        <div class="card-body">
            <?php
            if(isset($_SESSION['success']) && $_SESSION['success'] !='') 
            {
                echo '<h2 class="bg-primary text-white">' .$_SESSION['success'].'</h2>';
                unset($_SESSION['success']);
            }
            ?>
            <?php
            if(isset($_SESSION['status']) && $_SESSION['status'] !='') 
            {
                echo '<h2 class="bg-danger text-white">' .$_SESSION['status'].'</h2>';
                unset($_SESSION['status']);
            }
            ?>
            <div class="table-responsive">
            <?php
                $connection = mysqli_connect("localhost","root","","dbpharmacy");
                $query = "SELECT * FROM register";
                $query_run = mysqli_query($connection, $query);
            ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th> ID </th>
                        <th> Firstname </th>
                        <th> Middle Name </th>
                        <th> Lastname </th>
                        <th> Email</th>
                        <th> Password</th>
                        <th> Usertype</th>
                        <th> EDIT </th>
                        <th> DELETE </th>
                    </thead>
                    <tbody>
                    <?php
                    if(mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            ?>    
                        <tr>
                            <td> <?php echo $row['id']; ?></td>
                            <td> <?php echo $row['first_name']; ?></td>
                            <td> <?php echo $row['mid_name']; ?></td>
                            <td> <?php echo $row['last_name']; ?></td>
                            <td> <?php echo $row['email']; ?></td>
                            <td> <?php echo $row['password']; ?></td>
                            <td> <?php echo $row['usertype']; ?></td>
                            <td> 
                                <form action="register_edit.php" method="post">
                                    <input type="hidden" name= edit_id value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                </form>
                            </td>
                            <td> 
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id'];?>">
                                    <button type="submit" name="delete_btn" class="btn btn-danger">DELETE</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                        }
                    }
                    else{
                        echo "No record Found";
                    }
                    ?>
                    </tbody>
                </table>
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
