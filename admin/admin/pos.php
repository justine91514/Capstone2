<?php
session_start();
include 'includes/header_pos.php';
include 'includes/navbar_pos.php';

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

                <label class="input-skulabel" for="barcode" id="productInfoLabel">Barcode:</label>
                <input type="text" class="form-control" id="barcode" autocomplete="off" readonly>

                <label class="input-skulabel" for="descript" id="productquantLabel">Description:</label>
                <input type="text" class="form-control" id="descript" autocomplete="off"readonly>

                <label class="input-skulabel" for="price" id="productStocksLabel">Price:</label>
                <input type="text" class="form-control" id="price" autocomplete="off" readonly>

                <label class="input-skulabel" for="quantity " id="productpriceLabel">Quantity:</label>
                <input type="text" class="form-control" id="quantity" autocomplete="off" readonly>


                <div class="container-fluid">

                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#payment">
                      Proceed To Payment
                    </button>
                    <button type="button" name="void_btn" class="btn btn-primary" id="voidButton">Void</button>
                    <button type="button" name="delete_void_btn" class="btn btn-primary" id="delete_void_Button">Delete</button>
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
                            <form action="code.php" method="POST"
                                <div class="modal-body">
                                    <div class="form-group">
                                    <label class="input-skulabel" for="sub_total">Sub Total:</label>
                                    <input type="text" class="form-control" name="sub_total" id="sub_total" autocomplete="off" readonly>
                                    <label>Discounts</label>
                                        <select id="discountSelect" name="discount" class="form-control">
                                            <option value="">No Discount</option> <!-- Empty option -->
                                            <?php
                                                // Include the database connection file
                                                include 'dbconfig.php';
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
                                <label class="input-skulabel" for="total">Grand Total:</label>
                                <input type="text" class="form-control" name="total" id="total" autocomplete="off" readonly>

                                <label>Cash</label>
                                <input type="text" class="form-control" id="cash">

                                <label>Change</label>
                                <input type="text" class="form-control" id="change" readonly>


                                <input type="hidden" id="payment_mode" name="mode_of_payment">

                                
                                <div>
                                    <label>Select Payment Mode:</label>
                                    <div>
                                        <input type="radio" id="cashRadio" name="mode_of_payment" value="Cash" checked>
                                        <label for="cashRadio">Cash</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="gcashRadio" name="mode_of_payment" value="G-Cash">
                                        <label for="gcashRadio">G-Cash</label>
                                    </div>
                                </div>

                                <label>Reference#</label>
                                <input type="text" name="ref_no" class="form-control" id="referenceInput" readonly>

                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <form action="transaction_history.php" method="POST">
                                    <!-- Existing form fields -->
                                    <input type="text" name="full_name" value="<?php echo $user_info['first_name'] . ' ' . $user_info['mid_name'] . ' ' . $user_info['last_name']; ?>">

                                    <button type="submit" name="charge_btn" class="btn btn-primary" id="chargeButton" disabled>Charge</button>
                                </form>

                            </div>
                            </div>
                           
                        </form>

                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
    // Store the original total amount
    var originalTotal = parseFloat($('#total').val());

    $('#discountSelect').change(function() {
        // Get the selected discount value
        var discountValue = parseFloat($(this).val());

        // If a valid discount value is selected
        if (!isNaN(discountValue)) {
            // Calculate the discounted total
            var discountedTotal = originalTotal - (originalTotal * (discountValue / 100));

            // Update the total input field with the discounted total
            $('#total').val(discountedTotal.toFixed(2));
        } else {
            // If no discount is selected, revert back to the original total
            $('#total').val(originalTotal.toFixed(2));
        }
    });
});

                </script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                
                <script>
    // Event listener for radio button change
    document.querySelectorAll('input[name="mode_of_payment"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var referenceInput = document.getElementById('referenceInput');
            if (this.value === 'G-Cash') {
                referenceInput.removeAttribute('readonly');
            } else {
                referenceInput.setAttribute('readonly', true);
            }
        });
    });

    function selectPaymentMode(mode) {
        document.getElementById('payment_mode').value = mode;
    }
</script>

