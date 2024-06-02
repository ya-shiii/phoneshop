<?php
$servername = "localhost";
$username = "root";
$password = "newpassword";
$dbname = "reederie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

		
		
		$shirt = $_POST['shirt'];
        $size = $_POST['size'];
		$color = $_POST['color'];

$sql = "INSERT INTO info (Shirt, Size, Color) 
VALUES ('$shirt', '$size', '$color')";

if ($conn->query ($sql) === TRUE) {
	    $last_id = $conn-> insert_id;
		$target_dir = "Uploads/";
		$_FILES["product_image"]["name"] = $last_id . ".png";
		$target_file = $target_dir . basename($_FILES["product_image"]["name"]);
		move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);

		 echo "New shoe added successfully";
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "Product Added",
                text: "Added successfully",
                icon: "success"
            }).then(function() {
                window.location = "view.php";
            });
        </script>
        <?php
    } else {
        echo "Error occure while adding";
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "Error",
                text: "Error occure",
                icon: "error"
            }).then(function() {
                window.location = "add.php";
            });
        </script>
        <?php
    }

$conn->close();
?>
