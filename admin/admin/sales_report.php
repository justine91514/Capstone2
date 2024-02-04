<?php
session_start();
include('includes/header.php');
include('includes/navbar2.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks</title>
</head>

</html>
<script>
    function changeTableFormat() {
        var selectedOption = document.getElementById("reportType").value;
        var dailyTable = document.getElementById("dailyTable");
        var weeklyTable = document.getElementById("weeklyTable");

        if (selectedOption === "Daily") {
            dailyTable.style.display = "table";
            weeklyTable.style.display = "none";
        } else if (selectedOption === "Weekly") {
            dailyTable.style.display = "none";
            weeklyTable.style.display = "table";
        }
    }
</script>
<div class="container-fluid">
    <div class="card shadow nb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
            <div class="form-group">
    <label> Branch </label>
    <select id="reportType" name="branch" class="form-control" onchange="changeTableFormat()" required>
        <option value="" disabled selected>Select Weekly or Daily</option>
        <option value="Weekly">Weekly</option>
        <option value="Daily">Daily</option>
    </select>
</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                $connection = mysqli_connect("localhost","root","","dbpharmacy");
                $query = "SELECT * FROM  sales_report_list";
                $query_run = mysqli_query($connection, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>                        
                        <th> Date </th>
                        <th> Time </th>
                        <th> Mode of Payment </th>
                        <th> Transaction no. </th>
                        <th> List of Items </th>
                        <th> Total </th>
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
                            <td> <?php echo $row['date']; ?> - <span style='font-size: 80%;'><?php echo $row['measurement']; ?></span></td>
                            <td> <?php echo $row['time']; ?></td>
                            <td> <?php echo $row['mode_of_payment']; ?></td>
                            <td> <?php echo $row['list_of_items']; ?></td>   
                            <td> <?php echo $row['Total']; ?></td>       
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
            <div class="table-responsive" id="weeklyTable" style="display: none;">
    <!-- Your Weekly Table -->
    <table class="table table-bordered" id="weeklyDataTable" width="100%" cellspacing="0">
        <thead>
            <th> Week </th>
            <th> Start Date </th>
            <th> End Date </th>
            <th> Total Sales </th>
            <th> Average Daily Sales </th>
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
                            <td> <?php echo $row['date']; ?> - <span style='font-size: 80%;'><?php echo $row['measurement']; ?></span></td>
                            <td> <?php echo $row['time']; ?></td>
                            <td> <?php echo $row['mode_of_payment']; ?></td>
                            <td> <?php echo $row['list_of_items']; ?></td>   
                            <td> <?php echo $row['Total']; ?></td>       
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
