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
    <title>Cashier</title>
</head>
<body>
    <div class="container" style="max-width: 80%; display: flex;">

        <div style="flex: 1;">
            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> SKU </th>
                        <th> Product Name </th>
                        <th> Quantity </th>
                        <th> Stocks Available </th>
                        <th> Expiry Date </th>
                        <th> Price </th>
                    </tr>
                </thead>
                <tbody id="scannedItems">
                    <!-- Scanned items will be appended here -->
                </tbody>
            </table>
        </div>

        <div style="flex: 1;">
            <div class="text-center mt-5 mb-4">
                <h2>Cashier</h2>
            </div>

            <div style="position: relative;">
            <input type="text" class="form-control" id="dbpharmacy" autocomplete="off"
                placeholder="Input SKU ...">
            <div id="searchresult" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 999; background-color: #fff; border: 1px solid #ced4da; border-top: none; display: none;"></div>
        </div>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){

            $("#dbpharmacy").on('input', function(){
                var input = $(this).val();

                if(input != ""){
                    $.ajax({
                        url:"livesearch.php",
                        method:"POST",
                        data:{input:input},

                        success:function(data){
                            $("#searchresult").html(data);
                        }
                    });
                }else{
                    $("#searchresult").css("display","none");
                }
            });

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
                                // Append the scanned data to the table
                                $('#scannedItems').append(data);
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
</body>
</html>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
