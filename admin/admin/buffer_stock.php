<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');

$connection = mysqli_connect("localhost", "root", "", "dbdaluyon");
$query = "SELECT prod_name FROM product_list";
$query_run = mysqli_query($connection, $query);
$productNames = array();
while ($row = mysqli_fetch_assoc($query_run)) {
    $productNames[] = $row['prod_name'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data
    // ...

    // Example usage of selected value in the form
    $selectedProduct = $_POST['product_stock_name'];
}
?>

<!-- Modal -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Buffer Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="code.php" method="POST">
    <div class="modal-body">
    <div class="form-group">
    <label>Product Name</label>
    <select name="buffer_stock_name" class="form-control" required>
        <?php
        foreach ($productNames as $productName) {
            $selected = ($selectedProduct == $productName) ? 'selected' : '';
            echo "<option value='$productName' $selected>$productName</option>";
        }
        ?>
    </select>
</div>
        <div class="form-group">
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" placeholder="Select Expiry Date" required />
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="text" name="quantity" class="form-control" placeholder="Enter Quantity" required />
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="text" name="price" class="form-control" placeholder="Enter Price" required />
        </div>
    </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="add_buffer_stock_btn" class="btn btn-primary">Save</button>
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
                    Add Buffer Stock
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

                $query = "SELECT * FROM buffer_stock_list";
                $query_run = mysqli_query ($connection, $query);
            ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th> ID </th>
                        <th> Product Name </th>
                        <th> Expiry Date </th>
                        <th> Quantity </th>
                        <th> Price </th>
                        <th> Edit </th>
                        <th> Delete </th>
                        <th> Move To Main </th>
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
                            <td> <?php echo $row['buffer_stock_name']; ?></td>
                            <td> <?php echo $row['expiry_date']; ?></td>
                            <td> <?php echo $row['quantity']; ?></td>
                            <td> <?php echo $row['price']; ?></td>
                            
                            <td> 
                                <form action="edit_stock_product.php" method="post">
                                    <input type="hidden" name= edit_id value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                </form>
                            </td>
                            <td> 
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id'];?>">
                                <button type="submit" name="delete_buffer_stock_btn" class="btn btn-danger">DELETE</button>
                                </form>
                            </td>
                            <td> 
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="move_id" value="<?php echo $row['id'];?>">
                                    <button type="submit" name="move_buffer_stock_btn" class="btn btn-danger">MOVE</button>
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
