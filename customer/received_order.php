<?php
include 'config.php';

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    // Update the order status to 'Received' and status to 'Completed'
    $sql = "UPDATE checkout SET status='Completed', order_status='Received' WHERE id=$orderId";
    
    if (mysqli_query($conn, $sql)) {
        echo "Order received successfully!";
    } else {
        echo "Error receiving order: " . mysqli_error($conn);
    }
} else {
    echo "Invalid order ID.";
}

mysqli_close($conn);
?>
