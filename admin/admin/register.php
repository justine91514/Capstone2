<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="ack.css">
<style>
    .container-fluid {
        margin-top: 100px; /* Adjust the value as needed */
    }
    </style>
</head>
</html>

<?php 
session_start();
include('includes/header.php');
include('includes/navbar2.php');

?>

<!-- Modal -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"> <!-- Add modal-dialog-centered class -->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #259E9E; color: white; border-bottom: none;">
                <h5 class="modal-title" id="exampleModalLabel">Create Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="code.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Middle Name</label>
                        <input type="text" name="mid_name" class="form-control" placeholder="Enter Middle Name" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Confirm Password</label>
                        <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Branch</label>
                        <select name="branch" class="form-control" required>
                            <option value="" disabled selected>Branch</option>
                            <option value="Cell Med">Cell Med</option>
                            <option value="3G Med">3G Med</option>
                            <option value="Boom Care">Boom Care</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Usertype</label>
                        <select name="usertype" class="form-control">
                            <option value="" disabled selected>Select Usertype</option>
                            <option value="admin">Admin</option>
                            <option value="pharmacy_assistant">Pharmacy Assistant</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
                </div>
</form>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal for Editing Category -->
<div class="modal fade" id="editRegisterModal" tabindex="-1" role="dialog" aria-labelledby="editRegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #259E9E; color: white; border-bottom: none;">
                <h5 class="modal-title" id="editRegisterModalLabel">Edit Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm" style="margin-bottom: 5px;">
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="editCategoryId">
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Middle Name</label>
                        <input type="text" name="mid_name" class="form-control" placeholder="Enter Middle Name" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Confirm Password</label>
                        <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required />
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Branch</label>
                        <select name="branch" class="form-control" required>
                            <option value="" disabled selected>Select Branch</option>
                            <option value="Cell Med">Cell Med</option>
                            <option value="3G Med">3G Med</option>
                            <option value="Boom Care">Boom Care</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Usertype</label>
                        <select name="usertype" class="form-control">
                            <option value="" disabled selected>Select Usertype</option>
                            <option value="admin">Admin</option>
                            <option value="pharmacy_assistant">Pharmacy Assistant</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer" style="border-top: none;">
                    <button type="submit" name="categorybtn" class="btn btn-primary modal-btn" style="border-radius: 5px; padding: 10px 20px; background-color: #259E9E; border: none; position: absolute; bottom: 10px; right: 10px;">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card shadow nb-4">
        <div class="card-header py-3">
        <h1>User Management</h1>
        </div>
        <div class="card-body">

        <h6 class="m-0 font-weight-bold text-primary">
        <button type="button" class="btn btn-primary shadow" data-toggle="modal" data-target="#addadminprofile" style="background-color: #FFFFFF; border: 2px solid #259E9E; color: #000000; border-radius: 10px; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
    <i class="fas fa-user-plus fa-lg" style="color: #000000;"></i> <span style="font-weight: bold; text-transform: uppercase;">Add New Account</span>
</button>

            </h6>
            
            <div class="table-responsive">

            <?php
                $connection = mysqli_connect("localhost","root","","dbpharmacy");

                // Query to fetch product details with total quantity per branch
                $query = "SELECT p.id, p.prod_name, p.categories, p.type, p.measurement, 
                          SUM(CASE WHEN a.branch = 'Cell Med' THEN a.quantity ELSE 0 END) AS 'Cell Med',
                          SUM(CASE WHEN a.branch = '3G Med' THEN a.quantity ELSE 0 END) AS '3G Med',
                          SUM(CASE WHEN a.branch = 'Boom Care' THEN a.quantity ELSE 0 END) AS 'Boom Care',
                          p.prescription 
                          FROM product_list p
                          LEFT JOIN add_stock_list a ON p.prod_name = a.product_stock_name";

                
                

                $query .= " GROUP BY p.id";

                $query_run = mysqli_query($connection, $query);
            ?>
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
                <thead style="background-color: #259E9E; color: white;">
                        <th> ID </th>
                        <th> First Name </th>
                        <th> Middle Name </th>
                        <th> Last Name </th>
                        <th> Email</th>
                        <th> Password</th>
                        <th> Branch <button class="btn btn-link btn-sm" onclick="sortTable(1)"><i id="sortIcon" class="fas fa-sort" style="color: white;"></i></button></th>
                        <th> Usertype <button class="btn btn-link btn-sm" onclick="sortTable(1)"><i id="sortIcon" class="fas fa-sort" style="color: white;"></i></button></th>
                        <th> Action </th>
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
                            <td> <?php echo $row['branch']; ?></td>
                            <td> <?php echo $row['usertype']; ?></td>
                            
                            <td> 
                                <form action="register_edit.php" method="post">
                                <input type="hidden" name= edit_id value="<?php echo $row['id']; ?>">
                                <button type="submit" name="edit_btn" class="btn btn-action editBtn">
                                    <i class="fas fa-edit" style="color: #44A6F1;"></i>
                                </button>
                                <span class="action-divider">|</span>

                                <form action="code.php" method="POST" style="display: inline-block;">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id'];?>">
                                    <button type="submit" name="delete_category_btn" class="btn btn-action" style="border: none; background: none;">
                                        <i class="fas fa-trash-alt" style="color: #FF0000;"></i>
                                    </button>
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
<script>
    // JavaScript function to change the URL based on the selected branch
    function changeBranch() {
        var selectedBranch = document.getElementById("branch").value;
        window.location.href = 'product.php?branch=' + selectedBranch;
    }
</script>
</div>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>

<script>
    var ascending = true;

    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("dataTable");
        switching = true;
        var icon = document.getElementById("sortIcon");
        if (ascending) {
            icon.classList.remove("fa-sort");
            icon.classList.add("fa-sort-up");
        } else {
            icon.classList.remove("fa-sort-up");
            icon.classList.add("fa-sort-down");
        }
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[columnIndex];
                y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
                if (ascending) {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
        ascending = !ascending;
    }
</script>
        <!-- DataTables JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "pageLength": 10, // Display 10 entries per page
            "searching": true,
            "ordering": false, // Disable ordering/sorting
            "info": true,
            "autoWidth": false,
            "language": {
                "paginate": {
                    "previous": "<i class='fas fa-arrow-left'></i>", // Use arrow-left icon for previous button
                    "next": "<i class='fas fa-arrow-right'></i>" // Use arrow-right icon for next button
                }
            },
            "pagingType": "simple" // Set the pagination type to simple
        });
    });
</script>