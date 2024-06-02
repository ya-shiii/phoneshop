<?php
// Include database configuration
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $phoneId = $_POST['editPhoneId'];
    $brand = $_POST['editBrand'];
    $model = $_POST['editModel'];
    $price = $_POST['editPrice'];

    // File upload handling
    $targetDir = "uploads/"; // Directory where uploaded files will be saved
    $fileName = basename($_FILES["editImage"]["name"]); // Get the name of the uploaded file
    $targetFilePath = $targetDir . $fileName; // Path to save the uploaded file
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); // Get the file extension

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["editImage"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileType, $allowedTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["editImage"]["tmp_name"], $targetFilePath)) {
                // SQL query to update phone details with image
                $sql = "UPDATE phones SET brand='$brand', model='$model', price='$price', image='$targetFilePath' WHERE phone_id=$phoneId";

                if (mysqli_query($conn, $sql)) {
                    // If update successful, send success message
                    echo json_encode(array("status" => "success", "message" => "Phone details updated successfully"));
                } else {
                    // If update fails, send error message
                    echo json_encode(array("status" => "error", "message" => "Error updating phone details: " . mysqli_error($conn)));
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "Error uploading image"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Only JPG, JPEG, PNG & GIF files are allowed"));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "File is not an image"));
    }
}

// Close connection
mysqli_close($conn);
?>
