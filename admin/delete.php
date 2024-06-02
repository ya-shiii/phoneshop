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


    $sqlDelete = "DELETE FROM phones WHERE phone_id=$phoneId";

    if (mysqli_query($conn, $sqlDelete)) {
        unlink("img/$imageFilename"); 
    } else {
    }
}

// Close connection
mysqli_close($conn);
?>
