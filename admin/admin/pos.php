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
                                <button type="submit" name="charge_btn" class="btn btn-primary" id="chargeButton" disabled>Charge</button>

                            </div>
                            </div>
                           
                        </form>

                        </div>
                    </div>
                </div>
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

        </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function selectPaymentMode(mode) {
        document.getElementById('payment_mode').value = mode;
    }
</script>

<script>
        $(document).ready(function() {
    var voidButtonClicked = false;

    // I-deactivate ang "Void" button sa simula
    $('#voidButton').prop('disabled', true);
    $('#delete_void_Button').hide(); // Itago ang Delete button sa simula

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
        }
    });

    // I-check ang laman ng #scannedItems bago mag-activate o mag-deactivate ng "Void" button
    function checkTableContent() {
        if ($('#scannedItems tr').length > 0) {
            $('#voidButton').prop('disabled', false);
        } else {
            $('#voidButton').prop('disabled', true);
        }
    }

    function disableTableRowSelection() {
        $('#scannedItems').off('click', 'tr'); // I-turn off ang event listener para sa pag-click sa row ng table
        $('#scannedItems tr').removeClass('selected'); // I-remove ang selected class sa lahat ng rows
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

    // Tawagan ang checkTableContent function tuwing may pagbabago sa table content
    $('#scannedItems').on('DOMSubtreeModified', function() {
        checkTableContent();
    });

    // I-check din ang table content sa simula
    checkTableContent();
});

$(document).ready(function() {
    // Event listener para sa Delete button
    $('#delete_void_Button').click(function() {
        // Kumpirmahin kung mayroong napiling row
        if ($('#scannedItems tr.selected').length >= 0) {
            // Alisin ang bawat napiling row
            $('#scannedItems tr.selected').remove();
            // Pagkatapos ma-delete, i-clear ang mga field na naka-select
            $('#barcode').val('');
            $('#descript').val('');
            $('#price').val('');
            $('#quantity').val('');
            
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

        // Check kung may laman ang Cash input field
        if (!isNaN(cash) && cash > 0) {
            // Enable charge button
            $('#chargeButton').prop('disabled', false);
        } else {
            // Disable charge button kung walang laman
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

                                var productNameWithMeasurement = productName + ' - ' + measurement; // Concatenate product name and measurement

                                if (scannedProducts.hasOwnProperty(productNameWithMeasurement)) { // Modify here
                                    scannedProducts[productNameWithMeasurement]++;
                                    $('#quantity').val(scannedProducts[productNameWithMeasurement]);
                                    $('#scannedItems td:contains("' + productNameWithMeasurement + '")').next().text(scannedProducts[productNameWithMeasurement]);
                                } else {
                                    scannedProducts[productNameWithMeasurement] = 1;
                                    var html = "<tr>" +
                                        "<td>" + productNameWithMeasurement + "</td>" + // Display concatenated product name with measurement

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
                                    calculateChange(); // Recalculate change if no discount applied
                                }

                                originalAmount = totalAmount;

                                // Store scanned products in session
                                $.ajax({
                                    url: "store_scanned_products.php",
                                    method: "POST",
                                    data: { scannedProducts: scannedProducts },
                                    success: function(response) {
                                        console.log(response); // Optional: Log the response for debugging
                                    }
                                });

                                // Pagkatapos ng pag-append ng HTML sa table, i-store ang productList sa isang input field na hidden
                                var productList = []; // Magdagdag ng array para sa mga produkto
                                $('#scannedItems tr').each(function() {
                                    var productName = $(this).find('td:eq(0)').text();
                                    productList.push(productName);
                                });

                                // I-store ang productList sa isang input field na hidden
                                $('<input>').attr({
                                    type: 'hidden',
                                    id: 'productList',
                                    name: 'productList',
                                    value: JSON.stringify(productList) // I-convert sa JSON format
                                }).appendTo('form');


                                $.ajax({
                                    url: "code.php",
                                    method: "POST",
                                    data: {
                                        scannedProducts: scannedProducts,
                                        productList: JSON.stringify(productList) // Ito ang product list na ipapasa
                                    },
                                    success: function(response) {
                                        console.log(response); // Optional: Log the response for debugging
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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
include 'includes/scripts.php';
include 'includes/footer.php';
?>
