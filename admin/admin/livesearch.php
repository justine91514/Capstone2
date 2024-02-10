<?php
include("dbconfig.php");
if (isset($_POST['input'])) {

    $input = $_POST['input'];

    $query = "SELECT add_stock_list.*, product_list.measurement 
              FROM add_stock_list
              JOIN product_list ON add_stock_list.product_stock_name = product_list.prod_name
              WHERE add_stock_list.sku LIKE '{$input}%'";

    $result = mysqli_query($connection, $query);

    $response = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $sku = $row['sku'];
            $product_stock_name = $row['product_stock_name'];
            $description = $row['description'];
            $quantity = $row['quantity'];
            $stocks_available = $row['stocks_available']; // Corrected
            $expiry_date = $row['expiry_date'];
            $price = $row['price'];
            $measurement = $row['measurement'];
            
            // Build HTML for appending to the table
            $html = "<tr>
                        <td>{$product_stock_name} - <span style='font-size: 80%;'>{$measurement}</span></td>
                        <td>{$quantity}</td>
                        <td>{$stocks_available}</td>
                        <td>{$price}</td>
                    </tr>";
            
            // Add data to response array
            $response[] = array(
                'description' => $description,
                'price' => $price,
                'quantity' => $quantity,
                'html' => $html
            );
        }
    } else {
        // If no data found
        $response[] = array(
            'description' => '',
            'price' => '',
            'quantity' => '',
            'html' => "<h6 class='text-danger text-center mt-3'>No Data Found</h6>"
        );
    }
    // Send JSON response
    echo json_encode($response);
}
?>