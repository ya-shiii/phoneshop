<?php
// Include database configuration
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve phone ID from POST data
    $phoneId = $_POST['phoneId'];

    // Retrieve image filename from database
    $sqlImage = "SELECT image FROM phones WHERE phone_id=$phoneId";
    $resultImage = mysqli_query($conn, $sqlImage);
    $rowImage = mysqli_fetch_assoc($resultImage);
    $imageFilename = $rowImage['image'];

    // Delete rows from checkout table where phone_id matches
    $sqlDeleteCheckout = "DELETE FROM checkout WHERE phone_id=$phoneId";
    if (mysqli_query($conn, $sqlDeleteCheckout)) {
        // If rows are successfully deleted from checkout table, proceed to delete the phone entry
        // Prepare and execute delete query
        $sqlDelete = "DELETE FROM phones WHERE phone_id=$phoneId";
        if (mysqli_query($conn, $sqlDelete)) {
            // If phone entry is successfully deleted, delete the associated image file
            unlink("$imageFilename");
            // Redirect to view.php
            echo "<script>window.location.href = 'view.php'</script>";
        } else {
            echo "Error deleting phone entry: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting checkout entries: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
