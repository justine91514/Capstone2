<?php
session_start();
include('includes/header_pos.php');
include('includes/navbar_pos.php');
?>
<?php
    date_default_timezone_set('Asia/Manila');
    echo date('g:i:a');
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

                <input type="hidden" class="form-control" id="product_stock_name" autocomplete="off">
                
                <label class="input-skulabel" for="barcode">Barcode:</label>
                <input type="text" class="form-control" id="barcode" autocomplete="off">
                
                <label class="input-skulabel" for="descript">Description:</label>
                <input type="text" class="form-control" id="descript" autocomplete="off">
                
                <label class="input-skulabel" for="price">Price:</label>
                <input type="text" class="form-control" id="price" autocomplete="off">
                
                <label class="input-skulabel" for="quantity">Quantity:</label>
                <input type="text" class="form-control" id="quantity" autocomplete="off">

                <label class="input-skulabel" for="total">Total Amount:</label>
                <input type="text" class="form-control" id="total" autocomplete="off" readonly>

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
                                        <select id="discountSelect" name="discount" class="form-control">
                                            
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
                                <button type="button" class="btn btn-primary" onclick="selectPaymentMode('Cash')">Cash</button>
                                <button type="button" class="btn btn-primary" onclick="selectPaymentMode('G-Cash')">G-Cash</button>

                                <input type="hidden" id="payment_mode" name="mode_of_payment">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="charge_btn" class="btn btn-primary">Charge</button>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>
        

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function selectPaymentMode(mode) {
        document.getElementById('payment_mode').value = mode;
    }
</script>

    <script>
        $(document).ready(function() {
    var originalAmount = parseFloat($('#total').val());
    var scannedProducts = {};

    $('#discountSelect').change(function() {
        var totalAmount = parseFloat($('#total').val());
        var discountValue = parseFloat($(this).val());
        
        if (!isNaN(discountValue)) {
            var discountedAmount = originalAmount - (originalAmount * (discountValue / 100));
            $('#total').val(discountedAmount.toFixed(2));
        } else {
            $('#total').val(originalAmount.toFixed(2));
        }
    });

    $('#dbpharmacy').keypress(function(e) {
    if (e.which === 13) {
        var input = $(this).val();
        if (input != "") {
            $.ajax({
                url: "livesearch.php",
                method: "POST",
                data: { input: input },
                success: function(data) {
                    var responseData = JSON.parse(data);
                    if (responseData.length > 0) {
                        $('#descript').val(responseData[0].descript);
                        $('#price').val(responseData[0].price);
                        
                        var productName = responseData[0].product_stock_name;
                        var measurement = responseData[0].measurement;
                        var productNameWithMeasurement = productName + ' - ' + measurement; // Concatenate product name and measurement
                        $('#product_stock_name').val(productNameWithMeasurement);
                        if (scannedProducts.hasOwnProperty(productName)) {
                            scannedProducts[productName]++;
                            $('#quantity').val(scannedProducts[productName]);
                            $('#scannedItems td:contains("' + productName + '")').next().text(scannedProducts[productName]);
                        } else {
                            scannedProducts[productName] = 1;
                            var html = "<tr>" + 
                            "<td>" + productNameWithMeasurement + "</td>" + // Display concatenated product name with measurement
                                        "<td>" + scannedProducts[productName] + "</td>" + 
                                        "<td>" + responseData[0].stocks_available + "</td>" + 
                                        "<td>" + responseData[0].price + "</td>" + 
                                    "</tr>";

                            $('#scannedItems').append(html);

                            $('#quantity').val(scannedProducts[productName]);
                        }

                        var totalAmount = 0;
                        $('#scannedItems tr').each(function() {
                            var quantity = parseFloat($(this).find('td:eq(1)').text());
                            var price = parseFloat($(this).find('td:eq(3)').text());
                            totalAmount += quantity * price;
                        });
                        $('#total').val(totalAmount.toFixed(2));
                        originalAmount = totalAmount;
                    } else {
                        $('#descript').val('');
                        $('#price').val('');
                        $('#quantity').val('');
                        $('#total').val('');
                    }
                    $('#barcode').val(input);
                }
            });
        }
        $(this).val('');
        e.preventDefault();
    }
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


