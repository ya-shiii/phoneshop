<?php
include '../conn/config.php';

$phoneId = $_POST['phoneId'];
$brand = $_POST['checkoutBrand'];
$model = $_POST['checkoutModel'];
$fname = $_POST['checkoutFname'];
$lname = $_POST['checkoutLname'];
$address = $_POST['checkoutAddress'];

$sql = "INSERT INTO checkout (phone_id, brand, model, fname, lname, address) VALUES ('$phoneId', '$brand', '$model', '$fname', '$lname', '$address')";

if (mysqli_query($conn, $sql)) {
    echo "Order placed successfully";
} else {
    echo "Error placing order: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
