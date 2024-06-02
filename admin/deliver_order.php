<?php
include '../conn/config.php';

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    // Update the order to be En Route with status Pending
    $sql = "UPDATE checkout SET status='En Route', order_status='Pending' WHERE id=$orderId";
    
    if (mysqli_query($conn, $sql)) {
        echo "Order status updated to En Route!";
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid order ID.";
}

mysqli_close($conn);
?>
