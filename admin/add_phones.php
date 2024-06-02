<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">Reed's Phone Shop</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="dashboard.php">Home</a></li>
        <li class="active"><a href="add_phones.php">Add Product</a></li> <!-- Updated link to point to the add_phones.php file -->
        <li><a href="view.php">View Phones</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav> 
<!-- Add Phone Form -->
<div class="container">
    <center><h2>Add Phone</h2></center>
    <form method="POST" action="add_phones.php" enctype="multipart/form-data">

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required>

        <label for="brand">Brand:</label>
        <input type="text" name="brand" required>

        <label for="model">Model:</label>
        <input type="text" name="model" required>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required>

        <label for="year">Year Release:</label>
        <input type="date" name="year" required>

        <input type="submit" value="Add">
    </form>
</div>

</body>
</html>

<?php
// Include the SweetAlert library
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

// Include the database configuration file
include_once 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $year = $_POST['year']; // New line to retrieve 'year' input

    // File upload handling
    $targetDir = "img/"; // Directory where uploaded files will be stored
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . uniqid('', true) . '.' . $imageFileType; // Generate a unique file name

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Check file size
        if ($_FILES["image"]["size"] > 500000000) { // Adjust the file size limit as needed
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Sorry, your file is too large.',
                        showConfirmButton: true
                    });
                  </script>";
            exit();
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.',
                        showConfirmButton: true
                    });
                  </script>";
            exit();
        }

        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Create a new MySQLi object for database connection
            $mysqli = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Prepare the INSERT statement
            $sql = "INSERT INTO `phones`(`brand`, `model`, `price`, `year`, `image`) VALUES (?, ?, ?, ?, ?)";

            if ($stmt = $mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ssiss", $brand, $model, $price, $year, $targetFile);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Get the auto-incremented phone_id
                    $phone_id = $mysqli->insert_id;

                    // Rename the uploaded file with phone_id
                    $newFileName = $targetDir . $phone_id . '.' . $imageFileType;
                    rename($targetFile, $newFileName);

                    // Update the database with the new file name
                    $updateSql = "UPDATE `phones` SET `image` = ? WHERE `phone_id` = ?";
                    if ($updateStmt = $mysqli->prepare($updateSql)) {
                        $updateStmt->bind_param("si", $newFileName, $phone_id);
                        $updateStmt->execute();
                        $updateStmt->close();
                    }

                    // Show success message using SweetAlert
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'The file " . basename($_FILES["image"]["name"]) . " has been uploaded.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = 'view.php'; // Redirect after success message
                            });
                          </script>";
                    exit();
                } else {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Error uploading file to database.',
                                showConfirmButton: true
                            });
                          </script>";
                }

                // Close statement
                $stmt->close();
            }

            // Close connection
            $mysqli->close();
        } else {
            // Show error message using SweetAlert
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Sorry, there was an error uploading your file.',
                        showConfirmButton: true
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'File is not an image.',
                    showConfirmButton: true
                });
              </script>";
    }
}
?>


