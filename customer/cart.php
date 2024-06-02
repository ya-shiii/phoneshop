<?php
session_start();
include 'config.php';

// Check if the user is logged in and set the session variables
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  $userSql = "SELECT fname, lname FROM users WHERE id=$userId";
  $userResult = mysqli_query($conn, $userSql);
  if ($userResult && mysqli_num_rows($userResult) > 0) {
    $user = mysqli_fetch_assoc($userResult);
    $f_name = $user['fname'];
    $l_name = $user['lname'];
  }
}

// Fetch the phone models from the database
$sql = "SELECT * FROM phones";
$result = mysqli_query($conn, $sql);

?>

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
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="home.php">Shop</a></li>
          <li class="active"><a href="cart.php">My Cart</a></li>
          <li><a href="order.php">My Orders</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <h2>My Cart</h2>
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

        $orderSql = "SELECT * FROM checkout WHERE customer_id='$userId' AND `status` = 'Cart' ORDER BY id DESC";
        $orderResult = mysqli_query($conn, $orderSql);

        if ($orderResult) {
          if (mysqli_num_rows($orderResult) > 0) {
            while ($row = mysqli_fetch_assoc($orderResult)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['phone_id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
              echo "<td>" . htmlspecialchars($row['model']) . "</td>";
              echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
              echo "<td>" . htmlspecialchars($row['lname']) . "</td>";
              echo "<td>" . htmlspecialchars($row['address']) . "</td>";
              echo "<td>" . htmlspecialchars($row['status']) . "</td>";
              echo "<td>";
              if ($row['status'] == 'Cart' && $row['order_status'] == 'Pending') {
                echo '<button class="btn btn-info checkout-button" data-orderid="' . htmlspecialchars($row['id']) . '">Checkout Item</button>';
                echo '<button class="btn btn-danger cancel-button" data-orderid="' . htmlspecialchars($row['id']) . '">Cancel Order</button>';
              } else if ($row['status'] == 'En Route' && $row['order_status'] == 'Pending') {
                echo '<button class="btn btn-success receive-button" data-orderid="' . htmlspecialchars($row['id']) . '">Receive Item</button>';
              } else {
                echo htmlspecialchars($row['order_status']);
              }
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='9'>No orders found</td></tr>";
          }
        } else {
          echo "Error: " . mysqli_error($conn);
        }

        mysqli_close($conn);
        ?>

      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function () {
      $('.checkout-button').on('click', function () {
        var orderId = $(this).data('orderid');
        $.ajax({
          type: 'GET',
          url: 'process_checkout.php',
          data: { order_id: orderId },
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Order checked out successfully!',
              timer: 1500
            }).then(function () {
              window.location.href = 'cart.php';
            });
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error checking out order. Please try again.'
            });
          }
        });
      });

      $('.receive-button').on('click', function () {
        var orderId = $(this).data('orderid');
        $.ajax({
          type: 'GET',
          url: 'received_order.php',
          data: { order_id: orderId },
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Order received successfully!',
              timer: 1500
            }).then(function () {
              window.location.href = 'cart.php';
            });
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error receiving order. Please try again.'
            });
          }
        });
      });


      $('.cancel-button').on('click', function () {
        var orderId = $(this).data('orderid');
        $.ajax({
          type: 'POST',
          url: 'cancel_order.php',
          data: { order_id: orderId },
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Order cancelled successfully!',
              timer: 1500
            }).then(function () {
              window.location.href = 'cart.php';
            });
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error deleting order. Please try again.'
            });
          }
        });
      });
    });
  </script>
</body>

</html>