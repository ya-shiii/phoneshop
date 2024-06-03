<?php
session_start();
include '../conn/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('status' => 'error', 'message' => 'User not logged in'));
    exit();
}

$userId = $_SESSION['user_id'];

// Retrieve and validate POST data
$username = isset($_POST['editUsername']) ? mysqli_real_escape_string($conn, trim($_POST['editUsername'])) : '';
$fname = isset($_POST['editFname']) ? mysqli_real_escape_string($conn, trim($_POST['editFname'])) : '';
$lname = isset($_POST['editLname']) ? mysqli_real_escape_string($conn, trim($_POST['editLname'])) : '';
$email = isset($_POST['editEmail']) ? mysqli_real_escape_string($conn, trim($_POST['editEmail'])) : '';
$password = isset($_POST['editPassword']) ? mysqli_real_escape_string($conn, trim($_POST['editPassword'])) : '';

if (empty($username) || empty($fname) || empty($lname) || empty($email)) {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid input data'));
    exit();
}

// Update the user in the database
$updateSql = "UPDATE users SET username='$username', fname='$fname', lname='$lname', email='$email', password='$password' WHERE id='$userId'";

if (mysqli_query($conn, $updateSql)) {
    echo json_encode(array('status' => 'success', 'message' => 'User details updated successfully'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Database update failed'));
}

mysqli_close($conn);
?>
