<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="need.css">
</head>
</html>
<?php 
session_start();
include('includes/header.php');
include('includes/navbar2.php');
$selectedBranch = isset($_GET['branch']) ? $_GET['branch'] : 'All';

// Check if parameter indicating updated stocks available is present in URL
if(isset($_GET['updated_stocks_available'])) {
    $updated_stocks_available = $_GET['updated_stocks_available'];
    // Use the updated stocks available value
} else {
    // Use the regular query to fetch product details
    $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
    $query = "SELECT id, prod_name, categories, type, measurement, stocks_available, prescription FROM product_list";
    $query_run = mysqli_query($connection, $query);
}
?>

<!-- Modal -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="code.php" method="POST">
    <div class="modal-body">
        <div class="form-group">
        <label class="modal-label" style="color: #259E9E;">Product Name</label>
        <input type="text" name="prod_name" class="form-control" placeholder="Input Product Name" required style="border-radius: 5px; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        </div>
        
        <div class="form-group">
        <label class="modal-label" style="color: #259E9E;">Category</label>
        <select name="categories" class="form-control" required style="border-radius: 5px; border: 1px solid #ccc; padding: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <option value="" disabled selected>Select Category</option>
            <?php
            $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
            $query = "SELECT * FROM category_list";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<option value='" . $row['category_name'] . "'>" . $row['category_name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
    <label class="modal-label" style="color: #259E9E;">Product Type</label>
    <select name="type" class="form-control" required style="border-radius: 5px; border: 1px solid #ccc; padding: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <option value="" disabled selected>Select Product Type</option>
            <?php
            $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
            $query = "SELECT * FROM product_type_list";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<option value='" . $row['type_name'] . "'>" . $row['type_name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label class="modal-label" style="color: #259E9E;">Product Unit</label>
        <select name="unit" class="form-control" required style="border-radius: 5px; border: 1px solid #ccc; padding: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <option value="" disabled selected>Select Product Unit</option>
            <?php
            $connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
            $query = "SELECT * FROM unit_list";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<option value='" . $row['unit_name'] . "'>" . $row['unit_name'] . "</option>";
            }
            ?>
        </select>
    </div>
        <div class="form-group">
        <label class="modal-label" style="color: #259E9E;">Measurement</label>
        <input type="text" name="measurement" class="form-control" placeholder="Enter Measurement" required style="border-radius: 5px; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        </div>
        
        <div class="form-group">
        <label class="modal-label" style="color: #259E9E;">Prescription</label>
    <div class="form-check">
        <input type="checkbox" name="prescription" class="form-check-input" id="prescriptionCheckbox" value="1" />
        <label class="form-check-label" for="prescriptionCheckbox">Prescription required</label>
    </div>
    <div class="form-check">
        <input type="checkbox" name="discounted" class="form-check-input" id="generic_discount_Checkbox" value="1" />
        <label class="form-check-label" for="generic_discount_Checkbox">Generic Discount required</label>
    </div>
</div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add_prod_btn" class="btn btn-primary">Save</button>
    </div>
</form>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- DataTables Example -->
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                    Add Product
                </button>
            </h6>
            <div class="form-group">
        <label>Select Branch</label>
        <select id="branch" name="branch" class="form-control" onchange="changeBranch()">
            <option value="All" <?php if($selectedBranch == 'All') echo 'selected'; ?>>All</option>
            <option value="Cell Med" <?php if($selectedBranch == 'Cell Med') echo 'selected'; ?>>Cell Med</option>
            <option value="3G Med" <?php if($selectedBranch == '3G Med') echo 'selected'; ?>>3G Med</option>
            <option value="Boom Care" <?php if($selectedBranch == 'Boom Care') echo 'selected'; ?>>Boom Care</option>
        </select>
    </div>
        </div>
        <div class="card-body">

            <div class="table-responsive">

            <?php
                $connection = mysqli_connect("localhost","root","","dbpharmacy");

                // Query to fetch product details with total quantity per branch
                $query = "SELECT p.id, p.prod_name, p.prod_code, p.categories, p.type, p.unit, p.measurement, 
                          SUM(CASE WHEN a.branch = 'Cell Med' THEN a.quantity ELSE 0 END) AS 'Cell Med',
                          SUM(CASE WHEN a.branch = '3G Med' THEN a.quantity ELSE 0 END) AS '3G Med',
                          SUM(CASE WHEN a.branch = 'Boom Care' THEN a.quantity ELSE 0 END) AS 'Boom Care',
                          p.prescription,  p.discounted 
                          FROM product_list p
                          LEFT JOIN add_stock_list a ON p.prod_name = a.product_stock_name";

                // If a specific branch is selected, filter the products for that branch
                if($selectedBranch != 'All') {
                    $query .= " WHERE a.branch = '$selectedBranch'";
                }

                $query .= " GROUP BY p.id";

                $query_run = mysqli_query($connection, $query);
            ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th> ID </th>
                        <th> Product Name </th>
                        <!-- <th> Product Code </th>-->
                        <th> Category </th>
                        <th> Type </th>
                        <th> Unit </th>
                        <th> Measurement </th>
                        <th> Stocks Available</th>
                        <th> Prescription </th>
                        <th> Has Discount </th>
                        <th> Edit </th>
                        <th> Delete </th>
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
                            <td> <?php echo $row['prod_name']; ?></td>
                            
                            <td> <?php echo $row['categories']; ?></td>
                            <td> <?php echo $row['type']; ?></td>
                            <td> <?php echo $row['unit']; ?></td>
                            <td> <?php echo $row['measurement']; ?></td>
                            <td>
                                <?php 
                                if ($selectedBranch === 'All') {
                                    // Calculate the total quantity available across all branches
                                    $totalStocks = $row['Cell Med'] + $row['3G Med'] + $row['Boom Care'];
                                    echo $totalStocks;
                                } else {
                                    // Display the quantity available for the selected branch
                                    echo $row[$selectedBranch];
                                }
                                ?>
                            </td>

                            <td><?php echo ($row['prescription'] == 1) ? 'Yes' : 'No'; ?></td>
                            <td><?php echo ($row['discounted'] == 1) ? 'Yes' : 'No'; ?></td>

                            
                            <td> 
                                <form action="edit_product.php" method="post">
                                    <input type="hidden" name= edit_id value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                </form>
                            </td>
                            <td> 
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id'];?>">
                                <button type="submit" name="delete_prod_btn" class="btn btn-danger">DELETE</button>
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