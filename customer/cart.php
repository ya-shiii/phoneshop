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
          <li><a href="account.php">My Account</a></li>
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
                echo '<button class="btn btn-info checkout-button" data-orderid="' . htmlspecialchars($row['id']) . '" 
                      data-phoneid="' . htmlspecialchars($row['phone_id']) . '"
                      data-brand="' . htmlspecialchars($row['brand']) . '"
                      data-model="' . htmlspecialchars($row['model']) . '"
                      data-address="' . htmlspecialchars($row['address']) . '">Checkout Item</button>';
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

  <!-- Checkout Modal -->
  <div id="checkoutModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Checkout</h4>
        </div>
        <div class="modal-body">
          <form id="checkoutForm">
            <input type="hidden" id="orderId" name="orderId">
            <input type="hidden" id="phoneId" name="phoneId">
            <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>">

            <label for="checkoutBrand">Brand:</label><br>
            <input type="text" id="checkoutBrand" name="checkoutBrand" readonly><br>

            <label for="checkoutModel">Model:</label><br>
            <input type="text" id="checkoutModel" name="checkoutModel" readonly><br>

            <label for="checkoutFname">First Name:</label><br>
            <input type="text" id="checkoutFname" name="checkoutFname" readonly
              value="<?php echo htmlspecialchars($f_name); ?>"><br>

            <label for="checkoutLname">Last Name:</label><br>
            <input type="text" id="checkoutLname" name="checkoutLname" readonly
              value="<?php echo htmlspecialchars($l_name); ?>"><br>

            <label for="checkoutAddress">Address:</label><br>
            <input type="text" id="checkoutAddress" name="checkoutAddress" required><br>

            <input type="submit" value="Place Order" class="btn btn-success"><br>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('.checkout-button').on('click', function () {
        var orderId = $(this).data('orderid');
        var phoneId = $(this).data('phoneid');
        var brand = $(this).data('brand');
        var model = $(this).data('model');
        var address = $(this).data('address');

        $('#orderId').val(orderId);
        $('#phoneId').val(phoneId);
        $('#checkoutBrand').val(brand);
        $('#checkoutModel').val(model);
        $('#checkoutAddress').val(address);

        $('#checkoutModal').modal('show');
      });

      $('#checkoutForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: 'POST',
          url: 'process_checkout.php',
          data: formData,
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Order checked out successfully!',
              timer: 1500
            }).then(function () {
              window.location.href = 'order.php';
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
