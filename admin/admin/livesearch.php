<?php
include("dbconfig.php");
if (isset($_POST['input'])) {

    $input = $_POST['input'];

    $query = "SELECT add_stock_list.*, product_list.measurement 
              FROM add_stock_list
              JOIN product_list ON add_stock_list.product_stock_name = product_list.prod_name
              WHERE add_stock_list.sku LIKE '{$input}%'";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $sku = $row['sku'];
            $product_stock_name = $row['product_stock_name'];
            $quantity = $row['quantity'];
            $stocks_available = $row['stocks_available']; // Corrected
            $expiry_date = $row['expiry_date'];
            $price = $row['price'];
            $measurement = $row['measurement'];
            ?>

            <tr>
                <td><?php echo $id;?></td>
                <td><?php echo $sku;?></td>
                <td><?php echo $product_stock_name;?> - <span style='font-size: 80%;'><?php echo $measurement; ?></span></td>
                <td><?php echo $quantity;?></td>
                <td><?php echo $stocks_available;?></td>
                <td><?php echo $expiry_date;?></td>
                <td><?php echo $price;?></td>
            </tr>

            <?php
        }
    } else {
        echo "<h6 class='text-danger text-center mt-3'>No Data Found</h6>";
    }
}
?>