<script>
    $(document).ready(function() {
        var voidButtonClicked = false;

        // Deactivate the "Void" button initially
        $('#voidButton').prop('disabled', true);
        $('#delete_void_Button').hide(); // Hide the Delete button initially

        $('#voidButton').click(function() {
            if ($(this).text() === 'Void') { 
                voidButtonClicked = false;
                $(this).text('Cancel Void');
                $('#productInfoLabel').text('Product Name:');
                $('#productquantLabel').text('Quantity:');
                $('#productStocksLabel').text('Stocks Available:');
                $('#productpriceLabel').text('Price:');
                
                $('#barcode').val('');
                $('#descript').val('');
                $('#price').val('');
                $('#quantity').val('');
                enableTableRowSelection();
               
                $('#delete_void_Button').show();
            } else { 
                voidButtonClicked = true;
                $(this).text('Void');
                $('#productInfoLabel').text('Barcode:');
                $('#productquantLabel').text('Description:');
                $('#productStocksLabel').text('Price:');
                $('#productpriceLabel').text('Quantity:');
                
                $('#barcode').val('');
                $('#descript').val('');
                $('#price').val('');
                $('#quantity').val('');
                $('#delete_void_Button').hide(); 
                enableTableRowSelection();
            }
        });

        // Check the content of #scannedItems before enabling or disabling the "Void" button
        function checkTableContent() {
            if ($('#scannedItems tr').length > 0) {
                $('#voidButton').prop('disabled', false);
            } else {
                $('#voidButton').prop('disabled', true);
            }
        }

        function disableTableRowSelection() {
            $('#scannedItems').off('click', 'tr'); // Turn off the event listener for clicking on table rows
            $('#scannedItems tr').removeClass('selected'); // Remove the selected class from all rows
            $('#barcode').val('');
            $('#descript').val('');
            $('#price').val('');
            $('#quantity').val('');
        }

        function enableTableRowSelection() {
            $('#scannedItems').on('click', 'tr', function() {
                if (!voidButtonClicked) { 
                    if (!$(this).hasClass('selected')) {
                        $('#barcode').val('');
                        $('#descript').val('');
                        $('#price').val('');
                        $('#quantity').val('');
                    }
                    $(this).toggleClass('selected').siblings().removeClass('selected');
                    if ($(this).hasClass('selected')) {
                        var productNameWithMeasurement = $(this).find('td:eq(0)').text();
                        var quantity = $(this).find('td:eq(1)').text();
                        var stocksAvailable = $(this).find('td:eq(2)').text();
                        var price = $(this).find('td:eq(3)').text();

                        $('#barcode').val(productNameWithMeasurement);
                        $('#descript').val(quantity);
                        $('#price').val(stocksAvailable);
                        $('#quantity').val(price);
                    }
                }
            });
        }

        // Call the checkTableContent function whenever there is a change in table content
        $('#scannedItems').on('DOMSubtreeModified', function() {
            checkTableContent();
        });

        // Check the table content initially
        checkTableContent();
    });

    $(document).ready(function() {
        // Event listener for the Delete button
        $('#delete_void_Button').click(function() {
            // Confirm if any row is selected
            if ($('#scannedItems tr.selected').length >= 0) {
                // Remove each selected row
                $('#scannedItems tr.selected').remove();
                // After deletion, clear the selected fields
                var totalAmount = 0;
                $('#scannedItems tr').each(function() {
                    var quantity = parseFloat($(this).find('td:eq(1)').text());
                    var price = parseFloat($(this).find('td:eq(3)').text());
                    totalAmount += quantity * price;
                });

                // Update Sub Total
                $('#sub_total').val(totalAmount.toFixed(2));

                // Check if there's a discount applied
                var discountValue = parseFloat($('#discountSelect').val());
                if (!isNaN(discountValue)) {
                    var discountedAmount = totalAmount - (totalAmount * (discountValue / 100));
                    $('#total').val(discountedAmount.toFixed(2));
                } else {
                    $('#total').val(totalAmount.toFixed(2));
                }

                // Recalculate change
                calculateChange();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var originalAmount = parseFloat($('#total').val());
        var originalPrice = originalAmount; // Store original price

        var scannedProducts = {};

        $('#discountSelect').change(function() {
            var discountValue = parseFloat($(this).val());

            if (!isNaN(discountValue)) {
                var discountedAmount = originalAmount - (originalAmount * (discountValue / 100));
                $('#total').val(discountedAmount.toFixed(2));
                calculateChange(); // Recalculate change when discount changes
            } else {
                $('#total').val(originalAmount.toFixed(2));
                calculateChange(); // Recalculate change when discount is removed
            }
        });

        $('#cash').on('input', function() {
            var cash = parseFloat($(this).val());

            // Check if the Cash input field is not empty
            if (!isNaN(cash) && cash > 0) {
                // Enable the charge button
                $('#chargeButton').prop('disabled', false);
            } else {
                // Disable the charge button if empty
                $('#chargeButton').prop('disabled', true);
            }

            calculateChange(); 
        });

        // Function to calculate change
        function calculateChange() {
            var cash = parseFloat($('#cash').val());
            var total = parseFloat($('#total').val());

            if (!isNaN(cash)) {
                var change = cash - total;
                if (change >= 0) {
                    $('#change').val(change.toFixed(2));
                } else {
                    $('#change').val('not enough money, add more');
                }
            } else {
                $('#change').val('');
            }
        }

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
                                $('#product_stock_name').val(productNameWithMeasurement);

                                var productName = responseData[0].product_stock_name;
                                var measurement = responseData[0].measurement;

                                var productNameWithMeasurement = productName + ' - ' + measurement; 

                                if (scannedProducts.hasOwnProperty(productNameWithMeasurement)) { 
                                    scannedProducts[productNameWithMeasurement]++;
                                    $('#quantity').val(scannedProducts[productNameWithMeasurement]);
                                    $('#scannedItems td:contains("' + productNameWithMeasurement + '")').next().text(scannedProducts[productNameWithMeasurement]);
                                } else {
                                    scannedProducts[productNameWithMeasurement] = 1;
                                    var html = "<tr>" +
                                        "<td>" + productNameWithMeasurement + "</td>" + 
                                        "<td>" + scannedProducts[productNameWithMeasurement] + "</td>" +
                                        "<td>" + responseData[0].stocks_available + "</td>" +
                                        "<td>" + responseData[0].price + "</td>" +
                                        "</tr>";

                                    $('#scannedItems').append(html);

                                    $('#quantity').val(scannedProducts[productNameWithMeasurement]);
                                }

                                // Update Total Price
                                var totalAmount = 0;
                                $('#scannedItems tr').each(function() {
                                    var quantity = parseFloat($(this).find('td:eq(1)').text());
                                    var price = parseFloat($(this).find('td:eq(3)').text());
                                    totalAmount += quantity * price;
                                });
                                $('#sub_total').val(totalAmount.toFixed(2));

                                // Update Total Amount only if no discount applied
                                var discountValue = parseFloat($('#discountSelect').val());
                                if (isNaN(discountValue)) {
                                    $('#total').val(totalAmount.toFixed(2));
                                    calculateChange(); 
                                }

                                originalAmount = totalAmount;

                                // Store scanned products in session
                                $.ajax({
                                    url: "store_scanned_products.php",
                                    method: "POST",
                                    data: { scannedProducts: scannedProducts },
                                    success: function(response) {
                                        console.log(response); 
                                    }
                                });

                                // After appending HTML to the table, store the productList in a hidden input field
                                var productList = []; 
                                $('#scannedItems tr').each(function() {
                                    var productName = $(this).find('td:eq(0)').text();
                                    productList.push(productName);
                                });

                                $('<input>').attr({
                                    type: 'hidden',
                                    id: 'productList',
                                    name: 'productList',
                                    value: JSON.stringify(productList) 
                                }).appendTo('form');


                                $.ajax({
                                    url: "code.php",
                                    method: "POST",
                                    data: {
                                        scannedProducts: scannedProducts,
                                        productList: JSON.stringify(productList) 
                                    },
                                    success: function(response) {
                                        console.log(response); 
                                    }
                                });
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

        $('form').submit(function() {
            $('#productName').val($('#product_stock_name').val());
            $('#quantity').val($('#quantity').val());
            $('#price').val($('#price').val());
        });

        // Initial calculation of change
        calculateChange();
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
            <a class="btn btn-primary" href="index.php">Logout</a>
        </div>
    </div>
</div>
</div>
<?php
include 'includes/scripts.php';
include 'includes/footer.php';
?>
