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
        $_SESSION['fname'] = $user['fname'];
        $_SESSION['lname'] = $user['lname'];
    }
}
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
  <h2>Available Phones</h2>

  <?php
  // Fetch phone details
  $phoneSql = "SELECT * FROM phones";
  $phoneResult = mysqli_query($conn, $phoneSql);

  if (mysqli_num_rows($phoneResult) > 0) {
      echo '<table class="table table-bordered">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Image</th>';
      echo '<th>Brand</th>';
      echo '<th>Model</th>';
      echo '<th>Price</th>';
      echo '<th>Action</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      while ($row = mysqli_fetch_assoc($phoneResult)) {
        echo '<tr>';
        echo '<td><img src="' . $row["image"] . '" alt="Phone Image" width="100px"></td>';
        echo '<td>' . $row["brand"] . '</td>';
        echo '<td>' . $row["model"] . '</td>';
        echo '<td>' . $row["price"] . '</td>';
        echo '<td>';
        echo '<a href="#" data-toggle="modal" data-target="#checkoutModal" 
            data-phoneid="' . $row["phone_id"] . '" 
            data-brand="' . $row["brand"] . '" 
            data-model="' . $row["model"] . '" 
            class="btn btn-primary checkout-button">Checkout</a>';
        echo '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    } else {
        echo "No phones available";
    }
    
    mysqli_close($conn);
    ?>
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
              <input type="hidden" id="phoneId" name="phoneId">
    
              <label for="checkoutBrand">Brand:</label>
              <input type="text" id="checkoutBrand" name="checkoutBrand" readonly>
    
              <label for="checkoutModel">Model:</label>
              <input type="text" id="checkoutModel" name="checkoutModel" readonly>
    
              <label for="checkoutFname">First Name:</label>
              <input type="text" id="checkoutFname"
              name="checkoutFname" required>

<label for="checkoutLname">Last Name:</label>
<input type="text" id="checkoutLname" name="checkoutLname" required>

<label for="checkoutAddress">Address:</label>
<input type="text" id="checkoutAddress" name="checkoutAddress" required>

<input type="submit" value="Place Order" class="btn btn-success">
</form>
</div>
</div>
</div>
</div>

<script>
$(document).ready(function(){
$('.checkout-button').on('click', function(){
var phoneId = $(this).data('phoneid');
var brand = $(this).data('brand');
var model = $(this).data('model');

$('#phoneId').val(phoneId);
$('#checkoutBrand').val(brand);
$('#checkoutModel').val(model);
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
          title:  'Success',
          text: 'Order placed successfully!',
          timer: 1500
      }).then(function () {
          window.location.href = 'order.php'; // Redirect to order.php
      });
  },
  error: function (xhr, status, error) {
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error placing order. Please try again.'
      });
  }
});
});
});
</script>
</body>
</html>

