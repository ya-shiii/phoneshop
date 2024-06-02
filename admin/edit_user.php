<?php
// Include database configuration
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST['editUserId'];
    $username = $_POST['editUsername'];
    $email = $_POST['editEmail'];

    // Check if the new username already exists
    $checkUsernameSql = "SELECT id FROM users WHERE username='$username' AND id != $userId";
    $resultUsername = mysqli_query($conn, $checkUsernameSql);

    // Check if the new email already exists
    $checkEmailSql = "SELECT id FROM users WHERE email='$email' AND id != $userId";
    $resultEmail = mysqli_query($conn, $checkEmailSql);

    if (mysqli_num_rows($resultUsername) > 0) {
        // Username already exists, return error response
        echo json_encode(array("status" => "error", "message" => "Username already exists"));
    } elseif (mysqli_num_rows($resultEmail) > 0) {
        // Email already exists, return error response
        echo json_encode(array("status" => "error", "message" => "Email already exists"));
    } else {
        // No duplicates found, proceed to update user details
        $fname = $_POST['editFname'];
        $lname = $_POST['editLname'];
        $role = $_POST['editRole'];

        // Update user details in the database
        $sql = "UPDATE users SET username='$username', fname='$fname', lname='$lname', email='$email', role='$role' WHERE id=$userId";

        if (mysqli_query($conn, $sql)) {
            // If update successful, send success message
            echo json_encode(array("status" => "success", "message" => "User details updated successfully"));
        } else {
            // If update fails, send error message
            echo json_encode(array("status" => "error", "message" => "Error updating user details: " . mysqli_error($conn)));
        }
    }
}

// Close connection
mysqli_close($conn);
?>
