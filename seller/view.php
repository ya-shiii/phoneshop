<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard - Reed's Phone Shop</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="add_phones.php">Add Product</a></li>
          <li class="active"><a href="view.php">View Phones</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <?php
    // Include database configuration
    include '../conn/config.php';

    // SQL query to select all rows from 'phones' table
    $sql = "SELECT * FROM phones";
    $result = mysqli_query($conn, $sql);

    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
      echo '<table class="table table-bordered">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Image</th>';
      echo '<th>Brand</th>';
      echo '<th>Model</th>';
      echo '<th>Price</th>';
      echo '<th>Quantity</th>';
      echo '<th>Action</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      // Output data of each row
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td><img src="' . $row["image"] . '" alt="Phone Image" width="100px"></td>';
        echo '<td>' . $row["brand"] . '</td>';
        echo '<td>' . $row["model"] . '</td>';
        echo '<td>' . $row["price"] . '</td>';
        echo '<td>' . $row["quantity"] . '</td>';
        echo '<td>';
        echo '<a href="#" data-toggle="modal" data-target="#deleteModal" data-phoneid="' . $row["phone_id"] . '" class="btn btn-danger delete-btn">Delete</a>';
        echo '</td>';
        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
    } else {
      echo "No records found";
    }

    // Close connection
    mysqli_close($conn);
    ?>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete Phone</h4>
          </div>
          <form action="delete.php" method="POST">
            <div class="modal-body">
              <p>Are you sure you want to delete this phone?</p>
            </div>
            <div class="modal-footer mb-2">
              <input type="hidden" id="phoneId" name="phoneId">
              <!-- Hidden input for storing phone ID -->
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" id="confirmDelete" class="btn btn-danger">Delete</button>
            </div>
          </form>
        </div>

      </div>
    </div>

    
  </div>