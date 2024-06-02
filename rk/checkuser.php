<?php
session_start();

$servername = "localhost";
$dbusername = "root";
$dbpassword = "newpassword";
$dbname = "reederie";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uname = $conn->real_escape_string($_POST["uname"]);
$password = $conn->real_escape_string($_POST["password"]);

// Prepare and bind
$sql = "SELECT * FROM user WHERE BINARY Uname ='$uname' AND BINARY Pass = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    echo "Access Granted";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Access Granted",
            text: "Login successful",
            icon: "success"
        });
    </script>
    <?php
       if ($row = $result->fetch_assoc()){
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['UserType'] = $row['UserType'];
            
        }
        header('Refresh: 2; URL = view.php');
} else {
    echo "Access Denied";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Access Denied",
            text: "Invalid username or password",
            icon: "error"
        }).then(function() {
            window.location = "Login.php";
        });
    </script>
    <?php
}

$conn->close();
?>
