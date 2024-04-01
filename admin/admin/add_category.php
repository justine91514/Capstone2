<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <!-- Add your CSS styles and DataTables CSS CDN link here -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="need.css">

</head>
<body>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="code.php" method="POST" style="margin-bottom: 20px;">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="modal-label" style="color: #259E9E;">Category Name</label>
                        <input type="text" name="category_name" class="form-control modal-input" placeholder="Enter Category" required style="border-radius: 5px; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="submit" name="categorybtn" class="btn btn-primary modal-btn" style="border-radius: 5px; padding: 10px 20px; background-color: #259E9E; border: none; position: absolute; bottom: 10px; right: 10px;">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal for Editing Category -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #259E9E; color: white; border-bottom: none;">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm" style="margin-bottom: 20px;">
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="editCategoryId">
                    <div class="form-group">
                    <label class="modal-label" style="color: #259E9E;">Category Name</label>
                        <input type="text" class="form-control" id="editCategoryName" name="edit_category" placeholder="Enter Category" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                <button type="submit" name="categorybtn" class="btn btn-primary modal-btn" style="border-radius: 5px; padding: 10px 20px; background-color: #259E9E; border: none; position: absolute; bottom: 10px; right: 10px;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>




    <div class="container-fluid">
        <!-- DataTables Example -->
    <!-- DataTables Example -->
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
            <button type="button" class="btn btn-primary rounded-pill shadow" data-toggle="modal" data-target="#addadminprofile" style="background-color: #259E9E; border: none; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
    <i class="fas fa-plus-square fa-lg"></i> <span style="font-weight: bold; text-transform: uppercase;">Add New Category</span>
</button>
                </h6>
            </div>
            <div class="card-body">


<!-- this code is for the admin profile added (makikita sa code.php)-->
<?php
if(isset($_SESSION['success']) && $_SESSION['success'] !='') 
{
    echo '<h2 class="bg-primary text-white">' .$_SESSION['success'].'</h2>';
    unset($_SESSION['success']);
}
?>
<!-- this code is for the admin profile added  -->

<!-- this code is for the Password and confirm password does not match (makikita sa code.php)-->
<?php
if(isset($_SESSION['status']) && $_SESSION['status'] !='') 
{
    echo '<h2 class="bg-danger text-white">' .$_SESSION['status'].'</h2>';
    unset($_SESSION['status']);
}
?>
<!-- this code is for the Password and confirm password does not match (makikita sa code.php)-->


            <div class="table-responsive">

            <?php
                $connection = mysqli_connect("localhost","root","","dbpharmacy");

                $query = "SELECT * FROM category_list";
                $query_run = mysqli_query ($connection, $query);
            ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead style="background-color: #259E9E; color: white;">
                        <th> ID </th>
                        <th>Category Name <button class="btn btn-link btn-sm" onclick="sortTable(1)"><i id="sortIcon" class="fas fa-sort" style="color: white;"></i></button></th>
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
                            <td> <?php echo $row['category_name']; ?></td>
                            
                            <td>
    <form action="edit_category.php" method="post" style="display: inline-block;">
        <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
        <button type="submit" name="edit_btn" class="btn btn-action editBtn" value="<?php echo $row['id']; ?>">
            <i class="fas fa-edit" style="color: #44A6F1;"></i>
        </button>
    </form>

    <span class="action-divider">|</span>

    <form action="code.php" method="POST" style="display: inline-block;">
        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
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
            <a class="btn btn-primary" href="index.php">Logout</a>
        </div>
    </div>
</div>
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
</body>
</html>
