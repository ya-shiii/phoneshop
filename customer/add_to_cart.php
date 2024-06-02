<?php
include '../conn/config.php';

$userId = $_POST['userId'];
$phoneId = $_POST['phoneId'];
$brand = $_POST['checkoutBrand'];
$model = $_POST['checkoutModel'];
$fname = $_POST['checkoutFname'];
$lname = $_POST['checkoutLname'];
$address = $_POST['checkoutAddress'];

// Begin transaction
mysqli_begin_transaction($conn);

try {
    // Insert the new order into the checkout table
    $sql = "INSERT INTO checkout (phone_id, brand, model, customer_id, fname, lname, `address`, `status`, order_status) 
            VALUES ('$phoneId', '$brand', '$model', '$userId', '$fname', '$lname', '$address', 'Cart', 'Pending')";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error placing order: " . mysqli_error($conn));
    }

    // Update the phones table, decrementing the quantity by 1
    $updatePhoneSql = "UPDATE phones SET quantity = quantity - 1 WHERE phone_id='$phoneId'";
    if (!mysqli_query($conn, $updatePhoneSql)) {
        throw new Exception("Error updating phone quantity: " . mysqli_error($conn));
    }

    // Commit the transaction
    mysqli_commit($conn);
    echo "Order placed successfully and phone quantity updated!";
} catch (Exception $e) {
    // Rollback the transaction if any query fails
    mysqli_rollback($conn);
    echo $e->getMessage();
}

mysqli_close($conn);
?>
