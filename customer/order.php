<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home - Reed's Phone Shop</title>
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

  .container {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 900px;
    margin: 0 auto;
  }

  .navbar {
    margin-bottom: 20px;
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
      <a class="navbar-brand" href="home.php">Reed's Phone Shop</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="home.php">Home</a></li>
        <li class="active"><a href="order.php">My Orders</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav> 
<div class="container">
  <h2>My Orders</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Phone ID</th>
        <th>Brand</th>
        <th>Model</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Address</th>
        <th>Status</th>
        <th>Order Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include 'config.php';
      $orderSql = "SELECT * FROM checkout";
      $orderResult = mysqli_query($conn, $orderSql);
      if (mysqli_num_rows($orderResult) > 0) {
          while ($row = mysqli_fetch_assoc($orderResult)) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>" . $row['phone_id'] . "</td>";
              echo "<td>" . $row['brand'] . "</td>";
              echo "<td>" . $row['model'] . "</td>";
              echo "<td>" . $row['fname'] . "</td>";
              echo "<td>" . $row['lname'] . "</td>";
              echo "<td>" . $row['address'] . "</td>";
              echo "<td>" . $row['status'] . "</td>";
              echo "<td>" . $row['order_status'] . "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='7'>No orders found</td></tr>";
      }
      mysqli_close($conn);
      ?>
    </tbody>
  </table>
</div>
</body>
</html>
