<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');

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
            <label>Product Name</label>
            <input type="text" name="prod_name" class="form-control" placeholder="Input Product Name" required />
        </div>
        <div class="form-group">
        <label>Category</label>
        <select name="categories" class="form-control" required>
            <option value="" disabled selected>Select Category</option>
            <?php
            $connection = mysqli_connect("localhost", "root", "", "dbdaluyon");
            $query = "SELECT * FROM category_list";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<option value='" . $row['category_name'] . "'>" . $row['category_name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Product Type</label>
        <select name="type" class="form-control" required>
            <option value="" disabled selected>Select Product Type</option>
            <?php
            $connection = mysqli_connect("localhost", "root", "", "dbdaluyon");
            $query = "SELECT * FROM product_type_list";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<option value='" . $row['type_name'] . "'>" . $row['type_name'] . "</option>";
            }
            ?>
        </select>
    </div>
        <div class="form-group">
            <label>Measurement</label>
            <input type="text" name="measurement" class="form-control" placeholder="Enter Measurement" required />
        </div>
        
        <div class="form-group">
    <label>Prescription</label>
    <div class="form-check">
        <input type="checkbox" name="prescription" class="form-check-input" id="prescriptionCheckbox" />
        <label class="form-check-label" for="prescriptionCheckbox">Prescription required</label>
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
                $connection = mysqli_connect("localhost","root","","dbdaluyon");

                $query = "SELECT * FROM product_list";
                $query_run = mysqli_query ($connection, $query);
            ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th> ID </th>
                        <th> Product Name </th>
                        <th> Category </th>
                        <th> Type </th>
                        <th> Measurement </th>
                        
                        <th> Prescrpition </th>
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
                            <td> <?php echo $row['measurement']; ?></td>
                            <td><?php echo ($row['prescription'] == 1) ? 'Yes' : 'No'; ?></td>

                            
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

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
