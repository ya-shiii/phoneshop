<?php
include 'config.php';

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    $sql = "UPDATE checkout SET status='Checked Out', order_status='Pending' WHERE id=$orderId";
    
    if (mysqli_query($conn, $sql)) {
        echo "Order checked out successfully!";
    } else {
        echo "Error checking out order: " . mysqli_error($conn);
    }
} else {
    echo "Invalid order ID.";
}

mysqli_close($conn);
?>
