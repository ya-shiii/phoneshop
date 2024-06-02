<?php
$servername = "localhost";
$username = "root";
$password = "newpassword";
$dbname = "reederie";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$shirt = $_POST['shirt'];
$size = $_POST['size'];
$color = $_POST['color'];
$existingPhoto = $_POST['existingPhoto'];
$newPhoto = $_FILES['newPhoto']['name'];

// Update the shirt's info in the database
$sql = "UPDATE info SET Shirt='$shirt', Size='$size', Color='$color' WHERE IDno='$id'";

if ($conn->query($sql) === TRUE) {
    // If a new photo is uploaded, process the upload
    if ($newPhoto) {
        $target_dir = "Uploads/";
        $target_file = $target_dir . $id . ".png";
        
        // Move the uploaded file to the target directory and rename it
        if (move_uploaded_file($_FILES["newPhoto"]["tmp_name"], $target_file)) {
            $photo_message = "Record updated successfully with new photo.";
        } else {
            $photo_message = "Record updated, but there was an error uploading the new photo.";
        }
    } else {
        $photo_message = "Record updated successfully.";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Product edited",
            text: "<?php echo $photo_message; ?>",
            icon: "success"
        }).then(function() {
            window.location = "update.php";
        });
    </script>
    <?php
} else {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Error",
            text: "Error updating record: <?php echo $conn->error; ?>",
            icon: "error"
        }).then(function() {
            window.location = "update.php";
        });
    </script>
    <?php
}

$conn->close();
?>
