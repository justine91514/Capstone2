<?php
session_start();
include('includes/header_pos.php');
include('includes/navbar_pos.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier</title>
    <style>
        .container {
            max-width: 80%;
            display: flex;
            align-items: flex-start; /* Align items to the start (left side) */
        }

        .left-section {
            flex: 1;
        }

        .right-section {
            flex: 1;
            margin-left: 20px; /* Add margin between the two sections */
        }

        .product-info {
            text-align: left;
            margin-bottom: 20px;
        }

        .input-skulabel {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <input type="text" class="form-control" id="dbpharmacy" autocomplete="off"
                placeholder="Input SKU ...">
            <div id="searchresult" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 999; background-color: #fff; border: 1px solid #ced4da; border-top: none; display: none;"></div>

            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>                                           
                        <th> Product Name </th>
                        <th> Quantity </th>
                        <th> Stocks Available </th>
                        <th> Price </th>
                    </tr>
                </thead>
                <tbody id="scannedItems">
                    <!-- Scanned items will be appended here -->
                </tbody>
            </table>
        </div>

        <div class="right-section">
            <div class="product-info">
                <h2>PRODUCT INFO</h2>
                <label class="input-skulabel" for="barcode">Barcode:</label>
                <input type="text" class="form-control" id="barcode" autocomplete="off">
                
                <label class="input-skulabel" for="description">Description:</label>
                <input type="text" class="form-control" id="description" autocomplete="off">
                
                <label class="input-skulabel" for="price">Price:</label>
                <input type="text" class="form-control" id="price" autocomplete="off">
                
                <label class="input-skulabel" for="quantity">Quantity:</label>
                <input type="text" class="form-control" id="quantity" autocomplete="off">

                <label class="input-skulabel" for="total">Total Amount:</label>
                <input type="text" class="form-control" id="total" autocomplete="off">

                <div class="container-fluid">

                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#payment">
                      Proceed To Payment
                    </button>
                </h6>
        
           <!-- Modal -->
                <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Mode of Payment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="code.php" method="POST">
                                <div class="modal-body">
                                    <div class="form-group">
                                    <label>Discounts</label>
                                    <label>Discounts</label>
                                        <select id="discountSelect" name="discount" class="form-control" required>
                                            
                                            <option value="">No Discount</option> <!-- Empty option -->
                                            <?php
                                            // Include the database connection file
                                            include('dbconfig.php');
                                            
                                            // Fetch discount options from the database
                                            $query = "SELECT * FROM discount_list";
                                            $result = mysqli_query($connection, $query);
                                            
                                            // Loop through the results and display each discount option
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['value']}'>{$row['discount_name']} - {$row['value']}%</option>";
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="categorybtn" class="btn btn-primary">Charge</button>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>
        

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
    // Event listener for barcode scanner
    $('#dbpharmacy').keypress(function(e){
        if(e.which === 13){ // 13 is the ASCII code for Enter key
            var input = $(this).val();
            if(input != ""){
                $.ajax({
                    url:"livesearch.php",
                    method:"POST",
                    data:{input:input},

                    success:function(data){
                        // Parse JSON response
                        var responseData = JSON.parse(data);
                        // Check if data exists
                        if(responseData.length > 0) {
                            // Update description, price, and quantity fields
                            $('#description').val(responseData[0].description);
                            $('#price').val(responseData[0].price);
                            $('#quantity').val(responseData[0].quantity);
                            // Append new rows to the table
                            for(var i = 0; i < responseData.length; i++) {
                                $('#scannedItems').append(responseData[i].html);
                            }
                            // Calculate total amount
                            var totalAmount = 0;
                            $('#scannedItems tr').each(function() {
                                totalAmount += parseFloat($(this).find('td:last').text());
                            });
                            // Set total amount in the input field
                            $('#total').val(totalAmount.toFixed(2)); // Assuming you want to display 2 decimal places
                        } else {
                            // If no data found, clear the fields
                            $('#description').val('');
                            $('#price').val('');
                            $('#quantity').val('');
                            // Clear total amount
                            $('#total').val('');
                        }
                        // Populate the Barcode input field with the scanned value
                        $('#barcode').val(input);
                    }
                });
            }
            // Clear the input field after scanning
            $(this).val('');
            // Prevent form submission
            e.preventDefault();
        }
    });
});
    </script>   
    <script>
$(document).ready(function(){
    $('#discountSelect').change(function(){
        // Get the selected discount value
        var discountValue = $(this).val();

        // Calculate discounted total amount
        var totalAmount = parseFloat($('#total').val());
        if (discountValue !== "") {
            // If a discount is selected, calculate the discounted amount
            var discountAmount = totalAmount * (discountValue / 100);
            totalAmount -= discountAmount;
        }
        
        // Update the total amount input field
        $('#total').val(totalAmount.toFixed(2)); // Assuming you want to display 2 decimal places
    });
});
</script>
             
</body>
</html>
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
