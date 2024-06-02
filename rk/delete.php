<?php
session_start();

if (!isset($_SESSION['UserID']) || !isset($_SESSION['UserType'])) {
    // Redirect to login page if not logged in
    header('Location: Login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>.:: Allan Rey Sys ::.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
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
    <?php if($_SESSION['UserType'] == 'admin' || $_SESSION['UserType'] == 'seller') { ?>
        <li class="nav-item">
          <a class="nav-link" href="add.php">Add</a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="view.php">View</a>
      </li>
      <?php if($_SESSION['UserType'] == 'admin') { ?>
        <li class="nav-item">
          <a class="nav-link" href="update.php">Update</a>
        </li>
        <?php } ?>
        <?php if($_SESSION['UserType'] == 'admin') { ?>
        <li class="nav-item">
          <a class="nav-link" href="delete.php">Delete</a>
        </li>
      <?php } ?>
     
        <li class="nav-item">
          <a class="nav-link" href="search.php">Search </a>
        </li>

      <li class="nav-item">
        <a class="nav-link" href="Logout.php">Logout</a>
      </li>
    </ul>
  </div>  
</nav>
<br>

<div class="container">
  <h1>Delete Shirt</h1>
    
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

    if (isset($_POST['delete'])) {
      $id = $_POST['id'];

      $sql = "DELETE FROM info WHERE IDno='$id'";

      if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Record deleted successfully!</div>";
      } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting record: " . $conn->error . "</div>";
      }
    }

    $sql = "SELECT * FROM info";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table class='table'>";
      echo "<thead class='thead-dark'>";
      echo "<tr>";
      echo "<th>Shirt Name</th>";
      echo "<th>Size</th>";
      echo "<th>Color</th>";
      echo "<th>Image</th>";
      echo "<th>Action</th>";
      echo "</tr>";
      echo "</thead>";
      echo "<tbody>";
      while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><img src='Uploads/" . $row["IDno"] . ".png' width='100' height='100'></td>";
        echo "<td>" . $row["Shirt"] . "</td>";
        echo "<td>" . $row["Size"] . "</td>";
        echo "<td>" . $row["Color"] . "</td>";
       
        echo "<td>
                <form method='post' onsubmit='return confirm(\"Are you sure you want to delete this shirt?\")'>
                  <input type='hidden' name='id' value='" . $row["IDno"] . "'>
                  <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                </form>
              </td>";
        echo "</tr>";
      }
      echo "</tbody>";
      echo "</table>";
    } else {
      echo "<div class='alert alert-info' role='alert'>0 results</div>";
    }
    $conn->close();
  ?>
</div>

</body>
</html>
