<?php
$servername = "localhost";
$username = "root";
$password = "newpassword";
$dbname = "phoneshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pname = $_POST['name'];
$description = $_POST['description'];
$quantity = $_POST['price']; 
$category1 = $_POST['quantity'];
$product_price = $_POST['stock'];

$sql = "INSERT INTO devices (name, description, price, quantity, stock) VALUES ('$name', '$description', '$price', '$quantity', '$stock')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    $target_dir = "image/";
    $new_filename = $last_id . ".jpg";
    $target_file = $target_dir . $new_filename;
    move_uploaded_file($_FILES["prod_image"]["tmp_name"], $target_file);
    echo "<script>";
        echo "alert('Product added successfully');";
        echo "window.location.href = 'viewDevice.php';";
        echo "</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
