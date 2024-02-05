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
    <title>Point of Sale</title>
    <?php include('includes/scripts.php'); ?> <!-- Include scripts here -->
    <script>
    $(document).ready(function () {
        // Listen for barcode input changes
        $('#barcodeInput').on('input', function () {
            var barcode = $(this).val();

            // Send AJAX request to check for matching barcode
            $.ajax({
                type: 'POST',
                url: 'barcode_lookup.php',
                data: { barcode: barcode },
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    // Update the table with the response data
                    var tableRow = '<tr>';
                    tableRow += '<td>' + response.id + '</td>';
                    tableRow += '<td>' + response.product_stock_name + '</td>';
                    tableRow += '<td>' + response.quantity + '</td>';
                    tableRow += '<td>' + response.price + '</td>';
                    tableRow += '</tr>';

                    $('#dataTable tbody').html(tableRow);
                }
            });
        });
    });
</script>

</head>
<body>

<div class="container-fluid">
        <div class="row">
            <!-- Left Column: Table -->
            <div class="col-lg-8">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <th> ID </th>
                                <th> Product Name </th>
                                <th> Quantity </th>
                                <th> Price </th>
                            </thead>
                            <tbody>
                                <!-- Table content will be dynamically updated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Product Info -->
            <div class="col-lg-4">
                <div class="card-body">
                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="text" name="sku" id="barcodeInput" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>