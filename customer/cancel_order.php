<?php
include 'config.php';

if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    
    // Begin transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Get the phone_id associated with the order
        $phoneSql = "SELECT * FROM checkout WHERE id=$orderId";
        $phoneResult = mysqli_query($conn, $phoneSql);
        if (!$phoneResult || mysqli_num_rows($phoneResult) == 0) {
            throw new Exception("Phone ID not found for order ID $orderId.");
        }
        $phoneRow = mysqli_fetch_assoc($phoneResult);
        $phoneId = $phoneRow['phone_id'];
        
        // Increment the quantity of the corresponding phone in the phones table by 1
        $updatePhoneSql = "UPDATE phones SET quantity = quantity + 1 WHERE phone_id='$phoneId'";
        if (!mysqli_query($conn, $updatePhoneSql)) {
            throw new Exception("Error updating phone quantity: " . mysqli_error($conn));
        }
        
        // Delete the order
        $deleteSql = "DELETE FROM checkout WHERE id=$orderId";
        if (!mysqli_query($conn, $deleteSql)) {
            throw new Exception("Error deleting order: " . mysqli_error($conn));
        }
        
        // Commit transaction
        mysqli_commit($conn);
        echo "Order canceled successfully and phone quantity updated!";
    } catch (Exception $e) {
        // Rollback transaction if any query fails
        mysqli_rollback($conn);
        echo $e->getMessage();
    }
} else {
    echo "Invalid order ID.";
}

mysqli_close($conn);
?>
