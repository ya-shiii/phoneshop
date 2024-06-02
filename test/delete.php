<?php
require_once('config.php');
// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $product_no = $_GET['id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL to delete the product
    $sql_delete = "DELETE FROM devices WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);

    // Bind the product_no parameter
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Product deleted successfully
        echo "<script>";
        echo "alert('Product deleted successfully');";
        echo "window.location.href = 'viewDevices.php';";
        echo "</script>";
    } else {
        // Error deleting product
        echo "<script>";
        echo "alert('Error deleting product');";
        echo "window.location.href = 'viewDevices.php';";
        echo "</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect if 'id' is not set
    echo "<script>";
    echo "window.location.href = 'viewDevices.php';";
    echo "</script>";
}
?>
