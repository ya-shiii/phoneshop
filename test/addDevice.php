<?php
require_once('config.php'); // Include the database connection details

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $pname = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']); // Using floatval to ensure the price is a valid float number
    $quantity = intval($_POST['quantity']); // Using intval to ensure the quantity is a valid integer
    $stock = intval($_POST['stock']); // Using intval to ensure the stock is a valid integer

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO devices (name, description, price, quantity, stock) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssdii", $pname, $description, $price, $quantity, $stock);
        if ($stmt->execute()) {
            $last_id = $stmt->insert_id;
            $target_dir = "image/";
            $new_filename = $last_id . ".jpg";
            $target_file = $target_dir . $new_filename;

            // Check if file was uploaded without errors
            if ($_FILES["prod_image"]["error"] == 0) {
                if (move_uploaded_file($_FILES["prod_image"]["tmp_name"], $target_file)) {
                    echo "<script>";
                    echo "alert('Device added successfully');";
                    echo "window.location.href = 'viewDevices.php';";
                    echo "</script>";
                } else {
                    echo "Error uploading file.";
                }
            } else {
                echo "Error: " . $_FILES["prod_image"]["error"];
            }
        } else {
            echo "Error: Unable to execute the statement.";
        }
    } else {
        echo "Error: Unable to prepare the statement.";
    }

    $stmt->close();
} else {
    echo "Error: Form not submitted.";
}

$conn->close();
