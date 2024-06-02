<?php
include '../conn/config.php';

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    // Delete the order
    $sql = "DELETE FROM checkout WHERE id=$orderId";
    
    if (mysqli_query($conn, $sql)) {
        echo "Order deleted successfully!";
    } else {
        echo "Error deleting order: " . mysqli_error($conn);
    }
} else {
    echo "Invalid order ID.";
}

mysqli_close($conn);
?>
