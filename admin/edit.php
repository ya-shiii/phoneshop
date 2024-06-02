<?php
// Include database configuration
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $phoneId = $_POST['editPhoneId'];
    $brand = $_POST['editBrand'];
    $model = $_POST['editModel'];
    $price = $_POST['editPrice'];
    $quantity = $_POST['editQuantity']; 

    // Check if a new image file is uploaded
    if (!empty($_FILES["editImage"]["name"])) {
        // File upload handling
        $targetDir = "../img/"; // Directory where uploaded files will be saved
        $fileName = basename($_FILES["editImage"]["name"]); // Get the name of the uploaded file
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); // Get the file extension

        // New file name based on phone ID
        $newFileName = $phoneId . '.' . $fileType;

        // Path to save the uploaded file
        $targetFilePath = $targetDir . $newFileName;

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["editImage"]["tmp_name"]);
        if ($check !== false) {
            // Allow certain file formats
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($fileType, $allowedTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["editImage"]["tmp_name"], $targetFilePath)) {
                    // Update phone details with new image URL and quantity
                    $sql = "UPDATE phones SET brand='$brand', model='$model', price='$price', image='$targetFilePath', quantity='$quantity' WHERE phone_id=$phoneId";
                } else {
                    echo json_encode(array("status" => "error", "message" => "Error uploading image"));
                    exit;
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "Only JPG, JPEG, PNG & GIF files are allowed"));
                exit;
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "File is not an image"));
            exit;
        }
    } else {
        // No new image uploaded, update phone details without changing the image URL, but update the quantity
        $sql = "UPDATE phones SET brand='$brand', model='$model', price='$price', quantity='$quantity' WHERE phone_id=$phoneId";
    }

    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        // If update successful, send success message
        echo json_encode(array("status" => "success", "message" => "Phone details updated successfully"));
    } else {
        // If update fails, send error message
        echo json_encode(array("status" => "error", "message" => "Error updating phone details: " . mysqli_error($conn)));
    }
}

// Close connection
mysqli_close($conn);
?>
