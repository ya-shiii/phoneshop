<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('status' => 'error', 'message' => 'User not logged in'));
    exit();
}

$userId = $_SESSION['user_id'];

// Retrieve and validate POST data
$orderId = isset($_POST['orderId']) ? intval($_POST['orderId']) : 0;
$phoneId = isset($_POST['phoneId']) ? intval($_POST['phoneId']) : 0;
$address = isset($_POST['checkoutAddress']) ? mysqli_real_escape_string($conn, trim($_POST['checkoutAddress'])) : '';

if ($orderId <= 0 || $phoneId <= 0 || empty($address)) {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid input data'));
    exit();
}

// Update the order in the database
$updateSql = "UPDATE checkout SET address='$address', status='Checked Out', order_status='Pending' WHERE id='$orderId' AND customer_id='$userId' AND phone_id='$phoneId'";

if (mysqli_query($conn, $updateSql)) {
    echo json_encode(array('status' => 'success', 'message' => 'Order checked out successfully'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Database update failed'));
}

mysqli_close($conn);
?>
