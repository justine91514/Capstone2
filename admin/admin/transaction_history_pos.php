<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
</head>
<?php
session_start();
include('includes/header_pos.php');
include('includes/navbar_pos.php');
date_default_timezone_set('Asia/Manila');

?>


</html>
<div class="container-fluid">
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                $connection = mysqli_connect("localhost","root","","dbpharmacy");
                $query = "SELECT transaction_id, date, CONCAT(DATE_FORMAT(time, '%h:%i:%s'), ' ', DATE_FORMAT(NOW(), '%p')) AS time_with_am_pm, mode_of_payment, list_of_items, total FROM transaction_list";

                $query_run = mysqli_query($connection, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th> Transaction no. </th>
                        <th> Date </th>
                        <th> Time </th>
                        <th> Mode of Payment </th>
                        <th> List of Items </th>
                        <th> Total </th>
                        <th> Reissue of Reciept </th>

                    </thead>
                    <tbody>
                        <?php
                        if(mysqli_num_rows($query_run) > 0)
                        {
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                ?>    
                                <tr>
                        <td> <?php echo $row['transaction_id']; ?></td>
                        <td> <?php echo $row['date']; ?></td>
                        <td><?php echo $row['time_with_am_pm']; ?></td>
                        <td> <?php echo $row['mode_of_payment']; ?></td>
                        <td> <?php echo $row['list_of_items']; ?></td>   
                        <td> <?php echo $row['total']; ?></td>       
                        <td> 
                            <form action="print_product.php" method="post">
                                <input type="hidden" name= print_id>
                                <button type="submit" name="print_btn" class="btn btn-success">PRINT</button>
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
