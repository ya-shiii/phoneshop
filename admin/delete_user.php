<?php
// Include database configuration
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID from POST data
    $userId = $_POST['userId'];

    // SQL query to delete the user
    $sqlDelete = "DELETE FROM users WHERE id = $userId";

    if (mysqli_query($conn, $sqlDelete)) {
        // If delete successful, send success response
        echo json_encode(array("status" => "success", "message" => "User deleted successfully"));
    } else {
        // If delete fails, send error response
        echo json_encode(array("status" => "error", "message" => "Error deleting user: " . mysqli_error($conn)));
    }
}

// Close connection
mysqli_close($conn);
?>
