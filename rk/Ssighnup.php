<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "newpassword";
$dbname = "reederie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $usertype = 'customer';

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO user (Uname, Pass, UserType) VALUES ( ?, ?, ?)");
    $stmt->bind_param("sss", $uname, $password, $usertype);

    if ($stmt->execute()) {
        echo "Sign up successfully";
        echo "<script>";
        echo "alert('Sign up successfully');";
        $_SESSION['username'] = $uname;
        $_SESSION['userrole'] = 'customer'; // Set session role as 'customer'
        header("Location: view.php"); // Redirect to the homepage or any other page
        exit();
        echo "window.location.href = 'Login.php';";
        echo "</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}
$conn->close();
?>
