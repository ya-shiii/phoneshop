<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if not logged in
    header('Location: Login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>.:: Student Info Sys ::.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #FBF8DD;
      color: #A34343;
    }
    .navbar {
      background-color: #E9C874;
    }
    .navbar-brand img {
      filter: invert(1);
    }
    .navbar-dark .navbar-nav .nav-link {
      color: #A34343;
    }
    .navbar-dark .navbar-nav .nav-link:hover {
      color: #C0D6E8;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #C0D6E8;
    }
    img.student-photo {
      max-width: 100px;
      max-height: 100px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark">
  <a class="navbar-brand" href="index.php">
    <img src="img/logo.png" alt="Logo" style="width:40px;">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
    <?php
      if($_SESSION ['UserType'] == 'admin' || $_SESSION ['UserType'] == 'seller'){
      ?>
      <li class="nav-item">
        <a class="nav-link" href="add.php">Add</a>
      </li>
      <?php
      }
      
      ?>
      <li class="nav-item">
        <a class="nav-link" href="view.php">View</a>
      </li>
      <?php
       if($_SESSION ['UserType'] == 'admin'){
        ?>
      <li class="nav-item">
        <a class="nav-link" href="update.php">Update</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="delete.php">Delete</a>
      </li>
      <?php
      }
      ?>
      <?php
       if($_SESSION ['UserType'] == 'admin'){
        ?>
      <li class="nav-item">
        <a class="nav-link" href="user.php">Users</a>
      </li>
      <?php
       }
       ?>
      <li class="nav-item">
        <a class="nav-link" href="Logout.php">Logout</a>
      </li>
    </ul>
  </div>  
</nav>
<br>

<div class="container">
  <h1>View Student</h1>
  
 
  <?php
            $servername = "localhost";
            $username = "root";
            $password = "newpassword";
            $dbname = "reederie";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM user";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>User ID</th>";
                echo "<th>Username</th>";
                echo "<th>User Type</th>";
                
                echo "</tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["UserID"] . "</td>";
                    echo "<td>" . $row["Uname"] . "</td>";
                    echo "<td>" . $row["UserType"] . "</td>";
                    echo "<td>
                    </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Product</h2>
        <form id="editForm" method="post" action="saveupdate.php">
            <input type="hidden" id="shoeId" name="shoeId">
           
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="date" id="fname" name="fname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <textarea id="lastname" name="lastname" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="hidden" id="image" name="image">
                <img id="shoePhoto" alt=" Photo" style="max-width: 50px; height: 50px;"/>
            </div>
            <div class="text-center">
                <button type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
